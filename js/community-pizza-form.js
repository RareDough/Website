'use strict';

(function($, window, document, undefined) {

	let userID = null,
		ownedTokens = [],
		userLevel = null;

	// Get owned token IDs from contract
	async function addToken(supply) {
		let pizzomaticTxn = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATIC);
		//let pizzomaticTxn = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATICTESTNET);

		// Call the smart contract to retrieve the TokenIDs associated with the wallet
		ownedTokens = await pizzomaticTxn.methods.getTokensCreatedBy(window.walletAddress).call();

		// Get the last token created and add it to database with supply
		let lastTokenID = ownedTokens[ownedTokens.length - 1];
		$.ajax({
			type: 'POST',
			url: '/inc/add-token',
			dataType: 'json',
			data: {
				userWallet: window.walletAddress,
				tokenID: lastTokenID,
				supply: supply
			}
		}).done(function(data) {
			console.log(data);

			// Get created tokens
			getCreatedTokens(userID);

			// Enable the user to continue
			$('#buy-token').removeClass('loading');
			$('#buy-token').hide();
			$('a#next-step').attr('disabled', false).css('display', 'inline-block');
		});
	}

	// Select2 formatting
	function formatState (state) {
		let supply = $(state.element).attr('data-supply');
		if (!state.id || supply == 'placeholder') { return state.text; }
		var $state = $(
			'<span>' + state.text + '</span> <img sytle="display: inline-block;" src="/custom-mint/backgrounds/'+ supply +'.png" />'
		);
		return $state;
	}

	// Get created tokens from database
	let createdTokens = 0;
	function getCreatedTokens(userID) {
		$.ajax({
			type: 'POST',
			url: '/inc/get-created-tokens',
			dataType: 'json',
			data: {
				userID: userID,
			}
		}).done(function(data) {
			let createdTokens = data.created_tokens;
			$('select[name="token-select"]').empty();
			$('select[name="token-select"]').append('<option data-supply="placeholder" selected disabled>Select a TokenID</option>');
			if (createdTokens.length) {
				// User has created tokens awaiting metadata
				$.each(createdTokens, function( index, token ) {
					let tokenID = token['token_id'],
						tokenSupply = token['supply'];

					$('select[name="token-select"]').append('<option data-supply="' + tokenSupply + '" value="' + tokenID + '">Token #' + tokenID + '</option>');

					createdTokens++;
				});

				// If user owns tokens already show text link
				$('.prev-purchased').show();
			}
			$('select[name="token-select"]').select2({
				templateResult: formatState,
				minimumResultsForSearch: -1
			});
		});
	}

	// Create pizza token
	async function createPizza(creationPrice, salePrice, supply) {
		// Initialize transaction
		let gas = await web3.eth.getGasPrice();
		let createPizzaTxn = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATIC);
		//let createPizzaTxn = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATICTESTNET);

		// Hide skip link
		$('.prev-purchased').hide();

		createPizzaTxn.methods.createPizza(creationPrice, salePrice, supply).send({ from:window.walletAddress, amount:0, gasPrice:(gas)})
		.once('transactionHash', function(hash) {
			console.log(hash);
		})
		.once('receipt', function(receipt) {
			console.log(receipt);
		})
		.once('confirmation', function(confirmationNumber, receipt) {
			// Once confirmations start rolling in - add token to database
			addToken(supply);
		})
		.once('error', function(error, receipt) {
			if (error.code == '4001') {
				// User canceled transaction
				$('input[name="token-select-box"]').attr('disabled', false);
				$('input[name="token-select-box"]').prop('checked', false);
				$('input[name="token-select-box"]').parent().removeClass('disabled unselected');
				$('#buy-token').removeClass('loading');
			}
		});
	}

	// Wait for wallet address to be defined
	(async() => {
		while(!window.hasOwnProperty('walletAddress')) {
			await new Promise(resolve => setTimeout(resolve, 1000));
		}

		// Check if returning user
		$.ajax({
			type: 'POST',
			url: '/inc/check-user',
			dataType: 'json',
			data: {
				userWallet: window.walletAddress
			}
		}).done(function(data) {
			if (data.return_user) {
				// Set user ID
				userID = data.user_id;

				// Set user level
				userLevel = data.user_level;

				// Get created tokens
				getCreatedTokens(userID);

				// Check if user has already provided Twitter/Discord and hide fields if so
				if (data.user_twitter) {
					$('input[name="twitter-username"]').parent().hide();
				}

				if (data.user_discord) {
					$('input[name="discord-username"]').parent().hide();
				}
			}
		});
	})();

	// Custom Pizza Nav
	$('#mint-nav a').click(function(e) {
		e.preventDefault();
		const $this = $(this);
		const currentStep = $('#mint-nav a.active-step').attr('data-step');
		if ($this.hasClass('previous-step') && currentStep != '4') {
			const selectedStep = $this.attr('data-step');
			$('section.mint-section, #mint-nav a').removeClass('active-step');
			$('section.mint-section[data-step="'+selectedStep+'"], #mint-nav a[data-step="'+selectedStep+'"]').addClass('active-step');
			$('#mint-nav ol').attr('data-step', selectedStep);
			$('#mint-nav a').removeClass('previous-step');
			$('#mint-nav a[data-step="'+selectedStep+'"]').parent().prevAll().find('a').addClass('previous-step');

			// Hide navigation buttons if greater than Step 2
			if (selectedStep > 2) {
				$('#mint-section-buttons').hide();
			} else {
				$('#mint-section-buttons').show();
			}

			// Show/hide the skip 1st step link
			if (selectedStep > 1) {
				$('.prev-purchased').hide();
				$('#next-step').show();
			} else {
				if (createdTokens > 0) {
					$('.prev-purchased').show();
				}
				$('#buy-token').show();
				$('#next-step').hide();
			}

			// If user goes back to Step 1 to create a new token
			if (selectedStep == 1) {
				$('input[name="token-select-box"]').attr('disabled', false);
				$('input[name="token-select-box"]').prop('checked', false);
				$('input[name="token-select-box"]').parent().removeClass('disabled unselected');
			}
		}
	});

	// Form progression
	$('a#next-step, .prev-purchased a').click(function(e) {
		e.preventDefault();

		let $this = $(this);

		if (!$this.attr('disabled')) {
			let currentStep = $('section.mint-section.active-step').attr('data-step'),
				nextStep = parseInt(currentStep) + 1;

			// Disable the continue button
			if (!$this.parent().hasClass('prev-purchased')) {
				$this.attr('disabled', true);
			}

			// Hide current section and show next
			$('section.mint-section, #mint-nav a').removeClass('active-step');
			$('section.mint-section[data-step="'+nextStep+'"], #mint-nav a[data-step="'+nextStep+'"]').addClass('active-step');

			// Change data attribute for nav
			$('#mint-nav ol').attr('data-step', nextStep);

			// Set previous step classes
			$('#mint-nav a').removeClass('previous-step');
			$('#mint-nav a[data-step="'+nextStep+'"]').parent().prevAll().find('a').addClass('previous-step');

			// Hide navigation buttons if greater than Step 2
			if (nextStep > 2) {
				$('#mint-section-buttons').hide();
			} else {
				$('#mint-section-buttons').show();
			}

			$('#next-step').show();
			if (nextStep == 3 && $('select[name="token-select"]').val() !== null) {
				$('a#next-step').attr('disabled', false);
			}

			// Show/hide the skip 1st step link
			if (nextStep > 1) {
				$('.prev-purchased').hide();
			} else {
				$('.prev-purchased').show();
			}

			// Hide buy button
			$('#buy-token').hide();
		}
	});

	// Update token preview and background image
	function swapTokenBackground(supply) {
		$('.token-preview img').attr('src', '/custom-mint/backgrounds/' + supply + '.png');
		$('#pizza-template').attr('src', '/custom-mint/backgrounds/' + supply + '.png');
	}

	// Step 1 
	$('#buy-token').click(function(e) {
		e.preventDefault();

		let $this = $(this);

		if (!$this.attr('disabled')) {
			// Get supply value and set default token price
			const salePrice = '100';
			let tokenSupply = $('input[name="token-select-box"]:checked').val(),
				creationPrice = '100';

			// Disable buy button and add loading animation
			$('#buy-token').attr('disabled', true);
			$('#buy-token').addClass('loading');

			// Disable supply inputs
			$('input[name="token-select-box"]').attr('disabled', true);
			$('input[name="token-select-box"]').parent().addClass('disabled');

			// Reduce opacity of unselected options
			$('input[name="token-select-box"]:not(:checked)').parent().addClass('unselected');
			
			// Change price for 500 supply token
			if (tokenSupply == '500') {
				creationPrice = '1000';
			}
			// Call create pizza method
			createPizza(creationPrice, salePrice, tokenSupply);
		}
	});

	// Step 2
	$('select[name="token-select"]').change(function() {
		let $this = $(this),
			tokenSupply = $('option:selected', $this).attr('data-supply'),
			tokenID = $this.val();

		// Show preview
		$('.token-preview').show();

		// Update hidden fields with selected values
		$('input[name="token-supply"]').val(tokenSupply);
		$('input[name="token-id"]').val(tokenID);

		// Enable and show continue button
		$('a#next-step').attr('disabled', false);
		$('a#next-step').css('display', 'inline-block');

		// Update the background image
		swapTokenBackground(tokenSupply);
	});


	// Step 3
	var isAdvancedUpload = function() {
		var div = document.createElement('div');
		return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
	}();

	let $form 		  = $('#pizza-form'),
		$imgCont	  = $('#image-upload'),
		fileInput	  = document.getElementById('file-input'),
		customImage   = document.getElementById('custom-image'),
		$input		  = $form.find('input[type="file"]'),
		$label		  = $form.find('#image-upload label'),
		$errorMsg	  = $form.find('.input-error'),
		userFile 	  = {},
		userFileReady = true,
		droppedFiles  = false;

	// letting the server side to know we are going to make an Ajax request
	$form.append( '<input type="hidden" name="ajax" value="1" />' );

	// drag&drop files if the feature is available
	if (isAdvancedUpload) {
		$imgCont
		.addClass('has-advanced-upload')
		.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
			// preventing the unwanted behaviours
			e.preventDefault();
			e.stopPropagation();
		})
		.on('dragover dragenter', function() {
			$imgCont.addClass( 'is-dragover' );
		})
		.on('dragleave dragend drop', function() {
			$imgCont.removeClass( 'is-dragover' );
		})
		.on('drop', function(e) {
			droppedFiles = e.originalEvent.dataTransfer.files;
			userFile = {};
			userFileReady = false;

			customImage.files = droppedFiles;
			customImage.dispatchEvent(new Event('change'));
		});
	}

	// File select handler
	customImage.addEventListener('change', async (event) => {

		let validImage = $('#custom-image').valid();
		
		if (validImage) {
			userFile = {};
			userFileReady = false;

			const inputKey = customImage.getAttribute('name')
			let files = event.srcElement.files;
			const filePromises = Object.entries(files).map(item => {
				
				if (item) {
					$('#user-image').remove();
					return new Promise((resolve, reject) => {
						const [index, file] = item;
						const reader = new FileReader();
						reader.readAsBinaryString(file);

						reader.onload = function(event) {
							const fileKey = `${inputKey}${files.length > 1 ? `[${index}]` : ''}`
							userFile[fileKey] = `data:${file.type};base64,${btoa(event.target.result)}`
							let userImage = new Image();
							userImage.id = 'user-image';
							userImage.src = userFile[fileKey];
							document.getElementById('pizza-container').appendChild(userImage);
							document.getElementById('pizza-container').classList.add('image-selected');
							fileInput.style.display = 'none';
							resolve();
						};

						reader.onerror = function() {
							console.log('File not read');
							reject();
						};
					});
				}

			});

			Promise.all(filePromises)
			.then(() => {
				console.log('Ready to submit');
				userFileReady = true;
			})
			.catch((error) => {
				console.log(error);
				console.log('Something went wrong');
			});
		}
	});

	// Replace image
	$('#image-upload').click(function(e) {
		if ($('#user-image').length) {
			customImage.click();
		}
	});

	// Custom text on a curve
	const tokenTitleInput = document.getElementById('token-title');
	function updateName() {
		let tokenTitleVal = tokenTitleInput.value;

		const customText = document.getElementById('custom-text');
		customText.textContent = tokenTitleVal;
	}
	tokenTitleInput.addEventListener('keyup', updateName);

	// Add filesize check
	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

	// Check for errors
	$form.validate({
		rules: {
			'custom-image': {
				required: true,
            	extension: 'jpg|jpeg|gif|png|svg|webp|avif',
            	filesize: 5
			},
	        'token-name': {
	        	required: true,
	        	maxlength: 18
	        },
	        'token-title': {
	        	maxlength: 26
	        },
	        'token-desc': {
	        	required: true,
	        	maxlength: 1000
	        },
	        'twitter-username': {
	        	required: true
	        },
	        'discord-username': {
	        	required: true
	        },
	        'discord-joined': {
	        	required: true
	        }
	    },
	    messages: {
	    	'custom-image': {
				required: 'Please provide your custom artwork',
            	extension: 'Accepted filetypes: JPG, PNG, GIF, SVG, WEBP, AVIF',
            	filesize: 'Filesize must be ≤ 5MB'
			},
	        'token-name': {
	        	required: 'Please name your pizza',
	        	maxlength: 'Pizza name must be 18 characters or less'
	        },
	        'token-title': {
	        	maxlength: 'Pizza title must be 26 characters or less'
	        },
	        'token-desc': {
	        	required: 'Please name your pizza',
	        	maxlength: 'Pizza name must be 1000 characters or less'
	        },
	        'twitter-username': {
	        	required: 'Please enter your Twitter username',
	        },
	        'discord-username': {
	        	required: 'Please enter your Discord username',
	        },
	        'discord-joined': {
	        	required: 'Please confirm that you have joined our Discord server'
	        }
	    },
		errorPlacement: function(error, element) {
			if (element.attr('name') == 'custom-image') {
				error.insertAfter('#image-upload');
			} else if (element.attr('name') == 'discord-joined') {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		}
	});

	// Submit form if valid
	$('#submit-form').click(function(e) {
		e.preventDefault();

		let isvalid = $form.valid(),
			dataURL = null;

		if (isvalid) {
			// Check if form is already submitting
			if ($form.hasClass('is-uploading')) return false;

			$form.addClass('is-uploading').removeClass('is-error');

			// Disable submit button
			$('#submit-form').attr('disabled', true);
			$('#submit-form').addClass('loading');

			// Clone preview to final composition container
			let $finalPizza = $('#pizza-container').clone();
			$('#pizza-comp').html($finalPizza);

			// Generate image file
			const pizzaComp = document.getElementById('pizza-comp');
			html2canvas(pizzaComp, {
				allowTaint:true,
				width: 1000,
				height: 1000
			}).then(canvas => {
		        dataURL = canvas.toDataURL();
	            $.ajax({
	                type: 'POST',
	                url: '/inc/save-pizza',
	                dataType: 'json',
	                data: {
	                	userWallet: walletAddress,
	                    imgBase64: dataURL,
	                    id: document.getElementsByName('token-id')[0].value,
	                    supply: document.getElementsByName('token-select-box')[0].value,
	                    name: document.getElementsByName('token-name')[0].value,
	                    description: document.getElementsByName('token-desc')[0].value,
	                    twitter: document.getElementsByName('twitter-username')[0].value,
	                    discord: document.getElementsByName('discord-username')[0].value
	                }
	            }).done(function(data) {
					$('#image-preview').attr('src', dataURL);
					$('section.mint-section, #mint-nav a').removeClass('previous-step active-step');
					$('#mint-nav ol').attr('data-step', 4);
					$('section.mint-section').removeClass('active-step');
					$('section.mint-section[data-step="4"], #mint-nav a[data-step="4"]').addClass('active-step');
					$('#submit-form').removeClass('loading');
	            });
		    });
		}
	});

	// Firefox focus bug fix for file input
	$input
	.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
	.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });

	// Debugging
	// Sentry.init({
    //     dsn: "https://92fc69b645f93d52488af0d1524f357e@o4505762853683200.ingest.sentry.io/4505762855256064",
    //     debug: false,
    //     integrations: [
    //         new Sentry.Integrations.CaptureConsole({
    //             levels: ['log', 'info', 'warn', 'error', 'debug', 'assert']
    //         })
    //     ],
    // });

})( jQuery, window, document );
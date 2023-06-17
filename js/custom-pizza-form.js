'use strict';

(function($, window, document, undefined) {

	// Custom Pizza Nav
	$('#mint-nav a').click(function(e) {
		e.preventDefault();
		const $this = $(this);
		//if ($this.hasClass('previous-step')) {
			const selectedStep = $this.attr('data-step');
			$('section.mint-section, #mint-nav a').removeClass('active-step');
			$('section.mint-section[data-step="'+selectedStep+'"], #mint-nav a[data-step="'+selectedStep+'"]').addClass('active-step');
			$('#mint-nav ol').attr('data-step', selectedStep);
			$('#mint-nav a').removeClass('previous-step');
			$('#mint-nav a[data-step="'+selectedStep+'"]').parent().prevAll().find('a').addClass('previous-step');
		//}
	});

	// Form progression
	$('a#next-step').click(function(e) {
		e.preventDefault();
		let $this = $(this),
			currentStep = $('section.mint-section.active-step').attr('data-step'),
			nextStep = parseInt(currentStep) + 1;

		// Disable and hide continue button
		$(this).attr('disabled', true);
		$(this).hide();

		// Hide current section and show next
		$('section.mint-section, #mint-nav a').removeClass('active-step');
		$('section.mint-section[data-step="'+nextStep+'"], #mint-nav a[data-step="'+nextStep+'"]').addClass('active-step');

		// Change data attribute for nav
		$('#mint-nav ol').attr('data-step', nextStep);

		// Set previous step classes
		$('#mint-nav a').removeClass('previous-step');
		$('#mint-nav a[data-step="'+nextStep+'"]').parent().prevAll().find('a').addClass('previous-step');
	});

	// Update token preview and background image
	function swapTokenBackground() {
		let backgroundImage = $('input[name="token-supply"]:checked').siblings('img').attr('src');
		$('.token-preview img').attr('src', backgroundImage);
	}

	// Step 1 
	$('input[name="token-supply"]').on('change', function() {
		let $this = $(this);
		// Enable buy button once supply is selected
		$('#buy-token').attr('disabled', false);
		// Focus the buy button once a choice is made
		$('#buy-token').focus();
	});

	$('#buy-token').click(function(e) {
		e.preventDefault();
		// Get supply value
		let tokenSupply = $('input[name="token-supply"]:checked').val();

		// Hide buy button
		$('#buy-token').hide();
		
		// GECKO DO YOUR MAGIC HERE
		// Initialize transaction
		// Get all TokenIDs that do not have complete metadata yet
		// Populate token select dropdown with aforementioned token IDs
		let tokenArray = [{id:69, supply:1000}, {id:420, supply:500}];
		tokenArray.forEach(function(token) {
			$('select[name="token-select"]').append('<option data-supply="' + token['supply'] + '" value="' + token['id'] + '">Token #' + token['id'] + '</option>');
		});


		// Enable and show continue button
		$('a#next-step').attr('disabled', false);
		$('a#next-step').css('display', 'inline-block');

		// Update images
		swapTokenBackground();
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
	});

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
						fileInput.style.display = 'none';
						resolve();
					};

					reader.onerror = function() {
						console.log('File not read');
						reject();
					};
				});

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
            	extension: 'jpg|jpeg|gif|png|webp',
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
            	extension: 'Accepted filetypes: JPG, PNG, GIF, WEBP',
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
			} else {
				error.insertAfter(element);
			}
		}
	});

	// Submit form if valid
	$form.on('submit', function(e) {
		e.preventDefault();

		let isvalid = $form.valid();
		if (isvalid) {
			// Check if form is already submitting
			if ($form.hasClass('is-uploading')) return false;

			$form.addClass('is-uploading').removeClass('is-error');

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
		        var dataURL = canvas.toDataURL();
	            $.ajax({
	                type: 'POST',
	                url: '/inc/save-pizza',
	                data: {
	                	userWallet: walletAddress,
	                    imgBase64: dataURL,
	                    id: document.getElementsByName('token-id')[0].value,
	                    supply: document.getElementsByName('token-supply')[0].value,
	                    name: document.getElementsByName('token-name')[0].value,
	                    description: document.getElementById('token-desc').value,
	                    twitter: document.getElementsByName('twitter-username')[0].value,
	                    discord: document.getElementsByName('discord-username')[0].value
	                }
	            }).done(function(data) {
	                console.log(data);
	            });
		    });
		}
	});

	// Firefox focus bug fix for file input
	$input
	.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
	.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });

})( jQuery, window, document );
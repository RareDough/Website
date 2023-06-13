'use strict';

(function($, window, document, undefined) {

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
		})
	});

	const handleForm = async (event) => {
		event.preventDefault();

		if(!userFileReady) {
			console.log('Files being processed');
			return
		}
	}

	// Custom text on a curve
	const pizzaNameInput = document.getElementById('pizza-name');
	function updateName() {
		let pizzaNameVal = pizzaNameInput.value;

		const customText = document.getElementById('custom-text');
		customText.textContent = pizzaNameVal;
	}
	pizzaNameInput.addEventListener('keyup', updateName);

	// Show name on pizza
	const textPath = document.getElementById('text-path');
	const nameToggle = document.getElementsByName('show-name')[0];

	let show = function (elem) {
		elem.style.display = 'block';
	};

	let hide = function (elem) {
		elem.style.display = 'none';
	};

	let toggleName = function(elem) {
		if (window.getComputedStyle(elem).display === 'block') {
			hide(elem);
			return;
		}

		show(elem);
	};

	nameToggle.addEventListener('change', function() {
		toggleName(textPath);
	});

	// Check for errors
	$form.validate({
		rules: {
			'custom-image': {
				required: true,
            	accept: 'image/jpeg, image/png, image/gif, image/webp, image/svg+xml'
			},
	        'pizza-name': {
	        	required: true,
	        	maxlength: 18
	        },
	        'pizza-desc': {
	        	required: true,
	        	maxlength: 200
	        }
	    },
	    messages: {
	    	'custom-image': {
				required: true,
            	accept: 'Accepted filetypes: JPG, PNG, GIF, WEBP, SVG'
			},
	        'pizza-name': {
	        	required: 'Please name your pizza',
	        	maxlength: 'Pizza name must be 18 characters or less'
	        },
	        'pizza-desc': {
	        	required: 'Please name your pizza',
	        	maxlength: 'Pizza name must be 50 characters or less'
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
	                    name: pizzaNameInput.value,
	                    supply: document.getElementsByName('supply')[0].value,
	                    description: document.getElementById('pizza-desc').value
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
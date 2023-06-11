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

	// $form.addEventListener('submit', handleForm)

	// Form submission
	$form.on('submit', function(e) {
		// preventing the duplicate submissions if the current one is in progress
		if ($form.hasClass('is-uploading')) return false;

		$form.addClass('is-uploading').removeClass('is-error');



		if (isAdvancedUpload) {
			e.preventDefault();

			// gathering the form data
			// var ajaxData = new FormData($form.get(0));
			// if (droppedFiles) {
			// 	$.each( droppedFiles, function(i, file) {
			// 		ajaxData.append( $input.attr( 'name' ), file );
			// 	});
			// }

			// ajax request
			const customImageCont = document.getElementById('pizza-container');
			html2canvas(customImageCont,{allowTaint:true}).then(canvas => {
		        var dataURL = canvas.toDataURL();
		        console.log(dataURL);
                $.ajax({
                    type: 'POST',
                    url: '/inc/save-pizza',
                    data: {
                        imgBase64: dataURL
                    }
                }).done(function(o) {
                    console.log('saved');
                });
		    });
			// html2canvas(customImageCont, {
            //     onrendered: function(canvas) {
            //     	console.log(canvas);
            //         var imgsrc = canvas.toDataURL('image/png');
            //         console.log(imgsrc);
            //         // $("#holder-img").attr('src', imgsrc);
            //         // $("#holder-cont").show();
            //         var dataURL = canvas.toDataURL();
            //         $.ajax({
            //             type: 'POST',
            //             url: '/inc/save-pizza.php',
            //             data: {
            //                 imgBase64: dataURL
            //             }
            //         }).done(function(o) {
            //             console.log('saved');
            //         });
            //     }
            // });
			// $.ajax({
			// 	url: 			$form.attr( 'action' ),
			// 	type:			$form.attr( 'method' ),
			// 	data: 			ajaxData,
			// 	dataType:		'json',
			// 	cache:			false,
			// 	contentType:	false,
			// 	processData:	false,
			// 	complete: function() {
			// 		$form.removeClass( 'is-uploading' );
			// 	},
			// 	success: function(data) {
			// 		$form.addClass( data.success == true ? 'is-success' : 'is-error' );
			// 		if( !data.success ) $errorMsg.text( data.error );
			// 	},
			// 	error: function() {
			// 		alert( 'Error. Please, contact the webmaster!' );
			// 	}
			// });
		} else {
			// let iframeName	= 'uploadiframe' + new Date().getTime(),
			// 	$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

			// $('body').append($iframe);
			// $form.attr('target', iframeName);

			// $iframe.one('load', function() {
			// 	var data = $.parseJSON( $iframe.contents().find( 'body' ).text() );
			// 	$form.removeClass( 'is-uploading' ).addClass( data.success == true ? 'is-success' : 'is-error' ).removeAttr( 'target' );
			// 	if( !data.success ) $errorMsg.text( data.error );
			// 	$iframe.remove();
			// });
		}
	});

	// Firefox focus bug fix for file input
	$input
	.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
	.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });

})( jQuery, window, document );
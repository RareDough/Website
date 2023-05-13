'use strict';

(function($, window, document, undefined) {

	var isAdvancedUpload = function() {
		var div = document.createElement('div');
		return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
	}();

	let $form 		 = $('#pizza-form'),
		$imgCont	 = $('#image-upload'),
		$input		 = $form.find('input[type="file"]'),
		$label		 = $form.find('#image-upload label'),
		$errorMsg	 = $form.find('.input-error'),
		droppedFiles = false,
		showFiles	 = function(files) {
			$label.text( files[ 0 ].name );
		};

	// letting the server side to know we are going to make an Ajax request
	$form.append( '<input type="hidden" name="ajax" value="1" />' );

	// automatically submit the form on file select
	$input.on('change', function(e) {
		showFiles(e.target.files);
	});

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
			droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
			showFiles(droppedFiles);
		});
	}

	// Form submission
	// $form.on('submit', function(e) {
	// 	// preventing the duplicate submissions if the current one is in progress
	// 	if ($form.hasClass('is-uploading')) return false;

	// 	$form.addClass('is-uploading').removeClass('is-error');

	// 	if (isAdvancedUpload) {
	// 		e.preventDefault();

	// 		// gathering the form data
	// 		var ajaxData = new FormData($form.get(0));
	// 		if (droppedFiles) {
	// 			$.each( droppedFiles, function(i, file) {
	// 				ajaxData.append( $input.attr( 'name' ), file );
	// 			});
	// 		}

	// 		// ajax request
	// 		$.ajax({
	// 			url: 			$form.attr( 'action' ),
	// 			type:			$form.attr( 'method' ),
	// 			data: 			ajaxData,
	// 			dataType:		'json',
	// 			cache:			false,
	// 			contentType:	false,
	// 			processData:	false,
	// 			complete: function() {
	// 				$form.removeClass( 'is-uploading' );
	// 			},
	// 			success: function(data) {
	// 				$form.addClass( data.success == true ? 'is-success' : 'is-error' );
	// 				if( !data.success ) $errorMsg.text( data.error );
	// 			},
	// 			error: function() {
	// 				alert( 'Error. Please, contact the webmaster!' );
	// 			}
	// 		});
	// 	} else {
	// 		let iframeName	= 'uploadiframe' + new Date().getTime(),
	// 			$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

	// 		$('body').append($iframe);
	// 		$form.attr('target', iframeName);

	// 		$iframe.one('load', function() {
	// 			var data = $.parseJSON( $iframe.contents().find( 'body' ).text() );
	// 			$form.removeClass( 'is-uploading' ).addClass( data.success == true ? 'is-success' : 'is-error' ).removeAttr( 'target' );
	// 			if( !data.success ) $errorMsg.text( data.error );
	// 			$iframe.remove();
	// 		});
	// 	}
	// });

	// Firefox focus bug fix for file input
	$input
	.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
	.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });

})( jQuery, window, document );
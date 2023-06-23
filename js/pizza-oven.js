'use strict';

(function($, window, document, undefined) {

	let userID = null,
		userLevel = null;

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

				// Show moderator controls for approved users
				showModeratorFunctions();
			}
		});
	})();

	function showModeratorFunctions() {
		$('.status-heading').text('Actions');
		$('.pizza-status span').hide();

		// Add moderator buttons
		$('.pizza-item-container').each(function(i) {
			let $this = $(this),
				status = $this.attr('data-status'),
				modButtons = null;

			if (status == 'pending') {
				modButtons = `
					<a class="oven-btn mainBtn dark" href="#" data-action="enable">Enable</a>
					<a class="oven-btn mainBtn dark" href="#" data-action="reject">Reject</a>
				`;
			} else if (status == 'approved') {
				modButtons = `
					<a class="oven-btn mainBtn dark" href="#" data-action="disable">Disable</a>
					<a class="oven-btn mainBtn dark" href="#" data-action="pause">Pause</a>
				`;
			}

			$('.pizza-status', this).append(modButtons);
		});
		
	}

})( jQuery, window, document );
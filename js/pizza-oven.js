'use strict';

let gas = null;

async function verifyUser(walletAddress) {
	let authMsg = 'Please verify your wallet address';
	let signed = await web3.eth.personal.sign(authMsg, walletAddress);

	return signed;
}

(function($, window, document, undefined) {

	let userID = null,
		userLevel = null;

	(async() => {
		while(!window.hasOwnProperty('walletAddress')) {
			await new Promise(resolve => setTimeout(resolve, 1000));
		}

		gas = await web3.eth.getGasPrice();

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
					<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="enable">Enable</a>
					<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="reject">Reject</a>
				`;
			} else if (status == 'approved') {
				modButtons = `
					<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="disable">Disable</a>
					<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="pause">Pause</a>
				`;
			}

			$('.pizza-status', this).append(modButtons);
		});
		
	}

	$(document).on('click', '.mod-btn', function() {
		let $this = $(this),
			$tokenRow = $(this).closest('.pizza-item-container');

		verifyUser(window.walletAddress)
		.then(function(data) {
			// User validated
			let tokenID = $tokenRow.attr('data-token-id'),
				action = $this.attr('data-action'),
				// pizzaContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATIC),
				pizzomaticContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATICTESTNET);

			if (action == 'enable') {
				pizzomaticContract.methods.activateToken(tokenID).send({ from:window.walletAddress, amount:0, gasPrice:(gas)})
			} else if (action == 'disable') {
				pizzomaticContract.methods.deactivateToken(tokenID).call();
			}
		})
		.catch(function(err) {
			// User not validated
			console.log('Error: ' + err.message);
		});
	});

})( jQuery, window, document );
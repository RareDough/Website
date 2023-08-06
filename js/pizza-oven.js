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

				if (userLevel == 0) {
					// Show user controls for tokens they own
					showUserControls(userID);
				} else if (userLevel == 10) {
					// Show moderator controls for approved users
					showModeratorControls();
				}
			}
		});
	})();

	function showUserControls(userID) {
		$('.pizza-item-container').each(function(i) {
			let $this = $(this),
				status = $this.attr('data-status'),
				userButtons = null,
				creatorID = $this.attr('data-user-id'),
				tokenID = $this.attr('data-token-id'),
				supply = $this.attr('data-supply');

			if (status == 'approved') {
				userButtons = `
					<div class="oven-btns"><a class="oven-btn mod-btn mainBtn dark" href="#" data-action="activate">Activate</a></div>
				`;
			} else if (status == 'active') {
				userButtons = `
					<div class="oven-btns"><a class="oven-btn mod-btn mainBtn dark" href="#" data-action="pause">Pause</a></div>
				`;
			} else if (status == 'paused') {
				userButtons = `
					<div class="oven-btns">
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="activate">Activate</a>
					</div>
				`;
			}

			if (creatorID == userID && userButtons) {
				$('.pizza-status span', this).hide();
				$('.pizza-status', this).append(userButtons);
			}
		});
	}

	function showModeratorControls() {
		$('.status-heading').text('Actions');
		$('.pizza-status span').hide();

		// Add moderator buttons
		$('.pizza-item-container').each(function(i) {
			let $this = $(this),
				status = $this.attr('data-status'),
				modButtons = null,
				tokenID = $this.attr('data-token-id'),
				supply = $this.attr('data-supply');

			if (status == 'pending') {
				modButtons = `
					<div class="oven-btns">
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="enable">Enable</a>
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="reject">Reject</a>
					</div>
				`;
			} else if (status == 'approved' || status == 'active' || status == 'paused') {
				modButtons = `
					<div class="oven-btns">
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="disable">Disable</a>
					</div>
				`;
			} else if (status == 'disabled') {
				modButtons = `
					<div class="oven-btns">
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="reenable">Enable</a>
					</div>
				`;
			}

			if (modButtons) {
				$('.pizza-status', this).append(modButtons);
			}

			// Get number of minted for each token
			let pizzomaticContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATICTESTNET);
			pizzomaticContract.methods.getNumMintedForToken(tokenID).call().then(function(response) {
				return response;
			}).then(function(data) {
				$('.pizza-supply span', $this).text(data + ' /');

				// If token is sold out
				if (Number(data) == Number(supply)) {
					console.log('Sold Out');
					$('.pizza-status', $this).addClass('status-sold-out');
					$('.pizza-status span', $this).text('Sold Out');
				}
			})
		});
		
	}

	$(document).on('click', '.mod-btn', function(e) {
		e.preventDefault();
		
		let $this = $(this),
			$tokenRow = $(this).closest('.pizza-item-container');

		verifyUser(window.walletAddress)
		.then(function(data) {
			// User validated
			let tokenID = $tokenRow.attr('data-token-id'),
				action = $this.attr('data-action'),
				status = null,
				method =  null,
				// pizzaContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATIC),
				pizzomaticContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATICTESTNET);

			if (action == 'enable' || action == 'reenable') {
				method = 'activateToken';
				status = 'approved';
			} else if (action == 'activate') {
				method = 'activateSale';
				status = 'active';
			} else if (action == 'disable') {
				method = 'deactivateToken';
				status = 'disabled';
			} else if (action == 'pause') {
				method = 'deactivateSale';
				status = 'paused';
			}

			pizzomaticContract.methods[method](tokenID).send({ from:window.walletAddress, amount:0, gasPrice:(gas)})
			.once('transactionHash', function(hash) {
				console.log(hash);
			})
			.once('confirmation', function(receipt) {
				console.log(receipt);
			})
			.on('receipt', function(receipt) {
				// Once confirmations start rolling in - update token in database
				$.ajax({
					type: 'POST',
					url: '/inc/mod-tools',
					dataType: 'json',
					data: {
						userWallet: window.walletAddress,
						tokenID: tokenID,
						action: action,
						status: status
					}
				}).done(function(data) {
					console.log(data);
					// Transaction successful, refresh page
					window.location.reload();
				});
			});
		})
		.catch(function(err) {
			// User not validated
			console.log('Error: ' + err.message);
		});
	});

})( jQuery, window, document );
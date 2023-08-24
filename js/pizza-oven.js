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

				// Check if user has pizzas in oven
				const numPizzas = $('.pizza-item-container[data-user-id="'+userID+'"]').length;
				if (numPizzas) {
					$('.creator-filter a[data-creator="user"]').show();
				}

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
					<div class="oven-btns">
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="activate">Activate</a>
					</div>
				`;
			} else if (status == 'active') {
				userButtons = `
					<div class="oven-btns">
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="pause">Pause</a>
						<a class="oven-btn mod-btn mainBtn dark" href="#" data-action="airdrop">Airdrop</a>
					</div>
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
			let pizzomaticContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATIC);
			//let pizzomaticContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATICTESTNET);
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

	// Creator filter
	$('.creator-filter a').click(function(e) {
		e.preventDefault();
		const filter = $(this).attr('data-creator');

		if (filter == 'all') {
			$('.pizza-item-container').show();
		} else {
			$('.pizza-item-container').each(function() {
				let creatorID = $(this).attr('data-user-id');
				if (creatorID != userID) {
					$(this).hide();
				}
			});
		}

		$('.creator-filter a').removeClass('active');
		$(this).addClass('active');
	});

	$(document).on('click', '.mod-btn', function(e) {
		e.preventDefault();
		
		let $this = $(this),
			$tokenRow = $(this).closest('.pizza-item-container'),
			tokenID = $tokenRow.attr('data-token-id'),
			tokenName = $('.token-name', $tokenRow).text().trim(),
			action = $this.attr('data-action'),
			status = null,
			method =  null,
			pizzomaticContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATIC);
			//pizzomaticContract = new web3.eth.Contract(PIZZOMATIC_ABI, PIZZOMATICTESTNET);

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
		} else if (action == 'reject') {
			status = 'rejected';
		} else if (action == 'airdrop') {
			method = 'airdrop';
		}

		if (action == 'reject') {
			alert('Rejecting a submission is currently a manual process, please reach out to Jdogg or BigMouth');
			// verifyUser(window.walletAddress)
			// .then(function(data) {
			// 	// User validated
			// 	$.ajax({
			// 		type: 'POST',
			// 		url: '/inc/mod-tools',
			// 		dataType: 'json',
			// 		data: {
			// 			userWallet: '0xf39CEB8Ab0DE75Dca31e988fD59D53cC009803E4',
			// 			tokenID: tokenID,
			// 			action: action,
			// 			status: status
			// 		}
			// 	}).done(function(data) {
			// 		console.log(data);
			// 		// Transaction successful, refresh page
			// 		window.location.reload();
			// 	});
			// })
			// .catch(function(err) {
			// 	// User not validated
			// 	console.log('Error: ' + err.message);
			// });
		} else if (action == 'airdrop') {
			let airdropQty = (function ask() {
				let n = prompt('How many ' + tokenName + 's would you like to airdrop to your wallet? (max. 10)', '1');
				// If user hits "cancel" close prompt
				if (n === null) {
				  return;
				}
				// If amount is not a number, or the value is not between 1 and 10, re-prompt
				return isNaN(n) || +n > 10 || +n < 1 ? ask() : n;
			}());

			pizzomaticContract.methods[method](window.walletAddress, tokenID, airdropQty).send({ from:window.walletAddress, amount:0, gasPrice:(gas)})
		} else {
			pizzomaticContract.methods[method](tokenID).send({ from:window.walletAddress, amount:0, gasPrice:(gas)})
			.once('transactionHash', function(hash) {
				console.log(hash);
			})
			.once('confirmation', function(receipt) {
				console.log(receipt);
			})
			.on('receipt', function(receipt) {
				// Once confirmations start rolling in - update token in database
				if (action != 'airdrop') {
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
				}
			});
		}
	});

})( jQuery, window, document );
'use strict';

(function($, window, document, undefined) {

	window.ethereum.request({
		method: "eth_requestAccounts",
	}).then((txHash) => {
		fetch('/inc/save-pizza-test', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			body: 'wallet=' + txHash,
		})
		.then(response => response.json())
  		.then((data) => {
			$('#debug').append(data.wallet);
		})
	})

})( jQuery, window, document );
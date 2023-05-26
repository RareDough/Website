async function setSpendApproval() {
  let gas = await web3.eth.getGasPrice();

  let txn = new web3.eth.Contract(USDC_ABI, USDC);
  await txn.methods.approve( SHOP, SPENDAMOUNT ).send({ from:walletAddress, amount:0, gasPrice:(gas) });

  await allowance();
}

async function buyPizzas() {
  let gas = await web3.eth.getGasPrice();
  let txn = new web3.eth.Contract(SHOP_ABI, SHOP);
  let TOKENID = mintButton.dataset.id;

  await txn.methods.buyPizzas( TOKENID, AMOUNT ).send({ from:walletAddress, amount:0, gasPrice:(gas)});
}

$(function() {
  $('#mintButton').click(function(e) {
    e.preventDefault();
    if (page === 'bitcoin-pizza-80332' || page === 'bitcoin-pizza-79831' || page === 'bitcoin-pizza-80331' || page === 'bitcoin-pizza-79944' || page === 'bitcoin-pizza-79715' || page === 'bitcoin-pizza-79921' || page === 'bitcoin-pizza-79930' || page === 'bitcoin-pizza-80348' || page === 'vip') {
      if ($(this).hasClass('approve')) {
      // set approval
      setSpendApproval();
    } else {
      // buy
      buyPizzas();
    }
    }
    else if (!$(this).hasClass('disabled')) {
      if (!$('#connectBtn').hasClass('connected')) {
        connectWallet();
      } else {
        if (page === 'coldpizza' || page === 'infinity' || page === 'redheadphone' || page === 'vinnypizza' || page === 'chesspizza' || page === 'grafkaalpizza' || page === 'jdoggpizza' || page === 'minguspizza' || page === 'easter23pizza' || page === 'bulksenderpizza' || page === 'corapizza' || page === 'btcday23') {
          // Allow user to specify amount
          let pizzaName = $('.desktopView .itemHeading').text();
          AMOUNT = (function ask() {
            let n = prompt('How many ' + pizzaName + 's would you like to buy? (max. 10)', '1');
            // If user hits "cancel" close prompt
            if (n === null) {
              return;
            }
            // If amount is not a number, or the value is not between 1 and 10, re-prompt
            return isNaN(n) || +n > 10 || +n < 1 ? ask() : n;
          }());
          buyPizzas();
        } else {
          AMOUNT = 1;
          buyPizzas();
        }
      }
    }
  });
});


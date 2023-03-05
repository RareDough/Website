const AMOUNT = 1;

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

  console.log(TOKENID);

  await txn.methods.buyPizzas( TOKENID, AMOUNT ).send({ from:walletAddress, amount:0, gasPrice:(gas)});
}

$(function() {
  $('#mintButton').click(function(e) {
    e.preventDefault();
    if (page === 'bitcoin-pizza-80332' || page === 'bitcoin-pizza-79831' || page === 'bitcoin-pizza-80331' || page === 'bitcoin-pizza-79944' || page === 'bitcoin-pizza-79715' || page === 'bitcoin-pizza-79921' || page === 'bitcoin-pizza-79930' || page === 'bitcoin-pizza-80348' || page === 'coldpizza') {
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
        buyPizzas();
      }
    }
  });
});


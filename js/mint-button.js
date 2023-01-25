const AMOUNT = 1;

async function setSpendApproval() {
  let gas = await web3.eth.getGasPrice();

  let txn = new web3.eth.Contract(BREAD_ABI, BREAD);
  await txn.methods.approve( SHOP, SPENDAMOUNT ).send({ from:walletAddress, amount:0, gasPrice:(gas*3) });

  await allowance();
}

async function buyPizzas() {
  let gas = await web3.eth.getGasPrice();
  let txn = new web3.eth.Contract(SHOP_ABI, SHOP);
  let TOKENID = mintButton.dataset.id;

  console.log(TOKENID);

  await txn.methods.buyPizzas( TOKENID, AMOUNT ).send({ from:walletAddress, amount:0, gasPrice:(gas*3)});
}

$(function() {
  $('#mintButton').click(function(e) {
    e.preventDefault();
    if ($(this).hasClass('approve')) {
      // set approval
      setSpendApproval();
    } else {
      // buy
      buyPizzas();
    }
  });
});
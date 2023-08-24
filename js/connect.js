let web3 = null,
    walletAddress = null,
    chainID = null,
    pizzaHoldings = [];
    breadHoldings = null;

const truncateRegex = /^(0x[a-zA-Z0-9]{3})[a-zA-Z0-9]+([a-zA-Z0-9]{3})$/;
const provider = window.ethereum;
const SPENDAMOUNT = '25000000';
const SHOP_ABI = top.abi_shop;
const SHOP = '0xf829FDF890B800d2be08BEA228142726FeD3E71d';
const PIZZA = '0x2953399124F0cBB46d2CbACD8A89cF0599974963';
const PIZZA_ABI = top.abi_pizza;
const BREAD = '0xb8e57A05579b1F4c42DEc9e18E0b665B0dB5277f';
const BREADTESTNET = '0x3f080FC578D7879e701e54A6E78442b201F979A2';
const BREAD_ABI = top.abi_coin;
const BREAD_IMG = 'https://www.raredough.com/img/BAPC-coin.svg';
const inventoryContainer = document.getElementById('inventoryContainer');
const USDC = '0x2791Bca1f2de4661ED88A30C99A7a9449Aa84174';
const USDC_ABI = top.abi_usdc;
const PIZZOMATIC_ABI = top.abi_pizzomatic;
const PIZZOMATIC = '0x3c3CCd492c4a11f5D1744709793Ff5Cf40098019';
const PIZZOMATICTESTNET = '0xD8126E091148A5b056393b19191eb2b6a7D8d736';

// Specify which libray/oven to use
let LIBRARY = null,
    OVEN = null,
    OVEN_ABI = null;

if (page === 'burn-ovenv2') {
   LIBRARY = top.raredoughlib;
   OVEN = '0x2d67a8e2759942F77167438a3e8785Af4c04068e';
   OVEN_ABI = top.abi_ovenv2;
} else {
   LIBRARY = top.pizzalib;
   OVEN = '0x7e410FcF59dd30bC09E9ad21b008D36b907fC86B';
   OVEN_ABI = top.abi_oven;      
}

if (provider) {
   web3 = new Web3(window.ethereum);
}

function truncateAddress(address) {
   let match = address.match(truncateRegex);
   if (!match)
      return address;
   return match[1] + "\u2026" + match[2];
};

async function populateWalletData() {
   // CHECK IF USER IS ON CORRECT CHAIN
   chainID = await web3.eth.getChainId();
   if (chainID != 137 && chainID != 80001) {
      await window.ethereum.request({
         method: 'wallet_switchEthereumChain',
         params: [{chainId: '0x89'}],
      });
      window.location.reload();
   }

   // POPULATE WALLET DATA
   let walletTruncated = truncateAddress(walletAddress);
   connectBtn.querySelector('span').innerHTML = walletTruncated;
   connectBtn.classList.add('connected');
   connectBtn.setAttribute('data-bs-toggle', 'dropdown');

   // CHANGE MINT BUTTON TEXT IF CONNECTED
   if (document.getElementById('mintButton')) {
      mintButton.innerHTML = 'Buy Now';
   }

   // POPULATE WALLET ADDRESS IF ACCOUNT PAGE
   if(document.querySelector('.wallet-address')){
      document.querySelector('.wallet-address').innerHTML = walletTruncated;
      document.querySelector('.wallet-address').setAttribute('data-copy', walletAddress);
      walletCont.style.display = 'block';
   }

   //PULL PIZZA DATA AND STORE IT LOCALLY
   await getUserAssets();

   // IF BURN OVEN OR PRODUCTPAGE, CHECK APPROVAL
   if (page === 'burn-oven' || page === 'bitcoin-pizza-80332' || page === 'bitcoin-pizza-79831' || page === 'bitcoin-pizza-80331' || page === 'bitcoin-pizza-79944' || page === 'bitcoin-pizza-79715' || page === 'bitcoin-pizza-79921' || page === 'bitcoin-pizza-79930' || page === 'bitcoin-pizza-80348' || page === 'vip') {
      await checkApproval();
   }
}

async function connectWallet() {
   // CONNECT TO USER WALLET
   if (provider) {
      await window.ethereum.request({ method: 'eth_requestAccounts' });
      const account = web3.eth.accounts;
      walletAddress = account.givenProvider.selectedAddress;
      window.walletAddress = walletAddress;

      // POPULATE WALLET DATA
      populateWalletData();
     
   } else {
      console.log('No wallet detected');
   }
}

async function checkConnection() {
   if (provider) {
      window.ethereum.sendAsync({
         method: 'eth_accounts',
         params: [],
         jsonrpc: '2.0',
         id: new Date().getTime()
      },
      function(error, result) {
         if (result['result'] != '') {
            // if wallet found, populate data or else do nothing
            handleAccountsChanged(result['result']);
         }
      });
   } else {
      console.log('Wallet software not detected');
   }
}

async function handleAccountsChanged(accounts) {
   if (accounts[0] !== walletAddress) {
      walletAddress = accounts[0];

      // Load wallet data
      populateWalletData();
   }
}

async function getUserAssets() {
   let jlength = LIBRARY.length,
       pizzaTxn = null,
       walletArray = [],
       pizzaIdArray = [];

   for (i=0; i<jlength; i++) {
      pizzaIdArray.push(LIBRARY[i]['tokenid']);
      walletArray.push(walletAddress);
   }

   if (page === 'burn-ovenv2') {
      pizzaTxn = new web3.eth.Contract(SHOP_ABI, SHOP);
   } else {
      pizzaTxn = new web3.eth.Contract(PIZZA_ABI, PIZZA);
   }
   pizzaHoldings = await pizzaTxn.methods.balanceOfBatch(walletArray, pizzaIdArray).call();

   let breadTxn = new web3.eth.Contract(BREAD_ABI, BREAD);
   breadHoldings = await breadTxn.methods.balanceOf(walletAddress).call();
   breadHoldings = web3.utils.fromWei(breadHoldings, 'ether');

   let breadBalanceEles = document.querySelectorAll('.bread-balance');
   for(var i=0;i<breadBalanceEles.length;i++) {
      breadBalanceEles[i].innerHTML = parseFloat(breadHoldings).toLocaleString();
   }

   /* If shop page check if balance is sufficient */
   if (document.getElementById('mintButton')) {
      let itemPrice = mintButton.dataset.price;
      if (parseFloat(itemPrice) > parseFloat(breadHoldings)) {
         // user does not have enough BREAD
         mintButton.classList.add('disabled');
         mintButton.innerHTML = 'Insufficient $BREAD';
      }
   }

   /* Account Inventory */
   if (inventoryContainer) {
      inventoryContainer.innerHTML = '';
      let totalInventoryQuantity = 0;
          totalValue = 0;

      for (const [i, quantity] of pizzaHoldings.entries()) {
         // if token is held
         if (quantity !== '0') {
            let tokenName = LIBRARY[i]['name'],
                imageName = tokenName.replace(/\s+/g, '-').toLowerCase(),
                category = LIBRARY[i]['category'],
                value = LIBRARY[i]['price'];

            // build HTML
            if (page === 'burn-oven' || page === 'burn-ovenv2') {
               pizzaEle = `<div class="col-3">
                              <div class="itemImageParent inventoryItem" data-token-name="${tokenName}" data-image-name="${imageName}" data-quantity="${quantity}" data-value="${value}" data-index="${i}">
                                 <span class="itemRate">${quantity}</span>
                                 <img
                                   class="itemImg"
                                   src="./img/pizzas/${imageName}.jpg"
                                   alt="${tokenName}"
                                 />
                              </div>
                           </div>`;
            } else {
               pizzaEle = `<div class="col inventoryItem mt-4">
                                 <div class="shopCard">
                                    <img
                                       class="shopCardImg"
                                       src="./img/pizzas/${imageName}.jpg"
                                       alt=""
                                    />
                                    <div class="shopCardFooter">
                                       <p class="category">${category}</p>
                                       <p class="cardText">${tokenName}</p>
                                       <p class="cardText odd d-flex align-items-center justify-content-start">
                                          <img class="me-2" src="./img/bpac-sm-icon.svg" alt="" /> ${value.toLocaleString()}
                                       </p>
                                       <a href="#" class="mainBtn light shopBtn">Mint Now</a>
                                    </div>
                                 </div>
                              </div>`;
            }

            // increment total quantity
            totalInventoryQuantity += parseInt(quantity);

            // increment total value
            totalValue += (value * quantity);

            // populate inventory and value
            inventoryContainer.insertAdjacentHTML('beforeend', pizzaEle);
         }
      }

      if (page === 'burn-oven' || page === 'burn-ovenv2') {
         document.querySelector('#totalInventoryQuantity span').innerHTML = parseFloat(totalInventoryQuantity).toLocaleString();
      }

      let breadValueEles = document.querySelectorAll('.pizza-bread-value');
      for (var i = 0; i < breadValueEles.length; i++) {
         breadValueEles[i].innerHTML = parseFloat(totalValue).toLocaleString();
      }
   }
}

async function addToWallet(tokenAddress, tokenSymbol, tokenImage) {
   if (window.ethereum) {
      const wasAdded = await ethereum.request({
         method: 'wallet_watchAsset',
         params: {
            type: 'ERC20',
            options: {
               address: tokenAddress,
               symbol: tokenSymbol,
               decimals: 18,
               image: tokenImage
            }
         }
      })
      if (wasAdded) {
         console.log('$'+tokenSymbol+' added to wallet.');
      }
   }
}

async function setApproval() {
   let gas = await web3.eth.getGasPrice();

   let txn = new web3.eth.Contract(PIZZA_ABI, PIZZA);
   await txn.methods.setApprovalForAll( OVEN, true ).send({ from:walletAddress, amount:0, gasPrice:(gas) });

   await checkApproval();
}

async function checkApproval() {
   let txn = null,
       isApproved = null;

   if (page === 'burn-oven') {
      txn = new web3.eth.Contract(PIZZA_ABI, PIZZA);
      isApproved = await txn.methods.isApprovedForAll(walletAddress, OVEN).call();

      if (!isApproved) {
         burnButton.innerHTML = 'APPROVE';
         burnButton.classList.add('approve');
         burnButton.style.display = 'inline-block';
      }
   } else if (page === 'bitcoin-pizza-80332' || page === 'bitcoin-pizza-79831' || page === 'bitcoin-pizza-80331' || page === 'bitcoin-pizza-79944' || page === 'bitcoin-pizza-79715' || page === 'bitcoin-pizza-79921' || page === 'bitcoin-pizza-79930' || page === 'bitcoin-pizza-80348' || page === 'vip') {
      txn = new web3.eth.Contract(USDC_ABI, USDC);
      isApproved = await txn.methods.allowance(walletAddress, SHOP).call();

      console.log(isApproved);

      if (isApproved < 25000000) {
         mintButton.innerHTML = 'APPROVE';
         mintButton.classList.add('approve');
         mintButton.style.display = 'inline-block';
      }

   }
}

$(function() {
   $('#connectBtn').click(function() {
      if (!$(this).hasClass('connected')) {
         connectWallet();
      }
   });

   checkConnection();
});


let web3 = null,
    walletAddress = null,
    chainID = null,
    pizzaHoldings = [];
    breadHoldings = null;

const truncateRegex = /^(0x[a-zA-Z0-9]{3})[a-zA-Z0-9]+([a-zA-Z0-9]{3})$/;
const provider = window.ethereum;
const SPENDAMOUNT = '10000000000000000000000000000';
const SHOP_ABI = top.abi_shop;
const SHOP = '0x37322BF16cCF75FDCF2eE22B4361913b0FaCba49'; //Shop Contract
const PIZZA = '0x2953399124F0cBB46d2CbACD8A89cF0599974963'; //OpenSea ERC1155
const PIZZA_ABI = top.abi_pizza;
const BREAD = '0xb8e57A05579b1F4c42DEc9e18E0b665B0dB5277f'; //Bread address
const BREAD_ABI = top.abi_coin;
const BREAD_IMG = 'https://www.boredpizzas.com/img/BAPC-coin.svg';
const OVEN = '0x7e410FcF59dd30bC09E9ad21b008D36b907fC86B'; //Oven address
const OVEN_ABI = top.abi_oven;      
const LIBRARY = top.pizzalib;
const inventoryContainer = document.getElementById('inventoryContainer');

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
   if (chainID != 137) {
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
   if(document.querySelector('.wallet-address')){
      document.querySelector('.wallet-address').innerHTML = walletTruncated;
      document.querySelector('.wallet-address').setAttribute('data-copy', walletAddress);
      walletCont.style.display = 'block';
   }

   //PULL PIZZA DATA AND STORE IT LOCALLY
   await getUserAssets();

   // IF BURN OVEN OR PRODUCTPAGE, CHECK APPROVAL
   if (page === 'burn-oven' || page === 'freemint' || page === 'infinity' || page === 'whitelist-lvl1' || page === 'whitelist-lvl2' || page === 'whitelist-lvl3' || $page === 'airdrop-pass' || $page === 'custom-pizza-V1' || $page === 'twitter-promo') {
      await checkApproval();
   }
}

async function connectWallet() {
   // CONNECT TO USER WALLET
   if (provider) {
      await window.ethereum.request({ method: 'eth_requestAccounts' });
      const account = web3.eth.accounts;
      walletAddress = account.givenProvider.selectedAddress;

      // POPULATE WALLET DATA
      populateWalletData();
     
   } else {
      console.log('No wallet detected');
   }
}

async function checkConnection() {
   if (provider) {
      await ethereum.request({ method: 'eth_accounts' }).then(handleAccountsChanged).catch(console.error);
   } else {
      console.log('No wallet detected');
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
   let jlength = LIBRARY.length
   let walletArray = [];
   let pizzaIdArray = [];

   for (i=0; i<jlength; i++) {
      pizzaIdArray.push(LIBRARY[i]['tokenid']);
      walletArray.push(walletAddress);
   }

   let pizzaTxn = new web3.eth.Contract(PIZZA_ABI, PIZZA);
   pizzaHoldings = await pizzaTxn.methods.balanceOfBatch(walletArray, pizzaIdArray).call();

   let breadTxn = new web3.eth.Contract(BREAD_ABI, BREAD);
   breadHoldings = await breadTxn.methods.balanceOf(walletAddress).call();
   breadHoldings = web3.utils.fromWei(breadHoldings, 'ether');

   let breadBalanceEles = document.querySelectorAll('.bread-balance');
   for(var i=0;i<breadBalanceEles.length;i++) {
      breadBalanceEles[i].innerHTML = parseFloat(breadHoldings).toLocaleString();
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
            if (page === 'burn-oven') {
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

      if (page === 'burn-oven') {
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
   await txn.methods.setApprovalForAll( OVEN, true ).send({ from:walletAddress, amount:0, gasPrice:(gas*3) });

   await checkApproval();
}

async function checkApproval() {
   let txn = null,
       isApproved = null;

   if (page === 'burn-oven') {
      txn = new web3.eth.Contract(PIZZA_ABI, PIZZA);
      isApproved = await txn.methods.isApprovedForAll(walletAddress, OVEN).call();

      console.log(isApproved);

      if (!isApproved) {
         burnButton.innerHTML = 'APPROVE';
         burnButton.classList.add('approve');
         burnButton.style.display = 'inline-block';
      }
   } else if (page === 'freemint' || page === 'infinity' || page === 'whitelist-lvl1' || page === 'whitelist-lvl2' || page === 'whitelist-lvl3' || $page === 'airdrop-pass' || $page === 'custom-pizza-V1' || $page === 'twitter-promo') {
      txn = new web3.eth.Contract(BREAD_ABI, BREAD);
      isApproved = await txn.methods.allowance(walletAddress, SHOP).call();

      console.log(isApproved);

      if (isApproved < 9900000000000000000000000000) {
         mintButton.innerHTML = 'APPROVE';
         mintButton.classList.add('approve');
      }

      mintButton.style.display = 'inline-block';
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

// async function allowance() {
//    let txn = new web3.eth.Contract(BREAD_ABI, BREAD);
//    let isApproved = await txn.methods.allowance( walletAddress, SHOP ).call();

//    if (isApproved < 999999) {
//       mintButton.innerHTML = 'APPROVE';
//       mintButton.classList.add('approve');
//    }

//    mintButton.style.display = 'inline-block';
// }
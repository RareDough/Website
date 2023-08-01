document.addEventListener('DOMContentLoaded', function () {
   const category = shopSection.dataset.category;

   if (category == 'all') {
      for (var i = 0; i < pizzaArray.length; i++) {
         fetch(`./assets/${pizzaArray[i]}.json`)
         .then((response) => {
            return response.json()
         }).then(function(item) {
            let itemStatus = item.attributes[0].value,
               itemName = item.name,
               itemImage = item.image,
               itemPrice = item.attributes[2].value.split(' '),
               itemCategory = item.attributes[1].value,
               itemLink = item.external_link,
               shopItem = `<div class="col mt-4">
                           <a class="link" href="${itemLink}">
                              <div class="shopCard">
                                 <img class="shopCardImg" src="${itemImage}" alt="${itemName}" />
                                 <div class="shopCardFooter">
                                    <p class="category">${itemCategory}</p>
                                    <p class="cardText">${itemName}</p>
                                    <p class="cardText odd d-flex align-items-center justify-content-start"><img class="me-2" src="./img/bpac-sm-icon.svg" alt="">${parseInt(itemPrice[0]).toLocaleString()}</p>
                                 </div>
                                 </a>
                           </div>`;
                           
            if (itemStatus != 'inactive') {
               shopContainer.insertAdjacentHTML('beforeend', shopItem);
            }
         }).catch((ex) => {
            console.log('parsing failed', ex);
         });
      }

      for (var i = 0; i < communityPizzas.length; i++) {
         fetch(`./assets/community/${communityPizzas[i]}.json`)
         .then((response) => {
            return response.json()
         }).then(function(item) {
            let itemStatus = item.attributes[0].value,
               itemName = item.name,
               itemImage = item.image,
               itemPrice = item.attributes[2].value.split(' '),
               itemCategory = item.attributes[1].value,
               itemLink = item.external_link,
               shopItem = `<div class="col mt-4">
                           <a class="link" href="${itemLink}">
                              <div class="shopCard">
                                 <img class="shopCardImg" src="${itemImage}" alt="${itemName}" />
                                 <div class="shopCardFooter">
                                    <p class="category">${itemCategory}</p>
                                    <p class="cardText">${itemName}</p>
                                    <p class="cardText odd d-flex align-items-center justify-content-start"><img class="me-2" src="./img/bpac-sm-icon.svg" alt="">${parseInt(itemPrice[0]).toLocaleString()}</p>
                                 </div>
                                 </a>
                           </div>`;
   
            if (itemStatus != 'inactive') {
               shopContainer.insertAdjacentHTML('beforeend', shopItem);
            }
         }).catch((ex) => {
            console.log('parsing failed', ex);
         });
      }
   } else {
      if (category == 'community pizza') {
         pizzaDir = './assets/community/';
      } else {
         pizzaDir = './assets/';
      }

      for (var i = 0; i < pizzaArray.length; i++) {
         fetch(`${pizzaDir}${pizzaArray[i]}.json`)
         .then((response) => {
            return response.json()
         }).then(function(item) {
            let itemStatus = item.attributes[0].value,
               itemName = item.name,
               itemImage = item.image,
               itemPrice = item.attributes[2].value.split(' '),
               itemCategory = item.attributes[1].value,
               itemLink = item.external_link,
               shopItem = `<div class="col mt-4">
                           <a class="link" href="${itemLink}">
                              <div class="shopCard">
                                 <img class="shopCardImg" src="${itemImage}" alt="${itemName}" />
                                 <div class="shopCardFooter">
                                    <p class="category">${itemCategory}</p>
                                    <p class="cardText">${itemName}</p>
                                    <p class="cardText odd d-flex align-items-center justify-content-start"><img class="me-2" src="./img/bpac-sm-icon.svg" alt="">${parseInt(itemPrice[0]).toLocaleString()}</p>
                                 </div>
                                 </a>
                           </div>`;

            if (category === itemCategory.toLowerCase() && itemStatus != 'inactive') {
               shopContainer.insertAdjacentHTML('beforeend', shopItem);
            }
         }).catch((ex) => {
            console.log('parsing failed', ex);
         });
      }
   }
}, false);
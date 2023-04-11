document.addEventListener('DOMContentLoaded', function () {
   const category = shopSection.dataset.category;
   console.log(category);
   for (a = 1; a < 25; a++) {
     if (a === 10 || a === 11 || a === 12 || a === 13 || a === 14 || a === 15 || a === 16 || a === 17) {
         continue;
      }
      let itemIndex = a;
      fetch(`./assets/${a}.json`)
         .then((response) => {
            return response.json()
         }).then(function(item) {
            let itemName = item.name,
                itemPrice = item.attributes[1].value.split(' '),
                itemCategory = item.attributes[0].value,
                itemLink = item.external_link,
                shopItem = `<div class="col mt-4">
                            <a class="link" href="${itemLink}">
                              <div class="shopCard">
                                 <img class="shopCardImg" src="./img/pizzas/${itemName.replace(/\s+/g, '-').toLowerCase()}.webp" alt="${itemName}">
                                 <div class="shopCardFooter">
                                    <p class="category">${itemCategory}</p>
                                    <p class="cardText">${itemName}</p>
                                    <p class="cardText odd d-flex align-items-center justify-content-start"><img class="me-2" src="./img/bpac-sm-icon.svg" alt="">${parseInt(itemPrice[0]).toLocaleString()}</p>
                                 </div>
                                 </a>
                           </div>`;
                    

           
            // populate inventory and value
            if (category === 'all') {
               shopContainer.insertAdjacentHTML('beforeend', shopItem);
            } else if (category === itemCategory.toLowerCase()) {
               shopContainer.insertAdjacentHTML('beforeend', shopItem);
            }
         }).catch((ex) => {
            console.log('parsing failed', ex);
         });
   }
}, false);
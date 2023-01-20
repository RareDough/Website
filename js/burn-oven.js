let selectedTokenIds = [],
    selectedAmounts = [];

async function burnPizzas() {
  let gas = await web3.eth.getGasPrice();
  let txn = new web3.eth.Contract(OVEN_ABI, OVEN);

  await txn.methods.burnPizzaBatch( selectedTokenIds, selectedAmounts ).send({ from:walletAddress, amount:0, gasPrice:(gas*3)});

  // empty burn table
  burnList.innerHTML = '';
}

$(function() {
  // Inventory hover
  $(document).on('mouseenter', '.inventoryItem:not(.placeholder)', function() {
    const $this = $(this);
    const name = $this.attr('data-token-name');
    const image = $this.attr('data-image-name');
    const quantity = $this.attr('data-quantity');
    const value = $this.attr('data-value');
    const index = $this.attr('data-index');

    const $infoWindow = `
      <div class="pizzaImage"><img src="img/pizzas/${image}.jpg" alt="${name}"></div>
      <div class="pizzaInfo">
        <span>${name} Pizza</span>
        <div>
          <span>Burn for BREAD</span>
          <span>+<img src="img/BAPC-coin.svg" alt="Bread Coin" />${value}</span>
        </div>
      </div>
    `;

    const width = $this.width();
    const diff = (width - 145) / 2;
    const left = $this.position().left + (width + 10);
    const top = $this.position().top + diff;
    $('#inventoryItemHover').css({top: top,left: left}).show();

    $('#inventoryItemHover').html($infoWindow);
  });
  $(document).on('mouseleave', '.inventoryItem:not(.placeholder)', function() {
    $('#inventoryItemHover').hide();
  });

  // Build out burn table
  $(document).on('click', '.inventoryItem:not(.placeholder):not(.disabled)', function() {
    const $this = $(this);
    $this.addClass('disabled');

    // get token values
    const name = $this.attr('data-token-name');
    const image = $this.attr('data-image-name');
    const quantity = $this.attr('data-quantity');
    const value = $this.attr('data-value');
    const index = $this.attr('data-index');

    // build out table row
    const $tableRow = `<div class="burnListContainer" data-index="${index}" data-value="${value}" data-quantity="${quantity}">
                        <div class="burnImgArea">
                          <img class="burnListImg" src="./img/pizzas/${image}.jpg" alt="${name}">
                          <span class="burilistText">Genesis Pizza #8</span>
                        </div>
                        <div class="customCounter">
                          <a class="countBtn add ${quantity == 1 ? 'disabled' : ''}" href="#"><i class="fa-solid fa-square-plus"></i></a>
                          <div class="burilistText quantity">1</div>
                          <a class="countBtn sub" href="#">
                            <i class="fa-solid fa-square-minus"></i>
                          </a>
                        </div>
                        <div class="rightArea">
                          <div class="burilistText d-flex align-items-center justify-content-end">
                            <img class="me-2" src="./img/bpac-sm-icon.svg" alt=""><span class="me-2">${value}</span>
                            <a class="trashBtn" href="#">
                              <img src="./img/trash-icon.svg" alt="">
                            </a>
                          </div>
                        </div>
                      </div>`;

    // add row to table
    $('#burnList').prepend($tableRow);

    // loop over table rows
    getRows();
  });

  // Increase/decrease quantity
  $(document).on('click', 'a.add:not(.disabled), a.sub', function(e) {
    e.preventDefault();
    const $this = $(this);
    const $tableRow = $this.closest('.burnListContainer');
    const quantity = parseInt($tableRow.attr('data-quantity'));
    const value = parseFloat($tableRow.attr('data-value'));
    const index = $tableRow.attr('data-index');
    let amount = parseInt($('.quantity', $tableRow).text());
    let totalValue = value;
    if ($this.hasClass('add')) {
      amount++;
      if (amount === quantity) {
        $this.addClass('disabled');
      }
    } else {
      amount--;
      $('a.add', $tableRow).removeClass('disabled');
      if (amount === 0) {
        $tableRow.remove();
        $('.inventoryItem[data-index="'+index+'"]').removeClass('disabled');
      }
    }

    // calculate row total
    totalValue = (amount * value);
    $('.quantity', $tableRow).text(amount);
    $('.value span', $tableRow).text(totalValue);

    // loop over table rows
    getRows();
  });

  // Delete row 
  $(document).on('click', 'a.trashBtn', function(e) {
    e.preventDefault();
    const $this = $(this);
    const $tableRow = $this.closest('.burnListContainer');
    const index = $tableRow.attr('data-index');
    $tableRow.remove();
    $('.inventoryItem[data-index="'+index+'"]').removeClass('disabled');

    // loop over table rows
    getRows();
  });

  // Loop over table row function
  function getRows() {
    selectedTokenIds = [];
    selectedAmounts = [];
    let totalBurnValue = 0;
    let totalQuantity = 0;

    const rowCount = $('#burnList .burnListContainer').length;
    // if (rowCount > 0) {
    //   $('#burn table thead').show();
    //   $('#burn .tableFooter').show();
    // } else {
    //   $('#burn table thead').removeAttr('style');
    //   $('#burn .tableFooter').removeAttr('style');
    // }

    $('#burnList .burnListContainer').each(function(i) {
      const $tableRow = $(this);
      const tokenIndex = $tableRow.attr('data-index');
      const quantity = $('.quantity', $tableRow).text();
      const value = parseFloat($tableRow.attr('data-value'));

      selectedTokenIds.push(LIBRARY[tokenIndex]['tokenid']);
      selectedAmounts.push(quantity);

      totalQuantity += parseInt(quantity);
      totalBurnValue += (value * quantity);
    });

    // SHOW BURN BUTTON IF PIZZAS SELECTED OTHERWISE HIDE
    if (totalQuantity > 0) {
      $('#burnButton').css('display', 'inline-block');
    } else {
      $('#burnButton').hide();
    }

    // UPDATE QUANTITY SELECTED AND BURN VALUE
    $('#totalQuantity').text(totalQuantity);
    $('#totalBurnValue').text(totalBurnValue.toLocaleString());
  }

  function clearTable() {
    $('#burn tbody').html('');
  }

  $('#addToWallet').click(function(e) {
    e.preventDefault();
    // Add $BREAD to wallet
    addToWallet(BREAD, 'BREAD', BREAD_IMG)
  });

  $('#burnButton').click(function(e) {
    e.preventDefault();
    if ($(this).hasClass('approve')) {
      // set approval
      setApproval();
    } else {
      // burn
      burnPizzas();
    }
  });
});
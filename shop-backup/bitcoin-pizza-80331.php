<?php 
  include 'header.php';
  $itemData = file_get_contents('./assets/17.json');
  $itemDecoded = json_decode($itemData, false);

  $itemName = $itemDecoded->name;
  $itemDescription = $itemDecoded->description;
  $itemImage = $itemDecoded->image;
  $itemAttributes = $itemDecoded->attributes;
  $itemPrice = get_object_vars($itemAttributes[1])['value'];
?>

<!-- Infinity Section -->
<section class="infinitySection item">
  <!-- mobile view -->
  <div class="mobileView">
    <div class="container text-start">
      <h1 class="mainHeading itemHeading"><?= $itemName ?></h1>
      <a class="imageLink" href="#">
        <img
          class="pizzaImg"
            src="./img/pizzas/<?= (str_replace(' ', '-', strtolower($itemName))); ?>.jpg"
            alt="<?= $itemName ?>"
        />
      </a>
    </div>
  </div>

  <div class="container">
    <div class="row">

      <div class="col-lg-5 mt-4 mt-lg-0 desktopView">
        <a class="imageLink" href="#">
          <img
            class="pizzaImg"
            src="./img/pizzas/<?= (str_replace(' ', '-', strtolower($itemName))); ?>.jpg"
            alt="<?= $itemName ?>"
          />
        </a>
      </div>
      <div class="col-lg-7">
        <div class="desktopView">
          <h1 class="mainHeading itemHeading"><?= $itemName ?></h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="description mt-5 mb-5 mt-lg-0 mb-lg-0">
              <h1 class="subHeading">Description</h1>
              <div class="descriptionBody">
                <p class="mainText itemDescription"><?= $itemDescription ?></p>
                <div class="mainText">Current Price</div>
                <h1 class="mainHeading">
                  <img src="./img/bpac-lg-icon.svg" alt="" /> <?= str_replace(' BREAD','',$itemPrice); ?>
                </h1>
                <div class="row ">
                  <div class="col-lg-6 ">
                    <a id="mintButton" data-id="17" class="mainBtn light" data-price="<?= str_replace(' USDC','',$itemPrice); ?>" href="#">Connect Wallet</a>
                  </div>
                  <div class="col-lg-6 ">
                    <a href="https://app.uniswap.org/#/tokens/polygon/0x2791bca1f2de4661ed88a30c99a7a9449aa84174" target="_blank" class="mainBtn dark">Buy USDC</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-lg-4">
          <div class="col-lg-6">
            <a class="btn btn-primary collapseBtn" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false" aria-controls="collapseExample">
              <span>Properties</span>
              <img src="./img/downArrow.svg" alt="">
            </a>
            <div class="collapse" id="property">
              <div class="card card-body">
                <div class="cardContainer">
                  <div class="row">
                    <?php foreach ($itemAttributes as $attribute): if (get_object_vars($attribute)['trait_type'] !== 'Price'): ?>
                      <div class="col">
                        <div class="collapesCard">
                          <div class="smText"><?= get_object_vars($attribute)['trait_type']; ?></div>
                          <div class="mainText"><?= get_object_vars($attribute)['value']; ?></div>
                        </div>
                      </div>
                    <?php endif; endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <a class="btn btn-primary collapseBtn" data-bs-toggle="collapse" href="#token" role="button" aria-expanded="false" aria-controls="collapseExample">
              <span>Token Details</span>
              <img src="./img/downArrow.svg" alt="">
            </a>
            <div class="collapse" id="token">
              <div class="card card-body">
                <table>
                  <tbody>
                    <tr>
                      <td class="smText">Token ID</td>
                      <td class="mainText">12</td>
                    </tr>
                    <tr>
                      <td class="smText">Blockchain</td>
                      <td class="mainText">Polygon</td>
                    </tr>
                    <tr>
                      <td class="smText">Token Standard</td>
                      <td class="mainText">ERC1155</td>
                    </tr>
                    <tr>
                      <td class="smText">Contract</td>
                      <td class="mainText"> <a href="https://polygonscan.com/address/0xf829FDF890B800d2be08BEA228142726FeD3E71d">Polygonscan <img src="./img/collapesArrow.svg" alt=""></a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

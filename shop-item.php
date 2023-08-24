<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'header.php';

// Contract address
$contract = '0xf829FDF890B800d2be08BEA228142726FeD3E71d';

// Get ID param
$id = $_GET['id'];
$itemData = null;

// If type is set get type param
if (isset($_GET['type'])) :
    $pizzaType = $_GET['type'];

    if ($pizzaType == 'community'):
        $itemData = file_get_contents('./assets/community/' . $id . '.json');
        $contract = '0x4f65ca65362B284739F033611b8d3d84e70EdB10';
    endif;
else :
    $itemData = file_get_contents('./assets/' . $id . '.json');
endif;

$itemDecoded = json_decode($itemData, false);

$itemName = $itemDecoded->name;
$itemImage = $itemDecoded->image;
$itemDescription = $itemDecoded->description;
$itemImage = $itemDecoded->image;
$itemAttributes = $itemDecoded->attributes;
$itemStatus = get_object_vars($itemAttributes[0])['value'];
$soldOut = get_object_vars($itemAttributes[0])['soldout'];
$itemPrice = get_object_vars($itemAttributes[2])['value'];
?>

<!-- Infinity Section -->
<section
    class="infinitySection item">
    <!-- mobile view -->
    <div class="mobileView">
        <div class="container text-start">
            <h1 class="mainHeading itemHeading"><?= $itemName ?></h1>
            <a class="imageLink" href="#">
                <img class="pizzaImg" src="<?= $itemImage; ?>" alt="<?= $itemName ?>"/>
            </a>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-5 mt-4 mt-lg-0 desktopView">
                <a class="imageLink" href="#">
                <img class="pizzaImg" src="<?= $itemImage; ?>" alt="<?= $itemName ?>"/>
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
                                <?php if (!$soldOut && $itemStatus != 'disabled') : ?>
                                    <div class="mainText">Current Price</div>
                                <?php endif; ?>
                                <h1 class="mainHeading">
                                    <?php if ($soldOut) : ?>
                                        Sold Out
                                    <?php elseif ($itemStatus == 'disabled' || $itemStatus == 'paused') : ?>
                                        Unavailable
                                    <?php else : ?>
                                        <img src="./img/bpac-lg-icon.svg" alt=""/>
                                        <?= str_replace(' BREAD', '', $itemPrice); ?>
                                    <?php endif; ?>
                                </h1>
                                <?php if ($itemStatus != 'disabled' && $itemStatus != 'paused') : ?>
                                    <div class="row ">
                                        <div class="col-lg-6 ">
                                            <?php if ($soldOut) : ?>
                                                <a class="mainBtn light" href="https://opensea.io/assets/matic/<?= $contract; ?>/<?= $id; ?>" target="_blank">Buy on Opensea</a>
                                            <?php else : ?>
                                                <a id="mintButton" data-id="<?= $id; ?>" class="mainBtn light" data-price="<?= str_replace(' BREAD', '', $itemPrice); ?>" href="#">Connect Wallet</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <a href="https://app.uniswap.org/#/tokens/polygon/0xb8e57A05579b1F4c42DEc9e18E0b665B0dB5277f" target="_blank" class="mainBtn dark">Buy BREAD</a>
                                        </div>
                                    </div>
                                <?php endif; ?>
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
                                        <?php foreach ($itemAttributes as $attribute):
                                            if (get_object_vars($attribute)['trait_type'] !== 'Price' && get_object_vars($attribute)['trait_type'] !== 'Status'): ?>
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
                                            <td class="mainText"><?= $id; ?></td>
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
                                            <td class="mainText">
                                                <a href="https://polygonscan.com/address/<?= $contract; ?>">Polygonscan
                                                    <img src="./img/collapesArrow.svg" alt="Collapse">
                                                </a>
                                            </td>
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
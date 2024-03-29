<?php

include 'header.php';

include_once 'inc/functions.php';
$pdo = pdo_connect_mysql();

// Get submissions sorted by token ID
$stmt = $pdo->prepare('SELECT * FROM submissions WHERE status != ? ORDER BY ID DESC');

$stmt->execute([ 'created' ]);
$pizzas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section id="mint-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <h1 class="mainHeading">Pizza Oven</h1>
            </div>
        </div>
    </div>
</section>
<section id="pizza-oven-table">
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-between">
                <div class="creator-filter">
                    <a class="active" data-creator="all" href="#">All Pizzas</a>
                    <a data-creator="user" href="#">Your Pizzas</a>
                </div>
                <!-- <div class="pizza-sort">
                    <a class="list-view active" data-view="list" href="#">List View</a>
                    <a class="grid-view" data-view="grid" href="#">Grid View</a>
                </div> -->
            </div>
        </div>
        <div id="pizza-oven">
            <div class="row">
                <div class="col">
                    <div class="pizza-oven-headings">
                        <div class="pizza-item-heading">Item</div>
                        <div class="token-id-heading">TokenID</div>
                        <div class="rarity-heading">Rarity</div>
                        <div class="supply-heading">Supply</div>
                        <div class="status-heading">Status</div>
                    </div>
                    <div class="pizza-oven-container">
                        <?php 
                        foreach($pizzas as $pizza) :
                            $status = $pizza['status'];
                            if ($status == 'pending') :
                                $statusCopy = 'Under Review';
                            elseif ($status == 'sold') :
                                $statusCopy = 'Sold Out';
                            else :
                                $statusCopy = $status;
                            endif;

                            $tokenID = $pizza['token_id'];
                            $supply = $pizza['supply'];
                            $name = $pizza['name'];

                            $image = $pizza['image_path'];
                            if ($status == 'created') :
                                $image = '/custom-mint/backgrounds/'.$supply.'.png';
                            endif;

                            $userID = $pizza['user_id'];
                        ?>
                            <div class="pizza-item-container" data-user-id="<?= $userID; ?>" data-token-id="<?= $tokenID; ?>" data-supply="<?= $supply; ?>" data-status="<?= $status; ?>">
                                <div class="pizza-item">
                                    <div class="token-image">
                                        <a href="<?= $image; ?>" data-lightbox="token-<?= $tokenID; ?>" data-title="Token #<?= $tokenID; ?> - <?= $name; ?>"><img src="<?= $image; ?>" alt="<?= $name; ?>" /></a>
                                    </div>
                                    <div class="token-name">
                                        <?= $name; ?>
                                    </div>
                                    <div class="token-details">
                                        <?php if ($status == 'active'): ?>
                                            <a class="oven-btn mainBtn dark" style="<?= ($status !== 'active') ? 'display:none;' : ''; ?>" href="/shop-item?type=community&id=<?= $tokenID; ?>">Details</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="pizza-id">
                                    <?= $pizza['token_id']; ?>
                                </div>
                                <div class="pizza-rarity">
                                    Rarity
                                </div>
                                <div class="pizza-supply">
                                    <span></span>&nbsp;<?= number_format($supply); ?>
                                </div>
                                <div class="pizza-status status-<?= $status; ?>">
                                    <i></i> <span><?= ucwords($statusCopy); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php';?>
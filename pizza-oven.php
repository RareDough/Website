<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'header.php';

include_once 'inc/functions.php';
$pdo = pdo_connect_mysql();

// Add/Update the submission in the database
$stmt = $pdo->prepare('SELECT * FROM submissions');
$stmt->execute();
$pizzas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section id="mint-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <h1 class="mainHeading">All Submissions</h1>
            </div>
        </div>
    </div>
</section>
<section id="pizza-oven-table">
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-between">
                <div class="creator-filter d-flex">
                    <a class="all-pizzas" href="#">All Pizzas</a>
                    <a class="your-pizzas" href="#">Your Pizzas</a>
                </div>
                <div class="filter-toggles">
                    <a class="list-view active" href="#">List View</a>
                    <a class="grid-view" href="#">Grid View</a>
                </div>
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
                        ?>
                            <div class="pizza-item-container">
                                <div class="pizza-item">
                                    <div class="token-image">
                                        <img src="<?= $pizza['image_path']; ?>" alt="">
                                    </div>
                                    <div class="token-name">
                                        <?= $pizza['name']; ?>
                                    </div>
                                    <a class="token-details mainBtn dark" href="#" class="mainBtn dark">Details</a>
                                </div>
                                <div class="token-id-heading">
                                    <?= $pizza['token_id']; ?>
                                </div>
                                <div class="rarity-heading">
                                    Rarity
                                </div>
                                <div class="supply-heading">
                                    <?= number_format($pizza['supply']); ?>
                                </div>
                                <div class="status-heading">
                                    <span class="token-status status-<?= $pizza['status']; ?>"><i></i> <?= ucwords($statusCopy); ?></span>
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
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'header.php';

// Connect to database and check wallet address
include_once 'inc/functions.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
$stmt->execute(['0xf39CEB8Ab0DE75Dca31e988fD59D53cC009803E4']);

// Check if user exists
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
  echo '<pre style="color:white;">';
  echo 'User Level: ' . $user['user_level'];
  echo '</pre>';
} else {
  // User does not exist
  exit('User does not exist');
}

$path = 'custom-mint/backgrounds';
$backgrounds = array_values(array_diff(scandir($path), array('..', '.')));

?>

<section id="mint-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <h1 class="mainHeading">Mint your RareDough Pizza in a few simple steps!</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam a elementum turpis, non volutpat est. Nulla aliquam elementum quam ac dignissim. Sed mattis ultricies leo sagittis luctus.</p>
            </div>
        </div>
    </div>
</section>
<section id="mint-nav">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <ol>
                    <li data-step="1"><a href="#">1</a></li>
                    <li data-step="2"><a href="#">2</a></li>
                    <li data-step="3"><a href="#">3</a></li>
                    <li data-step="4"><a href="#">4</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<form action="" enctype="multipart/form-data" id="pizza-form">
    <section class="mint-section active" data-step="1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <h2>1. Buy a plate to create your pizza</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="mint-section" data-step="2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <label>Choose your pizza supply.</label>

                </div>
            </div>
        </div>
    </section>
    <section class="mint-section" data-step="3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <h2>Create a new pizza</h2>
                    <label class="instructions"><sup>*</sup>Required fields</label>
                    <label class="instructions">File types supported: JPG, PNG, GIF, SVG. Max size: 5 MB</label>
                    <!-- PIZZA IMAGE -->
                    <div id="image-upload">
                        <div id="pizza-container">
                            <img id="pizza-template" src="/custom-mint/backgrounds/<?php echo $backgrounds[0]; ?>" alt="Background Image" />
                            <!-- Text on Curve -->
                            <svg xmlns="http://www.w3.org/2000/svg" id="text-path" viewBox="0 0 500 500">
                                <g data-name="Layer 1">
                                    <path d="M0 0h500v500H0z" style="fill:none"/>
                                    <path id="curved-text" d="M63 250c0 103.55 83.95 187.5 187.5 187.5S438 353.55 438 250" style="stroke:none;fill:none"/>
                                    <text font-size="30" fill="#000000" letter-spacing="2" font-family="sans-serif" font-weight="bold" text-transform="uppercase" dominant-baseline="middle" text-anchor="middle">
                                        <textPath xlink:href="#curved-text" id="custom-text" startOffset="50%"></textPath>
                                    </text>
                                </g>
                            </svg>
                        </div>
                        <div id="file-input">
                            <label for="custom-image">
                                <input type="file" name="custom-image" id="custom-image" accept=".gif,.jpg,.jpeg,.png,.webp,.svg" required />
                                <img class="upload-arrow" src="/img/upload-arrow.svg" alt="Upload" />
                                <div>
                                    <strong>Choose a file</strong> <span class="d-none d-md-block">or drag it here.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <!-- <div id="holder-cont"><img id="holder-img" src="" alt=""></div> -->
                    <div class="form-fields">
                        <label>
                            Background image
                            <select name="background">
                                <?php foreach($backgrounds as $background) : ?>
                                    <option value="<?= $background; ?>"><?= ucwords(str_replace(array('-','.png'), array(' ', ''), $background)); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>
                            Name
                            <input id="pizza-name" type="text" maxlength="18" required />
                        </label>
                        <label class="small">
                            <input name="show-name" type="checkbox" />
                            <span>Show name on pizza</span>
                        </label>
                        <label>
                            Description
                            <textarea id="pizza-desc" name="pizza-desc" rows="5" cols="33" maxlength="1000" required></textarea>
                        </label>
                        <label>
                            <input type="hidden" name="quantity">
                            <input type="hidden" name="token-id" />
                            <input type="submit" />
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mint-section" data-step="2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <label>Choose your pizza supply.</label>

                </div>
            </div>
        </div>
    </section>
</form>
<div id="pizza-comp"></div>

<?php include 'footer.php';?>
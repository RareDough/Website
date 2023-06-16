<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'header.php';

// // Connect to database and check wallet address
// include_once 'inc/functions.php';
// $pdo = pdo_connect_mysql();
// $stmt = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
// $stmt->execute(['0xf39CEB8Ab0DE75Dca31e988fD59D53cC009803E4']);

// // Check if user exists
// $user = $stmt->fetch(PDO::FETCH_ASSOC);
// if ($user) {
//   echo '<pre style="color:white;">';
//   echo 'User Level: ' . $user['user_level'];
//   echo '</pre>';
// } else {
//   // User does not exist
//   exit('User does not exist');
// }

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
            <div class="col-md-7 col-lg-5">
                <ol>
                    <li><a class="active-step" href="#" data-step="1">1</a></li>
                    <li><a href="#" data-step="2">2</a></li>
                    <li><a href="#" data-step="3">3</a></li>
                    <li><a href="#" data-step="4">4</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<form action="" enctype="multipart/form-data" id="pizza-form">
    <section class="mint-section active-step" data-step="1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <h2>1. Buy a plate to create your pizza</h2>
                    <label>Choose your pizza supply.</label>
                    <div class="form-fields form-fields__row">
                        <label class="radio-label">
                            <?= number_format(500); ?>
                            <input name="pizza-supply" value="500" type="radio" />
                            <img src="/custom-mint/backgrounds/purple-background.png" />
                        </label>
                        <label class="radio-label">
                            <?= number_format(1000); ?>
                            <input name="pizza-supply" value="1000" type="radio" />
                            <img src="/custom-mint/backgrounds/purple-background.png" />
                        </label>
                        <label class="radio-label">
                            <?= number_format(5000); ?>
                            <input name="pizza-supply" value="5000" type="radio" />
                            <img src="/custom-mint/backgrounds/purple-background.png" />
                        </label>
                        <label class="radio-label">
                            <?= number_format(10000); ?>
                            <input name="pizza-supply" value="10000" type="radio" />
                            <img src="/custom-mint/backgrounds/purple-background.png" />
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mint-section" data-step="2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <h2>2. Select your plate (Pizza supply)</h2>
                    <label>
                        <div>
                            Choose your plate (TokenID).
                            <select name="token-select">
                                <option selected disabled>Select a TokenID</option>
                            </select>
                        </div>
                        <div class="token-preview">
                            <img src="" alt="Token Preview" />
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </section>
    <section class="mint-section" data-step="3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <h2>3. Create your pizza</h2>
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
                    <label class="instructions">File types supported: JPG, PNG, GIF, SVG. Max size: 5 MB</label>
                    <!-- <div id="holder-cont"><img id="holder-img" src="" alt=""></div> -->
                    <div class="form-fields">
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
                            <input type="hidden" name="token-quantity">
                            <input type="hidden" name="token-id" />
                            <input type="submit" />
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mint-section" data-step="4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <h2>4. Your RareDough Pizza has been submitted!</h2>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <div id="mint-section-buttons">
                    <a id="buy-token" href="#" class="mainBtn dark" disabled>Buy with BREAD</a>
                    <a id="next-step" href="#" class="mainBtn light" disabled>Continue</a>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="pizza-comp"></div>

<?php include 'footer.php';?>
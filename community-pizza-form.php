<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'header.php';

?>

<section id="mint-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <h1 class="mainHeading">Pizza Base</h1>
                <h3 id="return-user-heading"></h3>
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
                    <h2>1. Buy a Plate (and choose the Supply)</h2>
                    <div class="form-fields form-fields__row">
                        <label class="radio-label">
                            <?= number_format(500); ?>
                            <input name="token-select-box" value="500" type="radio" />
                            <img src="/custom-mint/backgrounds/500.png" />
                            <span class="token-cost mt-2"><i class="me-2"></i>1,000</span>
                        </label>
                        <label class="radio-label">
                            <?= number_format(1000); ?>
                            <input name="token-select-box" value="1000" type="radio" />
                            <img src="/custom-mint/backgrounds/1000.png" />
                            <span class="token-cost mt-2"><i class="me-2"></i>100</span>
                        </label>
                        <label class="radio-label">
                            <?= number_format(5000); ?>
                            <input name="token-select-box" value="5000" type="radio" />
                            <img src="/custom-mint/backgrounds/5000.png" />
                            <span class="token-cost mt-2"><i class="me-2"></i>100</span>
                        </label>
                        <label class="radio-label">
                            <?= number_format(10000); ?>
                            <input name="token-select-box" value="10000" type="radio" />
                            <img src="/custom-mint/backgrounds/10000.png" />
                            <span class="token-cost mt-2"><i class="me-2"></i>100</span>
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
                    <h2>2. Choose your Plate</h2>
                    <label>
                        <div>
                            Select your TokenID
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
                    <h2>3. Submit your Pizza</h2>
                    <!-- PIZZA IMAGE -->
                    <div id="image-upload">
                        <div id="pizza-container">
                            <img id="pizza-template" src="/custom-mint/backgrounds/500.png" alt="Background Image" />
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
                                <input type="file" name="custom-image" id="custom-image" required />
                                <img class="upload-arrow" src="/img/upload-arrow.svg" alt="Upload" />
                                <div>
                                    <strong>Choose a file</strong> <span class="d-none d-md-block">or drag it here.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <label class="instructions">File types supported: JPG, PNG, GIF, WEBP. Max size: 5 MB</label>
                    <!-- <div id="holder-cont"><img id="holder-img" src="" alt=""></div> -->
                    <div class="form-fields">
                        <label>
                            Name
                            <input id="token-name" name="token-name" type="text" maxlength="18" required />
                        </label>
                        <label>
                            Title (optional text on plate)
                            <input id="token-title" name="token-title" type="text" maxlength="50" />
                        </label>
                        <label>
                            Description
                            <textarea id="token-desc" name="token-desc" rows="5" cols="33" maxlength="1000" required></textarea>
                        </label>
                        <label>
                            Twitter Username
                            <input name="twitter-username" type="text" required />
                        </label>
                        <label>
                            Discord Username
                            <input name="discord-username" type="text" required />
                        </label>
                        <label class="checkbox-label">
                            <div class="checkbox-label__inner">
                                <span>Please make sure to <a href="https://discord.com/invite/GbwykC99N6" target="_blank">join our discord server</a> for further communication.</span>
                                <input name="discord-joined" type="checkbox" required />
                                <span class="checkmark"></span>
                            </div>
                        </label>
                        <label class="submit-label">
                            <input type="hidden" name="token-supply" value="">
                            <input type="hidden" name="token-id" value="" />
                            <a id="submit-form" href="#" class="mainBtn light">Submit</a>
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
                    <span class="submit-checkmark"></span>
                    <h2>Your RareDough Pizza has been submitted!</h2>
                    <div class="image-preview">
                        <img id="image-preview" src="" />
                    </div>
                    <p>Please wait for a moderator to review and activate your pizza, at which time you will be able to activate the sale of your pizza in our shop. In the meantime, check out what's cookin' in the oven!</p>
                    <div class="text-center">
                        <a href="/pizza-oven" class="mainBtn light">Pizza Oven</a>
                    </div>
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
                    <span class="prev-purchased">Already purchased a token? <a href="#">Click here</a> to continue.</span>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="pizza-comp"></div>

<?php include 'footer.php';?>
<?php include 'header.php';

$path  = 'custom-mint/backgrounds';
$backgrounds = array_values(array_diff(scandir($path), array('..', '.')));
?>

<div class="container">
  <div class="row">
    <div class="col text-center">
      <h1 class="mainHeading">Mint Your Own Raredough Pizza</h1>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
      <h2>Create a new pizza</h2>
      <form action="" enctype="multipart/form-data" id="pizza-form">
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
              <span class="input-error"></span>
            </label>
          </div>
        </div>
        <div id="holder-cont"><img id="holder-img" src="" alt=""></div>
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
            Supply
            <select name="supply">
              <option value="500">500</option>
              <option value="1000">1000</option>
              <option value="5000">5000</option>
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
            <textarea id="pizza-desc" name="pizza-desc" rows="5" cols="33" maxlength="200" required></textarea>
          </label>
          <label>
            <input type="submit" />
          </label>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="pizza-comp"></div>

<?php include 'footer.php';?>
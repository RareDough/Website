<?php include 'header.php';?>

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
          <div id="file-input">
            <label for="custom-image">
              <input type="file" name="custom-image" id="custom-image" />
              <img class="upload-arrow" src="/assets/images/upload-arrow.svg" alt="Upload" />
              <div>
                <strong>Choose a file</strong> <span class="d-none d-md-block">or drag it here.</span>
              </div>
              <span class="input-error"></span>
            </label>
          </div>
        </div>
        <div class="form-fields">
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
            <input type="text" />
          </label>
          <label>
            Description
            <textarea rows="5" cols="33"></textarea>
          </label>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php';?>
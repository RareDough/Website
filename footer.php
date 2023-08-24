      <!-- Copy Right Text -->
      <div class="copyRightText" tkey="copy_text">
        © <script>document.write(/\d{4}/.exec(Date())[0])</script> Made with ❤ by RareDough
      </div>
    </div>
    <!-- End Body Wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha512-72WD92hLs7T5FAXn3vkNZflWG6pglUDDpm87TeQmfSg8KnrymL2G30R7as4FmTwhgu9H7eSzDCX3mjitSecKnw==" crossorigin="anonymous"></script>
    <script src="./js/lightbox.min.js"></script>
    <script>
      lightbox.option({
        'disableScrolling': true,
        'showImageNumberLabel': false,
        'resizeDuration': 200,
        'fadeDuration': 200
      })
    </script>
    <script src="./js/main.js"></script>
    <script src="./js/lang.js"></script>
    <script>
      // Get Src from Image
      let allFlags = document.querySelectorAll(".flagSrc");
      for (let i = 0; i < allFlags.length; i++) {
        allFlags[i].addEventListener("click", flagsHandleClick);
      }

      function flagsHandleClick(e) {
        let flagSrc = e.target.src;
        console.log(flagSrc);
        document.getElementById("selectedFlag").src = flagSrc;
        document.getElementById("selectedFlag2").src = flagSrc;
      }

      const selected = localStorage.getItem("langCode");
      if (selected) {
        document.getElementById(
          "selectedFlag"
        ).src = `./img/${selected.toUpperCase()}.png`;
        document.getElementById(
          "selectedFlag2"
        ).src = `./img/${selected.toUpperCase()}.png`;
      }
    </script>
    <?php if (in_array($page, $shopPages)): ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.10.0/web3.min.js" integrity="sha512-EXk1TBrT1TC+ajcr8c+McVhGFv4xAI+8m+V7T4PwT3MdYAv47jkirleTTZh8IFtRv90ZtKPOk/4JJTGUaQ9d6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="./js/shopabi.js"></script>
      <script src="./js/usdcabi.js"></script>
      <script src="./js/coinabi.js"></script>
      <script src="./js/pizzaabi.js"></script>
      <script src="./js/ovenabi.js"></script>
      <script src="./js/ovenabiv2.js"></script>
      <script src="./js/pizzomaticabi.js"></script>
      <script src="./js/pizzalib.js"></script>
      <script src="./js/raredoughlib.js"></script>
      <script src="./js/connect.js?v=1.0.8"></script>
    <?php elseif ($page == 'leaderboard'): ?>
      <script src="./js/leaderboard.js"></script>
    <?php endif; ?>

    <?php if ($page == 'shop' || $page == 'utilities' || $page == 'whitelist' || $page == 'limited-editions' || $page == 'custom-pizzas' || $page == 'community-pizzas'): ?>
      <script src="./js/shop.js?v=1.0.3"></script>
    <?php endif; ?>

    <?php if ($page == 'burn-oven' || $page == 'burn-ovenv2'): ?>
      <script src="./js/burn-oven.js?v=1.0.2"></script>
    <?php endif; ?>

    <?php if ($page == 'community-pizza-form'): ?>
      <script src="./js/html2canvas.min.js"></script>
      <script src="./js/jquery.validate.min.js"></script>
      <script src="./js/select2.min.js"></script>
      <script src="./js/additional-methods.min.js"></script>
      <script src="./js/community-pizza-form.js?v=1.0.21"></script>
    <?php endif; ?>

    <?php if ($page == 'pizza-oven'): ?>
      <script src="./js/pizza-oven.js?v=1.0.11"></script>
    <?php endif; ?>

    <script src="./js/mint-button.js?v=1.0.9"></script>

  </body>
</html>

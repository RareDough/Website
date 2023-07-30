<?php include 'header.php'; ?>

<script>
    const pizzaArray = <?php $out = array();
    foreach (glob('./assets/community/*.json') as $filename) {
        $p = pathinfo($filename);
        $out[] = $p['filename'];
    }
    echo json_encode($out); ?>;
</script>

    <section id="shopSection" class="mt-lg-3" data-category="community pizza">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 smallSectionBorder py-lg-5">
                    <div class="sideMenu">
                        <!-- desktopView -->
                        <div class="sideMenuLinks desktopView">
                            <a class="sideMenuLink" href="./shop">All Items</a>
                            <a class="sideMenuLink" href="./whitelist">Whitelist</a>
                            <a class="sideMenuLink" href="./limited-editions">Limited Editions</a>
                            <a class="sideMenuLink" href="./custom-pizzas">Custom Pizzas</a>
                            <a class="sideMenuLink active" href="./community-pizzas">Community Pizzas</a>
                            <a class="sideMenuLink" href="./utilities">Utilities</a>
                        </div>
                      <!-- mobileView -->
                <div class="sideMenuLinks mobileView">
                  <a class="sideMenuLink active" data-bs-toggle="collapse" href="#sideMenu" role="button"
                    aria-expanded="false" aria-controls="collapseExample">
                    Community Pizzas
                  </a>
                  <div class="collapse collapsebg" id="sideMenu">
                    <div class="card card-body">
                      <a class="sideMenuLink " href="./shop">All Items</a>
                      <a class="sideMenuLink" href="./whitelist">Whitelist</a>
                      <a class="sideMenuLink" href="./limited-editions">Limited Editions</a>
                      <a class="sideMenuLink" href="./custom-pizzas">Custom Pizzas</a>
                      <a class="sideMenuLink" href="./utilities">Utilities</a>
                    </div>
                  </div>
                </div>
                    </div>
                </div>
                <div class="col-lg-10 py-lg-5 ps-lg-4">
                    <div class="row">

                      <!--
                      
                        <div class="col-lg-3">
                            <div class="searchArea">
                                <input type="text" placeholder="search">
                                <img src="./img/search-icon.svg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-2 ms-auto text-end mt-2 mt-lg-0">
                            <div class="dropdown newestDropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">Newest</button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Price (low to high)</a></li>
                                    <li><a class="dropdown-item" href="#">Price (high to low)</a></li>
                                    <li><a class="dropdown-item" href="#">Name (A to Z)</a></li>
                                </ul>
                            </div>
                        </div>

                        -->
                      
                    </div>
                    <div id="shopContainer" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5"></div>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>
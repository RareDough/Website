<?php include 'header.php';?>

  <div class="bodyContent">
    <h1 class="mainHeading">YOUR ACCOUNT</h1>
    <div class="container">
      <div class="accountInfo">
        <div class="row">
          <div class="col-lg-4">

          <!--
            
            <img src="./img/profileImg.png" alt="" class="profileImg" />
            
           -->
            
            <div class="subHeading">
              <span>Wallet address:</span>
             <!-- <img src="./img/Pen.svg" alt="" class="ms-2" /> -->
            </div>
            
            <div class="mainText">
              <div id="walletCont" class="copyTextTrigger">
                <span class="wallet-address copyText"></span>
                <img src="./img/Copy.svg" alt="" class="ms-2 copyIcon" />
              </div>
            </div>

            
          </div>
          <div class="col-lg-4 my-lg-auto">
            <div class="balance">
              <div class="mainText">
                <img src="./img/bpac-sm-icon.svg" alt="" /> Bread Balance
              </div>
              <div class="subHeading yourAccount bread-balance">0</div>
            </div>
          </div>
          <div class="col-lg-4 my-lg-auto">
            <div class="balance">
              <div class="mainText">
                <img src="./img/cup.svg" alt="" />
                Engagement Points
                <span>Rank #999</span>
              </div>
              <div class="subHeading yourAccount engagement-points">Coming Soon</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="inventory">
        <div class="inventoryHeader">
          <div>
            <h1 class="subHeading">Inventory</h1>
            <div class="desktopView">
              <span class="smText">Value in Bread:</span>
              <span class="mainText pizza-bread-value">0</span>
            </div>
          </div>
          <!--
          <div class="dropdown newestDropdown desktopView">
            <button
              class="btn btn-secondary dropdown-toggle"
              type="button"
              id="dropdownMenuButton1"
              data-bs-toggle="dropdown"
              data-bs-display="static" 
              aria-expanded="false"
            >
              Newest
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li>
            </ul>
          </div>

           load more -->
        </div>
        <div class="inventoryBody">
          <div class="mobileView">
            <div class="row">
              <div class="col">
                <div class="bread">
                  <span class="smText">Value in Bread:</span
                  ><span class="mainText pizza-bread-value">0</span>
                </div>
              </div>

              <!--
              
              <div class="col text-end">
                <div class="dropdown newestDropdown">
                  <button
                    class="btn btn-secondary dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton1"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Newest
                  </button>
                  <ul
                    class="dropdown-menu"
                    aria-labelledby="dropdownMenuButton1"
                  >
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li>
                      <a class="dropdown-item" href="#">Another action</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#"
                        >Something else here</a
                      >
                    </li>
                  </ul>
                </div>
              </div>

                  -->
            </div>
          </div>

          <!-- cards -->
          <div id="inventoryContainer" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5"></div>

          <!-- load more -->
          <!-- <span class="mainText loadMoreBtn" onclick="loadMore()">Load more</span> -->
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php';?>
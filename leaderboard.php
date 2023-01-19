<?php include 'header.php';?>

<h1 class="mainHeading">Engagement <br class="mobileView"/> Leaderboard (coming soon)</h1>
<div class="container">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="searchArea">
        <input type="text" placeholder="search" />
        <img src="./img/search-icon.svg" alt="" />
      </div>
    </div>
  </div>
  <!-- table desktopView -->
  <div class="desktopView">
    <div class="leaderBoardContainer">
      <div class="tableHeader">
          <div>
            <span>Rank</span>
            <span class="ms-lg-5">Twitter name</span>
          </div>
            
          <div>
            <span class="tableCounter">
              <span
              class="leftArrow"
              ><img src="./img/leftArrow.svg" alt="" class="arrow me-lg-2"
            onclick="shiftRight()"/></span>
            <span ><img src="./img/heart.svg" alt="" id="tableChange3"/></span>
            <span class="toolTip like">
              <img src="./img/about.svg" alt="" />
            </span>
            </span>
          
          
            <span class="tableCounter">
              <span><img src="./img/change.svg" alt="" id="tableChange1"/></span>
            <span class="toolTip retweet">
              <img src="./img/about.svg" alt="" />
            </span>
            </span>

            <span class="tableCounter">
              <span><img src="./img/tableMsg.svg" alt="" id="tableChange2"/></span>
              <span class="toolTip msg">
                <img src="./img/about.svg" alt="" />
              </span>
              <span
                class="rightArrow"><img
                  src="./img/rightArrow.svg"
                  alt=""
                  class="arrow ms-lg-2"
              onclick="shiftLeft()"/></span>
            </span>
            <!-- respTable -->
            <span class="tableCounter mobile">
              <span
              class="rightArrow"><img
                src="./img/leftArrow.svg"
                alt=""
                class="arrow ms-lg-1"
            onclick="respTable('left')"/></span>
              <span><img src="./img/t1.svg" alt="" /></span>
              <span class="toolTip resp">
                <img src="./img/about.svg" alt="" />
              </span>
              <span
                class="rightArrow"><img
                  src="./img/rightArrow.svg"
                  alt=""
                  class="arrow ms-lg-1"
              onclick="respTable('right')"/></span>
            </span>
            <span>
              <span>Points</span>
              <span class="toolTip points">
                <img src="./img/about.svg" alt="" />
              </span>
            </span>
          </div>
      </div>
      <div class="leaderBoardTable">
        <table>

          <tbody>
            <tr>
              <td>1</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername... <img src="./img/rank1.svg" alt="" class="rankImg"></span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>1</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername... <img src="./img/rank2.svg" alt="" class="rankImg"></span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...<img src="./img/rank3.svg" alt="" class="rankImg"></span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>11</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>12</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>13</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
            <tr>
              <td>14</td>
              <td>
                <img src="./img/profileSm.png" alt="" /><span
                  >@userwithverylongtwittername...</span
                >
              </td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
              <td>9999</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- table mobileView -->
  <div class="mobileView">
    <div class="leaderBoardContainer">
      <div class="tableHeader">
        <div>
          <span class="me-2">Rank</span>
          <span>Twitter name</span>
        </div>
        <div>
          <span class="tableCounter mobile">
            <span
            class="rightArrow"><img
              src="./img/leftArrow.svg"
              alt=""
              class="arrow me-1"
          onclick="respTable('left')"/></span>
            <span><img src="./img/t1.svg" alt="" id="tableChangeResp"/></span>
            <span class="toolTip resp">
              <img src="./img/about.svg" alt="" />
            </span>
            <span
              class="rightArrow"><img
                src="./img/rightArrow.svg"
                alt=""
                class="arrow ms-1"
            onclick="respTable('right')"/></span>
          </span>
          <span>
            <span>Points</span>
            <span class="toolTip points">
              <img src="./img/about.svg" alt="" />
            </span>
          </span>
        </div>
      </div>
      <div class="leaderBoardTable">
        <table>
          <tr>   
            <td>
              <span>1</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...<img src="./img/rank1.svg" alt="" class="rankImg"</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>2</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...<img src="./img/rank2.svg" alt="" class="rankImg"</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>3</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...<img src="./img/rank3.svg" alt="" class="rankImg"</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>4</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>5</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>6</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>7</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>8</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>9</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
          <tr>   
            <td>
              <span>10</span>
              <img src="./img/profileSm.png" alt="" /><span
                >@userwithver...</span
              >
            </td>
            <td>9999</td>
            <td>9999</td>
          </tr>
        
        </table>
      </div>
    </div>
  </div>
</div>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.7.0-rc.0/web3.min.js"
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>
<script
  type="text/javascript"
  src="https://mintplex.xyz/embeds/v2/embed1155.js"
  data-uuid="9c7e2db7-94b7-4a6a-a808-97b90d5692e3"
></script>
<!-- End Mintplex.xyz minting button-->

<?php include 'footer.php';?>
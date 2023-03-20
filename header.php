<?php 
  $filename = basename($_SERVER['PHP_SELF']);
  $page = preg_replace("/(.+)\.php$/", "$1", $filename);
  if ($page == 'index'):
    $page = 'home';
    $title = 'RareDough | Home';
    $description = 'Collect digital Pizza Collectibles, earn BREAD and buy innovative crypto products created by RareDough.';
  elseif ($page == 'shop'):
    $title = 'RareDough | Shop';
    $description = 'Discover our innovative RareDough Products. You can spend your BREAD Tokens for Services and NFTs here.';
  elseif ($page == 'account'):
    $title = 'RareDough | Account';
    $description = 'Connect your wallet to see your RareDough NFT Inventory, BREAD balance and Engagement Ranking.';
  elseif ($page == 'burn-oven'):
    $title = 'RareDough | Burn Oven';
    $description = 'Burn RareDough Pizza Collectibles to earn BREAD Tokens here. Use your BREAD in our Shop to buy unique products.';
  elseif ($page == 'leaderboard'):
    $title = 'RareDough | Leaderboard';
    $description = 'Displaying the TOP Supporters on Twitter. Interact with our official RareDough Account or post Tweets including #RareDough and @RareDough to climb the Twitter Engagement Leaderboard! ';
  elseif ($page == 'freemint'):
    $title = 'RareDough | Freemint';
    $description = 'Mint your FREE RareDough Pizza here. You can mint as many Free Pizzas as you like, please share with your friends!';
  elseif ($page == 'vip-pass'):
    $title = 'RareDough | VIP Pass';
    $description = 'Support us and enjoy privileged benefits in the RareDough Community.';
  elseif ($page == 'infinity'):
    $title = 'RareDough | Infinity';
    $description = 'This Pizza serves as BASIC access token to the RareDough Ecosystem. Holders may participate in the Private Sale AFTER the Whitelist lvl 1 mint (No guaranteed NFT).';
  elseif ($page == 'whitelist-lvl1'):
    $title = 'RareDough | Whitelist-lvl1';
    $description = 'This NFT serves as ELEVATED access token to the RareDough Ecosystem. Holders may buy 1x NFT during the Private Sale. A time window of 24 hours grants exclusive minting permissions AFTER the Whitelist lvl 2 mint.';
  elseif ($page == 'whitelist-lvl2'):
    $title = 'RareDough | Whitelist-lvl2';
    $description = 'This NFT serves as PRIVILEGED access token for the RareDough Ecosystem. Holders may buy up to 3x NFTs during the Private Sale. A time window of 24 hours grants exclusive minting permissions AFTER the Whitelist lvl 3 mint.';
  elseif ($page == 'whitelist-lvl3'):
    $title = 'RareDough | Whitelist-lvl3';
    $description = 'This NFT serves as PREMIUM access token for the RareDough Ecosystem. Holders are guaranteed to be the first to buy up to 5x NFTs during the Private Sale. A time window of 48 hours guarantees exclusive minting permissions before everyone else.';
  elseif ($page == 'twitter-promo'):
    $title = 'RareDough | Twitter Promo';
    $description = 'RareDough will host a Giveaway to promote you or your project through Twitter or Discord. This NFT can only be used in combination with a Custom Pizza Creation NFT. ONLY RareDough Pizza NFTs are allowed, you will have to send us your previously minted Pizzas (from our Smart Contract), we will take care of the distribution (including transactionfees). We reserve the right to deny promotion of questionable or harmful accounts.';
  elseif ($page == 'custom-pizza-V1'):
    $title = 'RareDough | Custom Pizza V1';
    $description = 'Holders of this NFT are eligible for 1x Custom Pizza Creation. RareDough will create and mint a Pizza NFT through our Collection for you. Contact us via Discord to redeem your Voucher. You will have to provide us your artworks & logo to include in the center of the Pizza. We reserve the right to deny abusive and illegal images.';
  elseif ($page == 'airdrop-pass'):
    $title = 'RareDough | Airdrop Pass';
    $description = 'Never miss out on new RareDough Pizza collaborations anymore. Holders of this NFT are guaranteed to be included in all future PUBLIC Airdrops and Giveaways involving custom-made Pizzas for other Communities. (Exceptions apply for private/exclusive drops)';
  elseif ($page == '100k-pizza'):
    $title = 'RareDough | 100k Pizza';
    $description = ' A limited edition Pizza only available for a limited time in the RareDough Shop. Owners of this NFT are eligible to receive 101k BREAD Tokens (1% Bonus), if burned in the NFT Oven.';
  elseif ($page == '50k-pizza'):
    $title = 'RareDough | 50k Pizza';
    $description = 'A limited edition Pizza only available for a limited time in the RareDough Shop. Owners of this NFT are eligible to receive 50250 BREAD Tokens (0.5% Bonus), if burned in the NFT Oven.';
  elseif ($page == '10k-pizza'):
    $title = 'RareDough | 10k Pizza';
    $description = 'A limited edition Pizza only available for a limited time in the RareDough Shop. Owners of this NFT are eligible to receive 10010 BREAD Tokens (0.1% Bonus), if burned in the Oven.';
  elseif ($page == 'burn-ovenv2'):
    $title = 'RareDough | Burn Oven V2';
    $description = 'Burn RareDough Pizza Collectibles to earn BREAD Tokens here. Use your BREAD in our Shop to buy unique products.';
  elseif ($page == 'bitcoin-pizza-79715'):
    $title = 'RareDough | Inscription 79715';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
  elseif ($page == 'bitcoin-pizza-79944'):
    $title = 'RareDough | Inscription 79944';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
  elseif ($page == 'bitcoin-pizza-80332'):
    $title = 'RareDough | Inscription 80332';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
  elseif ($page == 'bitcoin-pizza-79831'):
    $title = 'RareDough | Inscription 79831';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
  elseif ($page == 'bitcoin-pizza-80331'):
    $title = 'RareDough | Inscription 80331';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
  elseif ($page == 'bitcoin-pizza-79930'):
    $title = 'RareDough | Inscription 79930';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
  elseif ($page == 'burn-bitcoin-pizza-79921'):
    $title = 'RareDough | Inscription 79921';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
  elseif ($page == 'bitcoin-pizza-80348'):
    $title = 'RareDough | Inscription 80348';
    $description = 'This Pizza is forever inscribed on the Bitcoin Blockchain. Ordinals are digital assets inscribed on Satoshis, the lowest denomination of Bitcoin (BTC).';
    elseif ($page == 'coldpizza'):
    $title = 'RareDough | Coldpizza';
    $description = 'Showcasing our beloved Community Member "Coldpizza" (Twitter: @coldpizza_16). The Community Spotlight Pizza is a new campaign invented by RareDough to showcase supporters of the beloved Pizza Community and grow together.';
    elseif ($page == 'redheadphone'):
    $title = 'RareDough | Redheadphone Pizza';
    $description = 'Showcasing our beloved Community Member "RedHeadphone" (Twitter: @huzaifa_Khila). The Community Spotlight Pizza is a new campaign invented by RareDough to showcase supporters of the beloved Pizza Community and grow together.';
    elseif ($page == 'vinnypizza'):
    $title = 'RareDough | Vinnypizza';
    $description = 'Showcasing our beloved Community Member "Vinnypiazza" (Twitter: @vinnypiazza). The Community Spotlight Pizza is a new campaign invented by RareDough to showcase supporters of the beloved Pizza Community and grow together.';
    elseif ($page == 'chesspizza'):
    $title = 'RareDough | Chesspizza';
    $description = 'This is a special Promo Pizza created to Showcase great projects in the Web3 Space. The $ELO Chess Club is a Play-to-Earn crypto chess game in Decentraland.';
  endif;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8" />
    <meta
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
      name="viewport"
    />
    <title><?= $title; ?></title>
    <meta name="author" content="RareDough" />
    <meta
      name="description"
      content="<?= $description; ?>"
    />
    <meta
      name="keywords"
      content="Raredough, Blockchain, Ethereum, Polygon, NFT, Token, BREAD, Crypto, Freemint, Community, Whitelist, Digital Collectibles"
    />

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://raredough.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="RareDough.com">
    <meta property="og:description" content="Collect digital Pizza Collectibles, burn to earn BREAD and buy innovative RareDough products">
    <meta property="og:image" content="https://www.raredough.com/img/home-bg.jpg">
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="RareDough Pizzeria" />
    <meta property="og:image:type" content=".jpg" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="RareDough.com">
    <meta property="twitter:url" content="https://RareDough.com">
    <meta name="twitter:title" content="It's RareDough">
    <meta name="twitter:description" content="Collect digital Pizza Collectibles, burn to earn BREAD and buy innovative RareDough products">
    <meta name="twitter:image" content="https://www.raredough.com/img/home-bg.jpg">
    <meta name="twitter:image:alt" content="RareDough Pizzeria">
    
    <link rel="apple-touch-icon" sizes="180x180" href="img/bapc-favicon-180.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/bapc-favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/bapc-favicon-16.png">
    <link rel="shortcut icon" href="img/favicon.ico">
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/minireset.css/0.0.2/minireset.min.css" integrity="sha512-uBLaY+6crwV4JAHILx0HWvYncrX7TXL770hqxly0ZsQ199v4lr2yNB2jiPMoxNajFPHSQnU80B1O8dJLujWZMg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com"  />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/style.css?v=1.0.2" />
  </head>
  <body class="<?= $page; ?>" data-page="<?= $page; ?>" onload="connectWallet()">
    <!-- Hide Menu -->
    <div id="mobHideMenu" class="hideMenu">
      <div class="hideMenuHeader">
        <div>
          <a class="menuBrand" href="./">
            <img src="./img/logo.png" alt="RareDough Logo" />
          </a>
        </div>
        <div class="languagesSide">
          <div>
          <?php if ($page == 'home'): ?>
            <div class="dropdown flagDropdown me-3">
              <a
                class="dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img id="selectedFlag2" src="./img/EN.png" alt="" />
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div>
                  <a onClick="setLanguage('ch')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/CH.png"
                      alt="Chinese Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('fr')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/FR.png"
                      alt="French Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('gr')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/GR.png"
                      alt="German Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('it')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/IT.png"
                      alt="Italian Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('jp')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/JP.png"
                      alt="Japanese Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('tr')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/TR.png"
                      alt="Turkish Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('hi')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/HI.png"
                      alt="Hindi Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('th')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/TH.png"
                      alt="Thai Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('en')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/EN.png"
                      alt="British Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('es')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/ES.png"
                      alt="Spanish Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('nl')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/NL.png"
                      alt="Dutch Flag"
                  /></a>
                </div>
                <div>
                  <a onClick="setLanguage('pt')" class="dropdown-item" href="#"
                    ><img
                      img
                      class="flagSrc"
                      src="./img/PT.png"
                      alt="Portuguese Flag"
                  /></a>
                </div>
              </div>
            </div>
          <?php endif; ?>
          </div>
          <div id="hideMenuIcon" class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line mb-0"></span>
          </div>
        </div>
      </div>
      <div class="hideMenuBody">
        <a class="hideMenuLink" tkey="" href="./">Home</a>
        <br />
        <a class="hideMenuLink" tkey="get_btn" href="./vip-pass.php">Get Vip Pass</a>
        <br />
        <a class="hideMenuLink" tkey="" href="./burn-oven.php">Burn oven</a>
        <br />
        <a class="hideMenuLink" tkey="leaderboard" href="./leaderboard.php">Leaderboard</a>
        <br />
        <a class="hideMenuLink" tkey="shop" href="./shop.php">Shop</a>
        <div class="socialIcons">
          <a
            class=""
            href="https://opensea.io/collection/raredough"
            target="_blank"
          >
            <img src="./img/opensea-icon.png" alt="Opensea Icon" />
          </a>
          <a
            class="mx-2"
            href="https://twitter.com/RareDough"
            target="_blank"
          >
            <img src="./img/twitter-icon.png" alt="Twitter Icon" />
          </a>
          <a href="https://discord.com/invite/GbwykC99N6" target="_blank">
            <img src="./img/discrod-icon.png" alt="Discord Icon" />
          </a>
        </div>
      </div>
    </div>

    <!-- Start Body Wrapper -->
    <div class="bodyWapper <?= $page; ?>">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <a class="navbar-brand me-5" href="./">
            <img src="./img/logo.png" alt="" />
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav brandNav">
              <li class="nav-item">
                <a
                  tkey=""
                  class="nav-link"
                  aria-current="page"
                  href="./"
                  >Home</a
                >
              </li>
              <li class="nav-item">
                <a tkey="get_btn" class="nav-link" href="./vip-pass.php">Get VIP Pass</a>
              </li>
              <li class="nav-item">
                <a tkey="" class="nav-link" href="./burn-oven.php">Burn oven</a>
              </li>
              <li class="nav-item">
                <a tkey="leaderboard" class="nav-link" href="./leaderboard.php">Leaderboard</a>
              </li>
              <li class="nav-item">
                <a tkey="shop" class="nav-link" href="./shop.php">Shop</a>
              </li>
            </ul>
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a
                  class="nav-link"
                  href="https://opensea.io/collection/raredough"
                  target="_blank"
                  ><img src="./img/opensea-icon.png" alt=""
                /></a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link px-0"
                  href="https://twitter.com/RareDough"
                  target="_blank"
                  ><img src="./img/twitter-icon.png" alt=""
                /></a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  href="https://discord.com/invite/GbwykC99N6"
                  target="_blank"
                  ><img src="./img/discrod-icon.png" alt=""
                /></a>
              </li>
              <?php if ($page == 'home'): ?>
                <li class="nav-item dropdown flagDropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <img id="selectedFlag" src="./img/EN.png" alt="" />
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                      <a
                        onClick="setLanguage('ch')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          tkey="flag"
                          src="./img/CH.png"
                          alt="Chinese Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('fr')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/FR.png"
                          alt="French Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('gr')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/GR.png"
                          alt="German Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('it')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/IT.png"
                          alt="Italian Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('jp')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/JP.png"
                          alt="Japanese Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('tr')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/TR.png"
                          alt="Turkish Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('hi')"
                        class="dropdown-item"
                        href="#"
                        ><img class="flagSrc" src="./img/HI.png" alt="Hindi Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('th')"
                        class="dropdown-item"
                        href="#"
                        ><img class="flagSrc" src="./img/TH.png" alt="Thai Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('en')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/EN.png"
                          alt="English Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('es')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/ES.png"
                          alt="Spanish Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('pt')"
                        class="dropdown-item"
                        href="#"
                        ><img
                          class="flagSrc"
                          src="./img/PT.png"
                          alt="Portuguese Flag"
                      /></a>
                    </li>
                    <li>
                      <a
                        onClick="setLanguage('nl')"
                        class="dropdown-item"
                        href="#"
                        ><img class="flagSrc" src="./img/NL.png" alt="Dutch Flag"
                      /></a>
                    </li>
                  </ul>
                </li>
              <?php endif; ?>
            </ul>
            <?php if ($page == 'account' || $page == 'shop' || $page == 'burn-oven' || $page == 'freemint' || $page == 'infinity' || $page == 'whitelist-lvl1' || $page == 'whitelist-lvl2' || $page == 'whitelist-lvl3' || $page == 'airdrop-pass' || $page == 'custom-pizza-V1' || $page == 'twitter-promo' || $page == '100k-pizza' || $page == '50k-pizza' || $page == '10k-pizza' || $page == 'burn-ovenv2' || $page == 'bitcoin-pizza-80332' || $page == 'bitcoin-pizza-79831' || $page == 'bitcoin-pizza-80331' || $page == 'bitcoin-pizza-79944' || $page == 'bitcoin-pizza-79715' || $page == 'bitcoin-pizza-79921' || $page == 'bitcoin-pizza-79930' || $page == 'bitcoin-pizza-80348' || $page == 'coldpizza' || $page == 'redheadphone' || $page == 'vinnypizza' || $page == 'chesspizza'): ?>
              <ul class="navbar-nav ms-3 wallet">
                <li class="nav-item">
                </li>
                <li class="nav-item ms-3">
                  <div class="dropdown">
                    <button
                      id="connectBtn"
                      class="btn btn-secondary navDropDown"
                      type="button"
                      aria-expanded="false"
                    >
                 <!--    <img id="userIcon" src="./img/userIcon.svg" alt="" /> -->
                      <span>Connect</span>
                      <img
                        src="./img/downArrowDark.svg"
                        alt=""
                        class="downArrowDark"
                      />
                    </button>
                    <ul class="dropdown-menu">
                      <div class="mainText">Bread Balance</div>
                      <span class="subHeading">
                        <img
                          src="./img/bpac-sm-icon.svg"
                          alt=""
                          class="me-2"
                        /><span class="bread-balance">0</span>
                      </span>
                      <li>
                        <a href="./account.php" class="dropdown-item <?= ($page == 'account') ? 'active' : ''; ?>">Account</a>
                      </li>
                      <!-- <li><a href="#" class="dropdown-item">Logout</a></li> -->
                    </ul>
                  </div>
                </li>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </nav>
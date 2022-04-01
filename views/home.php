<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | PHP Motors</title>
        <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
    </head>
    <body>
        <div id="wrapper">
            <header>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/header.php'; ?>
            </header>
            
            <main>
                <nav>
                    <!-- <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/0_cse340_web_backend1/phpmotors/snippets/navigation.php'; ?> -->
                    <?php echo $navList;?>
                </nav>
                <h1>Welcome to PHP Motors!</h1>
                <div id="floatingOrderBox">
                    <ul>
                        <li><b>DMC Delorean</b></li>
                        <li>3 Cup holders</li>
                        <li>Superman doors</li>
                        <li>Fuzzy dice!</li>
                    </ul>
                    <img id="own_today" alt="own today" src="images/site/own_today.png">
                </div>
                <img id="bannerImgDelorean" alt="black and white image of delorean" src="images/vehicles/1982-dmc-delorean.jpg">

                <div id="upgradesDiv">    
                    <h2 id="upgrades">Delorean Upgrades</h2>
                    <ul id="upgrades_list">
                        <li id="fluxCapImg" class="upgradesImg"><img alt="flux capacitor" src="images/upgrades/flux-cap.png"></li>
                        <li id="fluxLabel" class="upgradesLabel"><a href="" class="upgradesLabel">Flux Capacitor</a></li>
                        <li id="flameDecImg" class="upgradesImg"><img alt="flame decals" src="images/upgrades/flame.jpg"></li>
                        <li id="flameLabel" class="upgradesLabel"><a href="" class="upgradesLabel">Flame Decals</a></li>
                        <li id="bumperStickerImg" class="upgradesImg"><img alt="bumper stickers" src="images/upgrades/bumper_sticker.jpg"></li>
                        <li id="bumpLabel" class="upgradesLabel"><a href="" class="upgradesLabel">Bumper Stickers</a></li>
                        <li id="hubCapImg" class="upgradesImg"><img alt="hub caps" src="images/upgrades/hub-cap.jpg"></li>
                        <li id="hubLabel" class="upgradesLabel"><a href="" class="upgradesLabel">Hub Caps</a></li>
                    </ul>
                </div>

                <div id="reviewsDiv">
                    <h2 id="reviews">DMC Delorean Reviews</h2>
                    <ul id="review_list">
                        <li><p>"So fast its almost like traveling in time." [4/5]</p></li>
                        <li><p>"Coolest ride on the road." [4/5]</p></li>
                        <li><p>"I'm feeling Marty McFly!" [5/5]</p></li>
                        <li><p>"The most futuristic ride of our day." [4.5/5]</p></li>
                        <li><p>"80's livin and I love it!" [5/5]</p></li>
                    </ul>
                </div>
                
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
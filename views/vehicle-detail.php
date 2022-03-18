<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $carInfo['invColor'].' '.$carInfo['invMake'].' '.$carInfo['invModel']; ?> | PHP Motors</title>
        <link href="/0_cse340_web_backend1/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
    </head>
    <body>
        <div id="wrapper">
            <header>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/header.php'; ?>
            </header>
            
            <main id="vehicleDetailsPage">
                <nav>
                    <!-- <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/0_cse340_web_backend1/phpmotors/snippets/navigation.php'; ?> -->
                    <?php echo $navList;?>
                </nav>
                <h1><?php echo $carInfo['invColor'].' '.$carInfo['invMake'].' '.$carInfo['invModel']; ?></h1>
                <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                ?>
                <?php
                    if (isset($vehicleDetailView)){
                        echo $vehicleDetailView;
                    }
                    if (isset($vehicleThumbnails)){
                        echo "<h2 id='additionalImagesThumb'>Additional Images</h2>";
                        echo $vehicleThumbnails;
                    }
                ?>
            
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']);?>
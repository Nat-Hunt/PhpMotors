<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: ..');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add New Vehicle | PHP Motors</title>
        <link href="/0_cse340_web_backend1/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
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
                <h1>Add New Vehicle</h1>

                <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                ?>
                <form action="../vehicles/" method="post" id="newVehicleForm">
                    <label for="invMake">*Make: </label>
                    <span>Make can be no more than 30 characters</span>
                    <input type="text" name="invMake" id="invMake" required pattern="[A-Za-z0-9]{1,30}" <?php if(isset($invMake)){echo "value='$invMake'";}  ?>><br>

                    <label for="invModel">*Model: </label>
                    <span>Model can be no more than 30 characters</span>
                    <input type="text" name="invModel" id="invModel" required pattern="[A-Za-z0-9]{1,30}" <?php if(isset($invModel)){echo "value='$invModel'";}  ?>><br>

                    <label for="invDescription">*Description: </label>
                    <input type="text" name="invDescription" id="invDescription" required <?php if(isset($invDescription)){echo "value='$invDescription'";}  ?>><br>

                    <label for="invImage">Image: </label>
                    <span>Image URL can be no more than 50 characters</span>
                    <input type="text" name="invImage" id="invImage" value="../images/no-image.png" required <?php if(isset($invImage)){echo "value='$invImage'";}  ?>><br>

                    <label for="invThumbnail">Image Thumbnail: </label>
                    <span>Thumbnail URL can be no more than 50 characters</span>
                    <input type="text" name="invThumbnail" id="invThumbnail" value="../images/no-image.png" required <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?>><br>

                    <label for="invPrice">*Price: </label>
                    <input type="number" name="invPrice" id="invPrice" required <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?>><br>

                    <label for="invStock">*Total in Stock: </label>
                    <span>Stock can be no more than 6 digits</span>
                    <input type="number" name="invStock" id="invStock" required pattern="[0-9]{1,6}" <?php if(isset($invStock)){echo "value='$invStock'";}  ?>><br>

                    <label for="invColor">*Color: </label>
                    <span>Color can be no more than 20 characters</span>
                    <input type="text" name="invColor" id="invColor" required pattern="[A-Za-z0-9]{1,20}" <?php if(isset($invColor)){echo "value='$invColor'";}  ?>><br>

                    <label for="carClassification">*Vehicle Classification: </label>
                    <?php echo $classificationList;?><br>

                    <input type="submit" name="submit" id="regbtn" value="Submit">
                    <input type="hidden" name="action" value="newVehicle">
                    <p>Areas marked with * indicate required fields.</p>
                </form>
            
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
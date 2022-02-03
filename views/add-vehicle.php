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
                    if (isset($message)) {
                        echo $message;
                    }
                ?>
                <form action="../vehicles/" method="post" id="newVehicleForm">
                    <label for="invMake">*Make: </label>
                    <input type="text" name="invMake" id="invMake" required><br>

                    <label for="invModel">*Model: </label>
                    <input type="text" name="invModel" id="invModel" required><br>

                    <label for="invDescription">*Description: </label>
                    <input type="text" name="invDescription" id="invDescription" required><br>

                    <label for="invImage">Image: </label>
                    <input type="text" name="invImage" id="invImage" value="../images/no-image.png" required><br>

                    <label for="invThumbnail">Image Thumbnail: </label>
                    <input type="text" name="invThumbnail" id="invThumbnail" value="../images/no-image.png" required><br>

                    <label for="invPrice">*Price: </label>
                    <input type="text" name="invPrice" id="invPrice" required><br>

                    <label for="invStock">*Total in Stock: </label>
                    <input type="text" name="invStock" id="invStock" required><br>

                    <label for="invColor">*Color: </label>
                    <input type="text" name="invColor" id="invColor" required><br>

                    <label for="carClassification">*Vehicle Classification: </label>
                    <?php echo $classificationList;?>

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
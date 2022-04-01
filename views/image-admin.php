<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Image Managment | PHP Motors</title>
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
                <h1>Image Managment</h1>
                <h2>Add New Vehicle Image</h2>
                <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                ?>

                <form action="../uploads/" method="post" enctype="multipart/form-data">
                	    <?php echo $prodSelect; ?>
                    <label for="file1">Upload Image:</label>
                    <input type="file" name="file1" id="file1">
                    <input type="submit" class="regbtn" value="Upload">
                    <input type="hidden" name="action" value="upload">
                </form>
                <hr>
                <h2>Existing Images</h2>
                <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
                <?php
                    if (isset($imageDisplay)){
                        echo $imageDisplay;
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
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
        <title>Add New Classification | PHP Motors</title>
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
                <h1>Add New Classification</h1>

                <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                ?>
                <form action="../vehicles/" method="post" id="classificationForm">
                    <label for="classificationName">*Classification Name: </label>
                    <span>Classification Name can be no more than 30 characters</span>
                    <input type="text" name="classificationName" id="classificationName" required pattern="[A-Za-z0-9]{1,30}"><br>
                    <input type="submit" name="submit" id="regbtn" value="Submit">
                    <input type="hidden" name="action" value="newClass">
                    <p>Areas marked with * indicate required fields.</p>
                </form>
            
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']);?>
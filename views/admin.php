<?php 
if (isset($_SESSION['loggedin'])){
    if (!$_SESSION['loggedin']) {
        header('Location: /0_cse340_web_backend1/phpmotors/');
    }
} else {
    header('Location: /0_cse340_web_backend1/phpmotors/');
}
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Template | PHP Motors</title>
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
                <h1><?php 
                echo $_SESSION['clientData']['clientFirstname'], " ";
                echo $_SESSION['clientData']['clientLastname'];
                ?></h1>
                <ul>
                <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname'];?></li>
                <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname'];?></li>
                <li>Email Address: <?php echo $_SESSION['clientData']['clientEmail'];?></li>
                </ul>
                <?php 
                    if ($_SESSION['clientData']['clientLevel'] > 1) {
                        echo '<p><a href="../vehicles/">Vehicles Management</a></p>';
                    }
                ?>
                
            
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
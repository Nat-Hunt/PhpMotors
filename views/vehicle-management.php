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
        <title>Vehicle Management | PHP Motors</title>
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
                <h1>Vehicle Management</h1>
                <ul>
                    <li><a href="../vehicles/?action=addClass">Add a new car classification</a></li>
                    <li><a href="../vehicles/?action=addVehicle">Add a vehicle to inventory</a></li>
                </ul>
                <div id="vehiclesByClassification">
                <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    if (isset($classificationList)){
                        echo '<h2>Vehicles By Classification</h2>';
                        echo '<p>Choose a classification to see those vehicles</p>';
                        echo $classificationList;
                    }
                ?>
                <noscript>
                    <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
                </noscript>
                </div>
                <table id="inventoryDisplay"></table>
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
        
        <script src="../js/inventory.js"></script>
    </body>
</html>
<?php unset($_SESSION['message']);?>
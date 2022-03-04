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
        <title><?php
        if (isset($invInfo['invMake']) && isset ($invInfo['invModel'])){
            echo "Delete $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            echo "Delete $invMake $invModel";
        }?> | PHP Motors</title>
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
                    if (isset($invInfo['invMake']) && isset ($invInfo['invModel'])){
                        echo "Delete $invInfo[invMake] $invInfo[invModel]";
                    }?>
                </h1>

                <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                ?>
                
                <form action="../vehicles/" method="post" id="deleteVehicleForm">
                    <p><strong>Confirm Vehicle Deletion.<br><em>The delete is permanent</em><p>
                    <label for="invMake">Make</label><br>
                    <input type="text" name="invMake" id="invMake" required readonly <?php if(isset($invInfo['invMake'])){echo "value='$invInfo[invMake]'"; }  ?>><br>

                    <label for="invModel">Model</label><br>
                    <input type="text" name="invModel" id="invModel" required readonly <?php if(isset($invInfo['invModel'])){echo "value='$invInfo[invModel]'"; }  ?>><br>

                    <label for="invDescription">Description</label><br>
                    <textarea name="invDescription" id="invDescription" required readonly><?php if(isset($invInfo['invDescription'])){echo "$invInfo[invDescription]"; }  ?></textarea><br>

                    <input type="submit" name="submit" id="regbtn" value="Delete Vehicle">
                    <input type="hidden" name="action" value="deleteVehicle">
                    <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){echo $invInfo['invId'];}
                    elseif(isset($invId)){echo $invId;} ?>
                    ">
                </form>
            
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']);?>
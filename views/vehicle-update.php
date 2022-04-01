<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: ..');
    exit;
}

// Build the car classification option list
    $classifList = '<select name="classificationId" id="classificationId">';
    $classifList .= "<option>Choose a Classification</option>";
    foreach ($classifications as $classification) {
        $classifList .= "<option value='$classification[classificationId]'";
        if(isset($classificationId)){
            if($classification['classificationId'] === $classificationId){
                $classifList .= ' selected ';
            }
        } elseif(isset($invInfo['classificationId'])){
            if($classification['classificationId'] === $invInfo['classificationId']){
                $classifList .= ' selected ';
            }
        }
        $classifList .= ">$classification[classificationName]</option>";
    }
    $classifList .= '</select>';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php
        if (isset($invInfo['invMake']) && isset ($invInfo['invModel'])){
            echo "Modify $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            echo "Modify $invMake $invModel";
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
                        echo "Modify $invInfo[invMake] $invInfo[invModel]";
                    } elseif (isset($invMake) && isset($invModel)) {
                        echo "Modify $invMake $invModel";
                    }?>
                </h1>

                <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                ?>
                <form action="../vehicles/" method="post" id="modifyVehicleForm">
                    <label for="invMake">*Make: </label>
                    <span>Make can be no more than 30 characters</span>
                    <input type="text" name="invMake" id="invMake" required pattern="[A-Za-z0-9\s]{1,30}" <?php if(isset($invMake)){echo "value='$invMake'";} elseif(isset($invInfo['invMake'])){echo "value='$invInfo[invMake]'"; }  ?>><br>

                    <label for="invModel">*Model: </label>
                    <span>Model can be no more than 30 characters</span>
                    <input type="text" name="invModel" id="invModel" required pattern="[A-Za-z0-9\s]{1,30}" <?php if(isset($invModel)){echo "value='$invModel'";} elseif(isset($invInfo['invModel'])){echo "value='$invInfo[invModel]'"; }  ?>><br>

                    <label for="invDescription">*Description: </label>
                    <textarea name="invDescription" id="invDescription" required><?php if(isset($invDescription)){echo $invDescription;} elseif(isset($invInfo['invDescription'])){echo "$invInfo[invDescription]"; }  ?></textarea><br>

                    <label for="invPrice">*Price: </label>
                    <input type="number" name="invPrice" id="invPrice" required <?php if(isset($invPrice)){echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])){echo "value='$invInfo[invPrice]'"; }  ?>><br>

                    <label for="invColor">*Color: </label>
                    <span>Color can be no more than 20 characters</span>
                    <input type="text" name="invColor" id="invColor" required pattern="[A-Za-z0-9]{1,20}" <?php if(isset($invColor)){echo "value='$invColor'";} elseif(isset($invInfo['invColor'])){echo "value='$invInfo[invColor]'"; }  ?>><br>

                    <label for="carClassification">*Vehicle Classification: </label>
                    <?php echo $classifList;?><br>

                    <input type="submit" name="submit" id="regbtn" value="Update Vehicle">
                    <input type="hidden" name="action" value="updateVehicle">
                    <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){echo $invInfo['invId'];}
                    elseif(isset($invId)){echo $invId;} ?>
                    ">
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
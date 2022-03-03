<?php

    // This is the Accounts Controller

    // Create or access a Session
    session_start();

    require_once '../library/connections.php';
    require_once '../library/functions.php';
    require_once '../model/main-model.php';
    require_once '../model/vehicles-model.php';

    $classifications = getClassifications();
    // var_dump($classifications);
    // exit;

    // Build a navigation bar using the $classifications array
    $navList = buildNavList($classifications);
    $classificationList = buildClassificationList($classifications);

    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, 'action');
    }
    
    switch ($action) {
        case 'newClass':
            $classificationName = filter_input(INPUT_POST, 'classificationName');
            // Verify input
            $checkName = checkName($classificationName);
            // Check for missing data
            if(empty($checkName)) {
                $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
                include '../views/add-classification.php';
                exit;
            }
            // Send the data to the model
            $regOutcome = newClass($classificationName);
            if($regOutcome === 1){
                header("Location: ../vehicles/");
                exit;
            } else {
                $_SESSION['message'] = "<p>Sorry, but the Submission failed. Please try again.</p>";
                include '../views/add-classification.php';
                exit;
            }
            break;
        case 'newVehicle':
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
            $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
            $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_URL));
            $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_URL));
            $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
            $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
            $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
            // Verify inputs
            $checkMake = checkMake($invMake);
            if ($checkMake == 0) {
                $invMake = NULL;
            }
            $checkModel = checkModel($invModel);
            if ($checkModel == 0) {
                $invModel = NULL;
            }
            $checkImage = checkImage($invImage);
            if ($checkImage == 0) {
                $invImage = NULL;
            }
            $checkThumbnail = checkThumbnail($invThumbnail);
            if ($checkThumbnail == 0) {
                $invThumbnail = NULL;
            }
            $checkStock = checkStock($invStock);
            if ($checkStock == 0) {
                $invStock = NULL;
            }
            $checkColor = checkColor($invColor);
            if ($checkColor == 0) {
                $invColor = NULL;
            }
            // Check for missing data
            if(empty($checkMake) || empty($checkModel) || empty($invDescription) || empty($checkPrice) || empty($checkStock) || empty($checkColor) || empty($classificationId)) {
                $_SESSION['message'] = '<p>Please verify information for form fields.</p>';
                include '../views/add-vehicle.php';
                exit;
            }
            // Send the data to the model
            $regOutcome = newVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
            if($regOutcome === 1){
                $_SESSION['message'] = "<p>Inventory update of $invMake $invModel successful. Current stock: $invStock Current price: $invPrice</p>";
                include '../views/add-vehicle.php';
                exit;
            } else {
                $_SESSION['message'] = "<p>Sorry, but the inventory update failed. Please try again.</p>";
                include '../views/add-vehicle.php';
                exit;
            }
            break;
        case 'addClass':
            include '../views/add-classification.php';
            break;
        case 'addVehicle':
            include '../views/add-vehicle.php';
            break;
        /* *****************************************
        * Get vehicles by classification Id
        * Used for starting Update & Delete process
        ***************************************** */
        case 'getInventoryItems':
            // Get the classificationId
            $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
            // Fetch the vehicles by classificationId from the DB
            $inventoryArray = getInventoryByClassification($classificationId);
            // Convert the array to a JSON object and send it back
            echo json_encode($inventoryArray);
            break;
        default:
            $classificationList = buildClassificationList($classifications);

            include '../views/vehicle-management.php';
            break;
    }

?>
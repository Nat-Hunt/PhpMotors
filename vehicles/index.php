<?php

    // This is the Accounts Controller

    require_once '../library/connections.php';
    require_once '../model/main-model.php';
    require_once '../model/vehicles-model.php';

    $classifications = getClassifications();
    // var_dump($classifications);
    // exit;

    // Build a navigation bar using the $classifications array
    $navList = "<ul id='navul'>";
    $navList .= "<li><a href='/0_cse340_web_backend1/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    $classificationList = "<select name='classificationId' id='carClassification'>";
    foreach ($classifications as $classification) {
        $name = $classification['classificationName'];
        $id = $classification['classificationId'];
        $navList .="<li><a href='/phpmotors/index.php?action=".urlencode($name)."' title='View our $name product line'>$name</a></li>";
        $classificationList .= "<option value='$id'>$name</option>";
    }
    $navList .='</ul>';
    $classificationList .="</select><br>";

    // echo $navList;
    // echo $classificationList;
    // exit;

    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, 'action');
    }
    
    switch ($action) {
        case 'newClass':
            $classificationName = filter_input(INPUT_POST, 'classificationName');
            // Check for missing data
            if(empty($classificationName)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../views/add-classification.php';
                exit;
            }
            // Send the data to the model
            $regOutcome = newClass($classificationName);
            if($regOutcome === 1){
                header("Location: ../vehicles/");
                exit;
            } else {
                $message = "<p>Sorry, but the Submission failed. Please try again.</p>";
                include '../views/add-classification.php';
                exit;
            }
            break;
        case 'newVehicle':
            $invMake = filter_input(INPUT_POST, 'invMake');
            $invModel = filter_input(INPUT_POST, 'invModel');
            $invDescription = filter_input(INPUT_POST, 'invDescription');
            $invImage = filter_input(INPUT_POST, 'invImage');
            $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
            $invPrice = filter_input(INPUT_POST, 'invPrice');
            $invStock = filter_input(INPUT_POST, 'invStock');
            $invColor = filter_input(INPUT_POST, 'invColor');
            $classificationId = filter_input(INPUT_POST, 'classificationId');
            // Check for missing data
            if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invPrice) || empty($invStock) || empty($invColor)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../views/add-vehicle.php';
                exit;
            }
            if(empty($classificationId)) {
                $message = '<p>Please provide information for all empty form fields.';
                $message .= ' You forgot the Classification</p>';
                include '../views/add-vehicle.php';
                exit;
            }
            // Send the data to the model
            $regOutcome = newVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
            if($regOutcome === 1){
                $message = "<p>Inventory update of $invMake $invModel successful. Current stock: $invStock Current price: $invPrice</p>";
                include '../views/add-vehicle.php';
                exit;
            } else {
                $message = "<p>Sorry, but the inventory update failed. Please try again.</p>";
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
        default:
            include '../views/vehicle-management.php';
            break;
    }

?>
<?php

    // This is the Vehicles Controller

    // Create or access a Session
    session_start();

    require_once '../library/connections.php';
    require_once '../library/functions.php';
    require_once '../model/main-model.php';
    require_once '../model/vehicles-model.php';
    require_once '../model/uploads-model.php';

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
                $_SESSION['message'] = '<p class="notice">Please provide information for all empty form fields.</p>';
                include '../views/add-classification.php';
                exit;
            }
            // Send the data to the model
            $regOutcome = newClass($classificationName);
            if($regOutcome === 1){
                header("Location: ../vehicles/");
                exit;
            } else {
                $_SESSION['message'] = '<p class="notice">Sorry, but the Submission failed. Please try again.</p>';
                include '../views/add-classification.php';
                exit;
            }
            break;
        case 'newVehicle':
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
            $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
            $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
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
            $checkColor = checkColor($invColor);
            if ($checkColor == 0) {
                $invColor = NULL;
            }
            // Check for missing data
            if(empty($checkMake) || empty($checkModel) || empty($invDescription) || empty($invPrice) || empty($checkColor) || empty($classificationId)) {
                $_SESSION['message'] = '<p class="notice">Please verify information for form fields.</p>';
                include '../views/add-vehicle.php';
                exit;
            }
            // Send the data to the model
            $regOutcome = newVehicle($invMake, $invModel, $invDescription, $invPrice, $invColor, $classificationId);
            if($regOutcome === 1){
                $_SESSION['message'] = '<p class="notice">Inventory update of '.$invMake.' '.$invModel.' successful. Current price: '.$invPrice.'</p>';
                include '../views/add-vehicle.php';
                exit;
            } else {
                $_SESSION['message'] = '<p class="notice">Sorry, but the inventory update failed. Please try again.</p>';
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
        case 'mod':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);
            if(count($invInfo)<1){
                $_SESSION['message'] = '<p class="notice">Sorry, no vehicle information could be found.</p>';
            }
            include '../views/vehicle-update.php';
            break;
        case 'updateVehicle':
            $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
            $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
            $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
            $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
            // Verify inputs
            // $_SESSION['message'] = "<ul>";
            $checkMake = checkMake($invMake);
            if ($checkMake == 0) {
                $invMake = NULL;
                // $_SESSION['message'] .= "<li>invMake</li>";
            }
            $checkModel = checkModel($invModel);
            if ($checkModel == 0) {
                $invModel = NULL;
                // $_SESSION['message'] .= "<li>checkModel</li>";
            }
            $checkColor = checkColor($invColor);
            if ($checkColor == 0) {
                $invColor = NULL;
                // $_SESSION['message'] .= "<li>checkColor</li>";
            }
            // $_SESSION['message'] .= "</ul>";
            // Check for missing data
            if(empty($checkMake) || empty($checkModel) || empty($checkColor) || empty($invDescription) || empty($invPrice) || empty($classificationId)) {
                $_SESSION['message'] .= '<p class="notice">Please verify information for form fields.</p>';
                include '../views/vehicle-update.php';
                exit;
            }
            // Send the data to the model
            $updateResult = updateVehicle($invId, $invMake, $invModel, $invDescription, $invPrice, $invColor, $classificationId);
            if($updateResult){
                $_SESSION['message'] = '<p class="notice">Update of '.$invMake.' '.$invModel.' successful. Current price: '.$invPrice.'</p>';
                header('location: ../vehicles');
                exit;
            } else {
                $_SESSION['message'] = '<p class="notice">Sorry, but the vehicle update failed. Please try again.</p>';
                include '../views/vehicle-update.php';
                exit;
            }
            break;
        case 'del':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);
            if(count($invInfo)<1){
                $message = 'Sorry, no vehicle information could be found.';
            }
            include '../views/vehicle-delete.php';
            break;
        case 'deleteVehicle':
            $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));

            // Send the data to the model
            $deleteResult = deleteVehicle($invId);
            if($deleteResult){
                $_SESSION['message'] = '<p class="notice">Deletion of '.$invMake.' '.$invModel.' successful.</p>';
                header('location: ../vehicles');
                exit;
            } else {
                $_SESSION['message'] = '<p class="notice">The deletion of '.$invMake.' '.$invModel.' failed. Please try again.</p>';
                include '../views/vehicle-delete.php';
                exit;
            }
            break;
        case 'classification':
            $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $vehicles = getVehiclesByClassification($classificationName);
            if(!count($vehicles)){
                $_SESSION['message'] = '<p class="notice">Sorry, no '.$classificationName.' vehicles could be found.</p>';
            } else {
                // var_dump($vehicles);
                // exit;
                $vehicleDisplay = buildVehiclesDisplay($vehicles);
            }
            // echo $vehicleDisplay;
            // exit;
            include '../views/classification.php';
            break;
        case 'getCarInfo':
            $carId = filter_input(INPUT_GET, 'carId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $carInfo = getInvItemInfo($carId);
            $thumbnails = getThumbnails($carId);
            if(empty($carInfo)){
                $_SESSION['message'] = '<p class="notice">Sorry, no information could be found.</p>';
            } else {
                $vehicleDetailView = buildVehicleDetails($carInfo);
                $vehicleThumbnails = buildVehicleThumbnails($thumbnails);
            }
            include '../views/vehicle-detail.php';
            break;
        case 'searchInventory':
            $query = filter_input(INPUT_GET, 'searchBar', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $currentPage = filter_input(INPUT_GET, 'pagination', FILTER_VALIDATE_INT);

            if (isset($_SESSION['query'])) {
                if ($query == $_SESSION['query']) {
                    if(!isset($_SESSION['results'])){
                        $searchResults = getInvSearchResults($query);
                        $_SESSION['results'] = $searchResults;
                    } else {
                        $searchResults = $_SESSION['results'];
                    }
                } else {
                    $searchResults = getInvSearchResults($query);
                    $_SESSION['results'] = $searchResults;
                    $_SESSION['query'] = $query;
                }
            } else {
                $searchResults = getInvSearchResults($query);
                $_SESSION['results'] = $searchResults;
                $_SESSION['query'] = $query;
            }

            // console_log($searchResults);

            if(empty($searchResults)){
                $_SESSION['message'] = '<p class="notice">Sorry, no information could be found.</p>';
            } else {
                $totalResults = count($searchResults);
                $totalPages = ceil($totalResults / 10);

                $searchResultsView = buildSearchResultsView($searchResults, $totalPages, $totalResults, $currentPage, $query);
            }

            include '../views/search-results.php';
            break;
        default:
            $classificationList = buildClassificationList($classifications);
            include '../views/vehicle-management.php';
            break;
    }

?>
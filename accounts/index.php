<?php

    // This is the Accounts Controller

    require_once '../library/connections.php';
    require_once '../library/functions.php';
    require_once '../model/main-model.php';
    require_once '../model/accounts-model.php';

    $classifications = getClassifications();
    // Build a navigation bar using the $classifications array
    $navList = buildNavList($classifications);

    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, 'action');
    }
    
    switch ($action) {
        // go to login screen
        case 'login':
            include '../views/login.php';
            break;
        // go to registration screen
        case 'registerNewUser':
            include '../views/registration.php';
            break;
        // verify correct login info
        case 'verifyLoginInfo':
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

            // Validate input
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            // Check for missing data
            if(empty($clientEmail) || empty($checkPassword)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../views/login.php';
                exit;
            }
            break;
        // update the database with new registration information
        case 'register':
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

            // Validate input
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../views/registration.php';
                exit;
            }
            // Hash the checked password
            $hashedPassword = password_hash($clientPAssword, PASSWORD_DEFAULT);

            // Send the data to the model
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
            if($regOutcome === 1){
                $message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
                include '../views/login.php';
                exit;
            } else {
                $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
                include '../views/registration.php';
                exit;
            }
            break;
        default:
            include '../views/500.php';
            break;
    }

?>
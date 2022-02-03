<?php

    // This is the Accounts Controller

    require_once '../library/connections.php';
    require_once '../model/main-model.php';
    require_once '../model/accounts-model.php';

    $classifications = getClassifications();
    // var_dump($classifications);
    // exit;

    // Build a navigation bar using the $classifications array
    $navList = "<ul id='navul'>";
    $navList .= "<li><a href='/0_cse340_web_backend1/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .="<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .='</ul>';

    // echo $navList;
    // exit;

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
            include '../views/home.php';
            break;
        // update the database with new registration information
        case 'register':
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname');
            $clientLastname = filter_input(INPUT_POST, 'clientLastname');
            $clientEmail = filter_input(INPUT_POST, 'clientEmail');
            $clientPassword = filter_input(INPUT_POST, 'clientPassword');
            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientPassword)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../views/registration.php';
                exit;
            }
            // Send the data to the model
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword);
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
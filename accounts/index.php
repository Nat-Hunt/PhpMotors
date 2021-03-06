<?php

    // This is the Accounts Controller

    // Create or access a Session
    session_start();

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
        case 'loginPage':
            $_SESSION['message'] = NULL;
            include '../views/login.php';
            break;
        case 'login':
            // echo "logging in...";
            // exit;
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
            // Validate input
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);

            // echo $clientEmail, $checkPassword;
            // exit;
            // Check for missing data
            if(empty($clientEmail) || empty($checkPassword)) {
                $_SESSION['message'] = '<p class="notice">Please provide information for all empty fields.</p>';
                include '../views/login.php';
                exit;
            }

            // A valid passowrd exists, proceed with the login process
            // Query the client data based on the email address
            $clientData = getClient($clientEmail);
            if (empty($clientData)){
                $_SESSION['message'] = '<p class="notice">Invalid username or password</p>';
                include '../views/login.php';
                exit;
            }
            // Compare the password just submitted against
            // the hashed password for the matching client
            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
            // if the hashes don't match create an error
            // and return to the login view
            if(!$hashCheck){
                $_SESSION['message'] = '<p class="notice">Invalid username or password</p>';
                include '../views/login.php';
                exit;
            }

            // A valid user exists, log them in
            $_SESSION['loggedin'] = TRUE;
            // Remove the password from the array
            // the array_pop function removes the last
            // element from an array
            array_pop($clientData);
            // Store the array into the session
            $_SESSION['clientData'] = $clientData;
            // Send them to the admin view
            include '../views/admin.php';
            break;
        // go to registration screen
        case 'registerNewUser':
            $_SESSION['message'] = NULL;
            include '../views/registration.php';
            break;
        // verify correct login info
        case 'Logout':
            session_unset();
            session_destroy();
            header('Location: /0_cse340_web_backend1/phpmotors/');
            break;
        // update the database with new registration information
        case 'register':
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

            // Check for an existing email address
            $existingEmail = checkExistingEmail($clientEmail);
            if($existingEmail) {
                $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
                include '../views/login.php';
                exit;
            }
            // Validate input
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
                $_SESSION['message'] = '<p class="notice">Please provide information for all empty form fields.</p>';
                include '../views/registration.php';
                exit;
            }
            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

            // Send the data to the model
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
            if($regOutcome === 1){
                setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
                $_SESSION['message'] = '<p class="notice">Thanks for registering '.$clientFirstname.'. Please use your email and password to login.</p>';
                header('Location: ../accounts/?action=login');
                exit;
            } else {
                $_SESSION['message'] = '<p class="notice">Sorry '.$clientFirstname.', but the registration failed. Please try again.</p>';
                include '../views/registration.php';
                exit;
            }
            break;
        case 'updateAccountInfo':
            include '../views/client-update.php';
            break;
        case 'updateAccount':
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT);
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));

            // Check for an existing email address
            if ($_SESSION['clientData']['clientEmail'] != $clientEmail){
                $existingEmail = checkExistingEmail($clientEmail);
                if($existingEmail) {
                    $_SESSION['message'] = '<p class="notice">That email address already exists.</p>';
                    include '../views/client-update.php';
                    exit;
                }
            }
            // Validate input
            $clientEmail = checkEmail($clientEmail);
            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
                $_SESSION['message'] = '<p class="notice">Please provide information for all empty form fields.</p>';
                include '../views/client-update.php';
                exit;
            }

            // Send the data to the model
            $updateOutcome = updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail);
            if($updateOutcome === 1){
                unset($_SESSION['clientData']);
                $_SESSION['clientData'] = getClientById($clientId);
                setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
                $_SESSION['message'] = '<p class="notice">'.$clientFirstname.', your account information has been succesfully updated.</p>';
                header('Location: ../accounts/');
                exit;
            } else {
                $_SESSION['message'] = '<p class="notice">Sorry '.$clientFirstname.', but the account information update failed. Please try again.</p>';
                include '../accounts/';
                exit;
            }
            break;
        case 'changePassword':
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT);
            $oldPassword = trim(filter_input(INPUT_POST, 'oldPassword', FILTER_SANITIZE_STRING));
            $confirmPassword = trim(filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

            $checkPassword1 = checkPassword($oldPassword);
            $checkPassword2 = checkPassword($confirmPassword);
            $checkPassword3 = checkPassword($clientPassword);
            // Check for missing data
            if(empty($checkPassword1) || empty($checkPassword2) || empty($checkPassword3)) {
                $_SESSION['passwordMessage'] = '<p class="notice">Invalid Password (missing)</p>';
                include '../views/client-update.php';
                exit;
            }

            // Check that the old and confirm passwords are the same
            $checkPasswordConfirmation = password_verify($confirmPassword, password_hash($oldPassword, PASSWORD_DEFAULT));
            if(!$checkPasswordConfirmation){
                $_SESSION['passwordMessage'] = '<p class="notice">Failed to confirm the old password</p>';
                include '../views/client-update.php';
                exit;
            }
            $clientData = getClientById($clientId);
            $hashCheck = password_verify($oldPassword, $clientData['clientPassword']);
            if(!$hashCheck){
                $_SESSION['passwordMessage'] = '<p class="notice">Invalid password (old didn not match)</p>';
                include '../views/client-update.php';
                exit;
            }

            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

            // Send the data to the model
            $passwordOutcome = changePassword($clientId, $hashedPassword);
            if($passwordOutcome === 1){
                $_SESSION['message'] = '<p class="notice">Password changed successfully.</p>';
                header('Location: ../accounts/');
                exit;
            } else {
                $_SESSION['message'] = '<p class="notice">Pasword update failed. Please try again.</p>';
                include '../accounts/';
                exit;
            }
            break;
        default:
            include '../views/admin.php';
            break;
    }

?>
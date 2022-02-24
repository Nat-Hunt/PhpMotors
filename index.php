<?php

    // This is the Root Controller

    // Create or access a Session
    session_start();

    require_once 'library/connections.php';
    require_once 'library/functions.php';
    require_once 'model/main-model.php';

    $classifications = getClassifications();
    // var_dump($classifications);
    // exit;

    // Build a navigation bar using the $classifications array
    $navList = buildNavList($classifications);

    // echo $navList;
    // exit;

    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, 'action');
    }

    switch ($action) {
        case 'template':
            include 'views/template.php';
            break;
        
        default:
            include 'views/home.php';
            break;
    }

?>
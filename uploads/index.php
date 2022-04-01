<?php
    // Image uploads controller

    session_start();

    require_once '../library/connections.php';
    require_once '../library/functions.php';
    require_once '../model/main-model.php';
    require_once '../model/vehicles-model.php';
    require_once '../model/uploads-model.php';

    // Get the array of classifications
    $classifications = getClassifications();
    // Build a navigation bar using the $classifications array
    $navList = buildNavList($classifications);

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /* * ****************************************************
    * Variables for use with the Image Upload Functionality
    * **************************************************** */
    // directory name where uploaded images are stored
    $image_dir = '/0_cse340_web_backend1/phpmotors/images/vehicles';
    // The path is the full path from the server root
    $image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

    switch ($action) {
        case 'upload':
            // Store the incoming vehicle id and primary picture indicator
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Store the name of the uploaded image
            $imgName = $_FILES['file1']['name'];

            $imgCheck = checkExistingImage($imgName);

            if ($imgCheck){
                $_SESSION['message'] = '<p class="notice">An image by that name already exists.</p>';
            } elseif (empty($invId) || empty($imgName)) {
                $_SESSION['message'] = '<p class="notice"> You must select a vehicle and image file for the vehicle.</p>';
            } else {
                // upload the image, store the returned path to the file
                $imgPath = uploadFile('file1');

                // Insert the image information to the database, get the result
                $result = storeImages($imgPath, $invId, $imgName);
                
                // Set a message based on the insert result
                if($result) {
                    $_SESSION['message'] = '<p class="notice">The upload succeeded.</p>';
                } else {
                    $_SESSION['message'] = '<p class="notice">Sorry, the upload failed.</p>';
                }
            }

            // Redirec tto this controller for default action
            header('location: .');
            break;
        case 'delete':
            // Get the image name and id
            $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);

            // Build the full path to the image to be deleted
            $target = $image_dir_path . '/' . $filename;

            // Check that the file exists in that location
            if (file_exists($target)) {
                // Deletes the file in the folder
                $result = unlink($target);
            }

            // Remove from database only if physical file deleted
            if ($result) {
                $remove = deleteImage($imgId);
            }

            // Set a message based on the delete result
            if ($remove){
                $_SESSION['message'] = "<p class='notice'>$filename was successfully deleted</p>";
            } else {
                $_SESSION['message'] = "<p class='notice'>$filename was NOT deleted</p>";
            }

            // Redirec tto this controller for default action
            header('location: .');
            break;
        default:
            // Call function to return image info from database
            $imageArray = getImages();

            // Build the image information into HTML for display
            if (count($imageArray)) {
                $imageDisplay = buildImageDisplay($imageArray);
            } else {
                $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
            }

            // Get vehicles information from database
            $vehicles = getVehicles();
            // build a select list of vehicle information fro the view
            $prodSelect = buildVehiclesSelect($vehicles);

            include '../views/image-admin.php';
            exit;
            break;
    }
?>
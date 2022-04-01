<?php

// function console_log($data){
//     echo '<script>';
//     echo 'console.log('. json_encode($data) .')';
//     echo '</script>';
// }

function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function checkPassword($clientPassword) {
    // Check the password for a minimum of 8 characters,
    // at least 1 capital letter, at least 1 number,
    // and at least 1 special character
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

function checkName($classificationName){
    $pattern = '/^[a-zA-Z0-9\s]{1,30}$/';
    return preg_match($pattern, $classificationName);
}

function checkMake($invMake){
    $pattern = '/^[a-zA-Z0-9\s]{1,30}$/';
    return preg_match($pattern, $invMake);
}

function checkModel($invModel){
    $pattern = '/^[a-zA-Z0-9\s]{1,30}$/';
    return preg_match($pattern, $invModel);
}

function checkColor($invColor){
    $pattern = '/^[a-zA-Z0-9]{1,20}$/';
    return preg_match($pattern, $invColor);
}

function buildNavList($classifications){
    $navList = "<ul id='navul'>";
    $navList .= "<li><a href='/0_cse340_web_backend1/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $name = $classification['classificationName'];
        $id = $classification['classificationId'];
        $navList .="<li><a href='/0_cse340_web_backend1/phpmotors/vehicles/?action=classification&classificationName=".urlencode($name)."' title='View our $name product line'>$name</a></li>";
    }
    $navList .='</ul>';
    return $navList;
}

function buildClassificationList($classifications){
    $classificationList = "<select name='classificationId' id='classificationList'>";
    $classificationList .= "<option value='none'>Choose a classification</option>";
    foreach ($classifications as $classification) {
        $name = $classification['classificationName'];
        $id = $classification['classificationId'];
        $classificationList .= "<option value='$id'>$name</option>";
    }
    $classificationList .="</select>";
    return $classificationList;
}

function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach($vehicles as $vehicle){
        $dv .= '<li>';
        $dv .= "<img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
        $dv .= '<hr>';
        $dv .= "<h2><a href='/0_cse340_web_backend1/phpmotors/vehicles/?action=getCarInfo&carId=".urlencode($vehicle['invId'])."'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
        $dv .= "<span>$".number_format($vehicle['invPrice'], 2)."</span>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehicleDetails($carInfo){
    $make = $carInfo['invMake'];
    $model = $carInfo['invModel'];
    $color = $carInfo['invColor'];
    $description = $carInfo['invDescription'];
    $image = $carInfo['imgPath'];
    $price = number_format($carInfo['invPrice'], 2);
    
    $dv = "<div id='vehicleDetails'>";
    // $dv .= "<h2>$make $model</h2>";
    $dv .= "<img class='leftColumn' src=$image alt='Image of $make $model on phpmotors.com'>";
    $dv .= "<div class='rightColumn'>";
    $dv .= "<p class='rightColumn'><strong>$$price</strong></p>";
    $dv .= "<p class='rightColumn'>$description</p>";
    $dv .= "</div>";
    $dv .= "</div>";
    return $dv;
}

function buildVehicleThumbnails($thumbnails){
    $dv = "<ul id='vehicleThumbnails'>";
    foreach($thumbnails as $thumbnail){
        $dv .= "<li><img src=$thumbnail[imgPath] alt='Image of $thumbnail[invMake] $thumbnail[invModel] on phpmotors.com'></li>";
    }
    $dv .= "</ul>";
    return $dv;
}

function buildSearchResultsView($searchResults, $totalPages, $totalResults, $currentPage, $query){

    $dv = '';
    $dv .= "<span id='countResults'>".$totalResults." results</span>";
    $dv .= '<ul id="search-display">';
    
    if ($currentPage == 1){
        $startingIndex = 0;
    } elseif ($currentPage > 1) {
        $startingIndex = $currentPage * 10 - 10;
    }
    $maxIndex = $startingIndex + 10;
    if ($maxIndex > $totalResults) {
        $maxIndex = $totalResults;
    }
    for ($i = $startingIndex; $i < $maxIndex; $i++){
        $result = $searchResults[$i];
        $dv .= '<li>';
        $dv .= "<h2><a href='/0_cse340_web_backend1/phpmotors/vehicles/?action=getCarInfo&carId=".urlencode($result['invId'])."'>$result[invMake] $result[invModel]</a></h2>";
        $dv .= "<img src='$result[imgPath]' alt='Image of $result[invMake] $result[invModel] on phpmotors.com'>";
        $dv .= "<span>".$result['invDescription']."</span>";
        $dv .= '</li>';
    }

    $dv .= '</ul>';
    $dv .= "<div id='resultsPages'>";
    if ($currentPage - 1 > 0) {
        $previousPage = $currentPage - 1;
        $dv .= "<a href='/0_cse340_web_backend1/phpmotors/vehicles/?action=searchInventory&searchBar=$query&pagination=$previousPage'>Previous</a>";
    }
    for ($i = 1; $i <= $totalPages; $i++){
        if ($i == $currentPage) {
            $dv .= "<span>$i</span>";
        } else {
            $dv .= "<a href='/0_cse340_web_backend1/phpmotors/vehicles/?action=searchInventory&searchBar=$query&pagination=$i'>$i</a>";
        }
    }
    if ($currentPage + 1 <= $totalPages) {
        $nextPage = $currentPage + 1;
        $dv .= "<a href='/0_cse340_web_backend1/phpmotors/vehicles/?action=searchInventory&searchBar=$query&pagination=$nextPage'>Next</a>";
    }
    $dv.="</div>";
    
    // exit;
    return $dv;
}

/* * ********************************
*  Functions for working with images
* ********************************* */
// Adds "-tn" designation to file name
function makeThumbnailName($image){
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray){
    $id = '<ul id="image-display">';
    foreach($imageArray as $image) {
        $id .= '<li class="imageDisplay">';
        $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
        $id .= "<p><a href='/0_cse340_web_backend1/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .='</li>';
    }
    $id .= '</ul>';
    return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<label for="invId">Vehicle</label>';
    $prodList .= '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

   // Handles the file upload process and returns the path
   // The file path is stored into the database
   function uploadFile($name) {
       // Gets the paths, full and local directory
       global $image_dir, $image_dir_path;
       if (isset($_FILES[$name])) {
           // Gets the actual file name
           $filename = $_FILES[$name]['name'];
           if(empty($filename)){
               return;
           }
           // Get the file from the temp folder on the server
           $source = $_FILES[$name]['tmp_name'];
           // Sets the new path - images folder in this directory
           $target = $image_dir_path . '/' . $filename;
           // Moves the file to the target folder
           move_uploaded_file($source, $target);
           // Send file for further processing
           processImage($image_dir_path, $filename);
           // Sets the path for the image for Database storage
           $filepath = $image_dir . '/' . $filename;
           return $filepath;
       }
   }

   // Processes images by getting paths and
   // creating smaller versions o fthe image
   function processImage($dir, $filename){
       // Set up the variables
       $dir = $dir . '/';

       // Set up the image path
       $image_path = $dir . $filename;

       // set up the thumbnail image path
       $image_path_tn = $dir.makeThumbnailName($filename);

       // Create a thumbnail image that's a maximum of 200 pixels square
       resizeImage($image_path, $image_path_tn, 200, 200);

       // Resize original to a maximum of 500 pixels square
       resizeImage($image_path, $image_path, 500, 500);
   }

   // Checks and Resizes image
   function resizeImage($old_iamge_path, $new_image_path, $max_width, $max_height){
       // Get image type
       $image_info = getimagesize($old_iamge_path);
       $image_type = $image_info[2];

       // Set up the function names
       switch($image_type){
            case IMAGETYPE_JPEG:
                $image_from_file = 'imagecreatefromjpeg';
                $image_to_file = 'imagejpeg';
                break;
            case IMAGETYPE_GIF:
                $image_from_file = 'imagecreatefromgif';
                $image_to_file = 'imagegif';
                break;
            case IMAGETYPE_PNG:
                $image_from_file = 'imagecreatefrompng';
                $image_to_file = 'imagepng';
                break;
            default:
                return;
       } // ends the switch

       // Get the old image and its height and width
       $old_image = $image_from_file($old_iamge_path);
       $old_width = imagesx($old_image);
       $old_height = imagesy($old_image);

       // Calculate height and width ratios
       $width_ratio = $old_width / $max_width;
       $height_ratio = $old_height / $max_height;

       // if image is larger than specified ratio, create the new image
       if ($width_ratio > 1 || $height_ratio > 1){
            // Calculate height and width for the new image
            $ratio = max($width_ratio, $height_ratio);
            $new_height = round($old_height / $ratio);
            $new_width = round($old_width / $ratio);

            // create the new image
            $new_image = imagecreatetruecolor($new_width, $new_height);

            // Set transparency according to image type
            if ($image_type == IMAGETYPE_GIF) {
                $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                imagecolortransparent($new_image, $alpha);
            }

            if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
                imagealphablending($new_image, false);
                imagesavealpha($new_image, true);
            }

            // copy old image to new image - this resizes the image
            $new_x = 0;
            $new_y = 0;
            $old_x = 0;
            $old_y = 0;
            imagecopyresampled($new_image,$old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

            // Write the new image to a new file
            $image_to_file($new_image, $new_image_path);
            // Free any memory associated with the new image
            imagedestroy($new_image);
       } else {
           // Write the old image to a new file
           $image_to_file($old_image, $new_image_path);
       }
       // Free any memory associated with teh old image
       imagedestroy($old_image);
   } // ends resizeImage function
?>
<?php

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

function checkStock($invStock){
    $pattern = '/^[0-9]{1,6}$/';
    return preg_match($pattern, $invStock);
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
        $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
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
    $image = $carInfo['invImage'];
    $price = number_format($carInfo['invPrice'], 2);
    $stock = $carInfo['invStock'];
    
    $dv = "<div id='vehicleDetails'>";
    // $dv .= "<h2>$make $model</h2>";
    $dv .= "<img class='leftColumn' src=$image alt='Image of $make $model on phpmotors.com'>";
    $dv .= "<div class='rightColumn'>";
    $dv .= "<p class='rightColumn'><strong>$$price</strong></p>";
    $dv .= "<p class='rightColumn'>Quantity available: $stock</p>";
    $dv .= "<p class='rightColumn'>$description</p>";
    $dv .= "</div>";
    $dv .= "</div>";
    return $dv;
}
?>
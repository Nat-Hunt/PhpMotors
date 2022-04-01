<?php

/*
* Vehicles Model
*/

// Create a new class of vehicle
function newClass($classificationName){
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO carclassification (classificationName)
        VALUES (:classificationName)';
    //Create the prepared statement using the php_motors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tell sthe database the type of data it is
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our inser
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows chagneD)
    return $rowsChanged;
}

// Create a new vehicle
function newVehicle($invMake, $invModel, $invDescription, $invPrice, $invColor, $classificationId) {
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invPrice, invColor, classificationId)
        VALUES (:invMake, :invModel, :invDescription, :invPrice, :invColor, :classificationId)';
    //Create the prepared statement using the php_motors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tell sthe database the type of data it is
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our inser
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows chagneD)
    return $rowsChanged;
}

// Get vehicles by classificationId
function getInventoryByClassification($classificationId){
    $db = phpmotorsConnect();
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}

// Get vehicle information by invId
function getInvItemInfo($invId){
    // echo $invId;
    // exit;
    $db = phpmotorsConnect();
    $sql = 'SELECT inv.invId, inv.invMake, inv.invModel, inv.invDescription, inv.invPrice, inv.invColor, inv.classificationId, img.imgPath 
    FROM inventory inv JOIN images img 
    ON inv.invId = img.invId 
    WHERE (inv.invId = :invId) AND (img.imgName NOT LIKE "%-tn.%")';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    // var_dump($invInfo);
    // exit;
    return $invInfo;
}

// Update an existing vehicle
function updateVehicle($invId, $invMake, $invModel, $invDescription, $invPrice, $invColor, $classificationId) {
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel,
        invDescription = :invDescription, invPrice = :invPrice, invColor = :invColor,
        classificationId = :classificationId WHERE invId = :invId';
    //Create the prepared statement using the php_motors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tell sthe database the type of data it is
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our inser
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows chagneD)
    return $rowsChanged;
}

// Delete an existing vehicle
function deleteVehicle($invId) {
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function getVehiclesByClassification($classificationName){
    $db = phpmotorsConnect();
    // would it not be better simply to store the classificationId
    // with the nav list as an additional name-value pair? It would
    // query the database less often. 
    // Is the way we were told to do this better from a security standpoint?
    $sql = 'SELECT inv.invId, inv.invYear, inv.invMake, inv.invModel, inv.invDescription, inv.invPrice, inv.invColor, inv.classificationId, img.imgPath 
    FROM inventory inv JOIN images img ON inv.invId = img.invId 
    WHERE inv.classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName) AND img.imgName LIKE "%-tn.%"';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
}

function getVehicles(){
    $db = phpmotorsConnect();
    $sql = 'SELECT invId, invMake, invModel FROM inventory';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

//Search Inventory table for possible matches to user query
function getInvSearchResults($userQuery){

    $db = phpmotorsConnect();
    $sql = 'SELECT inv.invId, inv.invMake, inv.invModel, inv.invDescription, inv.invPrice, inv.invColor, img.imgPath 
    FROM carclassification cc JOIN inventory inv 
    ON cc.classificationId = inv.classificationId JOIN images img 
    ON inv.invId = img.invId 
    WHERE (
        inv.invMake LIKE :userQuery OR 
        inv.invModel LIKE :userQuery OR 
        cc.classificationName LIKE :userQuery
        )
    AND (img.imgName LIKE "%-tn.%")';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userQuery', '%'.$userQuery.'%', PDO::PARAM_STR);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    // var_dump($searchResults);
    // exit;
    return $searchResults;
}

?>
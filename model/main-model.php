<?php
// this is the Main PHP Motors Model

if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   }

function getClassifications() {
    // Create a connection object from the phpomotors connection function
    $db = phpmotorsConnect();
    // The SQL statement to be used with the database
    $sql = 'SELECT classificationId, classificationName FROM carclassification ORDER BY classificationName ASC';
    // The next line creates the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next line runs the prepared statement
    $stmt->execute();
    // The next line gets the data from the database and
    // stores it as an array in the $classifications variable
    $classifications = $stmt->fetchAll();
    // The next line closes the interactino with the database
    $stmt->closeCursor();
    // The next line sends the array of data back to where the function
    // was called (this should be the controller)
    return $classifications;

}

?>
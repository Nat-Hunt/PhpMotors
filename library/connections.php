<?php
/*
* Proxy connection to the phpmotors database
*/
function phpmotorsConnect(){
    $server = 'localhost';
    $dbname= 'phpmotors';
    $username = 'iClient';
    $password = '2L2(9vALxoucIhk3'; 
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
   
    try {
        $link = new PDO($dsn, $username, $password, $options);
        // if (is_object($link)) {
        //     echo 'it worked';
        // }
        return $link;
    } catch(PDOException $e) {
        header('Location: /0_cse340_web_backend1/phpmotors/views/500.php');
        exit;
    }
}

// phpmotorsConnect();

?>
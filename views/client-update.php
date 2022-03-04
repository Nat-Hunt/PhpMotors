<?php 
    if (isset($_SESSION['loggedin'])){
        if (!$_SESSION['loggedin']) {
            header('Location: /0_cse340_web_backend1/phpmotors/');
        }
    } else {
        header('Location: /0_cse340_web_backend1/phpmotors/');
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Account Information | PHP Motors</title>
        <link href="/0_cse340_web_backend1/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
    </head>
    <body>
        <div id="wrapper">
            <header>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/header.php'; ?>
            </header>
            
            <main>
                <nav>
                    <!-- <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/0_cse340_web_backend1/phpmotors/snippets/navigation.php'; ?> -->
                    <?php echo $navList;?>
                </nav>
                <h1>Update Account Information</h1>
                
                <h2>Change Information</h2>
                
                <form action="../accounts/" method="post" id="accountUpdate">
                    <?php 
                        if (isset($_SESSION['message'])){
                            echo $_SESSION['message'];
                        }
                    ?>
                    <label for="clientFirstname">*First Name</label>
                    <input type="text" name="clientFirstname" id="clientFirstname" required <?php 
                        if(isset($_SESSION['clientData']['clientFirstname'])){
                            $firstName = $_SESSION['clientData']['clientFirstname'];
                            echo "value='$firstName'";
                        }  
                    ?>><br>
                    
                    <label for="clientLastname">*Last Name</label>
                    <input type="text" name="clientLastname" id="clientLastname" required <?php
                        if(isset($_SESSION['clientData']['clientLastname'])){
                            $lastName = $_SESSION['clientData']['clientLastname'];
                            echo "value='$lastName'";
                        }
                        ?>><br>
                    
                    <label for="clientEmail">*Email Address</label>
                    <input type="email" name="clientEmail" id="clientEmail" required <?php
                        if(isset($_SESSION['clientData']['clientEmail'])){
                            $email = $_SESSION['clientData']['clientEmail'];
                            echo "value='$email'";
                        }
                        ?>><br>

                    <input type="submit" name="submit" id="regbtn" value="Update">
                    <input type="hidden" name="action" value="updateAccount">
                    <input type="hidden" name="clientId" value="<?php
                        if(isset($_SESSION['clientData']['clientId'])){
                            echo $_SESSION['clientData']['clientId'];
                        }
                    ?>">
                    <p>Areas marked with * indicate required fields.</p>
                </form>

                <h2>Change Password</h2>
                <form action="../accounts/" method="post" id="changePassword">
                    <?php 
                        if (isset($_SESSION['passwordMessage'])){
                            echo $_SESSION['passwordMessage'];
                        }
                    ?>
                    <label for="oldPassword">*Old Password</label>
                    <input type="password" name="oldPassword" id="oldPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    
                    <label for="confirmPassword">*Confirm Password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    
                    <label for="clientPassword">*New Password</label>
                    <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
                    <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    
                    <input type="submit" name="submit" id="passregbtn" value="Submit">
                    <input type="hidden" name="action" value="changePassword">
                    <input type="hidden" name="clientId" value="<?php
                        if(isset($_SESSION['clientData']['clientId'])){
                            echo $_SESSION['clientData']['clientId'];
                        }
                    ?>">
                    <p>Areas marked with * indicate required fields.</p>
                </form>
            
            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
    unset($_SESSION['passwordMessage']);
?>
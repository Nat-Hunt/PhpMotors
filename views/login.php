<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | PHP Motors</title>
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
                <h1>Login</h1>
                <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                ?>
                <form action="../accounts/" method="post" id="loginForm">
                    <label for="clientEmail">Email Address: </label>
                    <input type="email" name="clientEmail" id="clientEmail" required <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>><br>
                    <label for="clientPassword">Password: </label>
                    <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
                    <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    <input type="submit" name="submit" id="logbtn">
                    <input type="hidden" name="action" value="login">
                    <p id="registerNewUser">No account? <a href='../accounts/?action=registerNewUser'>Register Here</a></p>
                </form>

            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']);?>
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
                    if (isset($message)) {
                        echo $message;
                    }
                ?>
                <form action="../accounts/?action=verifyLoginInfo" id="loginForm">
                    <label for="clientEmail">Email Address: </label>
                    <input type="text" name="clientEmail" id="clientEmail"><br>
                    <label for="clientPassword">Password: </label>
                    <input type="password" name="clientPassword" id="clientPassword"><br>
                    <input type="submit" value="Login">
                    <p id="registerNewUser">No account? <a href='../accounts/?action=registerNewUser'>Register Here</a></p>
                </form>

            </main>
            
            <footer>
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/0_cse340_web_backend1/phpmotors/snippets/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
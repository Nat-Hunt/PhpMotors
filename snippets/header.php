<img src="/0_cse340_web_backend1/phpmotors/images/site/logo.png" alt="PHP Motors logo" id="logoImg">
<p id="accountLink"><?php if(isset($cookieFirstname)){
    echo "<span>Welcome $cookieFirstname</span>";
} ?><br><a href="/0_cse340_web_backend1/phpmotors/accounts/?action=login">My Account</a></p>
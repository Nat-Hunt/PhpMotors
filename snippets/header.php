<img src="/0_cse340_web_backend1/phpmotors/images/site/logo.png" alt="PHP Motors logo" id="logoImg">

<form id="searchBox" action="/0_cse340_web_backend1/phpmotors/vehicles/" method="GET">
    <label for="searchBar">Search</label>
    <input name="searchBar" id="searchBar" required>
    <input type="submit" name="Submit" id="regbtn" value="Submit">
    <input type="hidden" name="action" value="searchInventory">
    <input type="hidden" name="pagination" value="1">
</form>

<p id="accountLink"><?php 
if(isset($_SESSION['clientData']['clientFirstname'])){
    $firstname = $_SESSION['clientData']['clientFirstname'];
    echo '<a href="/0_cse340_web_backend1/phpmotors/accounts">';
    echo "Welcome $firstname</a>";
} 
if(isset($_SESSION['loggedin'])){
    if($_SESSION['loggedin']){
        echo '<br><a href="/0_cse340_web_backend1/phpmotors/accounts/?action=Logout">Logout</a>';
    } else {
        echo '<br><a href="/0_cse340_web_backend1/phpmotors/accounts/?action=loginPage">My Account</a>';
    }
} else {
    echo '<br><a href="/0_cse340_web_backend1/phpmotors/accounts/?action=loginPage">My Account</a>';
}
?></p>
<!--index.php-->
<?php
/**
 * Created by PhpStorm.
 * User: Dung
 * Date: 3/8/2019
 * Time: 8:45 AM
 */
session_start();

if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = $_SESSION['userLoggedIn'];
    echo "Hello $userLoggedIn";
} else {
    header('Location: register.php');
}
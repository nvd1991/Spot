<!--config.php file-->
<?php
ob_start();
session_start();

/*
 * -------------------------
 * Config default timezone |
 * -------------------------
 */
$timezone = date_default_timezone_set('YOUR_TIMEZONE');

/*
 * ----------------
 * Config DB info |
 * ----------------
 */
$host = 'HOST';
$username = 'USERNAME';
$password = 'PASSWORD';
$dbname = 'DBNAME';
$port = 'PORT';

$connection = mysqli_connect($host, $username, $password, $dbname, $port);
if(!$connection){
    die('Connect error: ' . mysqli_connect_error());
}
//mysqli_close($connection);
<!--config.php file-->
<?php
ob_start();
session_start();

/*
 * -------------------------
 * Config default timezone |
 * -------------------------
 */
$timezone = date_default_timezone_set('Asia/Ho_Chi_Minh');

/*
 * ----------------
 * Config DB info |
 * ----------------
 */
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'spotifydb';
$port = '3306';

$connection = mysqli_connect($host, $username, $password, $dbname, $port);
if(!$connection){
    die('Connect error: ' . mysqli_connect_error());
}
//mysqli_close($connection);
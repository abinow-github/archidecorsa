<?php
$servername="localhost";
$username="root";
$password="";
$dbname="archidecorsa";

$mysqli= new mysqli($servername,$username,$password,$dbname);
if($mysqli->connect_error){
    die ("connectio faild:" . $mysqli->connect_error);
}
define('BASE_URL', 'http://localhost/archidecorsa');
?>


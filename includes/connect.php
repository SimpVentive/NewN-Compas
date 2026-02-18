<?php
$host="localhost";
//@$user="dbo300630203";
$user="teledialravi";
//@$pass="ads@ads";
$pass="ravi@123";
$dbase="teleidial";
$conn=mysql_connect($host,$user,$pass);
mysql_select_db($dbase,$conn);

$mysqli = new mysqli($host,$user,$pass,$dbase);
?>
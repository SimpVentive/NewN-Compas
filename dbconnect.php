<?php
defined('DBPATH') ? null : define ('DBPATH','');
defined('DBUSER') ? null : define ('DBUSER','');
defined('DBPASS') ? null : define ('DBPASS','');
defined('DBNAME') ? null : define ('DBNAME','');
try{
	global $con;
	$con=mysqli_connect(DBPATH,DBUSER,DBPASS,DBNAME);
	//mysql_select_db(DBNAME,$con)or die(mysql_error());
}
catch (Exception $e){
	throw new Exception( 'Something really gone wrong', 0, $e);
}
?>

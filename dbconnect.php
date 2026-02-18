<?php
defined('DBPATH') ? null : define ('DBPATH','localhost');
defined('DBUSER') ? null : define ('DBUSER','root');
defined('DBPASS') ? null : define ('DBPASS','UTS@2011IND');
defined('DBNAME') ? null : define ('DBNAME','heidelberg_ncompas');
//defined('DBNAME') ? null : define ('DBNAME','cs_fertilizer_backup');
try{
	global $con;
	$con=mysqli_connect(DBPATH,DBUSER,DBPASS,DBNAME);
	//mysql_select_db(DBNAME,$con)or die(mysql_error());
}
catch (Exception $e){
	throw new Exception( 'Something really gone wrong', 0, $e);
}
?>

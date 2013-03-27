<?php
require_once 'settings.php';
$db_handle=connectToDB($DB_SETUP);
function connectToDB($dbs){
	$host=$dbs['host'];
	$db=$dbs['db'];
	$user=$dbs['user'];
	$pass=$dbs['pass'];
	$db_handle = pg_connect("host=$host dbname=$db user=$user password=$pass")
	    or die ("Could not connect to server\n");
	return $db_handle;
}
?>
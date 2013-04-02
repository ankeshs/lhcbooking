<?php
require_once 'settings.php';
$db_handle=connectToDB($DB_SETUP);
function connectToDB($dbs){
	$host=$dbs['host'];
	$db=$dbs['db'];
	$user=$dbs['user'];
	$pass=$dbs['pass'];
	$db_handle = pg_connect("host=$host dbname=$db user=$user")
	    or die ("Could not connect to server\n");
	return $db_handle;
}

function getAssoc($db, $q){
	$rs = pg_query($db, $q);
	if($rs){		
		if($sd = pg_fetch_assoc($rs)){
			return $sd;
		}
	}
	return FALSE;
}

function getNumRows($db, $q){
	$rs = pg_query($db, $q);
	if($rs){		
		return pg_num_rows($rs);
	}
	return 0;
}

function getTable($db, $q){
	$rs = pg_query($db, $q);
	$a=array();	
	$i=0;
	if($sd = pg_fetch_assoc($rs)){
		$a[$i]=$sd;
		$i=$i+1;
	}	
	return $a;
}
?>

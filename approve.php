<?php
$uid='user11';
$bid=1;
$st='A';
require_once 'pgdb.php';
$rs=pg_query("select count(*) from approval where userid='$uid' and bookid=$bid ;");
$cl = pg_fetch_array($rs);
print_r($cl);
if($cl[0]){
	pg_query("begin;") or die("Could not start transaction\n");
	$ctime="20".date("y/m/d h:m:s");
	$res1 = pg_query("update approval set state = '$st', updated='$ctime' where userid='$uid' and bookid=$bid ;");
	if ($res1) {
		echo "Commiting transaction\n";
		pg_query("COMMIT") or die("Transaction commit failed\n");
	} else {
		echo "Rolling back transaction\n";
		pg_query("ROLLBACK") or die("Transaction rollback failed\n");
		;
	}
}
else{
	echo "Invalid request\n";
}

?>
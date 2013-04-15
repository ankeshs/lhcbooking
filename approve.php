<?php
require_once 'settings.php';
require_once 'users.php';

session_start();
if(! isset($_COOKIE[COOKI])){
	die("Session expired or invalid page request. <br>You need to <a class='explink' href='index.php'>login</a> first!");
}
$bid=$_GET['bid'];
$uid=$_COOKIE[COOKI];
$st=$_GET['act'];
require_once 'pgdb.php';
$rs=pg_query("select count(*) from approval where userid='$uid' and bookid=$bid ;");
$cl = pg_fetch_array($rs);
print_r($cl);
if($cl[0]){
	pg_query("begin;") or die("Could not start transaction\n");
	$ctime="20".date("y/m/d h:m:s");
	$res1 = pg_query("update approval set state = '$st', updated='$ctime' where userid='$uid' and bookid=$bid ;");
	if ($res1) {
		//echo "Commiting transaction\n";
		pg_query("COMMIT") or die("Transaction commit failed\n");
		nextApprovalAlert("", $bid, $uid);
		header("Location: index.php?msgtxt=Request successfully processed");
	} else {
		//echo "Rolling back transaction\n";
		pg_query("ROLLBACK") or die("Transaction rollback failed\n");
		header("Location: index.php?msgtxt=Request failed");
	}
}
else{
	header("Location: index.php?msgtxt=Invalid request");
}

?>
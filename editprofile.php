<?php
require_once 'settings.php';
session_start();
if(isset($_COOKIE[COOKI])){
	$uid=$_COOKIE[COOKI];
	$em=$_POST['email'];
	$cn=$_POST['contact'];
	$ad=$_POST['address'];
	
	require_once 'pgdb.php';
	pg_query("begin;") or die("Could not start transaction\n");
	$res1 = pg_query("update users set email='$em', contactno='$cn', address='$ad' where userid='$uid' ;");
	if ($res1) {
		//echo "Commiting transaction\n";
		pg_query("COMMIT") or die("Transaction commit failed\n");
	} else {
		//echo "Rolling back transaction\n";
		pg_query("ROLLBACK") or die("Transaction rollback failed\n");
		;
	}
}
header('Location: index.php');
?>

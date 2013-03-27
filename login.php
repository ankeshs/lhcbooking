<?php

function connect($l, $p){
	require_once 'pgdb.php';
	$p=md5($p);
	$query="select * from users where userID='$l' and password='$p';";
	$rs = pg_query($db_handle, $query);
	if($row = pg_fetch_row($rs)){
		return TRUE;
	}
	return FALSE;
}

session_start();
if(isset($_COOKIE[COOKI])){
	setcookie(COOKI, "", time()-60*60*24*100, "/");
}
if(isset($_POST['login']) && isset($_POST['pass']))
{
	$login = $_POST['login'];
	$password = $_POST['pass'];
	$expire=time()+60*10;	
	if(connect($login, $password)){
		echo "Connected";
	}
	else{
		header('Location: testerPage.php');
	}
	
}
?>
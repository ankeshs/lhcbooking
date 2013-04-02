<?php

function connect($l, $p, $db_handle){	
	$p=md5($p);
	$query="select * from users where userID='$l' and password='$p';";
	$rs = pg_query($db_handle, $query);
	if($row = pg_fetch_row($rs)){
		return TRUE;
	}
	return FALSE;
}

session_start();
require_once 'settings.php';
require_once 'pgdb.php';
if(isset($_COOKIE[COOKI])){
	setcookie(COOKI, "", time()-60*60*24*100, COOKpath);
}
if(isset($_POST['login']) && isset($_POST['pass']))
{
	$login = $_POST['login'];
	$password = $_POST['pass'];
	$expire=time()+60*10;	
	if(connect($login, $password, $db_handle)){		
		setcookie(COOKI, $login, $expire, "/");
		//echo $_COOKIE[COOKI];
		require_once 'users.php';
		setcookie(COOKr, getUserRole($login, $db_handle), $expire, "/" );
		header('Location: index.php');
	}
	else{
		header('Location: index.php?err=1');
	}
	
}
?>

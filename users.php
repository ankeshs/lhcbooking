<?php
require_once 'settings.php';
require_once 'pgdb.php';

function refreshCookie()
{
	if(isset($_COOKIE[COOKI])){
		$userID=$_COOKIE[COOKI];
		$expire=time()+60*10;
		setcookie(COOKI, $userID, $expire, "/");
	}
	if(isset($_COOKIE[COOKr])){
		$role=$_COOKIE[COOKr];
		$expire=time()+60*10;
		setcookie(COOKr, $role, $expire, "/");
	}
}

function getUserRole($userID, $db){	
	$r=0;	
	$query="select * from users natural join student where userID='$userID'";
	$sd=getAssoc($db, $query);
	if($sd){
		$r=10;
		$query="select * from users natural join student natural join coordinator where userID='$userID'";
		$scd=getAssoc($db, $query);
		if($scd){
			$r=11;
		}
		else{
			$query="select * from users natural join student natural join executive where userID='$userID'";
			$sed=getAssoc($db, $query);
			if($sed){
				$r=12;
			}
		}
	}
	else{
		$query="select * from users natural join faculty where userID='$userID'";
		$fd=getAssoc($db, $query);
		if($fd){
			$r=20;
		}
		else{
			$query="select * from users natural join auth where userID='$userID'";
			$ad=getAssoc($db, $query);
			if($ad){
				$r=30;
			}
			else{
				$query="select * from users natural join office where userID='$userID'";
				$od=getAssoc($db, $query);
				if($od){
					$r=40;
				}
			}
		}
	}	
	return $r;
}
?>
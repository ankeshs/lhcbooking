<?php
require_once 'settings.php';
require_once 'pgdb.php';

function refreshCookie()
{
	if(isset($_COOKIE[COOKI])){
		$userID=$_COOKIE[COOKI];
		$expire=time()+60 * TIMEOUTVAL;
		setcookie(COOKI, $userID, $expire, COOKpath);
	}
	if(isset($_COOKIE[COOKr])){
		$role=$_COOKIE[COOKr];
		$expire=time()+60 * TIMEOUTVAL;
		setcookie(COOKr, $role, $expire, COOKpath);
	}
}

function getUserRole($userID, $db){	
	$r=0;	
	$query="select * from users natural join student where userID='$userID'";
	$sd=getAssoc($db, $query);
	if($sd){
		$r=10;
		$query="select * from users natural join student natural join executive where userID='$userID'";
		$scd=getAssoc($db, $query);
		if($scd){
			$r=12;
		}
		else{
			$query="select * from users natural join student natural join coordinator where userID='$userID'";
			$sed=getAssoc($db, $query);
			if($sed){
				$r=11;
			}
		}
	}
	else{
		$query="select * from users natural join auth where userID='$userID'";
		$fd=getAssoc($db, $query);
		if($fd){
			$r=30;
		}
		else{
			$query="select * from users natural join faculty where userID='$userID'";
			$ad=getAssoc($db, $query);
			if($ad){
				$r=20;
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

function getUserDesc($uid){
	$query="with desct as ( (select userid, post as typeof from users natural join student natural join executive) union (select userid, club as typeof from users natural join student natural join coordinator) union (select userid, facid as typeof from faculty) union (select userid, authtype as typeof from auth) union (select userid, offtype as typeof from office) ) select * from desct where userid='$uid';";
	$rs=pg_query($query);
	if(pg_num_rows($rs)){
		$a=pg_fetch_assoc($rs);
		return $a['typeof'];
	}
	return $uid;
}
?>

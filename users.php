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

function nextApprovalAlert($uid, $bid, $capr){
	if($uid==""){
		$query="select * from booking natural join transaction where bookid=$bid and transtype='B';";
		$rsp=pg_query($query);
		if(pg_num_rows($rsp) == 0) return;
		$ap=pg_fetch_assoc($rsp);
		$uid=$ap['userid'];
	}
	$query="with apptype as ( with approvalP as (select * from approval where bookid=$bid and state='P') ( select userid, approver from approvalP natural join student natural join executive natural join (values ('executive')) a(approver)) union ( select userid, approver from approvalP natural join faculty natural join (values ('faculty')) a(approver)) union ( select userid, authtype as approver from approvalP natural join auth) union ( select userid, offtype as approver from approvalP natural join office) ) select * from apptype natural join precedence order by weight limit 1; ";
	$rsp=pg_query($query);
	if(pg_num_rows($rsp) == 0) return;
	$ap=pg_fetch_assoc($rsp);
	$apid=$ap['userid'];
	if(isset($capr) and $capr!=""){
		$msg1="Your booking (ID = $bid) has been approved by ".getUserDesc($capr)." and is now pending with ".getUserDesc($apid);
	}
	else{
		$msg1="Your booking (ID = $bid) has been requested and is now pending with ".getUserDesc($apid);
	}
	$msg2="Booking (ID = $bid) is pending your approval";
	$query="select * from users where userid='$uid';";
	$rsp=pg_query($query);
	$a=pg_fetch_assoc($rsp);
	$p1=$a['contactno'];
	$e1=$a['email'];
	$query="select * from users where userid='$apid';";
	$rsp=pg_query($query);
	$a=pg_fetch_assoc($rsp);
	$p2=$a['contactno'];
	$e2=$a['email'];
	//echo "$uid $p1 $e1 $msg1 \n";
	//echo "$uid $p2 $e2 $msg2 \n";
	pg_query("begin");
	$in1=pg_query("insert into alerts (userid, alerttype, alertto, msg) values ('$uid', 'email', '$e1', '$msg1') ;");
	$in2=pg_query("insert into alerts (userid, alerttype, alertto, msg) values ('$uid', 'sms', '$p1', '$msg1') ;");
	$in3=pg_query("insert into alerts (userid, alerttype, alertto, msg) values ('$apid', 'email', '$e2', '$msg2') ;");
	$in4=pg_query("insert into alerts (userid, alerttype, alertto, msg) values ('$apid', 'sms', '$p2', '$msg2') ;");
	if($in1 and $in2 and $in3 and $in4){
		pg_query("commit");
	}
	else{
		pg_query("rollback");
	}
}
?>

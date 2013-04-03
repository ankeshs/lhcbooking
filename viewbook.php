<?php
require_once 'settings.php';
require_once 'users.php';

session_start();
if(! isset($_COOKIE[COOKI])){
	die("Session expired or invalid page request. <br>You need to <a class='explink' href='index.php'>login</a> first!");
}

$uid=$_COOKIE[COOKI];
$do=date("Y/m/d");
$to=date("H:m:s");
//echo $do." ".$to."\n";
require_once 'pgdb.php';
$pg=$_GET['page'];
switch($pg){
	case 3:
	$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and userid='$uid') select bookid from approval natural join tbc where state='R') select * from tbcp natural join booking natural join location;";
	$rs=pg_query($query);
	break;
	
	case 2:
	$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and userid='$uid' and (bookdate < '$do' or (bookdate = '$do' and endtime < '$to'))) select * from  tbc except (select bookid from approval natural join tbc where state='R')) select * from tbcp natural join booking natural join location;";
	$rs=pg_query($query);
	break;
	
	case 1:
	$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and userid='$uid' and (bookdate > '$do' or (bookdate = '$do' and endtime >= '$to'))) select * from  tbc except (select bookid from approval natural join tbc where state='R')) select * from tbcp natural join booking natural join location;";
	$rs=pg_query($query);
	break;
}
?>
	
		
<?php
while($a=pg_fetch_assoc($rs)){
	$bip=$a['bookid'];
	?>
	<div class="viewbook">
		<table><tr>
		<td id="vbk01">
		<?php echo "Booking ID: <b>".$a['bookid']."</b><br>Date: ".$a['bookdate']."<br>Start: ".$a['starttime']."<br>End: ".$a['endtime']."<br>Lecture hall: ".$a['hallno'];
		if($pg==1){						
			echo "<a href='cancel.php?bid=$bip'><button>Cancel</button></a>";	
		}
		?>
		</td>
		<td id="vbk02">
		<?php
		
		$qr="select * from booking natural join transaction where bookid=$bip and transtype='B';";
		$rsp=pg_query($qr);
		$ap=pg_fetch_assoc($rsp);					
		echo "Requested By: ".$ap['userid']."<br><b>Details:</b><br> ".$ap['details']."<br>";
		?>
		</td>
		<td id="vbk03">
		<?php
		$active=true;
		$qr="select * from booking natural join approval where bookid=$bip ;";
		$rsp=pg_query($qr);
		while($ap=pg_fetch_assoc($rsp)){
			switch($ap['state']){
				case 'P': echo "<span class='pen'>Pending with " ; $active=false; break;
				case 'A': echo "<span class='app'>Approved by " ; break;
				case 'R': echo "<span class='rej'>Rejected by " ; $active=false; break;
			}
			echo getUserDesc($ap['userid'])."</span><br>";
		}
		if($active){
			echo "<div id='appbut'>Confirmed</div>";
		}
		else if($pg != 3){
			$query="with apptype as ( with approvalP as (select * from approval where bookid=$bip and state='P') ( select userid, approver from approvalP natural join student natural join executive natural join (values ('executive')) a(approver)) union ( select userid, approver from approvalP natural join faculty natural join (values ('faculty')) a(approver)) union ( select userid, authtype as approver from approvalP natural join auth) union ( select userid, offtype as approver from approvalP natural join office) ) select * from apptype natural join precedence order by weight limit 1; ";
			$rsp=pg_query($query);
			if(pg_num_rows($rsp)){
				$ap=pg_fetch_assoc($rsp);
				echo "<br>Required: ".getUserDesc($ap['userid']);
			}
		}
		?>
		</td>
		</tr>
		</table>
		</div>
	<?php
}	
?>	
<?php

function getStatus($bid){
	$query="select count(*) from booking natural join approval where bookid='$bid' and (state='P' or state='R');";
	$rs=pg_query($query);
	$c=pg_fetch_array($rs);
	if($c[0]) return true;
	return false;
}
?>

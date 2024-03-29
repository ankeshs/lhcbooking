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
	case 4:
		$query="select * from booking natural join location natural join approval where userid='$uid' and (bookdate < '$do' or (bookdate = '$do' and endtime < '$to')) and state <> 'R';";
		break;
		
	case 1:
		$query="select * from booking natural join location natural join approval where userid='$uid' and (bookdate > '$do' or (bookdate = '$do' and endtime >= '$to')) and state='P';";
		break;
		
	case 2:
		$query="select * from booking natural join location natural join approval where userid='$uid' and (bookdate > '$do' or (bookdate = '$do' and endtime >= '$to')) and state='A';";
		break;
		
	case 3:
		$query="select * from booking natural join location natural join approval where userid='$uid' and state='R';";
		break;
		
}
$rs=pg_query($query);

while($a=pg_fetch_assoc($rs)){
	$bip=$a['bookid'];
	?>
	<div class="viewbook">
		<table><tr>
		<td id="vbk01">
		<?php echo "Booking ID: <b>".$a['bookid']."</b><br>Date: ".$a['bookdate']."<br>Start: ".$a['starttime']."<br>End: ".$a['endtime']."<br>Lecture hall: ".$a['hallno'];
		if($pg==1){
			echo "<br><a href='approve.php?bid=$bip&act=A'><button>Approve</button></a>";
			echo "<a href='approve.php?bid=$bip&act=R'><button>Reject</button></a>";
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
		$qr="select * from booking natural join approval where bookid=$bip ;";
		$rsp=pg_query($qr);
		while($ap=pg_fetch_assoc($rsp)){
			switch($ap['state']){
				case 'P': echo "<span class='pen'>Pending with " ; break;
				case 'A': echo "<span class='app'>Approved by " ; break;
				case 'R': echo "<span class='rej'>Rejected by " ; break;
			}
			echo getUserDesc($ap['userid'])."</span><br>";
		}
		$query="with apptype as ( with approvalP as (select * from approval where bookid=$bip and state='P') ( select userid, approver from approvalP natural join student natural join executive natural join (values ('executive')) a(approver)) union ( select userid, approver from approvalP natural join faculty natural join (values ('faculty')) a(approver)) union ( select userid, authtype as approver from approvalP natural join auth) union ( select userid, offtype as approver from approvalP natural join office) ) select * from apptype natural join precedence order by weight limit 1; ";
		$rsp=pg_query($query);
		if(pg_num_rows($rsp)){
			$ap=pg_fetch_assoc($rsp);
			if($ap['userid']==$uid && $pg==1) echo "<div id='appbut'>Urgent</div>";
		}
		?>
		</td>
		</tr>
		</table>
		</div>
	<?php
}	
?>	


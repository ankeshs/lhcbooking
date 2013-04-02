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
	?>
	<div class="viewbook">
		<table><tr>
		<td id="vbk01">
		<?php echo "Booking ID: <b>".$a['bookid']."</b><br>Date: ".$a['bookdate']."<br>Start: ".$a['starttime']."<br>End: ".$a['endtime']."<br>Lecture hall: ".$a['hallno'];
		if($pg==1){			
			echo "<a href='cancel.php'><button>Cancel</button></a>";
		}
		?>
		</td>
		<td id="vbk02">
		<?php
		$bip=$a['bookid'];
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

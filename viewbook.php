<?php
require_once 'settings.php';
session_start();
if(isset($_COOKIE[COOKI])){
	$uid=$_COOKIE[COOKI];
	$do=date("Y/m/d");
	$to=date("H:m:s");
	echo $do." ".$to."\n";
	require_once 'pgdb.php';
	$pg=$_GET['page'];
	switch($pg){
		case 3:
		$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and userid='$uid') select bookid from approval natural join tbc where state='R') select * from tbcp natural join booking;";
		$rs=pg_query($query);
		break;
		
		case 2:
		$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and userid='$uid' and (bookdate < '$do' or (bookdate = '$do' and endtime < '$to'))) select * from  tbc except (select bookid from approval natural join tbc where state='R')) select * from tbcp natural join booking;";
		$rs=pg_query($query);
		break;
		
		case 1:
		$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and userid='$uid' and (bookdate > '$do' or (bookdate = '$do' and endtime >= '$to'))) select * from  tbc except (select bookid from approval natural join tbc where state='R')) select * from tbcp natural join booking;";
		$rs=pg_query($query);
		break;
	}
	while($a=pg_fetch_assoc($rs)){
		?>
		<pre>
		<?php
		print_r($a);
		?>
		</pre>
		<?php
	}	
}
else{
	echo "Invalid Request";
}

function getStatus($bid){
	$query="select count(*) from booking natural join approval where bookid='$bid' and (state='P' or state='R');";
	$rs=pg_query($query);
	$c=pg_fetch_array($rs);
	if($c[0]) return true;
	return false;
}
?>

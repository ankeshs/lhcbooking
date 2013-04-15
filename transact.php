<?php
$dateof = '1 April 2013';
$start = '0900';
$end = '1400';
$lh = 'L15';
$user = 'user1';
$approve = array('user10', 'user11');

require_once 'pgdb.php';

$rs = pg_query("with clash as ((select dateof, hallno, starttime, endtime from calendar natural join timetable where starttime >= '$start' and endtime <='$end' and dateof='$dateof') union ((select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$start' and endtime <='$end' and bookdate='$dateof' and state <> 'R') except (select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$start' and endtime <='$end' and bookdate='$dateof' and state = 'R'))) select count(*) from clash where hallno='$lh';");

$cl = pg_fetch_array($rs);
print_r($cl);
if ($cl[0] == 0) {
	pg_query("begin;") or die("Could not start transaction\n");
	$res1 = pg_query("insert into booking (bookdate, starttime, endtime) values ('$dateof', '$start', '$end');");
	$rs = pg_query("with req as (select bookid from booking where bookdate='$dateof' and starttime='$start' and endtime='$end') select bookid from req except (select bookid from req natural join approval);");
	$bi = pg_fetch_assoc($rs);
	print_r($bi);
	$ci = $bi['bookid'];
	$res2 = pg_query("INSERT INTO transaction(userid, bookid, transtype) values ('$user', $ci, 'B');");
	$res3 = pg_query("INSERT INTO location VALUES ($ci, '$lh');");
	$res4=TRUE;
	foreach ($approve as $a) {
		$rsa=pg_query("INSERT INTO approval(userID, bookid) values ('$a',$ci);");
		$res4=$res4 and $rsa;
	}

	if ($res1 and $res2 and $res3 and $res4) {
		echo "Commiting transaction\n";
		pg_query("COMMIT") or die("Transaction commit failed\n");
	} else {
		echo "Rolling back transaction\n";
		pg_query("ROLLBACK") or die("Transaction rollback failed\n");
		;
	}
} else {
	echo "Clash\n";
}
pg_close($db_handle);
?>

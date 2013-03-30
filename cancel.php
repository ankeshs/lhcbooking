<?php
$bid=3;
$user='user1';

require_once 'pgdb.php';
$rs=pg_query("with tbc as (select bookid from transaction natural join booking where bookid=$bid and transtype='B' and userid='$user') select count(*) from tbc except (select bookid from approval where bookid=$bid and state='R');");
$cl = pg_fetch_array($rs);
print_r($cl);
if ($cl[0] == 0) {
	echo "Requested Booking does not exist or not approved\n";
	exit;
}
echo "Booking found\n";
pg_query("begin;") or die("Could not start transaction\n");
$res1 = pg_query("INSERT INTO transaction(userid, bookid, transtype) values ('$user', $bid, 'C');");
$res2 = pg_query("delete from booking where bookid=$bid;");
if ($res1 and $res2) {
	echo "Commiting transaction\n";
	pg_query("COMMIT") or die("Transaction commit failed\n");
} else {
	echo "Rolling back transaction\n";
	pg_query("ROLLBACK") or die("Transaction rollback failed\n");
	;
}
?>
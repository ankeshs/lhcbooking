<div id="allbook">
<span>Shows only approved and completed transactions</span>
<table>
	<tr><th>ID</th><th>Date</th><th>Start</th><th>Finish</th><th>Hall</th><th class="fx1">Booked By</th><th class="fx2">Details</th></tr>
<?php
require_once 'settings.php';
require_once 'pgdb.php';
$do=date("Y/m/d");
$to=date("H:m:s");
$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and (bookdate > '$do' or (bookdate = '$do' and endtime >= '$to'))) select * from  tbc except (select bookid from approval natural join tbc where state='R' or state='P')) select * from tbcp natural join booking natural join location natural join transaction where transtype='B';";
$rs=pg_query($query);
while($a=pg_fetch_assoc($rs)){
	echo "<tr><td>".$a['bookid']."</td><td>".$a['bookdate']."</td><td>".$a['starttime']."</td><td>".$a['endtime']."</td><td>".$a['hallno']."</td><td>".$a['userid']."</td><td class='fx2'>".$a['details']."</td></tr>";	
}

$query="with tbcp as (with tbc as (select bookid from transaction natural join booking where transtype='B' and (bookdate < '$do' or (bookdate = '$do' and endtime < '$to'))) select * from  tbc except (select bookid from approval natural join tbc where state='R')) select * from tbcp natural join booking natural join location natural join transaction where transtype='B';";
$rs=pg_query($query);
while($a=pg_fetch_assoc($rs)){
	echo "<tr><td>".$a['bookid']."</td><td>".$a['bookdate']."</td><td>".$a['starttime']."</td><td>".$a['endtime']."</td><td>".$a['hallno']."</td><td>".$a['userid']."</td><td>".$a['details']."</td></tr>";	
}
?>
</table>
</div>
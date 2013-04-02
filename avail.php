<?php
require_once 'settings.php';
if(! isset($_COOKIE[COOKI])){
	die("Session expired or invalid page request. <br>You need to <a class='explink' href='index.php'>login</a> first!");
}


require_once 'pgdb.php';
$d=$_GET['date'];
$s=$_GET['start'];
$e=$_GET['end'];
echo $d." ".$s." ".$e;
$query= "with clash as ((select dateof, hallno, starttime, endtime from calendar natural join timetable where starttime >= '$s' and endtime <='$e' and dateof='$d') union ((select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$s' and endtime <='$e' and bookdate='$d' and state <> 'R') except (select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$s' and endtime <='$e' and bookdate='$d' and state = 'R'))) select * from clash;";

$rs=pg_query($query);
?>
<div id="alh">
Other bookings at the same time:<br>
<?php
if(pg_num_rows($rs)>0){
	?>
	<table>
		<tr><th>Date</th><th>Start</th><th>Finish</th><th>Lecture Hall</th></tr>
	<?php
while($a=pg_fetch_assoc($rs)){	
	echo "<tr><td>".$a['dateof']."</td><td>".$a['starttime']."</td><td>".$a['endtime']."</td><td>".$a['hallno']."</td></tr>";
}
?>
</table>
<?php
}
else echo "None";

$query="with clash as ((select dateof, hallno, starttime, endtime from calendar natural join timetable where starttime >= '$s' and endtime <='$e' and dateof='$d') union ((select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$s' and endtime <='$e' and bookdate='$d' and state <> 'R') except (select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$s' and endtime <='$e' and bookdate='$d' and state = 'R')))  select * from lechall natural join ((select hallno from lechall) except (select hallno from clash)) as cavhl order by hallno;";
$rs=pg_query($query);
?>
</div><br>
<div id="alh">
	Available Lecture Halls:<br>
	<?php
	if(pg_num_rows($rs)>0){
		?>
		<table>
		<tr><th></th><th>Lecture Hall</th><th>Capacity</th></tr>
		<?php
		while($a=pg_fetch_assoc($rs)){
			?>
			<tr><td><input type="radio" name="lechall" value="<?php echo $a['hallno']; ?>" /></td>
				<td><?php echo $a['hallno']; ?></td>
				<td><?php echo $a['capacity']; ?></td>
			</tr>
			<?php
		}	
		?>
		</table>
		<?php
	}
	else{
		echo "None";
	}
	?>
</div>
<br>


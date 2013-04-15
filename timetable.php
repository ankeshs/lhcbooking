<div id="timetable">
<table>
<?php
require_once 'settings.php';
require_once 'pgdb.php';
$query="SELECT dayof, course, starttime, endtime, meettype, array_to_string(array_agg(hallno), ',') as halls FROM timetable GROUP BY dayof, course, starttime, endtime, meettype;";
$result=pg_query($query);
$arr=pg_fetch_all($result);
$day=array('M','T','W','Th','F');
foreach ($day as $d) {
	?>
	<tr class="outer"><div>
	<?php
	echo "<td>$d</td><td><table>";
	foreach ($arr as $a) {
		if($a['dayof']!=$d) continue;
		?>
		<tr class="inner">
		<?php
		echo "<td>".substr($a['course']."     ",0,8)."</td><td>".substr($a['starttime'],0,5)."</td><td>".substr($a['endtime'],0,5)."</td><td>".$a['meettype']."</td><td>".$a['halls']."</td>";
		?>
		</div>
		</tr>
		<?php
	} 
	?>
	</table></td></tr>
	<?php
}
?>
</table>
</div>
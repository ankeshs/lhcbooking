<?php
$serv="http://localhost/phpPgAdmin";
?>
<!DOCTYPE html>
<html>
	<body>
		Admin Requires <a href="<?php echo $serv; ?>/" >phpPgAdmin</a>.<br> <br>
		<table>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=users" target="_blank">Add User</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=users&subject=table&return=table" target="_blank">Remove User</a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=student" target="_blank">Add User as student</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=student&subject=table&return=table" target="_blank">Remove User as student</a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=coordinator" target="_blank">Add student as Coordinator</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=coordinator&subject=table&return=table" target="_blank">Remove student as Coordinator</a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=executive" target="_blank">Add student as Executive</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=executive&subject=table&return=table" target="_blank">Remove student as Executive</a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=faculty" target="_blank">Add User as faculty</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=faculty&subject=table&return=table" target="_blank">Remove User as faculty</a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=auth" target="_blank">Add User as auth</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=auth&subject=table&return=table" target="_blank">Remove User as auth</a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=office" target="_blank">Add User as office</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=office&subject=table&return=table" target="_blank">Remove User as office</a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $serv; ?>/tables.php?action=confinsertrow&server=%3A5432%3Aallow&database=booking&schema=public&table=timetable" target="_blank">Add to Timetable</a></td>
				<td><a href="<?php echo $serv; ?>/display.php?server=%3A5432%3Aallow&database=booking&schema=public&table=timetable&subject=table&return=table" target="_blank">Remove from Timetable</a></td>
			</tr>
		</table>		
	</body>
</html>
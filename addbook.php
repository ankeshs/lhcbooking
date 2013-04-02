<?php
require_once 'settings.php';
if(! isset($_COOKIE[COOKI])){
	die("Session expired or invalid page request. <br>You need to <a class='explink' href='index.php'>login</a> first!");
}


require_once 'pgdb.php';

$user=$_POST['user'];
$dateof=$_POST['bdate'];
$start=$_POST['start'];
$end=$_POST['end'];
$ac='false';
if(isset($_POST['aircon']) && $_POST['aircon']=='on')$ac='true';
$req=array();
$ri=0;
if(isset($_POST['cmic']) && $_POST['cmic']=='on'){$req[$ri]="Collar Microphone"; $ri=$ri+1;}
if(isset($_POST['hmic']) && $_POST['hmic']=='on'){$req[$ri]="Microphone"; $ri=$ri+1;}
if(isset($_POST['proj']) && $_POST['proj']=='on'){$req[$ri]="Multimedia Projector"; $ri=$ri+1;}
if(isset($_POST['ohp']) && $_POST['ohp']=='on'){$req[$ri]="Overhead Projector"; $ri=$ri+1;}
$det=$_POST['detail'];
$lh=$_POST['lechall'];
$ft=$_POST['formtype'];
$appr=array();
$ai=0;
if($ft=='1a' || $ft=='1b' ){
	$query="select * from auth where authtype='DOSA';";
	$rs=pg_query($query);
	$dosa=pg_fetch_assoc($rs);
	$appr[$ai]=$dosa['userid'];
	$ai=$ai+1;
}
if($ft=='1a'){
	if(isset($_POST['execpost']) && $_POST['execpost']!="")$pos=$_POST['execpost'];
	else die("Invalid data error");
	$query="select * from executive natural join student where post='$pos';";
	$rs=pg_query($query);
	$dosa=pg_fetch_assoc($rs);
	$appr[$ai]=$dosa['userid'];
	$ai=$ai+1;
}
if($ft=='1c'){
	if(isset($_POST['facid']) && $_POST['facid']!="")$pos=$_POST['facid'];
	else die("Invalid data error");
	$query="select * from faculty where facid='$pos';";
	$rs=pg_query($query);
	$dosa=pg_fetch_assoc($rs);
	$appr[$ai]=$dosa['userid'];
	$ai=$ai+1;
}
if($ft!='2b'){
	$query="select * from auth where authtype='DOAA';";
	$rs=pg_query($query);
	$dosa=pg_fetch_assoc($rs);
	$appr[$ai]=$dosa['userid'];
	$ai=$ai+1;
	if($ac=='true'){
		$query="select * from auth where authtype='DD';";
		$rs=pg_query($query);
		$dosa=pg_fetch_assoc($rs);
		$appr[$ai]=$dosa['userid'];
		$ai=$ai+1;
	}
}
$query="select * from office where offtype='LHC Office';";
$rs=pg_query($query);
$dosa=pg_fetch_assoc($rs);
$appr[$ai]=$dosa['userid'];
$ai=$ai+1;
?>

<?php
//echo $user." ".$dateof." ".$start." ".$end." ".$ac." ".$det." ".$lh."\n";
//print_r($req);
//print_r($appr);

$rs = pg_query("with clash as ((select dateof, hallno, starttime, endtime from calendar natural join timetable where starttime >= '$start' and endtime <='$end' and dateof='$dateof') union ((select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$start' and endtime <='$end' and bookdate='$dateof' and state <> 'R') except (select bookdate as dateof, hallno, starttime, endtime from booking natural join approval natural join location where starttime >= '$start' and endtime <='$end' and bookdate='$dateof' and state = 'R'))) select count(*) from clash where hallno='$lh';");

$cl = pg_fetch_array($rs);
//print_r($cl);
if ($cl[0] == 0) {
	pg_query("begin;") or die("Could not start transaction\n");
	$res1 = pg_query("insert into booking (bookdate, starttime, endtime, aircon) values ('$dateof', '$start', '$end', '$ac');");
	//$rs = pg_query("with req as (select bookid from booking where bookdate='$dateof' and starttime='$start' and endtime='$end') select bookid from req except (select bookid from req natural join approval);");
	$rs = pg_query("select lastval();");
	$bi = pg_fetch_assoc($rs);
	//print_r($bi);
	$ci = $bi['lastval'];
	$res2 = pg_query("INSERT INTO transaction(userid, bookid, transtype, details) values ('$user', $ci, 'B', '$det');");
	$res3 = pg_query("INSERT INTO location VALUES ($ci, '$lh');");
	$res4=TRUE;
	foreach ($appr as $a) {
		$rsa=pg_query("INSERT INTO approval(userID, bookid) values ('$a', $ci);");
		$res4=$res4 and $rsa;
	}
	foreach ($req as $r) {
		$rsa=pg_query("INSERT INTO requirement(bookid, equip) values ($ci, '$r');");
		$res4=$res4 and $rsa;
	}

	if ($res1 and $res2 and $res3 and $res4) {
		//echo "Commiting transaction\n";
		pg_query("COMMIT") or die("Transaction commit failed\n");
		header('Location:index.php?msgtxt=Booking successful');
	} else {
		//echo "Rolling back transaction\n";
		pg_query("ROLLBACK") or die("Transaction rollback failed\n");
		header('Location:index.php?msgtxt=Booking failed!');
	}
} else {
	header('Location:index.php?msgtxt=Booking has a clash');
}
pg_close($db_handle);
?>

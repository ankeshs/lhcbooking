<?php
	session_start();
	require_once 'components.php';
	require_once 'settings.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript" src="js/jquery-latest.js"></script>
		<title>LHC Booking Portal</title>
	</head>
	<body>
		<div id="main">			
		<?php		
		if(isset($_COOKIE[COOKI])){
			require_once 'users.php';
			require_once 'pgdb.php';
			refreshCookie();
		?>
			<div id="left-sidebar">
				<div class="lsbt" id="lsbt4"><a href="javascript: void(0)">New Booking</a></div>
				<?php
				if(isset($_COOKIE[COOKr]) and ($_COOKIE[COOKr]>11)){
					?>
					<div id="lsbt3" class="lsbt"><a href="javascript: void(0)">Approvals</a></div>
					<div id="lscd3" class="lscd">
						<div id='lsbt31'><a href="javascript: void(0)">Required</a></div>
						<div id='lsbt32'><a href="javascript: void(0)">Approved</a></div>
						<div id='lsbt33'><a href="javascript: void(0)">Rejected</a></div>
						<div id='lsbt34'><a href="javascript: void(0)">Completed</a></div>
					</div>
					<?php
				}
				?>
				<div id="lsbt1" class="lsbt"><a href="javascript: void(0)">Bookings</a></div>
				<div id="lscd1" class="lscd">
					<div id='lsbt11'><a href="javascript: void(0)">Live</a></div>
					<div id='lsbt12'><a href="javascript: void(0)">Completed</a></div>
					<div id='lsbt13'><a href="javascript: void(0)">Rejected</a></div>
				</div>
				<div class="lsbt" id="lsbt2"><a href="javascript: void(0)">All Bookings</a></div>
			</div>
			<script type="text/javascript">
				$("#left-sidebar div.lscd").hide();
				$("#left-sidebar #lsbt1").click(function (){
					$("#left-sidebar #lscd1").slideToggle("fast");
				});
				$("#left-sidebar #lsbt11").click(function (){
					$("#ajaxpane").load('viewbook.php?page=1');
				});
				$("#left-sidebar #lsbt12").click(function (){
					$("#ajaxpane").load('viewbook.php?page=2');
				});
				$("#left-sidebar #lsbt13").click(function (){
					$("#ajaxpane").load('viewbook.php?page=3');
				});
				$("#left-sidebar #lsbt3").click(function (){
					$("#left-sidebar #lscd3").slideToggle("fast");
				});
				$("#left-sidebar #lsbt31").click(function (){
					$("#ajaxpane").load('viewappr.php?page=1');
				});
				$("#left-sidebar #lsbt32").click(function (){
					$("#ajaxpane").load('viewappr.php?page=2');
				});
				$("#left-sidebar #lsbt33").click(function (){
					$("#ajaxpane").load('viewappr.php?page=3');
				});
				$("#left-sidebar #lsbt34").click(function (){
					$("#ajaxpane").load('viewappr.php?page=4');
				});
				$("#left-sidebar #lsbt4").click(function (){
					$("#ajaxpane").load('form.php');
				});
			</script>
			<div id="cpane">
				<div id="ajaxpane">
					
				</div>
			</div>
			<div id="right-sidebar">			
			<?php
				dashBoard($db_handle);
			?>
			</div>			
			<?php
			if(isset($_GET['msgtxt'])){
				messageDisplay($_GET['msgtxt']);
				?>
				
				<script>msgTxtShow();</script>	
				<?php
			}			
				
		}
		else{
			if(isset($_GET['err'])){
				switch($_GET['err']){
					case 1:
					loginForm(array('errmsg' => 'Login failed!'));
					break;
					case 2:
					loginForm(array('errmsg' => 'Session expired or invalid page request. <br>You need to login first!'));
					break;
				?>
				<script>loginErrorShow();</script>
				<?php
			}
		}
			else loginform(array()); 
		}
		?>
		</div>
		
		<?php
		footer();
		?>		
	</body>
</html>

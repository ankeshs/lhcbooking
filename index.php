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
			</script>
			<div id="cpane">
				
			</div>
			<div id="right-sidebar">			
			<?php
				dashBoard($db_handle);
			?>
			</div>			
			<?php
		}
		else{
			if(isset($_GET['err'])&& $_GET['err']==1){
				loginForm(array('errmsg' => 'Login failed!'));
				?>
				<script>loginErrorShow();</script>
				<?php
			}
			else loginform(); 
		}
		?>
		</div>
		
		<?php
		footer();
		?>		
	</body>
</html>
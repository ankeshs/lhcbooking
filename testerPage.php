<?php
require_once 'components.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript" src="js/jquery-latest.js"></script>
	</head>
	<body>
		<?php
			loginForm(array('errmsg'=>'Login Failed!'));
			footer();
		?>
		<script>loginErrorShow();</script>
	</body>
</html>
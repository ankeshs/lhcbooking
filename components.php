<?php
function loginForm($set)
{
//Sets up a login form and a call back javascript function to display errors.
?>
<div id="loginform">
	<form action="login.php" method="post" name="lgnform" >
		<table>
			<tr>
				<td><span>Login ID:</span></td>
				<td>
				<input type="text" name="login" />
				</td>
			</tr>
			<tr>
				<td><span>Password:</span></td>
				<td>
				<input type="password" name="pass"/>
				</td>
			</tr>
		</table>
		<button type="button" value="Login" onclick="formSubmit()">
			Login
		</button>
		<br />
		<?php
		if (isset($set['errmsg'])){
		?>
		<span class="error"> <?php echo $set['errmsg']; ?></span>
		<?php } ?>
	</form>
</div>
<script type="text/javascript">
	function formSubmit() {
		login = document.forms["lgnform"]["login"].value;
		pass = document.forms["lgnform"]["pass"].value;
		if (login == "" || login == " ") {
			alert("Invalid login ID");
			return false;
		}
		if (pass == "") {
			alert("Password cannot be left empty");
			return false;
		}
		document.forms["lgnform"].submit();
	}

	function loginErrorShow() {
		$('#loginform span.error').hide();		
		$('#loginform span.error').slideDown("slow");
		$('#loginform span.error').click(
			function (){
				$('#loginform span.error').fadeOut();
			}
		);
	}
</script>
<?php
}

function footer(){
	?>
	<div id="footer">
		<span id="sp1"><a href="http://web.cse.iitk.ac.in/users/cs315/" target="_blank"><i>CS315 </i>: Introduction to Database Systems</a></span>
		<span id="sp2"><i>Project </i>: Online LHC Booking Software</span>
		<span id="sp3"><i>Author </i>: <a href="mailto: ankeshs@iitk.ac.in">Ankesh Kumar Singh</a></span>
		<br />
		<span id="sp1"><a href="http://iitk.ac.in" target="_blank">IIT Kanpur</a></span>
		<span id="sp2"><i>Powered By :</i> PHP 5, PostgreSQL, jQuery</span>		
	</div>
	<?php
}
?>
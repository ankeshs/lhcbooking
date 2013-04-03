<?php
require_once 'users.php';
require_once 'pgdb.php';
require_once 'settings.php';

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

function dashBoard($db){
	if(! isset($_COOKIE[COOKI])) return;
	$userID = $_COOKIE[COOKI];
	$query="select * from users where userID='$userID'";
	$rs = pg_query($db, $query);
	if($ud = pg_fetch_assoc($rs)){
		?>
		<div id="dashboard">
			<div id="id">
				<?php echo $ud['userid']; ?>
				<span><a href="logout.php">Logout</a></span>
			</div>
			<div id="desc">
				<span id="nam"><?php echo $ud['name']; ?></span><br>
				<?php			
					$query="select * from users natural join student where userID='$userID';";
					$rs=pg_query($query);
					if(pg_num_rows($rs)>0){
						$arr=pg_fetch_assoc($rs);
						echo "User type: Student<br>Roll no. : ".$arr['rollno']."<br>";
					}					
					$query="select * from users natural join student natural join coordinator where userID='$userID';";
					$rs=pg_query($query);
					if(pg_num_rows($rs)>0){
						$arr=pg_fetch_assoc($rs);					
						echo "Role: Coordinator<br>". $arr['club'];
					}			
					$query="select * from users natural join student natural join executive where userID='$userID';";
					$rs=pg_query($query);
					if(pg_num_rows($rs)>0){
						$arr=pg_fetch_assoc($rs);
						echo "Role: Executive<br>". $arr['post'];
					}			
			
				 	$query="select * from users natural join faculty where userID='$userID';";
					$rs=pg_query($query);
					if(pg_num_rows($rs)>0){
						$arr=pg_fetch_assoc($rs);
						echo "User type: Faculty<br>Faculty ID: ".$arr['facid']."<br>";
					}
					
					$query="select * from users natural join auth where userID='$userID';";
					$rs=pg_query($query);
					if(pg_num_rows($rs)>0){
						$arr=pg_fetch_assoc($rs);
						echo "Role: ".$arr['authtype']."<br>";
					}
					
					$query="select * from users natural join office where userID='$userID';";
					$rs=pg_query($query);
					if(pg_num_rows($rs)>0){
						$arr=pg_fetch_assoc($rs);
						echo "Role: ".$arr['offtype']."<br>";
					}				
							
				?>
			</div>
			<div id="profile">				
				<div id="pb"><a href="javascript: void(0)">Profile</a></div>
				<div id="pt">
					<table>
					<tr><td class="nf">Email </td><td><?php echo $ud['email']; ?></td></tr>
					<tr><td class="nf">Contact no. </td><td><?php echo $ud['contactno']; ?></td></tr>
					<tr><td class="nf">Address </td><td><?php echo $ud['address']; ?></td></tr>
					<tr><td><a href="javascript: void(0)">Edit</a></td></tr>
					</table>
				</div>
				<div id="pf" class="dialog">
					<form action="editprofile.php" method="post">
					<table>
					<tr><td class="nf">Email </td><td><input type="text" name="email" value="<?php echo $ud['email']; ?>" /></td></tr>
					<tr><td class="nf">Contact no. </td><td><input type="text" name="contact" value="<?php echo $ud['contactno']; ?>" /></td></tr>
					<tr><td class="nf">Address </td><td><input type="text" name="address" value="<?php echo $ud['address']; ?>" /></td></tr>
					<tr><td><button type="submit" id="upd">Update</button></td><td><button type="button" id="can">Cancel</button></td></tr>
					</table>
					</form>
				</div>
				<script type="text/javascript">
					$("#dashboard #profile #pt").hide();
					$("#dashboard #profile #pb a").click(function(){
						$("#dashboard #profile #pt").slideToggle();
					});
					$("#dashboard #profile #pt a").click(function(){
						$('#dashboard #profile #pf').slideToggle("fast");
					});
					$("#dashboard #profile #pf #can").click(function(){
						$('#dashboard #profile #pf').slideToggle("fast");
					});
				</script>
			</div>
			<div id="action">
				
			</div>
		</div>
		<?php
	}	
}

function messageDisplay($txt){
	?>
	<div id="msgDisplay">
		<span class="error">			
			<?php echo $txt; ?> 
		</span>
	</div>
	<script type="text/javascript">
	function msgTxtShow() {
		$('#msgDisplay span.error').hide();		
		$('#msgDisplay span.error').slideDown("slow");
		$('#msgDisplay span.error').click(
			function (){
				$('#msgDisplay span.error').fadeOut();
			}
		);
	}
	</script>
	<?php
}
?>
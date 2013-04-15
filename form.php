<?php
session_start();
require_once 'settings.php';
require_once 'pgdb.php';
if(! isset($_COOKIE[COOKI])){
	die("Session expired or invalid page request. <br>You need to <a class='explink' href='index.php'>login</a> first!");
}


$do=date("Y-m-d");
$di=date("Y-m-d", strtotime("+1 day", strtotime($do)));
$df=date("Y-m-d", strtotime("+2 month", strtotime($do)));

$user=$_COOKIE[COOKI];

$fno=array();
$fix=0;
if(getNumRows($db_handle, "select * from users natural join student natural join coordinator where userid='$user';")){ $fno[$fix]='1a'; $fix=$fix+1; }
if(getNumRows($db_handle, "select * from users natural join student natural join executive where userid='$user';")){ $fno[$fix]='1b'; $fix=$fix+1; }
if(getNumRows($db_handle, "select * from users natural join student where userid='$user';")){ $fno[$fix]='1c'; $fix=$fix+1; }
if(getNumRows($db_handle, "select * from users natural join faculty where userid='$user';")){ $fno[$fix]='2a'; $fix=$fix+1; }
if(getNumRows($db_handle, "select * from users natural join office where userid='$user';")){ $fno[$fix]='2b'; $fix=$fix+1; }
if(getNumRows($db_handle, "select * from users natural join faculty natural join instructor where userid='$user';")){ $fno[$fix]='2b'; $fix=$fix+1; }

$desc=array('1a'=>'Form 1(a) is available to student coordinators. It requires approvals from student executives, DOSA, DOAA and DD (if air conditioning is needed)',
'1b' =>  'Form 1(b) is available to student executives and festival coordinators. It requires approvals from DOSA, DOAA and DD (if air conditioning is needed)',
'1c' => 'Form 1(c) is available to all students. It requires approvals from a faculty member, DOAA and DD (if air conditioning is needed)',
'2a' => 'Form 2(a) is available to all faculty members. It requires approvals from DOAA and DD (if air conditioning is needed)',
'2b' => 'Form 2(b) is available to all faculty members who are course instructors. It does not requires any approval.'
);
?>
<div id="addformdiv">
<form action="addbook.php" method="post" name="addform"id="addform">
	<div id="rq">User: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><?php echo $_COOKIE[COOKI]; ?></i>
		<input type="hidden" name="user" value="<?php echo $_COOKIE[COOKI]; ?>" /></div>
	<div id="rq">Booking Date: &nbsp;&nbsp;&nbsp;
		<input type="date" name="bdate" id="bdate0" min="<?php echo $di; ?>" max="<?php echo $df; ?>" /></div>
	<div id="se">Time (24 hr format, eg: 1700, 0900)<br>
	Start time: <input type="number" name="start" id="start0" maxlength="4" />
	Finish time: <input type="number" name="end" id="end0" maxlength="4" /></div>
	<div><input type="checkbox" name="aircon" />Air Conditioning Required</div>
	<div id="rq">Additional Requirements:
	<table><tr><td><input type="checkbox" name="cmic" />Microphone (Collar)
		</td><td><input type="checkbox" name="hmic" />Microphone			
		</td></tr><tr><td><input type="checkbox" name="proj" />Mutimedia projector
		</td><td><input type="checkbox" name="ohp" />Overhead Projector</td></tr></table>	
	</div>
	<div>Details: <br>
	<textarea name="detail" rows="4" cols="42"></textarea><br>
	</div>
	<button type="button" id="getHall">Get Available Halls</button>
	<div id="avhalls"></div>	
	<div id="appr">		
		Form type:		
		<?php
		foreach ($fno as $fn){
			?>
			<table><tr><td><input type="radio" name="formtype" value="<?php echo $fn; ?>" id="form<?php echo $fn; ?>" class="appradio" /></td><td class="formname">Form <?php echo $fn; ?></td><td><?php echo $desc[$fn];   ?></td></tr></table>
			<?php
			if($fn=='1c'){
				?>
				<span class="apprdetail">
				Faculty ID for approving faculty: 
				<select type="text" name="facid" id="apprfacid" disabled="disabled">
					<?php
					$query="select * from faculty natural join users;";
					$rs=pg_query($query);
					while($fac=pg_fetch_assoc($rs)){
						?>
						<option value="<?php echo $fac['facid']; ?>"><?php echo $fac['name']; ?></option>
						<?php
					}
					?>
				</select><br></span>
				<span class="apprdetail"><i>If option 1c is selected.</i></tr>
				</span><br><br>
				<?php
			}
			if($fn=='1a'){
				?>
				<span class="apprdetail">
				Approving executive: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;
				<select type="text" name="execpost" id="apprexec" disabled="disabled">
					<?php
					$query="select * from executive;";
					$rs=pg_query($query);
					while($fac=pg_fetch_assoc($rs)){
						?>
						<option value="<?php echo $fac['post']; ?>"><?php echo $fac['post']; ?></option>
						<?php
					}
					?>
				</select><br></span>
				<span class="apprdetail"><i>If option 1a is selected.</i></tr>
				</span><br><br>
				<?php
			}
		}
		?>		
	</div>
	<input type="submit" name="book" value="Book" />
</form>
</div>
<script type="text/javascript">
	$('#bdate0').change(process);
	$('#start0').change(function(){
		process();
	});
	$('#end0').change(function(){
		process();
	});
	$('#getHall').click(function(){
		process();
	});
	<?php
	if(in_array('1c', $fno) || in_array('1a', $fno)){
	?>
	$('.appradio').change(function(){
		if($('#form1c').is(":checked"))
			$('#apprfacid').prop('disabled',false);
		else{
			$('#apprfacid').prop('disabled',true);
			$('#apprfacid').val("");
		}
		if($('#form1a').is(":checked"))
			$('#apprexec').prop('disabled',false);
		else{
			$('#apprexec').prop('disabled',true);
			$('#apprexec').val("");
		}
		});
	<?php
	}
	?>
	function process()
	{
		var d=$('#bdate0').val();
		var s=$('#start0').val();
		var e=$('#end0').val();
		//alert("<b>Input: "+d+" "+s+" "+e+"</b>");
		if(s=="" || e=="" || d=="" || s=="undefined" || e=="undefined" || d=="undefined"){
			$('#avhalls').html("Input Date and Time");
			return;			
		}
		$('#avhalls').load('avail.php?date='+d+'&start='+s+'&end='+e);
	}
</script>

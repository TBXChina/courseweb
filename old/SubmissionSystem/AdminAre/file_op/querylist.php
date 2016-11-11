<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";
include_once $MYSQL_OP_DIR."/query.php";

if(!isset($_POST[$USERNAME]) || !query_Student($_POST[$USERNAME]))
	Signout();
$student_name = deal_username($_POST[$USERNAME]);
$student_dir = $STUDENT_DIR."/".$student_name;
?>


<!-- implement Submitted Homework List-->
	<?php echo $_POST[$USERNAME] ?>
	Submitted homework lists:
	<br/>	
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
	<ul>
		<?php
			ListDirinUL($student_dir);
		?>
		</ul>
	Choose Operation: <br/>
	<input type = "submit" name = "QueryDownload" value = "Download">
	<input type = "submit" name = "QueryDelete" value = "Delete">
	</form>
	<br>
	<br>

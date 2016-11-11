<?php

$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";

//start session
session_start();

if (isset($_POST['Signout']))
{
	unset($_SESSION[$IDENTITY]);
	unset($_SESSION[$USERNAME]);
	unset($_SESSION["student_dir"]);
}

//check if log in?
if (isset($_SESSION[$IDENTITY]) 
	&& 
	isset($_SESSION[$USERNAME])
	&& 
	$_SESSION[$IDENTITY] == $ADMIN) {
	# code...
	//echo $_SESSION[$IDENTITY];
	//echo "<br>";
	//echo $_SESSION[$USERNAME];
} else {
	# code...
	Signout();
}

//set the home page
$username = $_SESSION[$USERNAME];
$home_dir = $ADMIN_DIR."/".$username;
//mkdir admin home dir used for future
if(!is_dir($home_dir))
	mkdir($home_dir);
?>

<!-- implement download Homework Lists-->
<?php
		if(isset($_POST["RequirmentDownload"]))
		{
			if(isset($_POST["fileName"]))
			{
				include_once $FILE_OP_DIR."/download_or_delete_file.php";
				$file_dir = $HOMEWORK_DIR;
				$fileName = $_POST["fileName"];
				//echo $filepath."<br>";
				download($fileName, $file_dir);
			}
			else
			{
				echo "You should a file to download.";
			}
		}			
?>

<?php
		if(isset($_POST["QueryDownload"]))
		{
			if(isset($_POST["fileName"]))
			{
				include_once $FILE_OP_DIR."/download_or_delete_file.php";
				$file_dir = $_SESSION["student_dir"]; 
				//unset($_SESSION["student_dir"]);
				$fileName = $_POST["fileName"];

				download($fileName, $file_dir);
			}
			else
			{
				echo "You Should choice a file to operator.<br/>";
			}
		}
		
?>

<!-- implement export download -->
<?php
	if(isset($_POST["ExportHomework"]))
	{
		if (isset($_POST["Select"])) {
			# code...

			//export to correspond dir and download
			$save_file = export_homework($STUDENT_DIR, $_POST["Select"], $ADMIN_DIR);
			if ($save_file != "#") {
				# code...
				//echo $save_file;
				$file_dir = substr($save_file, 0, strrpos($save_file, "/"));
				$file_name = substr($save_file, strrpos($save_file, "/") + 1);
				//echo $file_dir."<br>";
				//echo $file_name."<br>";
				include_once $FILE_OP_DIR."/download_or_delete_file.php";
				download($file_name, $file_dir);
			}
			

		} 
		else
		{
			echo "You must choose No. <br>";
		}

	}	
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $COURSE." Submission Admin Console"; ?></title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php echo $COURSE; ?> Submission System" 
	/>
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!----webfonts---->
		<!-- <link href='http://fonts.googleapis.com/css?family=Oswald:100,400,300,700' rel='stylesheet' type='text/css'> -->
		<link href='css/googleapis.css' rel='stylesheet' type='text/css'>
		<!-- <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic' rel='stylesheet' type='text/css'> -->
		<link href='css/italic.css' rel='stylesheet' type='text/css'>
		<!----//webfonts---->
		<!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
		<script src="js/ajax.js"></script>
		<!--end slider -->
		<!--script-->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<!--/script-->
<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
<!---->

</head>
<body>
<!---header---->			
<div class="header">  
	 <div class="container">
		  <div class="logo">
			  <img src="images/logo.jpg" title="" />
		  </div>
		  <br/><br/><br/><br/><br/><br/>
		  <h2>
		  Welcome to Visit Probablity Theory Course Submission System
		  </h2>				
	 </div>
</div>
<!--/header-->
<div class="single">
	 <div class="container">
		  <div class="col-md-8 single-main">				 
			  <div class="single-grid">
					<img src="images/post1.jpg" alt=""/>						 			
			  </div>
			  <ul class="comment-list">
				 <li>
					<div class="desc">
					<h5 class="post-author_head">Distribute New Assignment</h5>
		  		   	<?php
						if(isset($_POST["DistributeHomework"]))
						{
							include_once $FILE_OP_DIR."/upload_file.php";

							$fileName = "file";

							if (isset($_FILES[$fileName]) 
								&& 
								isset($_POST["HomeworkNo"])
								&&
								!empty($_POST["HomeworkNo"])) {
									# code...
										$rename = $_POST["HomeworkNo"].".";
										if(empty($_POST["Homeworktitle"]))
										{
											$pos = strrpos($_FILES[$fileName]["name"], ".");
											$cut_name = substr($_FILES[$fileName]['name'], 0, $pos);
											$rename = $rename.$cut_name;
										}
										else
											$rename = $rename.$_POST["Homeworktitle"];	
											upload_file($fileName, 
													    $HOMEWORK_DIR, 
													    $UPLOAD_FILE_MAX, 
													    $rename);

										} else {
											# code...
											echo "You need at lease point out  No. and  choose a upload file";
							}	
			
						}
					?>
		  		   	<form enctype="multipart/form-data" 
						  action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
						  method = "post">
						No. &nbsp
						<input type = "text"
	     				name="HomeworkNo" 
	     				value="<?php echo CountDistributedHomeWork($HOMEWORK_DIR) + 1;  ?>"
	    				 size = 1
	    				 required>	&nbsp&nbsp
						Title (*optional):
						<input type = "text" 
						       name = "Homeworktitle"
						       placeholder="Fill if you want rename"
						       >
						<br/>
						<label for="file"> Choose a file: </label>
						<input type="file" name="file" id="file" required />
						<br/>
						<input type="submit" name = "DistributeHomework" value = "Distribute" />
						</form>
					</div>
				</li>
			</ul>
			 <ul class="comment-list">
		  		   <h5 class="post-author_head">Add News in Login Page</h5>
		  		   <li>
		  		   		<div class="desc">
		  		   			<!-- implement add news in Login Page -->
		  		   				<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
		  		   				      method = "post">
									<textarea name="msg" rows= "5" cols = "80"></textarea><br>
									<input type = "submit" name = "AddNotice" value = "Add">
								</form>

							<?php
								if(isset($_POST["AddNotice"]))
								include_once $FILE_OP_DIR."/Notice.php";
							?>
		  		   		</div>
		  		   </li>	   
		  	  </ul>
			  
			  <ul class="comment-list">
		  		   <h5 class="post-author_head">Export Submitted Homework</h5>
		  		   <li>
		  		   <div class="desc">
		  		   <form enctype="multipart/form-data" 
						action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
						method = "post">
						<p>Choose No.</p>
						<?php
							SubmitStudentForm($HOMEWORK_DIR);
						?>
						<p>Homework to export</p>
						<br/>
						<input type="submit" name = "ExportHomework" value = "Export" />			
					</form>


						
		  		   </div>
		  		   <div class="clearfix"></div>
		  		   </li>
		  	  </ul>
			  
			<div class="content-form">
				<h3>Query Submitted Homework:</h3><br>
					<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
						  method = "post">
						UserName: <input type = "text" name = "<?php  echo $USERNAME; ?>" required> 
						<input type="submit" Name = "QueryHomework" value = "Query">
					</form>
					<?php
						if(isset($_POST["QueryHomework"])
						&& isset($_POST[$USERNAME]))
						{
							if (empty($_POST[$USERNAME])) {
							# code...
							echo "Input a Username to query.<Br>";
							} else {
								# code...
								//check if a valid username
								include_once $MYSQL_OP_DIR."/query.php";
								if(query_Student($_POST[$USERNAME])) {
									include_once $FILE_OP_DIR."/querylist.php";
									$_SESSION["student_dir"] = $STUDENT_DIR."/".$_POST[$USERNAME];
								} else {
									# code...
									echo "Invalid.<br>";
								}
				
							}
			
						}
					?>
					<?php
						if(isset($_POST["QueryDelete"]))
						{
							if(isset($_POST["fileName"]))
							{
								include_once $FILE_OP_DIR."/download_or_delete_file.php";
								$file_dir = $_SESSION["student_dir"]; 
								//unset($_SESSION["student_dir"]);
								$fileName = $_POST["fileName"];
								delete_file($fileName, $file_dir);
							}
							else
						{
							echo "You Should choice a file to operator.<br/>";
						}
						}
		
					?>
				<br>
				
			</div>
			<div class="contact-details">
				<h3>Change Student Password:</h3><br/>
					<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
					      method = "post">
				    	<input type = "text" name = "<?php echo $USERNAME; ?>"
				    	       placeholder = "Student ID" required> 
						<input type = "password" name = "NewPassWD"
						   	   placeholder="New Password" required> 
						<input type="submit" Name = "ChangeStudentPassWD" value = "Change">
					</form>
					<!-- implement change student password function -->
					<?php
						if (isset($_POST["ChangeStudentPassWD"]))
						{
							if (!empty($_POST[$USERNAME]) && !empty($_POST["NewPassWD"])) {
								# code...
								//check the password if valid
								$studentName = $_POST[$USERNAME];
								$newpasswd = $_POST["NewPassWD"];
								if (is_valid_passwd($newpasswd)) {
								# code...
									include_once $MYSQL_OP_DIR."/update.php";
									update_username_passwd($studentName, $newpasswd, $TABLENAME);
								} else {
									# code...
								echo "Invalid New Password.<br/>";
								}
				
							} else {
									# code...
								if(empty($_POST[$USERNAME]))
									echo "Your Username is empty.<br>";
									if(empty($_POST["NewPassWD"]))
									echo "Your New Password is empty.<br>";
									echo "Your password won't change.<br/>";
							}
			
							}
						?>
			</div>

			<div class="contact-details">
				<h3>Insert New User:</h3><br/>
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
	<input type = "text" name = "<?php echo $USERNAME; ?>"
	       placeholder = "New Username" required> 
	<input type = "password" name = "NewPassWD"
	 		placeholder = "Password" required> 
	 		<br/>
	<input type = "radio" 
		   name = "<?php echo $IDENTITY; ?>" 
		   value = "<?php echo $STUDENT; ?>"
		   required />&nbsp Student 
	<input type = "radio" 
		   name = "<?php echo $IDENTITY; ?>" 
		   value = "<?php echo $ADMIN; ?>"
		   required />
		   &nbsp Admin &nbsp
	<input type="submit" Name = "InserNewUser" value = "Import">
	</form>

	<?php
		if (isset($_POST["InserNewUser"]))
		{
			if (!empty($_POST[$USERNAME])
			     && !empty($_POST["NewPassWD"]) 
			     && !empty($_POST[$IDENTITY])) {
				# code...
				//check the password if valid
				$newUsername  	 = $_POST[$USERNAME];
				$newpasswd 		 = $_POST["NewPassWD"];
				$table 			 = $TABLENAME;
				if($_POST[$IDENTITY] == $ADMIN)
					$table 		 = $ADMINTABLENAME;

				if (is_valid_passwd($newUsername)) {
					# code...
					include_once $MYSQL_OP_DIR."/insert.php";
					Insert_New_User($newUsername, $newpasswd, $table);
				} else {
					# code...
					echo "Invalid New Password.<br/>";
				}
				
			} else {
				# code...
				if(empty($_POST[$USERNAME]))
					echo "Your Username is empty.<br>";
				if(empty($_POST["NewPassWD"]))
					echo "Your New Password is empty.<br>";
				if(empty($_POST[$IDENTITY]))
					echo "You must choose an Identity to insert.<br>";

				echo "Your password won't change.<br/>";
			}
			
		}
	?>
			</div>

			<div class="contact-details">
			<h3>Delete Student User:
	<b>Warning: This process is irreversible!</b></h3><br/>
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
	<input type = "text" name = "<?php echo $USERNAME; ?>"
		 	placeholder = "Student ID" required> 
	<input type="submit" Name = "DeleteStudent" value = "Delete">
	</form>
	
	<?php
		if (isset($_POST["DeleteStudent"]))
		{
			if (!empty($_POST[$USERNAME])) {
				# code...
				//check the password if valid
				$delete_username 	 = deal_username($_POST[$USERNAME]);

				include_once $MYSQL_OP_DIR."/delete.php";
				$dir = $STUDENT_DIR."/".$delete_username;
				delete_student_user_count($delete_username, $dir);
				
			} else {
				# code...
					echo "Your Username is empty.<br>";
			}
			
		}
	?>
			</div>

			<!-- implement reset system, only root can see it -->
			<?php 
				if(isset($_SESSION[$IDENTITY]) 
					&& isset($_SESSION[$USERNAME])
					 && $_SESSION[$USERNAME] == "root")
				{
					echo "Reset All System. Warning: It is very dangerous, use caution!";
					$initialize_path = "AdminAre/initialization.php";
					echo "<form action = \"$initialize_path\" method = \"post\">";
					echo "<input type = \"submit\" name = \"reset\" value = \"Reset System\">";
					echo "</form>";
				}
					
			?>

		  </div>

			  <div class="col-md-4 side-content">
				 <div class="recent">
					 <h1>Hello, <?php echo $username; ?></h1><br>
					 <h3>Your Identity is <?php echo $_SESSION[$IDENTITY] ?></h3><br>
					 <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
					 	   method = "post">
						<input type = "submit" name = "Signout" value = "Sign Out">
						</form>
						<br>
					 <!-- implement update passwd-->
					 Change Password:
					 <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
						<input type = "password" 
							   name = "NewPassWD"
						       placeholder="New Passwor"
						       required> 
						<input type="submit" Name = "ChangeAdminPassWD" value = "Change">
					 </form>

					<?php
						if (isset($_POST["ChangeAdminPassWD"]))
						{
							if (!empty($_POST["NewPassWD"])) {
							# code...
							//check the password if valid
							$newpasswd = $_POST["NewPassWD"];
							if (is_valid_passwd($newpasswd)) {
								# code...
								include_once $MYSQL_OP_DIR."/update.php";
								update_username_passwd($username, $newpasswd, $ADMINTABLENAME);
								} else {
									# code...
									echo "Invalid New Password.<br/>";
								}
				
							} else {
								# code...
								echo "Your New Password is empty.<br>";
								echo "Your password won't change.<br/>";
							}
			
						}
					?>
					
				 </div>
				 <div class="archives">
					 <h3>Recent News</h3>
					 <ul>
					 <?php
		  				listRecentNewsinUL($NOTICE_PATH);
		  			 ?>
		  			 </ul>
				 </div>
				 <div class="comments">
					 <h3>Assignments</h3>
					 <!-- implement homework delete -->
					 <?php
						if(isset($_POST["DeleteHomework"]))
						{
							if(isset($_POST["fileName"]))
							{
								include_once $FILE_OP_DIR."/download_or_delete_file.php";
								$file_dir = $HOMEWORK_DIR;
								$fileName = $_POST["fileName"];
								//echo $filepath."<br>";
								delete_file($fileName, $file_dir);
							}
							else
							{
								echo "You should a file to download.";
							}
						}	
					?>
					 <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
					       method = "post">
					 	<ul>
							<?php
								ListDirinUL($HOMEWORK_DIR);
							?>
						</ul>
						<br>
						<input type = "submit" name = "RequirmentDownload" value = "Download">
						<input type = "submit" name = "DeleteHomework" value = "Delete">
					 </form>
				 </div>
				 
				 
				 
			  </div>
			  <div class="clearfix"></div>
		  </div>
	  </div>
</div>
<!---->
<div class="footer">
	 <div class="container">
		<p>Developed by the Teaching asistants</p>
	 </div>
</div>

	

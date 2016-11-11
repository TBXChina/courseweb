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
}

//check if log in?
if (isset($_SESSION[$IDENTITY]) 
	&& isset($_SESSION[$USERNAME])
	&& $_SESSION[$IDENTITY] == $STUDENT) {
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
$home_dir = $STUDENT_DIR."/".$username;
//mkdir student home dir
if(!is_dir($home_dir))
	mkdir($home_dir);

//$_POST['file_dir'] = $home_dir;
?>

 <!-- implement list and download distributed problems -->
<?php
	if(isset($_POST["RequirmentDownload"]))
	{
		if(isset($_POST["fileName"]))
		{
			include_once $FILE_OP_DIR."/download_or_delete_file.php";
			$file_dir = $HOMEWORK_DIR;
			$fileName = $_POST["fileName"];
			download($fileName, $file_dir);
		}
		else
		{
			echo "You should a file to download.";
		}
	}		
?>

<!-- implement download hisself homework function -->
<?php
	if(isset($_POST["Download"]))
	{
		if(isset($_POST["fileName"]))
			{
				include_once $FILE_OP_DIR."/download_or_delete_file.php";
				$file_dir = $home_dir;
				$fileName = $_POST["fileName"];
				download($fileName, $file_dir);
			}
			else
			{
				echo "You Should choice a file to operator.<br/>";
			}
	}


?>
<!DOCTYPE html>
<html>
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $COURSE." Submission Console"; ?></title>
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
		  		   <h5 class="post-author_head">Submit homework</h5>
		  		   <li>
		  		   <div class="desc">
		  		   <form enctype="multipart/form-data" 
						action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
						method = "post">
						<p>Choose No.</p>
						<?php
							SubmitStudentForm($HOMEWORK_DIR);
						?>
						<p>Assignment to submit.</p>
						<input type="file" name="file" id="file" required="" />
						<br/>
						<input type="submit" name = "SubmitHomework" value = "Upload" />			
					</form>


					<!-- implement upload function -->
					<?php
						if(isset($_POST["SubmitHomework"]))
						{
							include_once $FILE_OP_DIR."/upload_file.php";

							$fileName = "file";

							if (isset($_FILES[$fileName]) && isset($_POST["Select"])) {
							# code...
							$rename = $username."_No_".$_POST["Select"];
							upload_file($fileName, $home_dir, $UPLOAD_FILE_MAX, $rename);

						} else {
							# code...
							echo "You must both choose No. and upload file";
						}	
			
						}
					?>
					<!-- upload  -->
					<div class = "man-info">
						<b>* Notices:</b>
						<ul>
							<li>Size < <?php echo Byte2MB($UPLOAD_FILE_MAX); ?> MB </li>
							<li>Type is pdf/zip</li>
							<li>Uploaded file will be renamed.</li>
						</ul> 
					</div>
						
		  		   </div>
		  		   <div class="clearfix"></div>
		  		   </li>
		  	  </ul>



		  	  		
		  	  <ul class="comment-list">
		  		   <h5 class="post-author_head">Your homework lists:</h5>
		  		   <!-- implement delete function -->
		  		   <?php
		  		   		if(isset($_POST["Delete"]))
		  		   		{
		  		   			if(isset($_POST["fileName"]))
							{
								include_once $FILE_OP_DIR."/download_or_delete_file.php";
								$file_dir = $home_dir;
								$fileName = $_POST["fileName"];

								delete_file($fileName, $file_dir);
							}
							else
							{
								echo "You Should choice a file to operator.<br/>";
							}
		  		   		}
		  		   ?>
		  		   <li>
		  		   <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
		  		          method = "post">
		  		          
		  		        <table border = "1" border-spacing = "100" >
						<tr>
							<td align = "center" ><p>Name</p></td>
							<td align = "center"><p>Upload Time</p></td>
							<td align = "center"><p>Size MB</p></td>
							<?php
							ListDirinTable($home_dir);
							?>
						</table>
						<br>
						<input type = "submit" name = "Download" value = "Download">
						<input type = "submit" name = "Delete"   value = "Delete">
		  		   </form>		  		
		  		   </li>
		  	  </ul>
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
						Change Password: <br>
						<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
						<input type = "password" 
							   name = "NewPassWD"
							   placeholder = "New Password"
							   required> 
						<input type="submit" Name = "ChangePassWD" value = "Change">
						</form>

						<!-- php implement change password function -->
						<?php
							if (isset($_POST["ChangePassWD"]))
							{
								if (!empty($_POST["NewPassWD"])) {
								# code...
								//check the password if valid
								$newpasswd = $_POST["NewPassWD"];
								if (is_valid_passwd($newpasswd)) {
									# code...
									include_once $MYSQL_OP_DIR."/update.php";
									update_username_passwd($username, $newpasswd, $TABLENAME);
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
					 <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
					 	   method = "post">
					 	 <ul>
					 	 <?php
							ListDirinUL($HOMEWORK_DIR);
						 ?>
						 </ul>
						<br>
						<input type = "submit" name = "RequirmentDownload" value = "Download">
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

	

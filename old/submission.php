<?php
	$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
	include_once $SRC_ROOT."/AdminAre/conf.php";
	include_once $SRC_ROOT."/AdminAre/fun.php";

	session_start();

	if(isset($_SESSION[$IDENTITY]))
	{
		if ($_SESSION[$IDENTITY] == $ADMIN) {
			# code...
			$Admin_home = "AdminWelcome.php";
			Signin($Admin_home);
		} else {
			# code...
			$Student_home = "Welcome.php";
			Signin($Student_home);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="renderer" content="webkit"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $COURSE; ?></title>
	<link href="SubmissionSystem/css/bootstrap.css" 
		  rel='stylesheet' 
		  type='text/css' />
	<link href="SubmissionSystem/css/style.css" 
		  rel='stylesheet' 
		  type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php echo $COURSE; ?> Submission System" 
	/>
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!----webfonts---->
		<!-- <link href='http://fonts.googleapis.com/css?family=Oswald:100,400,300,700' rel='stylesheet' type='text/css'> -->
		<link href='SubmissionSystem/css/googleapis.css' rel='stylesheet' type='text/css'>
		<!-- <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic' rel='stylesheet' type='text/css'> -->
		<link href='SubmissionSystem/css/italic.css' rel='stylesheet' type='text/css'>
		<!----//webfonts---->
		<!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
		<script src="SubmissionSystem/js/ajax.js"></script>
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
			  <a href="submission.php"><img src="SubmissionSystem/images/logo.jpg" title="Probability Theory Course Website" /></a>
		  </div>
		  <br/><br/><br/><br/><br/><br/>
		  <h2>Welcome</h2>
	 </div>
</div>
<!--/header-->
<div class="contact-content">
	 <div class="container">
		     <div class="contact-info">
			 <h2>Submission System</h2>
			 <p>Welcome to Visit Course "<?php echo $COURSE; ?>" WebSite.</p>
			 <br>
			 强烈建议使用<b>chrome，Firefox，Edge</b>，或者360浏览器的<b>极速模式</b>（地址栏最右边有个按钮可以切换）
		     </div>
			 <div class="contact-details">
			 <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
				UserName: &nbsp<input type="text" 
									  name = "<?php echo $USERNAME;  ?>" 
									  placeholder = "Student ID"
									  required><br/>
				Password: &nbsp &nbsp<input type="password" 
							 	      name = "<?php echo $PASSWD;?>" 
							 	      placeholder = "Default Password is your Student ID"
							 	      required><br/>

<!-- ************************************php code****************************** -->
<?php
//check UserName & Passwd right?
if(isset($_POST[$USERNAME]) && ($_POST[$PASSWD]) )
{
	$username 		= deal_username($_POST[$USERNAME]);
	$passwd 		= deal_passwd($_POST[$PASSWD]);

	//connect to mysql and choose dataset Probability Theory
	$con = mysqli_connect($SERVERNAME, $DBUSER, $DBPWD);
	mysqli_select_db($con, $DBNAME);
	if(!$con)
		die('Could not connect: '.mysqli_connect_error($con));

	//first check student dataset
	$table 			= $TABLENAME;
	$sql = "SELECT $USERNAME, $PASSWD 
			FROM $table
			WHERE $USERNAME = '$username' AND 
				  $PASSWD 	= '$passwd'";
	//echo $sql."<br>";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) == 0) {
		# code...
		//They are not student, let's see where they are admin
		$table 		= $ADMINTABLENAME;
		$sql = "SELECT $USERNAME, $PASSWD 
				FROM $table
				WHERE $USERNAME = '$username' AND 
				 	  $PASSWD 	= '$passwd'";
		$result = mysqli_query($con, $sql);

		if ( mysqli_num_rows($result) == 0) {
			# code...
			//they are not student or admin
			echo "Invalid Password, please check.<br/><br/>";
			unset($_SESSION[$IDENTITY]);
			unset($_SESSION[$USERNAME]);
		} else {
			# code...
			//they are admin
			$_SESSION[$IDENTITY] = $ADMIN;
			$_SESSION[$USERNAME] = $username;	

			$Admin_home = "AdminWelcome.php";
			Signin($Admin_home);
		}
		

	} else {
		# code...
		//they are student
		$_SESSION[$IDENTITY] = $STUDENT;
		$_SESSION[$USERNAME] = $username;
		$Student_home 		 = "Welcome.php";
		Signin($Student_home);

	}
	
}
?>	
<!-- ************************************php code****************************** -->


				<input type = "submit" value = "Sign in">
			 </form>
		  </div>
		  <br>

		  <div class = "about-content">
		  <h2>Recent News:<br></h2>
		  	<div class = "about-grid2">		  		
		 		 <ul>
		 		 <?php
		  			listRecentNewsinUL($NOTICE_PATH);					
		  		?>
		 		 </ul>
		  	</div>
		  
		  </div>

		  <div class="contact-details">
			  <div class="col-md-6 contact-map">
				 <h4>FIND US HERE</h4>
				 <iframe src="http://map.baidu.com/?newmap=1&shareurl=1&l=19&tn=B_NORMAL_MAP&hb=B_SATELLITE_STREET&c=13243602,3755695" frameborder="0" style="border:0"></iframe>
			  </div>
			  <div class="col-md-6 company_address">		 
					<h4>GET IN TOUCH</h4>
					<p>305 Room, Panzhonglai Building</p>
					<p>163, Xianlin Avenue</p>
					<p>Nanjing, Jiangsu Province</p>
					<p>Email: <a href="mailto:probability2016@163.com">probability2016@163.com</a></p>
					<p>Lab Homepage: <a href="http://visg.nju.edu.cn">visg.nju.edu.cn</a>
			 </div>
			  <div class="clearfix"></div>
	     </div>		 


			 </div>
	 </div>
</div>

<div class="footer">
	 <div class="container">
		<p>Developed by the Teaching asistants</p>
	 </div>
</div>
	

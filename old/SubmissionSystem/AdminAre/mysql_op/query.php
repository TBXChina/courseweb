<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";

function query_Student ($UserName)
{
	$valid_username = false;
	if(!empty($UserName))
	{
		// some important var
		$SERVERNAME		= "127.0.0.1";
		$DBUSER 		= "root";
		$DBPWD 			= "eelab305";
		$DBNAME 		= "ProbabilityTheoryDB";
		$USERNAME		= "UserName";
		$PASSWD			= "PassWD";
		$TABLENAME		= "Student";

		$username 		= deal_username($UserName);
		$table 			= $TABLENAME;

		//connect to mysql
		$con = mysqli_connect($SERVERNAME, $DBUSER, $DBPWD);
		mysqli_select_db($con, $DBNAME);

		if(!$con)
			die('Could not connect: '.mysqli_connect_error($con));

		//check if already exist
		$sql = "SELECT * FROM $table  WHERE $USERNAME = '$username'";
		$result = mysqli_query($con, $sql );

		if (mysqli_num_rows($result) == 1) {
			# code...
			$valid_username = true;
		} else {
			# code...
			echo "Error: Don't exist: <br>Data: UserName: ".
			      $username."<br>";
			$valid_username = false;
		}
			
		mysqli_close($con);

	}


	return $valid_username;
}



?>
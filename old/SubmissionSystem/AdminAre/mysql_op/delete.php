<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";


function delete_student_user_count($StudentUserName, $StudentUser_dir)
{
	if (empty($StudentUserName)) {
		# code...
		echo "The Student UserName is empty.<br>";

	} else {
		# code...
		// some important var
		$SERVERNAME		= "127.0.0.1";
		$DBUSER 		= "root";
		$DBPWD 			= "eelab305";
		$DBNAME 		= "ProbabilityTheoryDB";
		$USERNAME		= "UserName";
		$PASSWD			= "PassWD";
		$TABLENAME		= "Student";

		$username       = deal_username($StudentUserName);
		$table 			= $TABLENAME;

		//connect to mysql
		$con = mysqli_connect($SERVERNAME, $DBUSER, $DBPWD);
		mysqli_select_db($con, $DBNAME);

		if(!$con)
			die('Could not connect: '.mysqli_connect_error($con));

		//check if already exist
		$sql = "SELECT * FROM $table  WHERE $USERNAME = '$username'";
		$result = mysqli_query($con, $sql );

		if (mysqli_num_rows($result) > 0) {
			# code...
			$sql = "DELETE FROM $table 	WHERE $USERNAME = '$username'";

			if (mysqli_query($con, $sql)) {
				# code...
				echo "Delete data: <br>UserName: ".$username."  <br>";

				//delete all his file
				$dir = $StudentUser_dir;
				del_dir($dir);
				echo "Files of ".$username." have been all cleaned.<br><br>";


			} else {
				# code...
				echo "Failed to Update data: <br>UserName: ".$username."<br><br>";
			}

		} else {
			# code...
			echo "Error: Don't exist: <br>Data: UserName: ".
			      $username."<br><br>";
			echo "Are you sure you are not kidding me?<br><br>";
		}



		mysqli_close($con);
	}
	
	//first check where a valid account

}



?>
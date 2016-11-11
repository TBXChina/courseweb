<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";

function Insert_New_User($NewUserName,
						 $NewPassWD,
						 $Table	)
{
	if (!empty($NewUserName) && !empty($NewPassWD)) {
		# code...
		if (is_valid_passwd($NewPassWD)) {
			# code...
			// some important var
			$SERVERNAME		= "127.0.0.1";
			$DBUSER 		= "root";
			$DBPWD 			= "eelab305";
			$DBNAME 		= "ProbabilityTheoryDB";
			$USERNAME		= "UserName";
			$PASSWD			= "PassWD";

			$username 	= deal_username($NewUserName);
			$passwd 	= deal_passwd($NewPassWD);
			$table 		= $Table;
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
				echo "Data: UserName: ".$username."<br>already exists, no need to insert.<br>";

			} else {
				# code...
				$sql = "INSERT INTO $table VALUES('$username', '$passwd')";

				if (mysqli_query($con, $sql)) {
					# code...
					echo "Import data: <br>UserName: ".$username."  <br>PassWD: ".$NewPassWD.
						"<br>In Table: ".
						$table."<br>";
				} else {
					# code...
					echo "Failed to Import data: <br>UserName: ".$username."<br>";
				}
					
			}
			
			mysqli_close($con);

		} else {
			# code...
			echo "Invalid New Password.<br/>";
		}
		

	} else {
		# code...
		if(empty($NewUserName))
			echo "Your New User Name is empty.<br/>";
		if(empty($NewPassWD))
			echo "Your New Password is empty.<br/>";
	}
}



?>
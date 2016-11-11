<?php
//Warning: this script is for initialize total Submission System.
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";

session_start();


if (isset($_POST["reset"]) && 
	isset($_SESSION[$IDENTITY]) &&
	isset($_SESSION[$USERNAME]) &&
	$_SESSION[$USERNAME] == "root")
	
{
	# code...

	session_destroy();
//two step reset dir and sql

//1. delete all form files
if (is_dir($STORE_DIR)) {
	# code...
	$dh = opendir($STORE_DIR);	
	while ($file = readdir($dh)) {
		# code...
		if ($file != "." && $file != "..")
		{
			$full_path = $STORE_DIR."/".$file;
			if(is_dir($full_path))
				del_dir($full_path);
		}
	}
	closedir($dh);

} else {
	# code...
	dir("You need create storage root dir handly.");

}

//create necessary dir and file
//mkdir($STORE_DIR, 0777);
mkdir($SHARED_DIR);
echo "Create DIR: ".$SHARED_DIR."<br>";
mkdir($ADMIN_DIR);
echo "Create DIR: ".$ADMIN_DIR."<br>";
mkdir($STUDENT_DIR);
echo "Create DIR: ".$STUDENT_DIR."<br>";
mkdir($HOMEWORK_DIR);
echo "Create DIR: ".$HOMEWORK_DIR."<br>";
mkdir($PPT_DIR);
echo "Create DIR: ".$PPT_DIR."<br>";
touch($NOTICE_PATH);
echo "Touch file: ".$NOTICE_PATH."<br>";



$con = mysqli_connect($SERVERNAME, $DBUSER, $DBPWD);
if (!$con)
{
  die('Could not connect: ' . mysqli_connect_error($con));
}

echo "Connect to Server: $SERVERNAME Successfully.<br>";

//delete exist database
$sql = "drop database if exists $DBNAME";
mysqli_query($con, $sql);
echo "Delete exists database: $DBNAME<br>";
echo "==========================================<br>";


//create new DB
$sql = "create database $DBNAME";
if (mysqli_query($con, $sql)) {
	# code...
	echo "New $DBNAME Created.<br>";
} else {
	# code...
	echo "Failed Create New $DBNAME.<br>";
}
//choose this DB
if (mysqli_select_db($con, $DBNAME))
	echo "Select $DBNAME.<br>";
else
	echo "Failed to select $DBNAME.<br>";

//create Name Table
$sql = "create table $TABLENAME
(
$USERNAME varchar(15) NOT NULL,
PRIMARY KEY($USERNAME),
$PASSWD varchar(40) NOT NULL
)";
if (mysqli_query($con, $sql)) {
	# code...
	echo "Create Table $TABLENAME Successfully.<br>";
} else {
	# code...
	echo "Failed to Create $TABLENAME.<br>";
}

echo "==========================================<br>";



//insert username and default passwd
$NameList_file = fopen($NAMELIST_DIR, "r");

while (!feof($NameList_file)) {
	# code...
	$line = fgets($NameList_file);
	$line = deal_username($line);
	$pw = deal_passwd($line);
	//echo $pw."<br>";
	$sql = "INSERT INTO $TABLENAME VALUES('$line', '$pw')";
	if (mysqli_query($con, $sql)) {
		# code...
		echo "Import data: UserName: ".$line." PassWD: ".$line."<br>";
	} else {
		# code...
		echo "Failed to Import data: ".$line."<br>";
	}
}
fclose($NameList_file);

/*
//test output
$result = mysqli_query($con, "SELECT * FROM $TABLENAME");
while($row = mysqli_fetch_array($result))
	echo $row["UserName"]." ".$row["PassWD"]."<br>";
*/

//mysqli_close($con);
echo "<br>=========Student List Complete============<br><br><br>";


/*********************************************************************
*********************************************************************
*********************************************************************/

//Now initialize Admin Table

//create Name Table
$sql = "create table $ADMINTABLENAME
(
$USERNAME varchar(15) NOT NULL,
PRIMARY KEY($USERNAME),
$PASSWD varchar(40) NOT NULL
)";
if (mysqli_query($con, $sql)) {
	# code...
	echo "Create Table $ADMINTABLENAME Successfully.<br>";
} else {
	# code...
	echo "Failed to Create $ADMINTABLENAME.<br>";
}

echo "==========================================<br>";



//insert username and default passwd
$NameList_file = fopen($ADMINLIST_DIR, "r");

while (!feof($NameList_file)) {
	# code...
	$line = fgets($NameList_file);
	$line = deal_username($line);
	$pw   = deal_passwd($line);
	//echo $pw."<br>";
	$sql = "INSERT INTO $ADMINTABLENAME VALUES('$line', '$pw')";
	if (mysqli_query($con, $sql)) {
		# code...
		echo "Import data: UserName: ".$line." PassWD: ".$line."<br>";
	} else {
		# code...
		echo "Failed to Import data: ".$line."<br>";
	}
}
fclose($NameList_file);

/*
//test output
$result = mysqli_query($con, "SELECT * FROM $TABLENAME");
while($row = mysqli_fetch_array($result))
	echo $row["UserName"]." ".$row["PassWD"]."<br>";
*/

mysqli_close($con);
echo "<br>==========Admin List Complete=============<br><br><br>";
echo "Initialize Submission System Complete.<br><br><br>";

} 

else {
	# code...
	echo "Invalid Visit.";
}


?>


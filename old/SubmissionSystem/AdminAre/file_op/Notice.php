<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";

if (isset($_POST["msg"])) {
	# code...
	if (empty($_POST["msg"])) {
		# code...
		echo "Empty Message.<br>";
	} else {
		# code...
		$user_msg = deal_string($_POST["msg"]);
		$msg = "\n".date("Y-m-d").".\t$user_msg";

		$noticefile = fopen($NOTICE_PATH, "a") or die("Unable to open file: $NOTICE_PATH");
		fwrite($noticefile, $msg);
		fclose($noticefile);
		echo "Write: \"".$user_msg."\" into notice.txt successfully.";
	}
} else {
	# code...
	echo "Invalid Visit.<br>";
}



?>

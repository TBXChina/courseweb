<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";

/*
if (isset($_POST['filePath']) 
		//&& isset($_POST['file_dir'])
		) {
		# code...
		$filepath = $_POST['filePath'];
		//$file_dir = $_POST['file_dir'];

		if(isset($_POST['Delete']))
			delete_file($filepath);

		if(isset($_POST['Download']))
			download($filepath);


	} else {
		# code...
		echo "Invalid Visit.";
	}

	echo "<br/>";

*/





//----------------function implement------------------------
function download($fileName, $file_dir)
{
	$complete_path = $file_dir."/".$fileName;
	//$complete_path = $filePath;
	

	if ( file_exists($complete_path)) {
		# code...
		
		$file = $complete_path;
		//echo $file."<br>";
		
		header('Content-Description: File Transfer');
    	header('Content-Type: application/octet-stream');
   	 	header('Content-Disposition: attachment; filename="'.basename($file).'"');
    	header('Expires: 0');
    	header('Cache-Control: must-revalidate');
    	header('Pragma: public');
    	header('Content-Length: ' . filesize($file));
    	if (ob_get_level()) 
			ob_end_clean();

    	readfile($file);
    	fclose ( $file ); 
    	
	} else {
		# code...
		echo "File: \"" . $fileName ."\" Can't find, please check.<br/>";
	}
}


function delete_file($fileName, $file_dir)
{
	$complete_path = $file_dir."/".$fileName;
	

	if ( !is_dir($complete_path) && file_exists($complete_path)) {
		# code...
		if (unlink($complete_path)) {
			# code...
			echo "Successfully delete File: \"" .$fileName."\"<br/><br/>";
		} else {
			# code...
			echo "Error deleting File: \"" .$fileName."\"<br/>";
		}
		

	} else {
		# code...
		echo "File: \"" . $fileName .
			"\" Can't find, please check.<br/><br/>";
	}
}

?>
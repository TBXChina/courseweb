<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
include_once $SRC_ROOT."/AdminAre/fun.php";




//-------------function implement-----------------
function file_limits($fileName, $UPLOAD_FILE_MAX)
{
	return ($_FILES[$fileName]["size"] < $UPLOAD_FILE_MAX)
		   &&
		   ($_FILES[$fileName]["type"] == "application/pdf"
		   	|| 
		   	substr($_FILES[$fileName]["name"], 
		   		   strrpos($_FILES[$fileName]["name"], ".") + 1
		   		   ) == "zip"
				||
		   	substr($_FILES[$fileName]["name"], 
		   		   strrpos($_FILES[$fileName]["name"], ".") + 1
		   		   ) == "pdf"
						);
}

function upload_file($fileName, 
					 $savePath,
					 $UPLOAD_FILE_MAX, 
					 $rename = "#") {

	if ($_FILES[$fileName]["error"] > 0) {
		# code...
		if ($_FILES[$fileName]["error"] == 4) {
			# code...
			echo "You haven't choose any file.<br/><br/>";
		} else {
			# code...
			echo "Upload error.<br>";
			echo "<h3>Error:<br/></h3>";
			echo "File Limits: ";
			echo "Only Size < ".Byte2MB($UPLOAD_FILE_MAX).
		  	     " MB and Type is pdf/zip can be upload<br/><br/>";
		//echo $_FILES[$fileName]["error"]."<br>";
		}
		
		
	} else {

		if (file_limits($fileName, $UPLOAD_FILE_MAX)) {
			# code...  			
			//check where need to rename
  			if($rename != "#")
  			{
  				$postfix = substr($_FILES[$fileName]["name"], 
		   		   			      strrpos($_FILES[$fileName]["name"], ".") + 1
		   		   				);
  				$_FILES[$fileName]["name"] = $rename.".".$postfix;

  			}

  			if (file_exists($savePath."/".$_FILES[$fileName]["name"])) {
  				# code...
  				echo "<h3>Error:</h3><br/>";
  				echo "File: ".$_FILES[$fileName]["name"].
  						"<br/>Already exists. 
  						May be you should delete ahead.<br/><br/>";
  			} else {
  				# code...
  				echo "Upload: " . $_FILES[$fileName]["name"] . "<br />";
  				echo "Size: " .
  				 	 Byte2MB($_FILES[$fileName]["size"]). " Mb<br />";

  				
  				move_uploaded_file($_FILES[$fileName]["tmp_name"], 
  							   $savePath."/".$_FILES[$fileName]["name"]);
  				//echo "Stroded in: ".$savePath."/".$_FILES[$fileName]["name"];
  				echo "Upload File: ".
  					 $_FILES[$fileName]["name"].
  					 " Successfully<br/><br/>";
  		}
	
		} else {
			# code..o
			echo "file Limits:<br>";
			echo "<h3>Error:<br/></h3>";
			echo "Upload file: ".$_FILES[$fileName]["name"];
			echo "<br/>";
			echo "Size: ".Byte2MB($_FILES[$fileName]['size'])." MB";
			echo "<br/>";
			echo "Type: ".substr($_FILES[$fileName]["name"], 
		   		   				 strrpos($_FILES[$fileName]["name"], ".") + 1
		   		   				);
			echo "<br/>";

			echo "File Limits: ";
			echo "Only Size < ".Byte2MB($UPLOAD_FILE_MAX).
			" MB and Type is pdf/zip can be upload<br/><br/>";
		}			
	}
}




?>

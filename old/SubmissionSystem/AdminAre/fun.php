<?php
$SRC_ROOT = "/usr/local/apache2/htdocs/SubmissionSystem";  
include_once $SRC_ROOT."/AdminAre/conf.php";
//include_once $SRC_ROOT."/AdminAre/fun.php";

function deal_string($line)
{
	$line = trim($line);
  	$line = stripslashes($line);
  	$line = htmlspecialchars($line);
  	return $line;
}

function deal_username($line)
{
	$line = trim($line);
  	$line = stripslashes($line);
  	$line = htmlspecialchars($line);
  	$line = strtolower($line);
  	return $line;
}

function deal_passwd($passwd)
{
	$passwd = trim($passwd);
	$passwd = stripcslashes($passwd);
	$passwd = htmlspecialchars($passwd);
	$passwd = md5($passwd);
	return $passwd;
}

function is_valid_passwd($passwd)
{
	if(strlen($passwd) > 20)
	{
		echo "Password Length should less than 20<br>";
		return false;
	}
	return true;
}

function password_requirment()
{
	echo "Your new password ";
}


function del_dir($dir)
{
	//check if a dir, other with do nothin
	if(is_dir($dir))
	{
		$dh = opendir($dir);

		while ($file = readdir($dh)) {
			# code...
			if($file != "." && $file != "..")
			{
				$full_path = $dir."/".$file;

				if (is_dir($full_path)) {
					# code...
					del_dir($full_path);
				} else {
					# code...
					unlink($full_path);
				}
				
			}
		}
		closedir($dh);

		//delete current dir
		if(is_dir($dir))
			rmdir($dir);
	}

}

function listRecentNewsinUL($news_path)
{
	$notice_file = fopen($news_path, "r") or die("Unable to read in Notice!");
		  			$lines = array();
		  			while (!feof($notice_file)) {
		  				# code...
		  				$one_line = fgets($notice_file);
		  				//echo $one_line."####<br>";
		  				if($one_line != "\n" && !empty($one_line))
		  					array_push($lines, $one_line);
		  			}
		  			fclose($notice_file);
		  			//reverse info
		  			//array_reverse($lines);
		  			$length = count($lines);
		  			for ($i=$length - 1; $i >= 0; $i--) { 
		  				# code...
		  				echo "<li>";
						echo $lines[$i]."<br>";
						echo "</li>";
		  			}	
}

function ListDirinTable($ListDir)
{
	$dh = opendir($ListDir);
	$file_set = array();
	while ($file = readdir($dh)) {
		# code...
		if($file != '.' && $file != '..')
		{
			array_push($file_set, $file);

		}
	}
	closedir($dh);

	sort($file_set);
	$array_length = count($file_set);
	for ($i=0; $i < $array_length ; $i++) { 
		# code...
		$file = $file_set[$i];
		echo "<tr>";
		echo "<td>";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<input type=\"radio\" 
			   name = \"fileName\" 
			   value = \"$file\"
			   required>&nbsp&nbsp";
		echo $file;
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "</td>";
		echo "<td>";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo date("Y-m-d H:i:s", filectime($ListDir."/".$file));
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "</td>";
		echo "<td align = \"center\">";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo Byte2MB(filesize($ListDir."/".$file));
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "</td>";
		//echo "<br/>";
		echo "</tr>";
	}
}

function ListDirinUL($ListDir)
{
	if(is_dir($ListDir))
	{
		$dh = opendir($ListDir);
	$file_set = array();
	while ($file = readdir($dh)) {
		# code...
		if($file != '.' && $file != '..')
		{
			array_push($file_set, $file);

		}
	}
	closedir($dh);

	sort($file_set);
	$array_length = count($file_set);
	for ($i=0; $i < $array_length ; $i++) { 
		# code...
		$file = $file_set[$i];
		echo "<li>";
		
		echo "<input type=\"radio\" 
			   name = \"fileName\" 
			   value = \"$file\"
			   required>";
		echo $file;
		echo "</li>";

		//echo "<td>".date("Y-m-d H:i:s", filectime($ListDir."/".$file))."</td>";
		//echo "<td>".Byte2MB(filesize($ListDir."/".$file))."</td>";
		//echo "<br/>";
		//echo "</tr>";
	}
}	
}

function ListDirinForm($ListDir)
{
	if(is_dir($ListDir))
	{
		$dh = opendir($ListDir);
	$file_set = array();
	while ($file = readdir($dh)) {
		# code...
		if($file != '.' && $file != '..')
		{
			array_push($file_set, $file);

		}
	}
	closedir($dh);

	sort($file_set);
	$array_length = count($file_set);
	for ($i=0; $i < $array_length ; $i++) { 
		# code...
		$file = $file_set[$i];
		//echo "<tr>";
		//echo "<td>";
		echo "<input type=\"radio\" 
			   name = \"fileName\" 
			   value = \"$file\"\>";
		echo $file;
		//echo "</td>";

		//echo "<td>".date("Y-m-d H:i:s", filectime($ListDir."/".$file))."</td>";
		//echo "<td>".Byte2MB(filesize($ListDir."/".$file))."</td>";
		echo "<br/>";
		//echo "</tr>";
	}
}	
}

function SubmitStudentForm($HOMEWORK_DIR)
{
	if(is_dir($HOMEWORK_DIR))
	{
		//parse distributed homework
	$dh = opendir($HOMEWORK_DIR);
	$file_set  = array();
	//$count = 0;
	while ($file = readdir($dh)) {
		# code...
		if($file != '.' && $file != '..')
		{
			
			array_push($file_set, $file);
		}
	}
	closedir($dh);
	sort($file_set);
	
	$array_length = count($file_set);
	for($i = 0; $i < $array_length; ++$i)
	{
		$file = $file_set[$i];
		//parse the homework's Name
		$No = substr($file, 0, strpos($file, "."));
		$title = substr($file, 0, strrpos($file, "."));
		echo "<input type=\"radio\" name = \"Select\" value = \"$No\" required>";
		echo " $No&nbsp&nbsp&nbsp";
		//echo "$title"; 
		//echo "<br/>";
	}
	}
}

function CountDistributedHomeWork($HOMEWORK_DIR)
{
	if(is_dir($HOMEWORK_DIR))
	{
		//parse distributed homework
	$dh = opendir($HOMEWORK_DIR);
	
	$count = 0;
	while ($file = readdir($dh)) {
		# code...
		if($file != '.' && $file != '..')
		{
			
			$count += 1;
		}
	}
	closedir($dh);
	return $count;
	}
	else
		return 0;
	
}

function export_homework($dir, $No, $dest_root_dir)
{
	if (is_dir($dest_root_dir) && is_numeric($No)) {
		# code...
		$dest_no_dir = $dest_root_dir."/No".$No;
		//echo $dest_no_dir."<br>";
		if(is_dir($dest_no_dir))
			del_dir($dest_no_dir);

		mkdir($dest_no_dir);



		if (is_dir($dir) ) {
		# code...
		$homework_root = opendir($dir);

		while ($student_name = readdir($homework_root)) {
			# code...
			if ($student_name != "." && $student_name != "..") {
				# code...
				//list all the student root, and entrance
				$student_dir = $dir."/".$student_name;
				if (is_dir($student_dir)) {
					# code...
					$student_root = opendir($student_dir);
					$pdf_file = sprintf("%s_No_%d.pdf",$student_name, $No);
					$zip_file = sprintf("%s_No_%d.zip", $student_name, $No);
					//echo $no_string."<br>";

					while ($homework_name = readdir($student_root)) {
						# code...
						//echo $homework_name."<br>";

						if ($homework_name != "." 
							&& $homework_name != ".." 
							&& ($homework_name == $pdf_file || $homework_name == $zip_file )    ) {
							# code...
							copy($student_dir."/".$homework_name, $dest_no_dir."/".$homework_name);

							//break;
						}
					}
					closedir($student_root);



				}
			}
		}
		closedir($homework_root);


		}
		$save_file = $dest_root_dir."/".$No.".tar.bz2";
		$to_save_relative_dir = "No".$No;
		$last_line = exec("cd $dest_root_dir; tar -jcv -f $save_file $to_save_relative_dir", $retval);
		return $save_file;
	}
	return "#";
}


function Signin($Default_skip = "Welcome.php")
{
	$url = $URL."/SubmissionSystem/".$Default_skip;
	header("Location: $url");
}

function Signout()
{
	$url = $URL."/submission.php";
	header("Location: $url");
}

function Byte2MB($num)
{
	return sprintf("%.2f", $num / 1024 / 1024);
}



?>

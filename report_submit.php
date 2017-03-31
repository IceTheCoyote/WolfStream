<?php
	$c = mysql_connect("localhost", "user", "password");
	
	$username = mysql_escape_string(stripslashes($_POST['strmreport_username']));
	$reason = mysql_escape_string(stripslashes($_POST['strmreport_reason']));
	
	if (strpos($username, '<?php') !== false || strpos($username, '?>') !== false || strpos($reason, '<?php') !== false || strpos($reason, '?>') !== false) {
		die("Do not use PHP under your username report/reason report as it will cause a break into the system! This message is to prevent you from exploiting the system with php. <a href='report.php'>Return back to reporting.</a>");
	}
	
	$getstreamkey = "SELECT * FROM `wolfstream`.`accounts` WHERE `stream_name` = '$username'";
	$e2 = mysql_query($getstreamkey, $c);
	
	if($row = mysql_fetch_array($e2)) {
		$stream_key = "{$row['stream_key']}";
		$stream_name = " {$row['stream_name']}";
	}
	
	$reportsubmit = "INSERT INTO `wolfstream`.`reports`(`username`,`reason`, `datetime`) VALUES('$username - Stream Key [$stream_key]', '$reason', NOW())";
	$e = mysql_query($reportsubmit, $c);
	
	//if(!$e) {
	//	die(mysql_error());
	//}
	
	mysql_close($c);
	die("You have successfully submitted your report! Your report will be sent directly to an admin. <a href='index.php'>Return safe.</a> To make sure you are safe and aren't watching anything extreme we advise you to go to another stream or on your own stream.");
?>
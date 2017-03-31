<?php
	session_start();
	
	$StreamIdentity = $_SESSION['StreamName'];
	$StreamKey = $_SESSION['StreamKey'];
	$StreamGame = $_SESSION['StreamGame'];
	
	$c = mysql_connect("localhost", "user", "password");
	
	$bancheck = "SELECT * FROM `wolfstream`.`accounts` WHERE `stream_name` = '$StreamIdentity'";
	$e = mysql_query($bancheck, $c);
	
	while($row = mysql_fetch_array($e)) {
		$banned = (int) "{$row['banned']}";
		$banreason = "{$row['banreason']}";
	}
	
	$enablePicture = mysql_escape_string(stripslashes($_POST['strmenable_picture']));
	
	if($enablePicture == 'yes') {
		$changepicturestatus = "UPDATE `wolfstream`.`accounts` SET `enablePicture` = 1 WHERE `stream_name` = '$StreamIdentity'";
		$e2 = mysql_query($changepicturestatus,$c);
		if(!$e2) {
			die(mysql_error());
		}
		
		mysql_close($c);
		header("Location: editstream.php");
	}else{
		$changepicturestatus = "UPDATE `wolfstream`.`accounts` SET `enablePicture` = 0 WHERE `stream_name` = '$StreamIdentity'";
		$e2 = mysql_query($changepicturestatus,$c);
		if(!$e2) {
			die(mysql_error());
		}
		
		mysql_close($c);
		header("Location: editstream.php");
	}
?>
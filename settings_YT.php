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
	
	$enableYT = mysql_escape_string(stripslashes($_POST['strmenable_YT']));
	$changeYT = mysql_escape_string(stripslashes($_POST['strmYT']));
	
	if($enableYT == 'yes') {
		$changeytstatus = "UPDATE `wolfstream`.`accounts` SET `enableYT` = 1 WHERE `stream_name` = '$StreamIdentity'";
		$e2 = mysql_query($changeytstatus,$c);
		if(!$e2) {
			die(mysql_error());
		}
		
		mysql_close($c);
		header("Location: editstream.php");
	}elseif($enableYT == 'no') {
		$changeytstatus = "UPDATE `wolfstream`.`accounts` SET `enableYT` = 0 WHERE `stream_name` = '$StreamIdentity'";
		$e2 = mysql_query($changeytstatus,$c);
		if(!$e2) {
			die(mysql_error());
		}
		
		mysql_close($c);
		header("Location: editstream.php");
	}elseif($enableYT == 'justchange') {
		$changeYT_url = "UPDATE `wolfstream`.`accounts` SET `YouTubeMusicPlayer` = '$changeYT' WHERE `stream_name` = '$StreamIdentity'";
		$e2 = mysql_query($changeYT_url,$c);
		if(!$e2) {
			die(mysql_error());
		}
		
		mysql_close($c);
		header("Location: editstream.php");
	}
?>

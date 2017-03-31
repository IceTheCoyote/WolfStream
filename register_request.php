<?php
	$c = mysql_connect("localhost", "user", "password");
	
	$user_name = mysql_escape_string(stripslashes($_POST['usrbox']));
	$pass_word = mysql_escape_string(stripslashes(hash('sha512', $_POST['pswbox'])));
	
	$collectusers = "SELECT * FROM `wolfstream`.`accounts`";
	$e = mysql_query($collectusers, $c);
	
	while($row = mysql_fetch_array($e)) {
		$usr = "{$row['username']}";
		$psw = "{$row['password']}";
		
		if($user_name == $usr) {
			die("Account already exists. <a href='index.php'>Return to wolf stream's homepage</a>");
		}
	}
	
	/**
		This part will generate our folders, stream name and stream key.
	**/
	$stream_name = "Member_".rand(1,9999999);
	$stream_key = hash('sha512', rand(1,9999999));
	
	mkdir('E:\RTMP_SERVER\www\/'.$stream_name);//Change this directory to your RTMP www server.
	mkdir('E:\RTMP_SERVER\www\/'.$stream_name.'\/'.$stream_key);//Change this directory to your RTMP www server.
	
	$register_user = "INSERT INTO `wolfstream`.`accounts`(`username`,`password`,`stream_name`,`stream_key`,`stream_game`,`banned`) VALUES('$user_name','$pass_word', '$stream_name', '$stream_key', 'null', 0)";
	$e2 = mysql_query($register_user, $c);
	
	session_start();
	$_SESSION['StreamName'] = $stream_name;
	$_SESSION['StreamKey'] = $stream_key;
	$_SESSION['StreamGame'] = 'null';
	mysql_close($c);
	header("Location: index.php");
?>
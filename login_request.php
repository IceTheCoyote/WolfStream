<?php
	$c = mysql_connect("localhost", "user", "password");
	
	$user_name = mysql_escape_string(stripslashes($_POST['usrbox']));
	$pass_word = mysql_escape_string(stripslashes(hash('sha512', $_POST['pswbox'])));
	
	$getusers = "SELECT * FROM `wolfstream`.`accounts`";
	$e = mysql_query($getusers, $c);
	
	while($row = mysql_fetch_array($e)) {
		$usr = "{$row['username']}";
		$psw = "{$row['password']}";
		$strmname = "{$row['stream_name']}";
		$strmkey = "{$row['stream_key']}";
		$strmgame = "{$row['stream_game']}";
		$banned = (int) "{$row['banned']}";
		$banreason = "{$row['banreason']}";
		
		if($user_name == $usr && $pass_word == $psw) {
			if($banned == '1') {
				session_unset();
				session_destroy();
				
				die("Your account was suspended for $banreason. If your account was banned wrongly then please <a href='mailto:gamewolf10@gmail.com'>contact me</a> to make a ban appeal. <a href='index.php'>Click</a> to go back into wolf stream's index page.");
			}
			session_start();
			$_SESSION['StreamName'] = $strmname;
			$_SESSION['StreamKey'] = $strmkey;
			$_SESSION['StreamGame'] = $strmgame;
			
			mysql_close($c);
			header("Location: index.php");
		}
	}
	echo "Either incorrect username/password or account doesn't exists? <a href='index.php'>Return to wolf stream homepage</a>";
mysql_close($c);
?>
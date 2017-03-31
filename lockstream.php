<?php
function deleteAll($directory, $empty = false) { 
    if(substr($directory,-1) == "/") { 
        $directory = substr($directory,0,-1); 
    } 

    if(!file_exists($directory) || !is_dir($directory)) { 
        return false; 
    } elseif(!is_readable($directory)) { 
        return false; 
    } else { 
        $directoryHandle = opendir($directory); 
        
        while ($contents = readdir($directoryHandle)) { 
            if($contents != '.' && $contents != '..') { 
                $path = $directory . "/" . $contents; 
                
                if(is_dir($path)) { 
                    deleteAll($path); 
                } else { 
                    unlink($path); 
                } 
            } 
        } 
        
        closedir($directoryHandle); 

        if($empty == false) { 
            if(!rmdir($directory)) { 
                return false; 
            } 
        } 
        
        return true; 
    } 
}

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
	
	$lock = mysql_escape_string(stripslashes($_POST['strmlock']));
	
	if($lock == 'yes') {
		$updateLock = "UPDATE `wolfstream`.`accounts` SET `isLocked` = 1 WHERE `stream_name` = '$StreamIdentity'";
		$e2 = mysql_query($updateLock, $c);
		if(!$e2){
			die(mysql_error());
		}
		
		deleteAll("E:\RTMP_SERVER\www\/".$StreamIdentity."\/".$StreamKey);
		deleteAll("E:\RTMP_SERVER\www\/".$StreamIdentity);
		die("Successfully locked your stream. <a href='editstream.php'>Click</a> to go back to editing.");
	}else{
		if($banned == 1) {
			die("Your account was suspended! Reasons why your account was banned $banreason.");
		}
		$updateLock = "UPDATE `wolfstream`.`accounts` SET `isLocked` = 1 WHERE `stream_name` = '$StreamIdentity'";
		$e2 = mysql_query($updateLock, $c);
		if(!$e2){
			die(mysql_error());
		}
		
		mkdir("E:\RTMP_SERVER\www\/".$StreamIdentity."\/".$StreamKey);
		mkdir("E:\RTMP_SERVER\www\/".$StreamIdentity);
		die("Successfully unlocked your stream. (WARNING: If someone has your stream key lock and change your stream key before unlocking.) <a href='editstream.php'>Click</a> to go back to editing,");
	}
	mysql_close($c);
?>

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

function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    if($path !== false AND is_dir($path))
    {
        // Return canonicalized absolute pathname
        die("Folder already exists! <a href='editstream.php'>Edit again with different name.</a>");
    }

    // Path/folder does not exist
    return $path;
}

session_start();
	
$StreamIdentity = $_SESSION['StreamName'];
$StreamKey = $_SESSION['StreamKey'];
$StreamGame = $_SESSION['StreamGame'];
$_SESSION['Password_PlainText'] = mysql_escape_string(stripslashes($_POST['strmpass']));

$StreamID = mysql_escape_string(stripslashes($_POST['strmname']));
$StreamGM = mysql_escape_string(stripslashes($_POST['strmgame']));
$StreamPSW = mysql_escape_string(stripslashes(hash('sha512', $_POST['strmpass'])));
$StreamPURL = mysql_escape_string(stripslashes($_POST['strmpurl']));
$StreamURL = mysql_escape_string(stripslashes($_POST['strmurl']));
$StreamDESC = mysql_escape_string(stripslashes($_POST['strmdesc']));
$StreamChange = mysql_escape_string(stripslashes($_POST['strmchange']));

if (strpos($StreamID, '<?php') !== false || strpos($StreamID, '?>') !== false || strpos($StreamGM, '<?php') !== false || strpos($StreamGM, '?>') !== false || strpos($StreamPSW, '<?php') !== false || strpos($StreamPSW, '?>') !== false || strpos($StreamPURL, '<?php') !== false || strpos($StreamPURL, '?>') !== false ||strpos($StreamURL, '<?php') !== false || strpos($StreamURL, '?>') !== false || strpos($StreamDESC, '<?php') !== false || strpos($StreamDESC, '?>') !== false) {
    die("Do not use PHP under your username/game/password/description/url as it will cause a break into the system! This message is to prevent you from exploiting the system with php. <a href='editstream.php'>Return back editing.</a>");
}

$c = mysql_connect("localhost", "user", "password");

$checkban = "SELECT * FROM `wolfstream`.`accounts` WHERE `stream_name` = '$StreamIdentity'";
$banforce = mysql_query($checkban, $c);
if($row = mysql_fetch_array($banforce)) {
	$banned = (int) "{$row['banned']}";
	$banreason = "{$row['banreason']}";
	$isLOCKED = (int) "{$row['isLocked']}";
	
	if($banned == 1) {
		session_unset();
		session_destroy();
		die("Your account was suspended for $banreason. If your account was banned wrongly then please <a href='mailto:gamewolf10@gmail.com'>contact me</a> to make a ban appeal.");
	}
	
	if($banreason == "stream_e.stream_key_taken_away") {
		die("Your stream key was taken away. If your account stream key was taken wrongly then please <a href='mailto:gamewolf10@gmail.com'>contact me</a> to make a stream key appeal. State your reasons why you want your stream key back.");
	}
}

if($StreamID == "") {
	if($StreamChange == "yes") {
		$RandomKeyChange = hash('sha512', rand(1,9999999));
		$editchange = "UPDATE `wolfstream`.`accounts` SET `stream_key` = '$RandomKeyChange' WHERE `stream_name` = '$StreamID'";
		$e = mysql_query($editchange, $c);
		deleteAll('E:\RTMP_SERVER\www\/'.$StreamID.'\/'.$StreamKey);//Change this directory to your RTMP www server.
		if($isLOCKED == 0) {
			mkdir('E:\RTMP_SERVER\www\/'.$StreamID.'\/'.$RandomKeyChange);//Change this directory to your RTMP www server.
		}
		$_SESSION['StreamKey'] = $RandomKeyChange;
		mysql_close($c);
		header("Location: editstream.php");
	}
	else
	{
		$editchange = "UPDATE `wolfstream`.`accounts` SET `stream_game` = '$StreamGM', `stream_pass` = '$StreamPSW', `background_pg` = '$StreamURL', `profile_picture` = '$StreamPURL', `description` = '$StreamDESC' WHERE `stream_name` = '$StreamIdentity'";
		$e = mysql_query($editchange, $c);
	}
	
	$_SESSION['StreamKey'] = $StreamKey;
	$_SESSION['StreamGame'] = $StreamGM;

	mysql_close($c);
	header("Location: editstream.php");
}else{
	if($StreamChange == "yes") {
		$RandomKeyChange = hash('sha512', rand(1,9999999));
		$editchange = "UPDATE `wolfstream`.`accounts` SET `stream_key` = '$RandomKeyChange' WHERE `stream_name` = '$StreamID'";
		$e = mysql_query($editchange, $c);
		deleteAll('E:\RTMP_SERVER\www\/'.$StreamID.'\/'.$StreamKey);//Change this directory to your RTMP www server.
		if($isLOCKED == 0) {
			mkdir('E:\RTMP_SERVER\www\/'.$StreamID.'\/'.$RandomKeyChange);//Change this directory to your RTMP www server.
		}
		mkdir('E:\RTMP_SERVER\www\/'.$StreamID.'\/'.$RandomKeyChange);//Change this directory to your RTMP www server.
		$_SESSION['StreamKey'] = $RandomKeyChange;
		mysql_close($c);
		header("Location: editstream.php");
	}
	else
	{
		$editchange = "UPDATE `wolfstream`.`accounts` SET `stream_name` = '$StreamID', `stream_game` = '$StreamGM', `stream_pass` = '$StreamPSW', `background_pg` = '$StreamURL', `profile_picture` = '$StreamPURL', `description` = '$StreamDESC' WHERE `stream_name` = '$StreamIdentity'";
		$e = mysql_query($editchange, $c);
	}
	
	folder_exist('E:\RTMP_SERVER\www\/'.$StreamID);//Change this directory to your RTMP www server.

	deleteAll('E:\RTMP_SERVER\www\/'.$StreamIdentity);//Change this directory to your RTMP www server.

	mkdir('E:\RTMP_SERVER\www\/'.$StreamID);//Change this directory to your RTMP www server.
	mkdir('E:\RTMP_SERVER\www\/'.$StreamID.'\/'.$StreamKey);//Change this directory to your RTMP www server.
	
	$_SESSION['StreamName'] = $StreamID;
	$_SESSION['StreamKey'] = $StreamKey;
	$_SESSION['StreamGame'] = $StreamGM;

	mysql_close($c);
	header("Location: editstream.php");
}
?>

<?php
function deleteDirectory($dir) { 
        if (!file_exists($dir)) { return true; }
        if (!is_dir($dir) || is_link($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) { 
            if ($item == '.' || $item == '..') { continue; }
            if (!deleteDirectory($dir . "/" . $item, false)) { 
                chmod($dir . "/" . $item, 0777); 
                if (!deleteDirectory($dir . "/" . $item, false)) return false; 
            }; 
        } 
        return rmdir($dir); 
    }

	$c = mysql_connect('localhost', 'user', 'password');	
	$admin_username = "admin";
	$admin_password = "password";
	$showStream = false;
	
	session_start();
	
	if(isset($_POST['login'])) {
		$usr = $_POST['user'];
		$psw = $_POST['pass'];
		
		if($usr == $admin_username && $psw == $admin_password) {
			$_SESSION['admin_login'] = "Logged in";
		}else{
			die("ERROR: CAN'T ACCESS THE ADMIN PANEL. INCORRECT USERNAME/PASSWORD.");
		}
	}
	if(isset($_POST['execute'])) {
		$command = $_POST['command_line'];
		$user = $_POST['target_usr'];
		$streamkey = $_POST['streamkey_targ'];
		$reason = $_POST['reasons'];
		
		if($command == 'ban') {
			$ex_ban = "UPDATE `wolfstream`.`accounts` SET `banned` = 1, `banreason` = '$reason' WHERE `stream_name` = '$user'";
			$e = mysql_query($ex_ban, $c);
			deleteDirectory('E:\RTMP_SERVER\www\/'.$user);//Change this directory to your RTMP www server.
			
			mysql_close($c);
			die("Successfully banned $user and destroyed the stream key. <a href='admin.php'>Return back to the admin panel.</a>");
		}
		
		if($command == 'unban') {
			$ex_unban = "UPDATE `wolfstream`.`accounts` SET `banned` = 0, `banreason` = '' WHERE `stream_name` = '$user'";
			$e = mysql_query($ex_unban, $c);
			
			$getinfo = "SELECT * FROM `wolfstream`.`accounts` WHERE `stream_name` = '$user'";
			$e2 = mysql_query($getinfo, $c);
			
			if($row = mysql_fetch_array($e2)) {
				$Stream_Name = "{$row['stream_name']}";
				$Stream_Key = "{$row['stream_key']}";
			}
			
			mkdir('E:\RTMP_SERVER\www\/'.$Stream_Name);//Change this directory to your RTMP www server.
			mkdir('E:\RTMP_SERVER\www\/'.$Stream_Name.'\/'.$Stream_Key);//Change this directory to your RTMP www server.
			
			mysql_close($c);
			die("Successfully unbanned $user and brought the stream key back. <a href='admin.php'>Return back to the admin panel.</a>");
		}
		
		if($command == 'take_stream_key') {
			deleteDirectory('E:\RTMP_SERVER\www\/'.$user.'\/'.$streamkey);//Change this directory to your RTMP www server.
			
			$updatereason = "UPDATE `wolfstream`.`accounts` SET `banreason` = 'stream_e.stream_key_taken_away' WHERE `stream_name` = '$user'";
			$e = mysql_query($updatereason, $c);
			
			mysql_close($c);
			die("Successfully taken stream $user key away. <a href='admin.php'>Return back to the admin panel.</a>");
		}
		
		if($command == 'giveback_stream_key') {
			$getmuchinfo = "SELECT * FROM `wolfstream`.`accounts` WHERE `stream_name` = '$user'";
			$e = mysql_query($getmuchinfo, $c);
			if($row = mysql_fetch_array($e)) {
				$streamname = "{$row['stream_name']}";
				$streamkey = "{$row['stream_key']}";
			}
			
			$updatereason = "UPDATE `wolfstream`.`accounts` SET `banreason` = '' WHERE `stream_name` = '$streamname'";
			$e2 = mysql_query($updatereason, $c);
			
			mkdir('E:\RTMP_SERVER\www\/'.$streamname.'\/'.$streamkey);//Change this directory to your RTMP www server.
			mysql_close($c);
			die("Successfully given stream key to $streamname. <a href='admin.php'>Return back to the admin panel.</a>");
		}
		if($command == 'show_stream') {
			$getid = "SELECT * FROM `wolfstream`.`accounts` WHERE `stream_name` = '$user'";
			$e=mysql_query($getid, $c);
			
			while($row = mysql_fetch_array($e)) {
				$strmname = "{$row['stream_name']}";
				$strmkey = "{$row['stream_key']}";
			}
			$showStream = true;
			mysql_close($c);
		}
	}
?>
<html>
 <head>
  <title>Admin Page</title>
 </head>
 <body>
  <?php
	if(!$_SESSION['admin_login']) {
		echo "<form action = '' method = 'POST'>Admin Username: <input type='text' name='user' /><br/>Admin Password: <input type='password' name='pass' /><br/><input type='submit' name='login' value='Login to admin panel.' /></form>";
		mysql_close($c);
	}else{
		if(isset($_GET['deleted'])) {
			$log_id = $_GET['logid'];
			
			$del = "DELETE FROM `wolfstream`.`reports` WHERE `id` = $log_id";
			$e = mysql_query($del, $c);
		}
		
		echo "<form action = '' method = 'POST'>COMMAND OPTIONS<br/>ban - (streamer's name on bottom input box)<br/>show_stream - (Streamer's name on the target box. This will allow you to break into streams that are private.)<br/>take_stream_key (streamer's name on bottom input box)<br/>giveback_stream_key (streamer's name on bottom input box)<br/>ip_ban (IP ADDRESS OF THE PERSON [Comming soon on summer])<br/>unban - (Unban's the streamer and gives them access to their stream key.)<br/>
		<br/>
		Command: <input type='text' name='command_line' value='type the command displayed on the help text.' /><br/>
		Target: <input type='text' name='target_usr' value='user goes here' /><br/>
		Stream Key Target: <input type='text' name='streamkey_targ' value='stream key goes here' /><br/>
		Reason: <input type='text' name='reasons' value='type your reason here' /><br/>
		<input type='submit' name='execute' value='Execute command.' />
		</form><br/><table border='1' style='background-color: gray;'>
		<tr>
		 <td>Streamer's Username Reported</td><td>Reported For</td><td>Date and Time</td><td>ID</td><td>Delete</a>
		</tr>";
		
		$getinfo_reports = "SELECT * FROM `wolfstream`.`reports`";
		$lreports = mysql_query($getinfo_reports, $c);
	
		while($row = mysql_fetch_array($lreports)) {
			$username = "{$row['username']}";
			$reason = "{$row['reason']}";
			$datetime = "{$row['datetime']}";
			$id = (int) "{$row['id']}";
			$rDetection = $username;
			
			echo "<tr><td>$username</td><td>$reason</td><td>$datetime<td>$id</td><td><a href='admin.php?logid=$id&deleted=yes'>Delete</a></td></tr>";
		}
		if($rDetection == '') {
			echo "<tr><td>---</td><td>---</td><td>---</td><td>---</td></tr>";
		}
		echo "</table><br/><p><b>Warning: </b>Once you delete a report it cannot be recovered. However this is sometimes good because we will need space in order to save up space.</p><br/>";
		mysql_close($c);
		
		if($showStream == 1) {
			echo '<object width="560" height="400"> <param name="movie" value="http://hosting-marketers.com/strobe/StrobeMediaPlayback.swf"></param><param name="flashvars" value="streamType=Live&autoPlay=false&scaleMode=letterbox&loop=true&backgroundColor=000000&optimizeBuffering=true&initialBufferTime=0.1&expandedBufferTime=10&minContinuousPlaybackTime=30&src=rtmp://server.twsicommunity.com/'.$strmname.'/'.$strmkey.'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://hosting-marketers.com/strobe/StrobeMediaPlayback.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"  width="560" height="400" flashvars="streamType=Live&autoPlay=false&scaleMode=letterbox&loop=true&backgroundColor=000000&optimizeBuffering=true&initialBufferTime=0.1&expandedBufferTime=10&minContinuousPlaybackTime=30&src=rtmp://server.twsicommunity.com/'.$strmname.'/'.$strmkey.'"></embed></object>';
		}
	}
  ?>
 </body>
</html>
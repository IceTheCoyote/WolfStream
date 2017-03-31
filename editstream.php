<?php
/**
function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}
**/

	session_start();
	
	$StreamIdentity = $_SESSION['StreamName'];
	$StreamKey = $_SESSION['StreamKey'];
	$StreamGame = $_SESSION['StreamGame'];
	$StreamPass = $_SESSION['Password_PlainText'];
	
	$c = mysql_connect("localhost", "user", "password");
	
	$getinfo = "SELECT * FROM `wolfstream`.`accounts` WHERE `stream_name` = '$StreamIdentity'";
	$e = mysql_query($getinfo, $c);
	
	if($row = mysql_fetch_array($e)) {
		$background = "{$row['background_pg']}";
		$desc = "{$row['description']}";
		$prof = "{$row['profile_picture']}";
	}
	mysql_close($c);
?>
<html>
 <head>
  <title>Wolf Stream Online RTMP Service</title>
 </head>
 <body>
  <center><b>Welcome streamers to your own stream.</b><br/>
  <table border = '1' style = 'background-color: gray;'>
   <tr>
	<td><a href='index.php'><img src='img/button_home.png' /></a></td>
    <td><?php if($StreamIdentity == ""){ echo "<a href='login.php'>Login</a>"; }else{echo "Welcome, $StreamIdentity";} ?></td>
	<td><?php if($StreamIdentity == ""){ echo "<a href='register.php'>Register</a>"; }else{echo "Already Registered. <a href='logout.php'>Logout</a>";} ?></td>
	<td><?php if($StreamIdentity == ""){ echo "---"; }else{echo "<a href='editstream.php'>Edit your stream account</a>";} ?></td>
	<td><a href='tos.php'>Terms of Service</a></td>
	<td><a href='privacy.php'>Privacy of Policy</a></td>
	<td><a href='searchstream.php'>Search for a streamer</a></td>
	<td><a href='howto.php'>How to stream in this service</a></td>
	<td><a href='report.php'>Report a streamer</a></td>
   </tr>
  </table></center><br/>
  <p><b>Stream Name: </b><?php echo $StreamIdentity; ?><br/>
  <b>Stream Key: </b><?php echo $StreamKey; ?><br/>
  <b>Game Currently Streaming: </b><?php echo $StreamGame; ?><br/>
  <form action='editstream_request.php' method='POST'>
  Stream Name (Leave blank to not change it.): <input type='text' name='strmname' value='<?php echo $StreamIdentity; ?>' />
  <br/>
  Stream Game: <input type='text' name='strmgame' value='<?php echo $StreamGame; ?>' />
  <br/>
  Stream Password: <input type='text' name='strmpass' value='<?php echo $StreamPass; ?>' />
  <br/>
  Stream Profile Picture: <input type='text' name='strmpurl' value='<?php echo $prof; ?>' />
  <br/>
  Stream URL Background: <input type='text' name='strmurl' value='<?php echo $background; ?>' />
  <br/>
  Stream Description: <br/>
  <textarea name='strmdesc' rows='20' cols='80'><?php echo $desc; ?></textarea>
  <br/><b>Change stream key? (Yes to change your stream key or click no to keep the changes.)</b><br/>
  <input type="radio" name="strmchange" value="yes"> Yes<br/>
  <input type="radio" name="strmchange" value="no"> No<br/>
  <input type='submit' name='submitstreamchange' value='Change Stream' /><br/>
  </form>
  <form action='lockstream.php' method='POST'>
   <p><b>Locking your stream</b> is a good way to prevent others from streaming on your channel since they will need the stream key.</p>
   <input type="radio" name="strmlock" value="yes"> Yes, Lock my stream so no unwanted streamers can stream.<br/>
   <input type="radio" name="strmlock" value="no"> Allow my stream to be streamed. (Only do this when you are streaming.)<br/>
   <input type="submit" name="lockstream" value="Change lock status" />
  </form>
  <form action='settings_picture.php' method='POST'>
   <p><b>Enabling your stream's photo</b> will enable your profile picture to be shown on your stream video. If you have a image on your stream then you can disable this. (it doesn't actually go into your flash video but just stays there until you disable it.)</p>
   <input type="radio" name="strmenable_picture" value="yes"> Yes, show my profile picture on my stream video.<br/>
   <input type="radio" name="strmenable_picture" value="no"> No, do not show my profile picture on my stream video.<br/>
   <input type="submit" name="changepicturesettings" value="Change profile picture status" />
  </form>
  <b>WARNING: Do not show anyone your stream key at all! Anyone can stream onto your account and abuse it. This is your stream and only you can have access to.</b>
 </body>
</html>
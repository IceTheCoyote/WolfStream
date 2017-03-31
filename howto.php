<?php
	session_start();
	
	$StreamIdentity = $_SESSION['StreamName'];
	// $StreamKey = $_SESSION['StreamKey'];
	// $StreamGame = $_SESSION['StreamGame'];
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
  <p><b>Step 1. </b>Open any broadcasting software such as XSplit, OBS or any other.<br/>
  <b>Step 2. </b><br/>On OBS Goto File > Settings > Stream and set the Stream type to custom rtmp. Set the RTMP URL to rtmp://server.twsicommunity.com:1935/(Your stream name). Then enter the stream key which is located under the "Edit your stream account" link. Copy and paste it under the Stream Key box. Then click apply and start stream.<br/><br/>
  On XSplit goto Outputs > Set up a new output > Custom RTMP and follow the configuration below<br/><br/>
  Name: (Any name you like the stream to be)<br/>
  Description: (Describe your channel to be)<br/>
  RTMP URL: rtmp://server.twsicommunity.com:1935/(Your stream name)<br/>
  Stream Name: (Your stream key goes in the box)<br/>
  Share Link (Optional): http://server.twsicommunity.com/WolfStream/watchstream.php?streamid=(Your account id)<br/>
  User Agent: I'd peferr using XSplit as my user agent but what ever works for you.<br/>
  Then click OK and and click on Outputs > Your custom RTMP you just set up. Your stream should be available for watchers to see (Unless it requires a password.)<br/><br/>
  <b>That is all for now.</b></p>
 </body>
</html>
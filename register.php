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
  </table><br/>
  <form action = 'register_request.php' method = 'POST'>
   Username: <input type='text' name='usrbox' /><br/>
   Password: <input type='password' name='pswbox' /><br>
   <input type='submit' value='Register Account' name='register' /></center>
 </body>
</html>
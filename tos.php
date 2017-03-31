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
  </center>
  <b>STREAMING RULES</b><br/>
  <ul>
   <li>Do not stream adult content. Doing so will result in your account either being suspended or deleted.</li>
   <li>Do not threaten other streamers on this service.</li>
   <li>Do not ban evade your bans.</li>
   <li>Do not promote drugs or any alcohol, streaming is all about streaming your popular games and not about drinking alcohol or use of drugs.</li>
   <li>Do not show nudity which also includes not wearing a shirt or pants. If you are wearing clothes that is fine.</li>
   <li>Do not stream movies that were ripped or used on another website source. If the stream is private and requires a password then streaming a movie is possible as the watcher will have to enter the password in order to watch.</li>
   <li>Do not stream any graphical gore. Doing so will have your account banned (Which also involves the stream key being taken away until the account is unsuspended).</li>
  </ul>
  <b>ACCOUNT RULES</b><br/>
  <ul>
   <li>Account usernames must not contain any swearing, using slurs or making fun of a user then the username will be automatically changed which cannot be changed unless requested by you.</li>
   <li>Accounts must be kept secure and do not share your password with anyone including tech support.</li>
   <li>Account profiles (Not implemented yet) must not contain any adult content or any gore.</li>
  </ul>
  <br/><b>Updated Rules for Private Streaming!</b><br/>
  <ul>
   <li>Streams must have a password and a good one in order to keep their streams out of the public incase of [Adult content and movie streaming]. There is a reason why to this.</li>
   <li>The streamer who don't have a password set on their stream will get reported for breaking the above rules.</li>
   <li>Yes we all know this.... Child pornography and killing someone is against the law but come on we all need to follow the laws around here. Child pornography and Graphical Gore [Such as killing someone where a viewer can see.] is not allowed even in private stream! So don't do it. (Admins can see what your privately streaming. So my warning to you is don't do it obviously. It is a crime to kill someone.)</li>
   <li>Rape porn is not allowed obviously. Those kinds of things need to stay out of the streaming area. Even in a private stream.</li>
  </ul>
  <br/>
  <p><b style="color: red;">Warning! </b>If you break any of these rules you will be held responsible. Any such laws broken will lead you to court and your account suspended. Rules such as using drugs, streaming movies in public and threatening someone will not lead you to court but rather a stream key taken away or suspended from the live stream.</p>
 </body>
</html>
<?php
	session_start();
	
	$StreamIdentity = $_SESSION['StreamName'];
	$StreamKey = $_SESSION['StreamKey'];
	$StreamGame = $_SESSION['StreamGame'];
?>
<html>
 <head>
  <title>Wolf Stream Online RTMP Service</title>
 </head>
 <body>
 <body onload='restrainIllegalOperation()' oncontextmenu="return false">
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
  </table><center/>
  <br/>
  <form action = '' method = 'POST'>
   Search for a streamer: <input type='text' name='search_streamname' value='Search a member by stream name.' /><input type='submit' name='searching' value='Search member' />
  </form>
  <br/>
<?php
	if(isset($_POST['searching'])) {
		$c = mysql_connect('localhost', 'user', 'password');
		
		$search_index = mysql_escape_string(stripslashes($_POST['search_streamname']));
		if($search_index == "") {
			die("Please type a key word you are searching for...");
		}
		
		$startsearch = "SELECT * FROM `wolfstream`.`accounts` WHERE stream_name LIKE '%$search_index%'";
		$e = mysql_query($startsearch, $c);
		
		if(!$e) {
			die("Failed: ".mysql_error());
		}
		
		while($row = mysql_fetch_array($e)) {
			$banned = (int) "{$row['banned']}";
			$banreason = "{$row['banreason']}";
			
			if($banned == 0) {
				echo "<a href='watchstream.php?streamid={$row['id']}'>{$row['stream_name']}</a> - Game Currently Streaming: {$row['stream_game']}<br/><br/>";
			}else{
				echo "<a href='watchstream.php?streamid={$row['id']}'>{$row['stream_name']} (Currently Banned)</a> - (Banned for $banreason)<br/><br/>";
			}
		}
		
		mysql_close($c);
	}
?>
 </body>
</html>
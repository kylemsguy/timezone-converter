<?php
date_default_timezone_set('Etc/UTC');
$time = "Error!";
if(isset($_GET['time']) && isset($_GET['offset'])) {
  $time = strtotime($_GET['time']) + intval($_GET['offset']) * 3600;
}
if(gettype($time) == "integer"){
	$prevdate = new DateTime();
	$prevdate->setTimestamp($time - intval($_GET['offset']) * 3600);
	$prevtime = $prevdate->format('g:ia');
	$prevoffset = $_GET['offset'];
} else {
	$prevtime = "12:00pm";
	$prevoffset = "0";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Time Zone Converter!</title>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/converttime.js"></script>
<link rel="stylesheet" href="css/main.css">
</head>
<body>
<noscript>
<div class="nojs">
	If you see this, you have Javascript disabled. You can still use this site to generate links for other people to
	use, but in order to convert others' events to your local time, you need to enable Javascript.
</div>
</noscript>
<div id="container">
	<!--<div id="header"></div>-->
	<div id="body">
		<div id="timeblock">
		Your current time is <div id="currtime" class="time"></div><br>
		The time of the event in UTC is <div id="eventtime" class="time"></div><br>
		The time of the event in your local time is <div id="localeventtime" class="time"></div>
		</div>
		<input id="timestamp" type="hidden" value="<?=$time?>">
		<!-- TODO: make a version for if person has disabled javascript -->
		<!--<form id="nojssubmit" action="converttime.php" method="GET">
		<input type="text" name="sourcetime value=""-->

		<br>
		<br>
		<br>
	</div>

	<div id="footer">
		<form id="converttimeform" action="<?=$_SERVER['PHP_SELF'];?>" method="GET">
			Time of event: <input id="timeeventbox" type="text" name="time" value="<?=$prevtime?>"><br>
			Time zone offset from GMT: <input id="timezonebox" value="<?=$prevoffset?>" type="text" name="offset" maxlength="6"><br>
			<input type="submit" value="Submit">
		</form>

		<div id="instructions">
			If you're not sure what your time zone offset is, please refer to this link (will open in a new window): <a href="https://en.wikipedia.org/wiki/List_of_UTC_time_offsets" target="_blank">Wikipedia</a><br>
			<b>Note: if you are entering offsets of half-hours please enter the offset as a decimal. (e.g. Nepal: GMT+5:45 -> 5.75)</b>
		</div>
	</div>
</div>
</body>
</html>

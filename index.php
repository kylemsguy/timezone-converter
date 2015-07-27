<?php
date_default_timezone_set('Etc/UTC');

function offsetToHrsMins($offset) {
	$sign = "+";
	$hours = floor($offset / 3600);
	$mins = ($offset / 3600 - $hours) * 60;
	if ($mins == 0) {
		$mins = "00";
	}
	if ($offset < 0) {
		$sign = "";
	}
	return $sign . $hours . ":" . $mins;
}

$time = "Error!";
if (isset($_GET['time'])) {
	if (isset($_GET['offset'])) {
		$offset = intval($_GET['offset']) * 3600;
	} else if (isset($_GET['offset_h']) && isset($_GET['offset_m'])) {
		if ($_GET['offset_h'] < 0) {
			$offset_m = intval($_GET['offset_m']);
		} else {
			$offset_m = -intval($_GET['offset_m']);
		}

		$offset = intval((intval($_GET['offset_h']) + $offset_m / 100) * 3600);
	}
	$time = strtotime($_GET['time']) - $offset;
}
if (gettype($time) == "integer") {
	$prevdate = new DateTime();
	$prevdate->setTimestamp($time + $offset);
	$prevtime = $prevdate->format('H:i');
	$prevoffset = $offset;
} else {
	$time = 0;
	$prevtime = "00:00";
	$prevoffset = 0;
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
		Your current time is <div id="currtime" class="time"></div>
		The time of the event in the specified localtime is <div class="time"><?=$prevtime?> GMT<?php
echo (offsetToHrsMins($prevoffset));
?>
		</div>
		The time of the event in UTC is <div id="eventtime" class="time"></div>
		The time of the event in your local time is <div id="localeventtime" class="time"></div>
		</div>
		<input id="timestamp" type="hidden" value="<?=$time?>">
		<!-- TODO: make a version for if person has disabled javascript -->
		<!--<form id="nojssubmit" action="converttime.php" method="GET">
		<input type="text" name="sourcetime value=""-->

		<br>
		<br>
	</div>

	<div id="footer">
		<form id="converttimeform" action="<?=$_SERVER['PHP_SELF'];?>" method="GET">
			Time of event: <input id="timeeventbox" type="text" name="time" value="<?=$prevtime?>"><br>
			Time zone offset:
			<select name="offset_h">
				<option value="-12">GMT-12</option>
				<option value="-11">GMT-11</option>
				<option value="-10">GMT-10</option>
				<option value="-9">GMT-9</option>
				<option value="-8">GMT-8</option>
				<option value="-7">GMT-7</option>
				<option value="-6">GMT-6</option>
				<option value="-5">GMT-5</option>
				<option value="-4">GMT-4</option>
				<option value="-3">GMT-3</option>
				<option value="-2">GMT-2</option>
				<option value="-1">GMT-1</option>
				<option value="0" selected="selected">GMT+0</option>
				<option value="1">GMT+1</option>
				<option value="2">GMT+2</option>
				<option value="3">GMT+3</option>
				<option value="4">GMT+4</option>
				<option value="5">GMT+5</option>
				<option value="6">GMT+6</option>
				<option value="7">GMT+7</option>
				<option value="8">GMT+8</option>
				<option value="9">GMT+9</option>
				<option value="10">GMT+10</option>
				<option value="11">GMT+11</option>
				<option value="12">GMT+12</option>
				<option value="13">GMT+13</option>
				<option value="14">GMT+14</option>
			</select>
			:
			<select name="offset_m">
				<option value="0" selected="selected">0</option>
				<option value="25">15</option>
				<option value="50">30</option>
				<option value="75">45</option>
			</select>
			<br>
			<input type="submit" value="Submit">
		</form>

		<div id="instructions">
			If you're not sure what your time zone offset is, please refer to this link (will open in a new window): <a href="https://en.wikipedia.org/wiki/List_of_UTC_time_offsets" target="_blank">Wikipedia</a><br>
			<b>Note: if you are entering offsets of half-hours please enter the offset as a decimal. (e.g. Nepal: GMT+5:45 -> 5.75)</b><br>
			<br>
			After clicking submit, simply share the URL in the address bar of your browser to let others know when an event is in their own time zone!
		</div>
	</div>
</div>
</body>
</html>

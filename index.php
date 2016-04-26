<?php
date_default_timezone_set('Etc/UTC');

function offsetToHrsMins($offset) {
	$sign = "+";
	$hours = floor($offset / 3600);
	$mins = abs((abs($offset) / 3600 - abs($hours)) * 60);
	if ($mins == 0) {
		$mins = "00";
	}
	if ($offset < 0) {
		$sign = "";
	}
	return $sign . $hours . ":" . $mins;
}

function offsetToHrs($offset) {
	$hours = floor($offset / 3600);
	return $hours;
}

/*function offsetToMins($offset) {
$hours = abs(floor($offset / 3600));
$mins = abs(($offset / 3600 - $hours) * 60);
if ($mins == 0) {
$mins = "00";
}
return $mins;
}*/

$time = "Error!";
if (isset($_GET['time'])) {
	if (isset($_GET['offset'])) {
		$offset = intval($_GET['offset']) * 3600;
	} else if (isset($_GET['offset_h']) && isset($_GET['offset_m'])) {
		if ($_GET['offset_h'] < 0) {
			$offset_m = -intval($_GET['offset_m']);
		} else {
			$offset_m = intval($_GET['offset_m']);
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
	$time = 1438041600;
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
<div class="nojs">
	If you see this, you have Javascript disabled. You can still use this site to generate links for other people to
	use, but in order to convert others' events to your local time, you need to enable Javascript.
</div>
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
	</div>

	<div id="footer">
		<form id="converttimeform" action="<?=$_SERVER['PHP_SELF'];?>" method="GET">
			Time of event: <input id="timeeventbox" type="time" name="time" value="<?=$prevtime?>"><br>
			Time zone offset: GMT(+)
			<input type="number" name="offset_h" id="timezonebox" min="-12" max="14" maxlength="3" value="<?=offsetToHrs($prevoffset)?>">
			:
			<select name="offset_m">
				<option value="0">00</option>
				<option value="25">15</option>
				<option value="50">30</option>
				<option value="75">45</option>
			</select>
			<br>
			<input type="submit" value="Submit">
		</form>
		<br>
		<div id="instructions">
			<b>To customize the page to your own event's time, simply enter the time of the event (in your local time zone) and your local timezone offset in the respective fields.</b><br>
			If you're not sure what your time zone offset is, please refer to this link (will open in a new window): <a href="https://en.wikipedia.org/wiki/List_of_UTC_time_offsets" target="_blank">Wikipedia</a><br>
			<br>
			<!--After clicking submit, simply share the URL in the address bar of your browser to let others know when an event is in their own time zone!-->
		</div>
		<div id="share">
			To share this page, share the following link:<br>
			<input type="text" id="linkbox" value="">
		</div>
		<br>
		<center><i>If you encounter any bugs, please submit an issue to the <a href="https://github.com/kylemsguy/timezone-converter">GitHub repo</a></i></center>
	</div>
</div>
</body>
</html>


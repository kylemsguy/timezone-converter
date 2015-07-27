function formatTimeString(hours, minutes) {
    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    //if (seconds < 10) {seconds = "0"+seconds;}
    return hours + ":" + minutes;
}

function get(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
}

function toUnixTimestamp(time_str, offset) {
    var timestamp = Date.parse(time_str);
}

function showTimes(event_timestamp) {
    // get relevant strings
    var currdate = new Date();
    var eventdate = new Date(parseInt(event_timestamp) * 1000);

    var currtime_str = formatTimeString(currdate.getHours(), currdate.getMinutes());
    var eventtime_utc_str = formatTimeString(eventdate.getUTCHours(), eventdate.getUTCMinutes());
    var eventtime_str = formatTimeString(eventdate.getHours(), eventdate.getMinutes());

    console.log(currtime_str);
    console.log(eventtime_str);

    $("#currtime").text(currtime_str);
    $("#eventtime").text(eventtime_utc_str);
    $("#localeventtime").text(eventtime_str);

}

$(function(){
    // activate form
    $("#converttimeform").attr("action", window.location.pathname);
    // get parameters from url
    var event_time = get("time");
    var event_tz_offset_h = get("offset_h");
    var event_tz_offset_m = get("offset_m");

    if(!(event_time === undefined || event_tz_offset_h === undefined || event_tz_offset_m === undefined)){
        event_time = "January 1, 1970 " + event_time;
        var timestamp = Date.parse(timestamp);
        console.log(event_time);
        var timestamp_utc = timestamp - (parseInt(event_tz_offset_h) + event_tz_offset_h >= 0 ? event_tz_offset_m : -event_tz_offset_m)
        showTimes(timestamp_utc);
    } else {
        // not enough params. Tell user.
    }
    
});

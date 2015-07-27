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

function parseTime(time_str){
    var time_ary = time_str.split(':');
    console.log(time_ary);
    var int_time_ary = time_ary.map(function(currentValue, index, array){
        return parseInt(currentValue);
    });
    console.log(time_ary);
    console.log(int_time_ary);
    return int_time_ary;
}

function addOffset(time_ary, offset_ary) {
    time_ary[0] -= parseInt(offset_ary[0]);
    time_ary[1] -= parseInt(offset_ary[0]) < 0 ? -parseInt(offset_ary[1]) * (2/3) : parseInt(offset_ary[1]) * (2/3);

    if(time_ary[0] < 0){
        time_ary[0] += 24;
    } else if(time_ary[0] >= 24) {
        time_ary[0] -= 24
    }
    if(time_ary[1] < 0){
        time_ary[1] += 60;
    } else if(time_ary[1] >= 60) {
        time_ary[1] -= 60;
    }
}


function showTimes(event_ary) {
    // get relevant strings
    var currdate = new Date();
    var tz_offset = currdate.getTimezoneOffset();
    var tz_offset_ary = [Math.floor(tz_offset / 60), tz_offset % 60 *(3/2)];
    var local_event_ary = event_ary.slice(0);
    addOffset(local_event_ary, tz_offset_ary);

    var currtime_str = formatTimeString(currdate.getHours(), currdate.getMinutes());
    var eventtime_utc_str = formatTimeString(event_ary[0], event_ary[1]);
    var eventtime_str = formatTimeString(local_event_ary[0], local_event_ary[1]);

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

    $("#origtime").text(event_time + " GMT+" + event_tz_offset_h + ":" + (parseInt(event_tz_offset_m) * (2/3)));

    if(!(event_time === undefined || event_tz_offset_h === undefined || event_tz_offset_m === undefined)){
        var event_time_ary = parseTime(event_time);
        var offset_ary = [parseInt(event_tz_offset_h), parseInt(event_tz_offset_m)];
        addOffset(event_time_ary, offset_ary);
        showTimes(event_time_ary);

    } else {
        // not enough params. Tell user.
    }
    /*event_time = "January 1, 1970 " + event_time;
        var timestamp = Date.parse(timestamp);
        console.log(event_time);
        var timestamp_utc = timestamp - (parseInt(event_tz_offset_h) + event_tz_offset_h >= 0 ? event_tz_offset_m : -event_tz_offset_m)
        showTimes(timestamp_utc);*/
    
});


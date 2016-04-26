function formatTimeString(hours, minutes) {
    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    //if (seconds < 10) {seconds = "0"+seconds;}
    return hours + ":" + minutes;
}

$(function(){
    // Hide all nojs tags
    $('.nojs').hide();
    // get relevant strings
    var currdate = new Date();
    var eventdate = new Date(parseInt($("#timestamp").attr("value")) * 1000);

    var currtime_str = formatTimeString(currdate.getHours(), currdate.getMinutes());
    var eventtime_utc_str = formatTimeString(eventdate.getUTCHours(), eventdate.getUTCMinutes());
    var eventtime_str = formatTimeString(eventdate.getHours(), eventdate.getMinutes());

    console.log(currtime_str);
    console.log(eventtime_str);

    $("#currtime").text(currtime_str);
    $("#eventtime").text(eventtime_utc_str);
    $("#localeventtime").text(eventtime_str);
    $("#linkbox").attr("value", window.location.href);
});


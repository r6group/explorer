var now = new Date();
var baseYahooURL = 'https://query.yahooapis.com/v1/public/yql?format=json&rnd='+now.getFullYear()+now.getMonth()+now.getDay()+now.getHours()+'&diagnostics=true&callback=?&q=';
var selectedCity = "Bangkok, TH";
var placeholder = "";
var unit = "c"
init();

function init(){

    getLocation();


    //$('#city').keypress(function() {
    //    if ( event.which == 13 ) {
    //        selectedCity =  $('#city').val();
    //        getWoeid(selectedCity);
    //        $('#city').blur();
    //    }
    //});
    //
    //$('#btn').click(function() {
    //    if($('#btn').html() == "F")
    //    {
    //        unit = "c";
    //    }
    //    else unit = "f";
    //    $('#btn').html(unit.toUpperCase());
    //    getWoeid(selectedCity);
    //})
    //
    //$('#city').focus(function(event) {
    //    placeholder = $("#city").val();
    //    $("#city").val("");
    //});
    //
    //$('#city').blur(function(event) {
    //    if($("#city").val() == "")
    //    {
    //        $("#city").val(placeholder);
    //    }
    //});
}

//var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {

        if (navigator.geolocation.getCurrentPosition(showPosition, errorCallback,
                {timeout:6000}) == false) {

            getWeatherInfo(selectedCity);
        }



    } else {

        getWeatherInfo(selectedCity);
    }


}
function showPosition(position) {

    selectedCity =  position.coords.latitude + "," + position.coords.longitude;
    getWeatherInfo(selectedCity);
}

function errorCallback(error) {
    getWeatherInfo(selectedCity);
}

function getWoeid(city){
    var woeidYQL = 'select woeid from geo.placefinder where text="'+ city +'"&format=json';
    var jsonURL = baseYahooURL + woeidYQL;
    $.getJSON(jsonURL, woeidDownloaded);
}

function woeidDownloaded(data){
    var woeid = null;
    if(data.query.count <= 0)
    {
        $('#city').val("No city found");
        $('#deg').html("");
        setImage(999, $("#big")[0]);
        for(var i = 0; i <= 3;i++)
        {
            $('#forecast'+i).html("");
            setImage(999, $("#forecastimg" + i)[0]);
            $('#forecastdeg' + i).html("");
        }
        return;
    }
    else if(data.query.count == 1){
        woeid = data.query.results.Result.woeid;
    }
    else
    {
        woeid = data.query.results.Result[0].woeid;
    }
    getWeatherInfo(woeid);
}

function getWeatherInfo(selectedCity){
    var weatherYQL = 'select * from weather.forecast where woeid in (select woeid from geo.placefinder where text="'+ selectedCity +'" and gflags="R" limit 1) and u="'+unit+'"';//'select * from weather.forecast where woeid=' + woeid + ' and u = "'+unit+'" &format=json';


    var jsonURL = baseYahooURL + weatherYQL;
    $.getJSON(jsonURL, weaterInfoDownloaded);
}

function weaterInfoDownloaded(data){
    var textMapping = {
        0: "ทอร์นาโด",
        1: "พายุโซนร้อน",
        2: "พายุเฮอริเคน",
        3: "พายุฝนฟ้าคะนองรุนแรง",
        4: "พายุฟ้าคะนอง",
        5: "มีฝนปนหิมะ",
        6: "มีฝนปนลูกเห็บ",
        7: "มีหิมะปนลูกเห็บ",
        8: "ละอองฝนและอากาศหนาว",
        9: "ฝนตกปรอยๆ",
        10: "ฝนตก อากาศหนาวเย็น",
        11: "ฝนเป็นบางแห่ง",
        12: "ฝนซู่ หรือ ฝนไล่ช้าง",
        13: "ละอองหิมะ",
        14: "หิมะตกเบาๆ",
        15: "หิมะ",
        16: "หิมะ",
        17: "ลูกเห็บตก",
        18: "ฝนลูกเห็บ",
        19: "ฝุ่นละออง",
        20: "มีหมอก",
        21: "หมอกควัน",
        22: "ควัน",
        23: "ลมกระโชกแรง",
        24: "ลมแรง",
        25: "หนาวเย็น",
        26: "มีเมฆมาก",
        27: "มีเมฆเป็นส่วนมาก",// (กลางคืน)
        28: "มีเมฆเป็นส่วนมาก", // (กลางวัน)
        29: "มีเมฆบางส่วน",// (กลางคืน)
        30: "มีเมฆบางส่วน",// (กลางวัน)
        31: "ท้องฟ้าปลอดโปร่ง",// (กลางคืน)
        32: "มีแดดมาก",
        33: "ท้องฟ้าแจ่มใส",// (กลางคืน)
        34: "ท้องฟ้าแจ่มใส",// (กลางวัน)
        35: "ฝนปนลูกเห็บ",
        36: "อากาศร้อน",
        37: "มีฝนพายุฝนฟ้าคะนอง",
        38: "พายุฝนฟ้าคะนองกระจาย",
        39: "พายุฝนฟ้าคะนองกระจาย",
        40: "ฝนตกโปรยปรายเป็นหย่อมๆ",
        41: "หิมะตกหนัก",
        42: "หิมะตกประปราย",
        43: "หิมะตกหนัก",
        44: "เมฆบางส่วน",
        45: "ฝนฟ้าคะนอง",
        46: "หิมะตก",
        47: "ฝนฟ้าคะนอง",
        3200: "Not available"};

    var dayMapping = {
        'Sun': "อา.",
        'Mon': "จ.",
        'Tue': "อ.",
        'Wed': "พ.",
        'Thu': "พฤ.",
        'Fri': "ศ.",
        'Sat': "ส.",
    }
    //$('#city').val(data.query.results.channel.location.city);
    $('#deg').html(data.query.results.channel.item.condition.temp + "°" + unit.toUpperCase());
    $('#wind').html(data.query.results.channel.wind.speed);
    $('#speed-unit').html(data.query.results.channel.units.speed);
    $('#condition-text').html(textMapping[data.query.results.channel.item.condition.code]);
    $('#description').html(data.query.results.channel.location.city);

    $('#head-deg').html(data.query.results.channel.item.condition.temp + "°" + unit.toUpperCase());
    $('#head-condition-text').html(textMapping[data.query.results.channel.item.condition.code]);
    $('#city').html(data.query.results.channel.location.city);

    setImage(data.query.results.channel.item.condition.code, $('#big')[0]);
    for(var i = 0; i <= 3;i++)
    {
        var fc = data.query.results.channel.item.forecast[i];
        $('#forecast'+i).html(dayMapping[fc.day]);
        setImage(fc.code, $("#forecastimg" + i)[0]);
        $('#forecastdeg' + i).html((parseInt(fc.low) + parseInt(fc.high)) / 2 + " °" + unit.toUpperCase());
    }
}

function setImage(code, image){



    var iconname = code.toString();
    if (code == 999) {
        iconname = 'na';
    } //else if(code < 10) { iconname = "0" + code.toString()};

    image.src = "http://team.sko.moph.go.th/work/images/weather/white/" + iconname + ".png";


}


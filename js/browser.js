function getOs()
{
    var OsObject = "";
    if(navigator.userAgent.indexOf("MSIE")>0) {
        OsObject = "MSIE";
    } else if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){
        OsObject = "Firefox";
    } else if(isMozilla=navigator.userAgent.indexOf("Opera")>0){ //这个也被判断为chrome
        OsObject = "Opera";
    } else if(isFirefox=navigator.userAgent.indexOf("Chrome")>0){
        OsObject = "Chrome";
    } else if(isSafari=navigator.userAgent.indexOf("Safari")>0) {
        OsObject = "Safari";
    } else if(isCamino=navigator.userAgent.indexOf("Camino")>0){
        OsObject = "Camino";
    } else if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){
        OsObject = "Gecko";
    }
    if ("MSIE" == OsObject) {
        var msg = "您的浏览器是ie内核，不支持本网站部分功能，推荐使用Chrome，Firefox，\n或者双核浏览器中的极速内核.\n\n" +
              "以360安全浏览器为例，如何切换浏览器内核\n" +
              "点击确认前往教程." +
              "点击取消留在本页面";
        if ( true == confirm(msg) ) {
            location.href = 'help.html';
        }
    }
}

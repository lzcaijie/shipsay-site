function setCookies(cookieName, cookieValue, minutes) {
    let today = new Date();
    let expire = new Date();
    let exp = minutes * 1000 * 60 || 1000 * 3600 * 24 * 365;
    expire.setTime(today.getTime() + exp);
    document.cookie = cookieName + '=' + escape(cookieValue) + ';expires=' + expire.toGMTString() + '; path=/'
}

function readCookies(cookieName) {
    let theCookie = '' + document.cookie;
    let ind = theCookie.indexOf(cookieName);
    if (ind == -1 || cookieName === '') return '';
    let ind1 = theCookie.indexOf(';', ind);
    if (ind1 == -1) ind1 = theCookie.length;
    let rico_ret = theCookie.substring(ind + cookieName.length + 1, ind1).replace(/%/g, '%25');
    return unescape(decodeURI(rico_ret))
}

//cookie处理
var Cookie = {
    get: function (n) {
        var dc = '; ' + document.cookie + '; ';
        var coo = dc.indexOf('; ' + n + '=');
        if (coo != -1) {
            var s = dc.substring(coo + n.length + 3, dc.length);
            return unescape(s.substring(0, s.indexOf('; ')));
        } else {
            return null;
        }
    }
};
//根据Cookie获取用户登录信息
var jieqiUserInfo = {
    jieqiUserId: 0,
    jieqiUserName: '',
    jieqiUserPassword: '',
    jieqiUserToken: '',
    jieqiUserGroup: 0,
    jieqiNewMessage: 0,
    jieqiCodeLogin: 0,
    jieqiCodePost: 0
};
if (document.cookie.indexOf('jieqiUserInfo') >= 0) {
    var cinfo = Cookie.get('jieqiUserInfo');
    start = 0;
    offset = cinfo.indexOf(',', start);
    while (offset > 0) {
        tmpval = cinfo.substring(start, offset);
        tmpidx = tmpval.indexOf('=');
        if (tmpidx > 0) {
            tmpname = tmpval.substring(0, tmpidx);
            tmpval = tmpval.substring(tmpidx + 1, tmpval.length);
            if (jieqiUserInfo.hasOwnProperty(tmpname)) jieqiUserInfo[tmpname] = tmpval;
        }
        start = offset + 1;
        if (offset < cinfo.length) {
            offset = cinfo.indexOf(',', start);
            if (offset == -1) offset = cinfo.length;
        } else {
            offset = -1;
        }
    }
}

if (document.getElementById('header-login')) {
    $("#header-login").html('');
}


function ReadKeyEvent() {
    var index_page = $("#linkIndex").attr("href");
    var prev_page = $("#linkPrev").attr("href");
    var next_page = $("#linkNext").attr("href");

    function jumpPage() {
        var event = document.all ? window.event : arguments[0];
        if (event.keyCode == 37) document.location = prev_page;
        if (event.keyCode == 39) document.location = next_page;
        if (event.keyCode == 13) document.location = index_page
    }

    document.onkeydown = jumpPage
}

function is_mobile() {
    var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
    var u = navigator.userAgent;
    if (null === u) {
        return true
    }
    var result = regex_match.exec(u);
    if (null === result) {
        return false
    } else {
        return true
    }
}

function go_page(url) {
    window.location.href = url;
    $(this).href = url;
    return false
}

$("#back-to-top").css({right: 10, bottom: "10%"});
var isie6 = window.XMLHttpRequest ? false : true;

function newtoponload() {
    var c = $("#back-to-top");

    function b() {
        var a = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
        if (a > 100) {
            if (isie6) {
                c.hide();
                clearTimeout(window.show);
                window.show = setTimeout(function () {
                    var d = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
                    if (d > 0) {
                        c.fadeIn(100)
                    }
                }, 300)
            } else {
                c.fadeIn(100)
            }
        } else {
            c.fadeOut(100)
        }
    }

    if (isie6) {
        c.style.position = "absolute"
    }
    window.onscroll = b;
    b()
}

function nav_sel(type){
    var csstext = "background: #5E8E9E;";
    if(type == "nav_index"){
        document.getElementById("nav_index").style.cssText = "background-color:#2e6da4;";
    }
    if(type == "nav_sort"){
        document.getElementById("nav_sort").style.cssText = "background-color:#2e6da4;";
    }
    if(type == "nav_top"){
        document.getElementById("nav_top").style.cssText = "background-color:#2e6da4;";
    }
    if(type == "nav_full"){
        document.getElementById("nav_full").style.cssText = "background-color:#2e6da4;";
    }
    if(type == "nav_his"){
        document.getElementById("nav_his").style.cssText = "background-color:#2e6da4;";
    }
    if(type == "sort1"){
        document.getElementById("sort1").style.cssText = "color: red; font-weight: 700;";
    }
    if(type == "sort2"){
        document.getElementById("sort2").style.cssText = "color: red; font-weight: 700;";
    }
    if(type == "sort3"){
        document.getElementById("sort3").style.cssText = "color: red; font-weight: 700;";
    }
    if(type == "sort4"){
        document.getElementById("sort4").style.cssText = "color: red; font-weight: 700;";
    }
    if(type == "sort5"){
        document.getElementById("sort5").style.cssText = "color: red; font-weight: 700;";
    }
    if(type == "sort6"){
        document.getElementById("sort6").style.cssText = "color: red; font-weight: 700;";
    }
    if(type == "sort7"){
        document.getElementById("sort7").style.cssText = "color: red; font-weight: 700;";
    }
    if(type == "sort8"){
        document.getElementById("sort8").style.cssText = "color: red; font-weight: 700;";
    }
}

if (window.attachEvent) {
    window.attachEvent("onload", newtoponload)
} else {
    window.addEventListener("load", newtoponload, false)
}
document.getElementById("back-to-top").onclick = function () {
    window.scrollTo(0, 0)
}

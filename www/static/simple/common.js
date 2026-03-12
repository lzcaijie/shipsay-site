action = window.location.pathname;

function login() {
    var html = [];
    if (window.SS_RANK_ENTRY_URL) {
        html.push("<a href='" + window.SS_RANK_ENTRY_URL + "' title='排行榜'>排行榜</a>");
    }
    if (window.SS_RECENTREAD_URL) {
        html.push("<a href='" + window.SS_RECENTREAD_URL + "' title='阅读记录' rel='nofollow'>阅读记录</a>");
    }
    if (html.length) {
        document.writeln(html.join(" | "));
    }
}

// ie7以下的浏览器提示
var isIE = !!window.ActiveXObject;
var isIE6 = isIE && !window.XMLHttpRequest;
var isIE8 = isIE && !!document.documentMode;
var isIE7 = isIE && !isIE6 && !isIE8;
function tip_ie7() {
    if (isIE && (isIE6 || isIE7 || isIE8)) {
        document.writeln("<div class=\"tip-browser-upgrade\">");
        document.writeln("    你正在使用IE低级浏览器，如果你想有更好的阅读体验，<br />强烈建议您立即 <a class=\"blue\" href=\"http://windows.microsoft.com/zh-cn/internet-explorer/download-ie\" target=\"_blank\" rel=\"nofollow\">升级IE浏览器</a> 或者用更快更安全的 <a class=\"blue\" href=\"https://www.google.com/intl/zh-CN/chrome/browser/?hl=zh-CN\" target=\"_blank\" rel=\"nofollow\">谷歌浏览器Chrome</a> 。");
        document.writeln("</div>");
    }
}

//阅读页键盘操作事件
function ReadKeyEvent() {
    var index_page = $("#linkIndex").attr("href");
    var prev_page =  $("#linkPrev").attr("href");
    var next_page = $("#linkNext").attr("href");
    function jumpPage() {
        var event = document.all ? window.event : arguments[0];
        if (event.keyCode == 37) document.location = prev_page;
        if (event.keyCode == 39) document.location = next_page;
        if (event.keyCode == 13) document.location = index_page;
    }
    document.onkeydown = jumpPage;
}

//是否移动端
function is_mobile() {
    var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
    var u = navigator.userAgent;
    if (null == u) {
        return true;
    }
    var result = regex_match.exec(u);
    if (null == result) {
        return false;
    }
    return true;
}

//历史记录
var _num = 100;

function LastRead(){
    this.bookList = "bookList";
}
LastRead.prototype = {
    set:function(bid,tid,title,texttitle,author,sortname){
        if(!(bid&&tid&&title&&texttitle&&author&&sortname)) return;
        var v = bid + '#' + tid + '#' + title + '#' + texttitle + '#' + author + '#' + sortname;
        this.setItem(bid,v);
        this.setBook(bid);
    },
    get:function(k){
        return this.getItem(k) ? this.getItem(k).split("#") : "";
    },
    remove:function(k){
        this.removeItem(k);
        this.removeBook(k);
    },
    setBook:function(v){
        var reg = new RegExp("(^|#)" + v);
        var books = this.getItem(this.bookList);
        if (books == "") {
            books = v;
        } else if (books.search(reg) == -1) {
            books += "#" + v;
        } else {
            books = books.replace(reg, "#" + v);
        }
        this.setItem(this.bookList, books);
    },
    getBook:function(){
        var v = this.getItem(this.bookList) ? this.getItem(this.bookList).split("#") : [];
        var books = [];
        if (v.length) {
            for (var i = 0; i < v.length; i++) {
                var raw = this.getItem(v[i]);
                var tem = raw ? raw.split('#') : [];
                if (i > v.length - (_num + 1)) {
                    if (tem.length > 3) books.push(tem);
                } else if (tem.length > 0) {
                    lastread.remove(tem[0]);
                }
            }
        }
        return books;
    },
    removeBook:function(v){
        var reg = new RegExp("(^|#)" + v);
        var books = this.getItem(this.bookList);
        if (!books) {
            books = "";
        } else if (books.search(reg) != -1) {
            books = books.replace(reg, "");
        }
        this.setItem(this.bookList, books);
    },
    setItem:function(k,v){
        if (!!window.localStorage) {
            localStorage.setItem(k,v);
        } else {
            var expireDate = new Date();
            var EXPIR_MONTH = 30 * 24 * 3600 * 1000;
            expireDate.setTime(expireDate.getTime() + 12 * EXPIR_MONTH);
            document.cookie = k + "=" + encodeURIComponent(v) + ";expires=" + expireDate.toGMTString() + "; path=/";
        }
    },
    getItem:function(k){
        var value = "";
        var result = "";
        if (!!window.localStorage) {
            result = window.localStorage.getItem(k);
            value = result || "";
        } else {
            var reg = new RegExp("(^| )" + k + "=([^;]*)(;|$)");
            result = reg.exec(document.cookie);
            if (result) {
                value = decodeURIComponent(result[2]) || "";
            }
        }
        return value;
    },
    removeItem:function(k){
        if (!!window.localStorage) {
            window.localStorage.removeItem(k);
        } else {
            var expireDate = new Date();
            expireDate.setTime(expireDate.getTime() - 1000);
            document.cookie = k + "= ;expires=" + expireDate.toGMTString();
        }
    },
    removeAll:function(){
        var v = this.getItem(this.bookList) ? this.getItem(this.bookList).split("#") : [];
        if (v.length) {
            for (var i = 0; i < v.length; i++) {
                if (v[i]) {
                    this.removeItem(v[i]);
                }
            }
        }
        this.removeItem(this.bookList);
    }
};
function showbook(){
    var showbook = document.getElementById('showbook');
    if (!showbook) return;
    var bookhtml = '';
    var books = lastread.getBook().reverse();
    if (books.length) {
        for (var i = 0; i < books.length; i++) {
            bookhtml += '<div class="bookbox"><div class="p10"><span class="num">' + (i + 1) + '</span><div class="bookinfo"><h4 class="bookname"><a href="' + books[i][0] + '">' + books[i][2] + '</a></h4><div class="cat">分类：' + books[i][5] + '</div><div class="author">作者：' + books[i][4] + '</div><div class="update"><span>已读到：</span><a href="' + books[i][1] + '">' + books[i][3] + '</a></div></div><div class="delbutton"><a class="del_but" href="javascript:removebook(\'' + books[i][0] + '\')">删除</a></div></div></div>';
        }
    } else {
        bookhtml += '<div style="height:100px;line-height:100px; text-align:center">还木有任何书籍( ˙﹏˙ )</div>';
    }
    showbook.innerHTML = bookhtml;
}
function removebook(k){
    lastread.remove(k);
    showbook();
}
window.lastread = new LastRead();

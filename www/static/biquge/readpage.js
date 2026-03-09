var ReadSet = {
    bgcolor: ["#E9FAFF", "#efefef", "#ffffff"],
    bgcname: ["默认", "灰色世界", "白雪天地"],
    bgcvalue: "#E9FAFF",
    fontsize: ["14px", "18px", "22px"],
    fontsname: ["小", "中", "大"],
    fontsvalue: "18px",
    pageid: "apage",
    textid: "atext",
    contentid: "ss-reader-main",
    rtextid: "article",
    mountid: "readSetMount",
    SetBgcolor: function(color) {
        var pageNode = document.getElementById(this.pageid);
        var contentNode = document.getElementById(this.contentid);
        if (pageNode) {
            pageNode.style.backgroundColor = color;
        } else if (contentNode) {
            contentNode.style.backgroundColor = color;
        }
        if (this.bgcvalue !== color) {
            this.SetCookies("bgcolor", color);
        }
        this.bgcvalue = color;
    },
    SetFontsize: function(size) {
        var textNode = document.getElementById(this.rtextid);
        if (!textNode) {
            return;
        }
        textNode.style.fontSize = size;
        if (this.fontsvalue !== size) {
            this.SetCookies("fontsize", size);
        }
        this.fontsvalue = size;
    },
    LoadCSS: function() {
        var style = "";
        style += ".readSet{padding:6px 0 2px;clear:both;line-height:20px;text-align:center;margin:auto;}\n";
        style += ".readSet .rc{color:#333333;padding-left:14px;}\n";
        style += ".readSet a.ra{border:1px solid #cccccc;display:inline-block;width:16px;height:16px;margin-left:6px;overflow:hidden;vertical-align:middle;}\n";
        style += ".readSet .rt{padding:0 5px;}\n";
        if (document.createStyleSheet) {
            var legacySheet = document.createStyleSheet();
            legacySheet.cssText = style;
        } else {
            var sheet = document.createElement("style");
            sheet.type = "text/css";
            sheet.innerHTML = style;
            document.getElementsByTagName("head")[0].appendChild(sheet);
        }
    },
    Render: function() {
        var mountNode = document.getElementById(this.mountid);
        if (!mountNode) {
            return;
        }
        var output = '';
        output += '<div class="readSet">';
        output += '<span class="rc">背景色：</span>';
        for (var i = 0; i < this.bgcolor.length; i++) {
            output += '<a style="background-color:' + this.bgcolor[i] + '" class="ra" title="' + this.bgcname[i] + '" onclick="ReadSet.SetBgcolor(\'' + this.bgcolor[i] + '\')" href="javascript:;"></a>';
        }
        output += '<span class="rc">字体：</span><span class="rf">[';
        for (var j = 0; j < this.fontsize.length; j++) {
            output += '<a class="rt" onclick="ReadSet.SetFontsize(\'' + this.fontsize[j] + '\')" href="javascript:;">' + this.fontsname[j] + '</a>';
        }
        output += ']</span>';
        output += '<div style="font-size:0;clear:both;"></div></div>';
        mountNode.innerHTML = output;
    },
    SetCookies: function(cookieName, cookieValue) {
        var today = new Date();
        var expire = new Date();
        expire.setTime(today.getTime() + 3600000 * 356 * 24);
        document.cookie = cookieName + '=' + escape(cookieValue) + ';expires=' + expire.toGMTString() + '; path=/';
    },
    ReadCookies: function(cookieName) {
        var theCookie = '' + document.cookie;
        var ind = theCookie.indexOf(cookieName);
        if (ind === -1 || cookieName === '') return '';
        var ind1 = theCookie.indexOf(';', ind);
        if (ind1 === -1) ind1 = theCookie.length;
        return unescape(theCookie.substring(ind + cookieName.length + 1, ind1));
    },
    LoadSet: function() {
        var tmpstr = this.ReadCookies("bgcolor");
        if (tmpstr !== "") this.bgcvalue = tmpstr;
        this.SetBgcolor(this.bgcvalue);
        tmpstr = this.ReadCookies("fontsize");
        if (tmpstr !== "") this.fontsvalue = tmpstr;
        this.SetFontsize(this.fontsvalue);
    },
    Init: function() {
        this.LoadCSS();
        this.Render();
        this.LoadSet();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        ReadSet.Init();
    });
} else {
    ReadSet.Init();
}

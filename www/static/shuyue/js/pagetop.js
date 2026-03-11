var ReadSet = {
    bgcolor: ["#eeeeee", "#cddfcd", "#cfdde1", "#ebcece", "#ffffff", "#ede7da"],
    bgcname: ["默认灰", "护眼绿", "海水蓝", "胭脂粉", "冷淡白", "纸张黄"],
    bgcvalue: "#eeeeee",
    fontcolor: ["#111111", "#111111", "#111111", "#111111", "#111111", "#111111"],
    fontcname: ["1", "2", "3", "4", "5", "6"],
    fontcvalue: "#111111",
    fontsize: ["18px", "20px", "22px"],
    fontsname: ["小", "中", "大"],
    fontsvalue: "20px",
    pageid: "apage",
    textid: "rtext",
    SetBgcolor: function (color) {
        document.getElementById(this.pageid).style.backgroundColor = color;
        if (this.bgcvalue != color) setCookies("bgcolor", color);
        this.bgcvalue = color
    },
    SetFontcolor: function (fcolor) {
        document.getElementById(this.textid).style.color = fcolor;
        if (this.fontcvalue != fcolor) setCookies("fontcolor", fcolor);
        this.fontcvalue = fcolor
    },
    SetFontsize: function (size) {
        document.getElementById(this.textid).style.fontSize = size;
        if (this.fontsvalue != size) setCookies("fontsize", size);
        this.fontsvalue = size
    },
    Show: function () {
        var output;
        output = '<div class="readSet">';
        for (i = 0; i < this.bgcolor.length; i++) {
            output += '<a style="background-color: ' + this.bgcolor[i] + '" class="ra" title="' + this.bgcname[i] + '" onclick="ReadSet.SetBgcolor(\'' + this.bgcolor[i] + '\');ReadSet.SetFontcolor(\'' + this.fontcolor[i] + '\')" href="javascript:;"></a>'
        }
        output += '<span class="rf">';
        for (i = 0; i < this.fontsize.length; i++) {
            output += '<a class="rt" onclick="ReadSet.SetFontsize(\'' + this.fontsize[i] + '\')" href="javascript:;">' + this.fontsname[i] + '</a>'
        }
        output += '</span>';
        output += '<div style="font-size:0px;clear:both;"></div></div>';
        if (is_mobile()) {
            document.getElementById("mReadSet").innerHTML = output
        } else {
            document.getElementById("ReadSet").innerHTML = output
        }
    },
    SaveSet: function () {
        setCookies("bgcolor", this.bgcvalue);
        setCookies("fontcolor", this.fontcvalue);
        setCookies("fontsize", this.fontsvalue)
    },
    LoadSet: function () {
        tmpstr = readCookies("bgcolor");
        if (tmpstr !== "") this.bgcvalue = tmpstr;
        this.SetBgcolor(this.bgcvalue);
        tmpstr = readCookies("fontcolor");
        if (tmpstr !== "") this.fontcvalue = tmpstr;
        this.SetFontcolor(this.fontcvalue);
        tmpstr = readCookies("fontsize");
        if (tmpstr !== "") this.fontsvalue = tmpstr;
        this.SetFontsize(this.fontsvalue)
    }
};
ReadSet.Show();

function LoadReadSet() {
    ReadSet.LoadSet()
}

if (window.attachEvent) {
    window.attachEvent('onload', LoadReadSet)
} else {
    window.addEventListener('load', LoadReadSet, false)
}

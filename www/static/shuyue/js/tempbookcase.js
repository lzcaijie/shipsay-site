let bookmax = 30;

function LastRead() {
    this.bookList = "bookList"
}

LastRead.prototype = {
    set: function (bid, url, bookname, chaptername, author, readtime, cover) {
        if (!(bid && url && bookname && chaptername && author && readtime)) return;
        var v = bid + '#' + url + '#' + bookname + '#' + chaptername + '#' + author + '#' + readtime + '#' + cover;
        var aBooks = lastread.getBook();
        var aBid = [];
        for (i = 0; i < aBooks.length; i++) {
            aBid.push(aBooks[i][0])
        }
        if ($.inArray(bid, aBid) != -1) {
            lastread.remove(bid)
        } else {
            while (aBooks.length >= bookmax) {
                lastread.remove(aBooks[0][0]);
                aBooks = lastread.getBook()
            }
        }
        this.setItem(bid, v);
        this.setBook(bid)
    }, get: function (k) {
        return this.getItem(k) ? this.getItem(k).split("#") : ""
    }, remove: function (k) {
        this.removeItem(k);
        this.removeBook(k)
    }, setBook: function (v) {
        var reg = new RegExp("(^|#)" + v);
        var books = this.getItem(this.bookList);
        if (books === "") {
            books = v
        } else {
            if (books.search(reg) === -1) {
                books += "#" + v
            } else {
                books.replace(reg, "#" + v)
            }
        }
        this.setItem(this.bookList, books)
    }, getBook: function () {
        var v = this.getItem(this.bookList) ? this.getItem(this.bookList).split("#") : Array();
        var books = Array();
        if (v.length) {
            for (var i = 0; i < v.length; i++) {
                var tem = this.getItem(v[i]).split('#');
                if (tem.length > 3) books.push(tem)
            }
        }
        return books
    }, removeBook: function (v) {
        var reg = new RegExp("(^|#)" + v);
        var books = this.getItem(this.bookList);
        if (!books) {
            books = ""
        } else {
            if (books.search(reg) != -1) {
                books = books.replace(reg, "")
            }
        }
        this.setItem(this.bookList, books)
    }, setItem: function (k, v) {
        if (!!window.localStorage) {
            localStorage.setItem(k, v)
        } else {
            var expireDate = new Date();
            var EXPIR_MONTH = 30 * 24 * 3600 * 1000;
            expireDate.setTime(expireDate.getTime() + 12 * EXPIR_MONTH);
            document.cookie = k + "=" + encodeURIComponent(v) + ";expires=" + expireDate.toGMTString() + "; path=/"
        }
    }, getItem: function (k) {
        var value = "";
        var result = "";
        if (!!window.localStorage) {
            result = window.localStorage.getItem(k);
            value = result || ""
        } else {
            reg = new RegExp("(^| )" + k + "=([^;]*)(;|\x24)");
            result = reg.exec(document.cookie);
            if (result) {
                value = decodeURIComponent(result[2]) || ""
            }
        }
        return value
    }, removeItem: function (k) {
        if (!!window.localStorage) {
            window.localStorage.removeItem(k)
        } else {
            var expireDate = new Date();
            expireDate.setTime(expireDate.getTime() - 1000);
            document.cookie = k + "= " + ";expires=" + expireDate.toGMTString()
        }
    }, removeAll: function () {
        var v = this.getItem(this.bookList) ? this.getItem(this.bookList).split("#") : Array();
        if (!!window.localStorage) {
            if (v.length) {
                for (var i = 0; i < v.length; i++) {
                    if (v[i]) window.localStorage.removeItem(v[i]);
                }
            }
            window.localStorage.removeItem(this.bookList)
        } else {
            if (v.length) {
                for (var i = 0; i < v.length; i++) {
                    if (v[i]) this.removeItem(v[i]);
                }
            }
            this.removeItem(this.bookList)
        }
    }
};

function removebook(k) {
    layer.confirm('确定要从阅读记录删除本书吗？', {btn: ['删除', '取消']}, function (index) {
        lastread.remove(k);
        layer.close(index);
        window.location.reload();
    }, function (index) {
        layer.close(index);
    });
}

function removeall() {
    layer.confirm('确定要清空阅读记录吗？', {btn: ['清空', '取消']}, function (index) {
        lastread.removeAll();
        layer.close(index);
        window.location.reload();
    }, function (index) {
        layer.close(index);
    });
}

function showtempbooks() {
    var books = lastread.getBook().reverse();
    let bookhtml = '<tr><th class="hidden-xs">时间</th><th>书名</th><th>阅读到</th><th class="hidden-xs">作者</th><th style="width:50px;">删除</th></tr>';
    if (books.length) {
        for (var i = 0; i < books.length; i++) {
            if (i < bookmax) {
                bookhtml += '<tr><td class="hidden-xs">' + books[i][5] + '</td><td><a href="' + books[i][0] + '">' + books[i][2] + '</a></td><td><a href="' + books[i][1] + '">' + books[i][3] + '</a></td><td class="hidden-xs">' + books[i][4] + '</td><td class="delbutton"><a class="del_but" href="javascript:removebook(\'' + books[i][0] + '\')">删除</a></td></tr>'
            }
        }
        $("#tempBookcase").html(bookhtml)
    }
}

window.lastread = new LastRead();

let bookmax = 20;

function LastRead() {
  this.bookList = "bookList";
}

LastRead.prototype = {
  set: function (bid, url, bookname, chaptername, author, readtime) {
    if (!(bid && url && bookname && chaptername && author && readtime)) return;
    var v = bid + "#" + url + "#" + bookname + "#" + chaptername + "#" + author + "#" + readtime;

    var aBooks = lastread.getBook();
    var aBid = [];
    for (var i = 0; i < aBooks.length; i++) aBid.push(aBooks[i][0]);

    if ($.inArray(bid, aBid) != -1) {
      lastread.remove(bid);
    } else {
      while (aBooks.length >= bookmax) {
        lastread.remove(aBooks[0][0]);
        aBooks = lastread.getBook();
      }
    }
    this.setItem(bid, v);
    this.setBook(bid);
  },
  get: function (k) {
    return this.getItem(k) ? this.getItem(k).split("#") : "";
  },
  remove: function (k) {
    this.removeItem(k);
    this.removeBook(k);
  },
  setBook: function (v) {
    var reg = new RegExp("(^|#)" + v);
    var books = this.getBook();
    if (!reg.test(books)) books.push(v);
    this.setItem(this.bookList, books.join("#"));
  },
  getBook: function () {
    var bookList = this.getItem(this.bookList);
    return bookList ? bookList.split("#").map(this.get, this) : [];
  },
  removeBook: function (v) {
    var books = this.getBook();
    for (var i = 0; i < books.length; i++) {
      if (books[i][0] == v) {
        books.splice(i, 1);
        i--;
      }
    }
    var str = [];
    for (var j = 0; j < books.length; j++) str.push(books[j][0]);
    this.setItem(this.bookList, str.join("#"));
  },
  setItem: function (k, v) {
    localStorage.setItem(k, v);
  },
  getItem: function (k) {
    return localStorage.getItem(k);
  },
  removeItem: function (k) {
    localStorage.removeItem(k);
  }
};

function fmtReadTime(t) {
  if (t === undefined || t === null) return "";
  t = String(t).trim();
  if (!t || t === "undefined") return "";
  if (/^https?:\/\//i.test(t)) return "";
  if (/^\d{10,13}$/.test(t)) {
    var n = parseInt(t, 10);
    if (t.length === 13) n = Math.floor(n / 1000);
    var d = new Date(n * 1000);
    if (!isNaN(d.getTime())) {
      var m = String(d.getMonth() + 1).padStart(2, "0");
      var day = String(d.getDate()).padStart(2, "0");
      return m + "-" + day;
    }
    return "";
  }
  if (/^\d{4}-\d{2}-\d{2}/.test(t)) {
    var dt = new Date(t.replace(/-/g, "/"));
    if (!isNaN(dt.getTime())) {
      var m2 = String(dt.getMonth() + 1).padStart(2, "0");
      var d2 = String(dt.getDate()).padStart(2, "0");
      return m2 + "-" + d2;
    }
  }
  if (/^\d{2}-\d{2}$/.test(t)) return t;
  if (t.length > 20) return "";
  return t;
}

function removebook(bookid) {
  lastread.remove(bookid);
  showtempbooks();
}

function showtempbooks() {
  var books = lastread.getBook().reverse();
  var bookhtml = "";
  if (books.length) {
    for (var i = 0; i < books.length; i++) {
      if (i < bookmax) {
        var rt = fmtReadTime(books[i][5]);
        bookhtml += '<div class="recentread-main"><a href="' + books[i][1] + '">';
        bookhtml += "<span>" + (i + 1) + "</span>";
        bookhtml += "<span>" + (books[i][2] || "") + "</span>";
        bookhtml += "<span>" + (books[i][3] || "") + "</span>";
        bookhtml += "<span>" + (books[i][4] || "") + "</span>";
        bookhtml += "<span>" + rt + "</span>";
        bookhtml += "</a>";
        bookhtml += '<a href="javascript:removebook(\'' + books[i][0] + '\')" onclick="return confirm(\'确定要将本书移除吗？\')">移除</a></div>';
      }
    }
  } else {
    bookhtml += "<span>没有阅读记录。</span>";
  }
  $("#tempBookcase").html(bookhtml);
}

window.lastread = new LastRead();

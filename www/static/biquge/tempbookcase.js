let bookmax = 20;

function LastRead() {
  this.bookList = "bookList";
}

LastRead.prototype = {
  set: function (bid, url, bookname, chaptername, author, readtime) {
    if (!(bid && url && bookname && chaptername && author && readtime)) return;
    var v = bid + "#" + url + "#" + bookname + "#" + chaptername + "#" + author + "#" + readtime;

    var aBooks = this.getBook();
    var aBid = [];
    for (var i = 0; i < aBooks.length; i++) aBid.push(aBooks[i][0]);

    if ($.inArray(String(bid), aBid) !== -1) {
      this.remove(bid);
    } else {
      while (aBooks.length >= bookmax) {
        this.remove(aBooks[0][0]);
        aBooks = this.getBook();
      }
    }
    this.setItem(bid, v);
    this.setBook(bid);
  },
  get: function (k) {
    var value = this.getItem(k);
    return value ? value.split("#") : [];
  },
  remove: function (k) {
    this.removeItem(k);
    this.removeBook(k);
  },
  setBook: function (v) {
    var ids = this.getBookIds();
    var next = [];
    v = String(v);
    for (var i = 0; i < ids.length; i++) {
      if (ids[i] && ids[i] !== v) next.push(ids[i]);
    }
    next.push(v);
    this.setItem(this.bookList, next.join("#"));
  },
  getBookIds: function () {
    var raw = this.getItem(this.bookList);
    if (!raw) return [];
    var ids = raw.split("#");
    var next = [];
    for (var i = 0; i < ids.length; i++) {
      var id = String(ids[i] || "").trim();
      if (id) next.push(id);
    }
    return next;
  },
  getBook: function () {
    var ids = this.getBookIds();
    var books = [];
    var validIds = [];
    for (var i = 0; i < ids.length; i++) {
      var tem = this.get(ids[i]);
      if (tem.length >= 4 && tem[0] && tem[1] && tem[2]) {
        books.push(tem);
        validIds.push(String(tem[0]));
      }
    }
    var normalized = validIds.join("#");
    if (normalized !== ids.join("#")) {
      this.setItem(this.bookList, normalized);
    }
    return books;
  },
  removeBook: function (v) {
    var ids = this.getBookIds();
    var next = [];
    v = String(v);
    for (var i = 0; i < ids.length; i++) {
      if (ids[i] !== v) next.push(ids[i]);
    }
    this.setItem(this.bookList, next.join("#"));
  },
  setItem: function (k, v) {
    localStorage.setItem(k, v);
  },
  getItem: function (k) {
    return localStorage.getItem(k) || "";
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

function escapeHtml(value) {
  return String(value || "")
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
}

function removebook(bookid) {
  lastread.remove(bookid);
  showtempbooks();
}

function showtempbooks() {
  var books = lastread.getBook().reverse();
  var bookhtml = "";
  var rendered = 0;
  if (books.length) {
    for (var i = 0; i < books.length; i++) {
      if (rendered >= bookmax) break;
      var item = books[i];
      if (!item || item.length < 4 || !item[0] || !item[1] || !item[2]) continue;
      var rt = fmtReadTime(item[5]);
      rendered++;
      bookhtml += '<div class="recentread-main"><a href="' + escapeHtml(item[1]) + '">';
      bookhtml += "<span>" + rendered + "</span>";
      bookhtml += "<span>" + escapeHtml(item[2]) + "</span>";
      bookhtml += "<span>" + escapeHtml(item[3] || "") + "</span>";
      bookhtml += "<span>" + escapeHtml(item[4] || "") + "</span>";
      bookhtml += "<span>" + escapeHtml(rt) + "</span>";
      bookhtml += "</a>";
      bookhtml += '<a href="javascript:removebook(\'' + escapeHtml(item[0]) + '\')" onclick="return confirm(\'确定要将本书移除吗？\')">移除</a></div>';
    }
  }
  if (!bookhtml) {
    bookhtml = '<span style="display:block;padding:12px 10px;color:#888;">没有阅读记录。</span>';
  }
  $("#tempBookcase").html(bookhtml);
}

window.lastread = new LastRead();

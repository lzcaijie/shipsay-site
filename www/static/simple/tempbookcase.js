let bookmax = 20;
function LastRead(){
  this.bookList = "bookList";
}
LastRead.prototype = {
  set:function(bid,url,bookname,chaptername,author,readtime){
    if(!(bid&&url&&bookname&&chaptername&&author&&readtime)) return;
    var v = bid + '#' + url + '#' + bookname + '#' + chaptername + '#' + author + '#' + readtime;
    var aBooks = lastread.getBook();
    var aBid = [];
    for (var i = 0; i < aBooks.length; i++) {
      aBid.push(aBooks[i][0]);
    }
    if($.inArray(bid, aBid) != -1){
      lastread.remove(bid);
    } else {
      while (aBooks.length >= bookmax) {
        lastread.remove(aBooks[0][0]);
        aBooks = lastread.getBook();
      }
    }
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
        if (tem.length > 3) books.push(tem);
      }
    }
    return books;
  },
  removeBook:function(v){
    var reg = new RegExp("(^|#)" + v);
    var books = this.getItem(this.bookList);
    if(!books){
      books = "";
    } else if(books.search(reg) != -1){
      books = books.replace(reg, "");
    }
    this.setItem(this.bookList, books);
  },
  setItem:function(k,v){
    if(!!window.localStorage){
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
    if(!!window.localStorage){
      result = window.localStorage.getItem(k);
      value = result || "";
    } else {
      var reg = new RegExp("(^| )" + k + "=([^;]*)(;|$)");
      result = reg.exec(document.cookie);
      if(result){
        value = decodeURIComponent(result[2]) || "";
      }
    }
    return value;
  },
  removeItem:function(k){
    if(!!window.localStorage){
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
function removebook(k){
  lastread.remove(k);
  showtempbooks();
}
function removeall(){
  lastread.removeAll();
  showtempbooks();
}
function showtempbooks(){
  var books = lastread.getBook().reverse();
  let bookhtml = '<p class="tc" style="padding-bottom:.625rem">阅读记录：' + books.length + ' / ' + bookmax + '&nbsp;&nbsp; <a href="javascript:removeall();" onclick="return confirm(\'确定要移除全部记录吗？\')"><i class="fa fa-trash-o"></i></a></p>';
  if (books.length){
    for(var i = 0; i < books.length; i++){
      if (i < bookmax){
        bookhtml += '<div style="position:relative"><a class="flex recent-list-a" href="' + books[i][1] + '"><div class="hot-list-div"><h4 class="book-title">' + books[i][2] + '</h4><p class="author">' + rico_lastupdate(books[i][5]) + '</p><div class="flex flex-between gray"><p class="author fs15">读至:' + books[i][3] + '</p><p class="recent-btn-continue">继续阅读></p></div></div></a><a class="recent-del-a" href="javascript:removebook(\'' + books[i][0] + '\')" onclick="return confirm(\'确定要将本书移除吗？\')"><i class="fa fa-trash-o"></i></a></div>';
      }
    }
  } else {
    bookhtml += '<span>没有阅读记录。</span>';
  }
  $("#tempBookcase").html(bookhtml);
}
window.lastread = new LastRead();

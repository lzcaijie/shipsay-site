var bookmax = 30;
function normUrl(u){ if(!u) return ''; u=String(u); if(/^https?:\/\//i.test(u)) return u; if(u.charAt(0)==='/') return u; return '/' + u; }
function safeText(t){ return (t === undefined || t === null) ? '' : String(t); }
function pickCover(arr){ var c = arr[6] || ''; c = String(c); if(!c || c==='undefined' || c==='null') return '/static/ss_wap/nocover.jpg'; return c; }
function isValidHistoryItem(arr){ return !!(arr && arr.length > 4 && arr[0] && arr[1] && arr[2] && arr[3] && arr[4]); }
function LastRead(){ this.bookList = 'bookList'; }
LastRead.prototype = {
    set: function(bid,url,bookname,chaptername,author,readtime,cover){
        if(!(bid && url && bookname && chaptername && author)) return;
        var v = bid + '#' + url + '#' + bookname + '#' + chaptername + '#' + author + '#' + (readtime || '') + '#' + (cover || '');
        var aBooks = lastread.getBook();
        var aBid = [];
        for (var i=0;i<aBooks.length;i++) aBid.push(aBooks[i][0]);
        if($.inArray(bid, aBid) !== -1){ lastread.remove(bid); }
        else { while(aBooks.length >= bookmax){ lastread.remove(aBooks[0][0]); aBooks = lastread.getBook(); } }
        this.setItem(bid, v); this.setBook(bid);
    },
    get: function(k){ return this.getItem(k) ? this.getItem(k).split('#') : ''; },
    remove: function(k){ this.removeItem(k); this.removeBook(k); },
    setBook: function(v){
        var reg = new RegExp('(^|#)' + v);
        var books = this.getItem(this.bookList);
        if (books === '') books = v;
        else {
            if (books.search(reg) === -1) books += '#' + v;
            else books = books.replace(reg, '#' + v);
        }
        this.setItem(this.bookList, books);
    },
    getBook: function(){
        var keys = this.getItem(this.bookList) ? this.getItem(this.bookList).split('#') : [];
        var books = [], validKeys = [];
        for (var i=0;i<keys.length;i++) {
            if (!keys[i]) continue;
            var item = this.getItem(keys[i]);
            if (!item) continue;
            var tem = item.split('#');
            if (!isValidHistoryItem(tem)) { this.removeItem(keys[i]); continue; }
            books.push(tem); validKeys.push(keys[i]);
        }
        this.setItem(this.bookList, validKeys.join('#'));
        return books;
    },
    removeBook: function(v){
        var reg = new RegExp('(^|#)' + v);
        var books = this.getItem(this.bookList);
        if (!books) books = '';
        else if (books.search(reg) !== -1) books = books.replace(reg, '');
        books = books.replace(/^#+|#+$/g, '').replace(/#{2,}/g, '#');
        this.setItem(this.bookList, books);
    },
    setItem: function(k,v){
        if (!!window.localStorage) localStorage.setItem(k,v);
        else {
            var expireDate = new Date();
            var EXPIR_MONTH = 30 * 24 * 3600 * 1000;
            expireDate.setTime(expireDate.getTime() + 12 * EXPIR_MONTH);
            document.cookie = k + '=' + encodeURIComponent(v) + ';expires=' + expireDate.toGMTString() + '; path=/';
        }
    },
    getItem: function(k){
        var value = '';
        if (!!window.localStorage) value = window.localStorage.getItem(k) || '';
        else {
            var reg = new RegExp('(^| )' + k + '=([^;]*)(;|$)');
            var result = reg.exec(document.cookie);
            if (result) value = decodeURIComponent(result[2]) || '';
        }
        return value;
    },
    removeItem: function(k){
        if (!!window.localStorage) window.localStorage.removeItem(k);
        else {
            var expireDate = new Date();
            expireDate.setTime(expireDate.getTime() - 1000);
            document.cookie = k + '=;expires=' + expireDate.toGMTString() + '; path=/';
        }
    },
    removeAll: function(){
        var keys = this.getItem(this.bookList) ? this.getItem(this.bookList).split('#') : [];
        for (var i=0;i<keys.length;i++) if (keys[i]) this.removeItem(keys[i]);
        this.removeItem(this.bookList);
    }
};
function removebook(k){ lastread.remove(k); showtempbooks(); }
function removeall(){ lastread.removeAll(); showtempbooks(); }
function showtempbooks(){
    var books = lastread.getBook().reverse();
    var box = document.getElementById('tempBookcase');
    if (!box) return;
    var html = '';
    if (!books.length) { box.innerHTML = '<div class="bookcase-no">没有阅读记录。</div>'; return; }
    for (var i=0;i<books.length && i<bookmax;i++) {
        var b = books[i];
        var infoUrl = normUrl(b[0]);
        var readUrl = normUrl(b[1]);
        var bookname = safeText(b[2]);
        var chaptername = safeText(b[3]);
        var author = safeText(b[4]);
        var readtime = safeText(b[5]);
        var cover = pickCover(b);
        html += '<div class="bookcase-item" id="'+ safeText(b[0]).replace(/"/g,'&quot;') +'">';
        html += '<div class="book-img"><a href="' + infoUrl + '"><img src="' + cover + '" alt="' + bookname + '" onerror="this.src=&quot;/static/ss_wap/nocover.jpg&quot;;this.onerror=null;"></a></div>';
        html += '<div class="book-info">';
        html += '<a class="booktitle" href="' + infoUrl + '">' + bookname + '</a>';
        html += '<p>作者：' + author + '</p>';
        html += '<p>已读到：<a href="' + readUrl + '">' + chaptername + '</a></p>';
        if (readtime) html += '<p>最后阅读：' + readtime + '</p>';
        html += '<p><a href="javascript:removebook(' + JSON.stringify(b[0]) + ');" class="book-del">移除记录</a></p>';
        html += '</div><div class="cc"></div></div>';
    }
    box.innerHTML = html;
}
window.lastread = new LastRead();

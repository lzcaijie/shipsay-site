var bookmax = 30;

function normUrl(u) {
    if (!u) return '';
    u = String(u);
    if (/^https?:\/\//i.test(u)) return u;
    if (u.charAt(0) === '/') return u;
    return '/' + u;
}

function safeText(t) {
    return (t === undefined || t === null) ? '' : String(t);
}

function pickCover(arr) {
    var c = arr[6] || arr[5] || '';
    c = String(c);
    if (!c || c === 'undefined' || c === 'null') return '/static/biqugewap/nocover.jpg';
    return c;
}

function isValidHistoryItem(arr) {
    return !!(arr && arr.length > 4 && arr[0] && arr[1] && arr[2] && arr[3] && arr[4]);
}

function LastRead() { this.bookList = 'bookList'; }

LastRead.prototype = {
    set: function (bid, url, bookname, chaptername, author, readtime, cover) {
        if (!(bid && url && bookname && chaptername && author)) return;

        if (typeof cover === 'undefined' && typeof readtime === 'string' && /^(https?:\/\/|\/)/i.test(readtime)) {
            cover = readtime;
            readtime = '';
        }

        var v = bid + '#' + url + '#' + bookname + '#' + chaptername + '#' + author + '#' + (readtime || '') + '#' + (cover || '');

        var aBooks = lastread.getBook();
        var aBid = [];
        for (var i = 0; i < aBooks.length; i++) aBid.push(aBooks[i][0]);

        if ($.inArray(bid, aBid) !== -1) {
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

    get: function (k) { return this.getItem(k) ? this.getItem(k).split('#') : ''; },
    remove: function (k) { this.removeItem(k); this.removeBook(k); },

    setBook: function (v) {
        var reg = new RegExp('(^|#)' + v);
        var books = this.getItem(this.bookList);
        if (books === '') books = v;
        else {
            if (books.search(reg) === -1) books += '#' + v;
            else books = books.replace(reg, '#' + v);
        }
        this.setItem(this.bookList, books);
    },

    getBook: function () {
        var keys = this.getItem(this.bookList) ? this.getItem(this.bookList).split('#') : [];
        var books = [];
        var validKeys = [];

        for (var i = 0; i < keys.length; i++) {
            if (!keys[i]) continue;
            var item = this.getItem(keys[i]);
            if (!item) continue;
            var tem = item.split('#');
            if (!isValidHistoryItem(tem)) {
                this.removeItem(keys[i]);
                continue;
            }
            books.push(tem);
            validKeys.push(keys[i]);
        }

        this.setItem(this.bookList, validKeys.join('#'));
        return books;
    },

    removeBook: function (v) {
        var reg = new RegExp('(^|#)' + v);
        var books = this.getItem(this.bookList);
        if (!books) books = '';
        else if (books.search(reg) !== -1) books = books.replace(reg, '');
        books = books.replace(/^#+|#+$/g, '').replace(/#{2,}/g, '#');
        this.setItem(this.bookList, books);
    },

    setItem: function (k, v) {
        if (!!window.localStorage) localStorage.setItem(k, v);
        else {
            var expireDate = new Date();
            var EXPIR_MONTH = 30 * 24 * 3600 * 1000;
            expireDate.setTime(expireDate.getTime() + 12 * EXPIR_MONTH);
            document.cookie = k + '=' + encodeURIComponent(v) + ';expires=' + expireDate.toGMTString() + '; path=/';
        }
    },

    getItem: function (k) {
        var value = '';
        if (!!window.localStorage) value = window.localStorage.getItem(k) || '';
        else {
            var reg = new RegExp('(^| )' + k + '=([^;]*)(;|$)');
            var result = reg.exec(document.cookie);
            if (result) value = decodeURIComponent(result[2]) || '';
        }
        return value;
    },

    removeItem: function (k) {
        if (!!window.localStorage) window.localStorage.removeItem(k);
        else {
            var expireDate = new Date();
            expireDate.setTime(expireDate.getTime() - 1000);
            document.cookie = k + '=;expires=' + expireDate.toGMTString() + '; path=/';
        }
    },

    removeAll: function () {
        var keys = this.getItem(this.bookList) ? this.getItem(this.bookList).split('#') : [];
        for (var i = 0; i < keys.length; i++) {
            if (keys[i]) this.removeItem(keys[i]);
        }
        this.removeItem(this.bookList);
    }
};

function removebook(k) { lastread.remove(k); showtempbooks(); }
function removeall() { lastread.removeAll(); showtempbooks(); }

function showtempbooks() {
    var books = lastread.getBook().reverse();
    var $box = $('#tempBookcase');
    $box.empty();

    if (!books.length) {
        $box.append($('<div class="nobook">没有阅读记录。</div>'));
        return;
    }

    for (var i = 0; i < books.length && i < bookmax; i++) {
        var b = books[i];
        var infoUrl = normUrl(b[0]);
        var readUrl = normUrl(b[1]);
        var bookname = safeText(b[2]);
        var chaptername = safeText(b[3]);
        var author = safeText(b[4]);
        var readtime = safeText(b[5]);
        var cover = pickCover(b);

        var $dl = $('<dl></dl>');
        var $coverA = $('<a></a>').addClass('cover').attr('href', infoUrl).attr('title', bookname);
        var $img = $('<img></img>').attr('src', cover).attr('alt', bookname).on('error', function () {
            this.src = '/static/biqugewap/nocover.jpg';
            this.onerror = null;
        });
        $coverA.append($img);

        var $dt = $('<dt></dt>');
        $dt.append($('<a></a>').attr('href', infoUrl).attr('title', bookname).text(bookname));

        var $dd1 = $('<dd class="history"></dd>');
        $dd1.append('已读到：');
        $dd1.append($('<a></a>').attr('href', readUrl).attr('title', chaptername).text(chaptername));

        var $dd2 = null;
        if (readtime) {
            $dd2 = $('<dd class="history"></dd>').text('最后阅读：' + readtime);
        }

        var $dd3 = $('<dd></dd>');
        $dd3.append($('<a></a>').attr('href', '/author/' + encodeURIComponent(author) + '/').attr('title', author).text(author));
        $dd3.append(
            $('<a id="del_temp">移除</a>').attr('href', '#').on('click', (function (key) {
                return function (e) {
                    e.preventDefault();
                    if (confirm('确定要将本书移除吗？')) removebook(key);
                };
            })(b[0]))
        );

        $dl.append($coverA, $dt, $dd1);
        if ($dd2) $dl.append($dd2);
        $dl.append($dd3);
        $box.append($dl);
    }
}

window.lastread = new LastRead();

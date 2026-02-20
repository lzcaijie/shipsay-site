// /www/static/youdu/js/history.js  （整文件覆盖）

var bookmax = 10;

function LastRead(){
  this.bookList="bookList";
}

LastRead.prototype={
  // 兼容两种 set：
  // 1) set(bid, chapterid, title, chaptername, author)
  // 2) set(articleid, uri, articlename, chaptername, author, lastvisit, imgurl)
  set:function(bid, arg2, bookname, chaptername, author, arg6, arg7){
    if(!(bid && arg2 && bookname && chaptername && author)) return;

    bid = (bid + '').trim();
    if(!bid) return;

    var uri = (arg2 + '').trim();
    var isUri = (uri.charAt(0) === '/' || /^https?:\/\//i.test(uri));
    if(!isUri){
      var cid = uri;
      uri = '/book/' + encodeURIComponent(bid) + '/' + encodeURIComponent(cid) + '.html?hty';
    }

    var imgurl = '';
    if(typeof arg7 !== 'undefined' && arg7 !== null){
      imgurl = (arg7 + '').trim();
    }else if(typeof arg6 !== 'undefined' && arg6 !== null){
      var t = (arg6 + '').trim();
      if(t.indexOf('http') === 0 || t.charAt(0) === '/') imgurl = t;
    }

    // 覆盖升级：新写入 imgurl 为空时保留旧的
    var old = this.getItem(bid);
    if(old){
      var tem = old.split('#');
      if(tem.length >= 6){
        var oldImg = (tem[5] || '').trim();
        if(!imgurl && oldImg) imgurl = oldImg;
      }
    }

    var v = bid + '#' + uri + '#' + bookname + '#' + chaptername + '#' + author + '#' + imgurl;
    this.setItem(bid, v);
    this.setBook(bid);
  },

  get:function(k){
    return this.getItem(k)?this.getItem(k).split("#"):"";
  },

  remove:function(k){
    this.removeItem(k);
    this.removeBook(k);
  },

  // ✅ bookList 只保留最近 50 个 id（不删每本书的数据项）
  setBook:function(v){
    var books = this.getItem(this.bookList);
    var arr = books ? books.split('#') : [];
    var out = [];
    for(var i=0;i<arr.length;i++){
      if(arr[i] && arr[i] !== v) out.push(arr[i]);
    }
    out.push(v);

    if(out.length > 50){
      out = out.slice(out.length - 50);
    }
    this.setItem(this.bookList, out.join('#'));
  },

  // ✅ 只取最近 bookmax 条展示，不删除更旧数据
  getBook:function(){
    var v = this.getItem(this.bookList) ? this.getItem(this.bookList).split("#") : [];
    var books = [];

    if(v.length){
      var start = Math.max(0, v.length - 50);
      for(var i=start;i<v.length;i++){
        var raw = this.getItem(v[i]);
        if(!raw) continue;

        var tem = raw.split('#');

        // 兼容旧结构：bid#chapterid#title#chapter#author
        if(tem.length === 5){
          var bid = (tem[0]||'').trim();
          var cid = (tem[1]||'').trim();
          var title = tem[2]||'';
          var ch = tem[3]||'';
          var au = tem[4]||'';
          var uri = '/book/' + encodeURIComponent(bid) + '/' + encodeURIComponent(cid) + '.html?hty';
          tem = [bid, uri, title, ch, au, ''];
          this.setItem(bid, tem.join('#'));
        }

        if(tem.length < 5) continue;
        books.push(tem);
      }
    }

    if(books.length > bookmax){
      books = books.slice(books.length - bookmax);
    }

    return books;
  },

  removeBook:function(v){
    var books = this.getItem(this.bookList);
    var arr = books ? books.split('#') : [];
    var out = [];
    for(var i=0;i<arr.length;i++){
      if(arr[i] && arr[i] !== v) out.push(arr[i]);
    }
    this.setItem(this.bookList, out.join('#'));
  },

  setItem:function(k,v){
    if(!!window.localStorage){
      localStorage.setItem(k,v);
    }else{
      var expireDate=new Date();
      var EXPIR_MONTH=30*24*3600*1000;
      expireDate.setTime(expireDate.getTime()+12*EXPIR_MONTH);
      document.cookie=k+"="+encodeURIComponent(v)+";expires="+expireDate.toGMTString()+"; path=/";
    }
  },

  getItem:function(k){
    var value="";
    if(!!window.localStorage){
      var result=window.localStorage.getItem(k);
      value=result||"";
    }else{
      var reg=new RegExp("(^| )"+k+"=([^;]*)(;|$)");
      var result2=reg.exec(document.cookie);
      if(result2){
        value=decodeURIComponent(result2[2])||"";
      }
    }
    return value;
  },

  removeItem:function(k){
    if(!!window.localStorage){
      window.localStorage.removeItem(k);
    }else{
      var expireDate=new Date();
      expireDate.setTime(expireDate.getTime()-1000);
      document.cookie=k+"= "+";expires="+expireDate.toGMTString();
    }
  }
};

function _safeText(s){
  s=(s===undefined||s===null)?'':(s+'');
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
          .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}
function _validImg(u){
  if(!u) return false;
  u=(u+'').trim();
  if(!u) return false;
  if(u.indexOf('javascript:')===0) return false;
  if(u.indexOf('data:')===0) return false;
  return (u.charAt(0)==='/' || /^https?:\/\//i.test(u));
}

function showbook(){
  var box=document.getElementById('history');
  if(!box) return;

  // ✅ 占位图：让站内 lazyload 接管（避免“闪一下就没了”）
  var placeholder = '/static/youdu/images/nopic.jpg';

  var books=window.lastread.getBook();
  var html='<ul class="g_row hom-books hom-gutter hon-continue" style="max-height:inherit;">';

  if(books.length){
    for(var i=books.length-1;i>-1;i--){
      var bid=(books[i][0]||'').trim();
      var uri=(books[i][1]||'').trim();
      var bookname=books[i][2]||'';
      var chaptername=books[i][3]||'';
      var imgurl=(books[i].length>=6)?(books[i][5]||''):'';

      // ✅ 真实封面放 _src，src 固定占位，交给站内 lazyload
      var realCover = _validImg(imgurl) ? imgurl : '';

      html+='<li id="his" class="g_col_2" style="position: relative;">';
      html+='<a class="g_thumb hom-thumb" href="'+_safeText(uri)+'" title="'+_safeText(chaptername)+'">';

      if(realCover){
        html+='<img _src="'+_safeText(realCover)+'" src="'+placeholder+'" onerror="this.onerror=null;this.src=\''+placeholder+'\';" width="140" height="186" alt="'+_safeText(bookname)+'">';
      }else{
        html+='<img src="'+placeholder+'" onerror="this.onerror=null;this.src=\''+placeholder+'\';" width="140" height="186" alt="'+_safeText(bookname)+'">';
      }

      html+='</a>';
      html+='<span class="g_his" style="text-overflow:clip;overflow:hidden;text-overflow:ellipsis;"><nobr>'+_safeText(bookname)+'</nobr></span>';
      html+='<span class="g_his"><a href="javascript:removebook(\''+_safeText(bid)+'\')">移除</a></span>';
      html+='</li>';
    }
  }

  html+='</ul>';
  box.innerHTML=html;

  // ✅ 主动触发一次你们站内的懒加载（不同模板函数名可能不同，做兼容）
  try{
    if(typeof imgload === 'function') imgload();
  }catch(e){}
}

function removebook(k){
  window.lastread.remove(k);
  showbook();
}

// 保持模板原调用（recentread 里会调用 history();）
function history(){
  showbook();
}

window.lastread=new LastRead();

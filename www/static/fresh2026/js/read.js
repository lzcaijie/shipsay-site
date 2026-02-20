(function(){
  function toggleNight(){
    document.body.classList.toggle('night');
    try{ localStorage.setItem('read_night', document.body.classList.contains('night') ? '1':'0'); }catch(e){}
  }
  function restoreNight(){
    try{
      if (localStorage.getItem('read_night') === '1') document.body.classList.add('night');
    }catch(e){}
  }

  function fontDelta(delta){
    var el = document.getElementById('chaptercontent');
    if (!el) return;
    var size = parseFloat(window.getComputedStyle(el).fontSize) || 16;
    size = Math.min(26, Math.max(14, size + delta));
    el.style.fontSize = size + 'px';
    try{ localStorage.setItem('read_font', String(size)); }catch(e){}
  }
  function restoreFont(){
    var el = document.getElementById('chaptercontent');
    if (!el) return;
    try{
      var v = localStorage.getItem('read_font');
      if (v) el.style.fontSize = parseFloat(v) + 'px';
    }catch(e){}
  }
  function toTop(){ window.scrollTo({top:0,behavior:'smooth'}); }

  function writeReadLog(){
    if (!window.__READLOG__) return;
    var d = window.__READLOG__;
    // (articleid, uri, articlename, chaptername, author, lastvisit, imgurl)
    if (window.lastread && typeof window.lastread.set === 'function'){
      window.lastread.set(d.bid, d.readUrl, d.bookname, d.chaptername, d.author, d.readtime, d.cover);
    }
  }

  restoreNight();
  restoreFont();

  document.addEventListener('click', function(e){
    var a = e.target.closest('[data-action]');
    if (!a) return;
    var act = a.getAttribute('data-action');
    if (act === 'toggleNight'){ e.preventDefault(); toggleNight(); return; }
    if (act === 'fontUp'){ e.preventDefault(); fontDelta(1); return; }
    if (act === 'fontDown'){ e.preventDefault(); fontDelta(-1); return; }
    if (act === 'toTop'){ e.preventDefault(); toTop(); return; }
  });

  setTimeout(writeReadLog, 0);
})();
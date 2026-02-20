(function(){
  function bootLazy(){
    var imgs = document.querySelectorAll('img[data-src]');
    if (!imgs.length) return;

    if (!('IntersectionObserver' in window)){
      imgs.forEach(function(img){
        img.src = img.getAttribute('data-src');
        img.removeAttribute('data-src');
      });
      return;
    }
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if (!e.isIntersecting) return;
        var img = e.target;
        var src = img.getAttribute('data-src');
        if (src){
          img.src = src;
          img.removeAttribute('data-src');
        }
        io.unobserve(img);
      });
    }, {rootMargin:'240px 0px'});
    imgs.forEach(function(img){ io.observe(img); });
  }

  document.addEventListener('DOMContentLoaded', bootLazy);
})();
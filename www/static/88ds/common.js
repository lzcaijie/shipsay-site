function reloadcode() {
    var img = document.getElementById('showcode');
    if (!img) return;
    img.src = img.src.split('?')[0] + '?' + Math.random();
}


function toggleSort() {
    var el = document.getElementById('submenu');
    if (!el) return false;
    if (window.jQuery && typeof window.jQuery.fn.slideToggle === 'function') {
        window.jQuery(el).stop(true, true).slideToggle(120);
    } else {
        var hidden = (el.style.display === 'none') || (window.getComputedStyle && window.getComputedStyle(el).display === 'none');
        el.style.display = hidden ? 'block' : 'none';
    }
    return false;
}

function st() {
    return false;
}

var checkbg = '#fff';

function nr_setbg(type) {
    var expire = new Date();
    expire.setHours(expire.getHours() + (24 * 30));

    if (type === 'huyan') {
        var current = getCookieValue('light');
        var next = current === 'huyan' ? 'no' : 'huyan';
        document.cookie = 'light=' + next + ';path=/;expires=' + expire.toGMTString();
        set('light', next);
        return;
    }

    if (type === 'light') {
        var currentLight = getCookieValue('light');
        var lightMode = currentLight === 'yes' ? 'no' : 'yes';
        document.cookie = 'light=' + lightMode + ';path=/;expires=' + expire.toGMTString();
        set('light', lightMode);
        return;
    }

    if (type === 'big' || type === 'big2' || type === 'middle' || type === 'small') {
        document.cookie = 'font=' + type + ';path=/;expires=' + expire.toGMTString();
        set('font', type);
    }
}

function getCookieValue(name) {
    var cookies = document.cookie ? document.cookie.split('; ') : [];
    for (var i = 0; i < cookies.length; i++) {
        var parts = cookies[i].split('=');
        if (parts[0] === name) return parts[1] || '';
    }
    return '';
}

function getset() {
    var light = getCookieValue('light');
    var font = getCookieValue('font');

    if (light === 'yes' || light === 'no' || light === 'huyan') {
        set('light', light);
    } else {
        set('light', 'no');
    }

    if (font === 'big' || font === 'big2' || font === 'middle' || font === 'small') {
        set('font', font);
    } else {
        set('font', 'middle');
    }
}

function applyCssToIds(ids, cssText) {
    for (var i = 0; i < ids.length; i++) {
        var el = document.getElementById(ids[i]);
        if (el) el.style.cssText = cssText;
    }
}

function set(mode, value) {
    var body = document.getElementById('nr_body');
    var huyan = document.getElementById('huyandiv');
    var light = document.getElementById('lightdiv');
    var fontBig = document.getElementById('fontbig');
    var fontBig2 = document.getElementById('fontbig2');
    var fontMiddle = document.getElementById('fontmiddle');
    var fontSmall = document.getElementById('fontsmall');
    var content = document.getElementById('nr1');
    var title = document.getElementById('nr_title');

    if (!body || !content || !title) return;

    if (mode === 'light') {
        if (value === 'yes') {
            if (light) light.innerHTML = '开灯';
            if (huyan) huyan.style.backgroundColor = '';
            body.style.backgroundColor = '#32373B';
            title.style.color = '#ccc';
            content.style.color = '#999';
            applyCssToIds(['pt_info','pt_prev','pt_mulu','pt_next','pt_home','pt_info1','pt_prev1','pt_mulu1','pt_next1','pt_home1'], 'background-color:#3e4245;color:#ccc;border:1px solid #313538');
        } else if (value === 'huyan') {
            if (light) light.innerHTML = '关灯';
            if (huyan) huyan.style.backgroundColor = '#c9edcc';
            body.style.backgroundColor = '#c9edcc';
            title.style.color = '#555';
            content.style.color = '#555';
            applyCssToIds(['pt_info','pt_prev','pt_mulu','pt_next','pt_home','pt_info1','pt_prev1','pt_mulu1','pt_next1','pt_home1'], 'background-color:#deede0;color:#666;border:1px solid #cad9cc');
        } else {
            if (light) light.innerHTML = '关灯';
            if (huyan) huyan.style.backgroundColor = '';
            body.style.backgroundColor = checkbg;
            title.style.color = '#333';
            content.style.color = '#333';
            applyCssToIds(['pt_info','pt_prev','pt_mulu','pt_next','pt_home','pt_info1','pt_prev1','pt_mulu1','pt_next1','pt_home1'], '');
        }
    }

    if (mode === 'font') {
        if (fontBig2) fontBig2.style.backgroundColor = '';
        if (fontBig) fontBig.style.backgroundColor = '';
        if (fontMiddle) fontMiddle.style.backgroundColor = '';
        if (fontSmall) fontSmall.style.backgroundColor = '';

        if (value === 'big2') {
            content.style.fontSize = '2.1rem';
            content.style.lineHeight = '2.25';
            if (fontBig2) fontBig2.style.backgroundColor = '#208181';
        } else if (value === 'big') {
            content.style.fontSize = '1.75rem';
            content.style.lineHeight = '2.1';
            if (fontBig) fontBig.style.backgroundColor = '#208181';
        } else if (value === 'small') {
            content.style.fontSize = '1rem';
            content.style.lineHeight = '1.9';
            if (fontSmall) fontSmall.style.backgroundColor = '#208181';
        } else {
            content.style.fontSize = '1.35rem';
            content.style.lineHeight = '2';
            if (fontMiddle) fontMiddle.style.backgroundColor = '#208181';
        }
    }
}

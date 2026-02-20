<?php if (!defined('__ROOT_DIR__')) exit;


function subtext($text, $length)
{
    if(mb_strlen($text, 'utf8') > $length) {
        return mb_substr($text, 0, $length, 'utf8').'..';
    } else {
        return $text;
    }
}

?>
<?//=mb_substr($text, 0, 8)?>

<?php
/**
 * 船说 sitemap 自动生成工具（Bing 稳定版）
 */

$per_page = 5000;

header("Cache-Control: no-store, no-cache, must-revalidate");
date_default_timezone_set('Asia/Chongqing');
set_time_limit(300);

define('__ROOT_DIR__', dirname(dirname(__DIR__)));
require_once __ROOT_DIR__ . '/shipsay/configs/config.ini.php';

spl_autoload_register('ss_autoload');

if (!empty($authcode)) {
    $dbarr['host'] = $authcode;
}

$is_sortid = strpos($fake_sort_url, '{sortid}') !== false;
$articlecode_str = $sys_ver < 2.4 ? '' : 'articlecode,';

$dbarr = array_merge([
    'pre' => $sys_ver < 5 ? 'jieqi_' : 'shipsay_',
    'words' => $sys_ver < 2.4 ? 'size' : 'words',
    'sortarr' => $sortarr,
    'is_multiple' => $is_multiple
], $dbarr);

$db = new Db($dbarr);

$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

if (empty($site_url)) {
    $site_url = ($_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
}

if (isset($_GET['page'])) {

    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '
          . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
          . 'xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/" '
          . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 '
          . 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

    if (intval($_GET['page']) == 0) {

        $static_url = [];
        $static_url[] = $site_url;

        foreach (Sort::ss_sorthead() as $v) {
            $static_url[] = $site_url . $v['sorturl'];
        }

        foreach ($static_url as $k => $u) {
            $xml .= "<url>\n";
            $xml .= "  <loc>{$u}</loc>\n";
            $xml .= "  <lastmod>" . date('Y-m-d\TH:i:s') . "+08:00</lastmod>\n";
            $xml .= "  <changefreq>daily</changefreq>\n";
            $xml .= $k == 0 ? "  <priority>1.00</priority>\n" : "  <priority>0.70</priority>\n";
            $xml .= "</url>\n";
        }

    } else {

        $start_offset = (intval($_GET['page']) - 1) * $per_page;

        $sql = 'SELECT ' . $articlecode_str . 'articleid,lastupdate FROM '
             . $dbarr['pre'] . 'article_article '
             . 'ORDER BY articleid LIMIT '
             . $start_offset . ',' . $per_page;

        $res = $db->ss_query($sql);

        while ($row = mysqli_fetch_array($res)) {

            if (strpos($fake_info_url, '{acode}') !== false) {
                $aid = $row['articlecode'];
            } else {
                $aid = $is_multiple ? ss_newid($row['articleid']) : $row['articleid'];
            }

            $url = $is_3in1
                ? $site_url . Url::index_url($aid)
                : $site_url . Url::info_url($aid);

            $xml .= "<url>\n";
            $xml .= "  <loc>{$url}</loc>\n";
            $xml .= "  <lastmod>" . date('Y-m-d\TH:i:s', $row['lastupdate']) . "+08:00</lastmod>\n";
            $xml .= "  <changefreq>weekly</changefreq>\n";
            $xml .= "  <priority>0.70</priority>\n";
            $xml .= "</url>\n";
        }
    }

    $xml .= "</urlset>";

} else {

    $row = $db->ss_getone('SELECT COUNT(articleid) AS allbooks FROM ' . $dbarr['pre'] . 'article_article');
    $allpage = ceil($row['allbooks'] / $per_page);

    $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    for ($i = 0; $i < $allpage; $i++) {
        $xml .= "<sitemap>\n";
        $xml .= "  <loc>{$site_url}/sitemap/sitemap_{$i}.xml</loc>\n";
        $xml .= "</sitemap>\n";
    }

    $xml .= "</sitemapindex>";
}

header('Content-Type: text/xml');
ob_clean();
echo $xml;

function ss_autoload($classname)
{
    require __ROOT_DIR__ . '/shipsay/class/' . $classname . '.php';
}

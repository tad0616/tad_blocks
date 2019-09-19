<?php
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Utility;

//取得 menu 區塊DataCenter內容
function get_content($bid = 0)
{
    global $xoopsTpl;

    require __DIR__ . "/config.php";
    foreach ($default as $k => $v) {
        $xoopsTpl->assign($k, $v);
    }
    // 傳回陣列的項目
    if ($bid) {
        $arr = ['groups', 'text', 'url', 'img'];
        $TadDataCenter = new TadDataCenter('tad_blocks');
        $TadDataCenter->set_col('bid', $bid);
        $block = $TadDataCenter->getData();

        foreach ($block as $k => $v) {
            if (in_array($k, $arr)) {
                $xoopsTpl->assign($k, $v);
            } else {
                $xoopsTpl->assign($k, $v[0]);
            }
        }
    }

    return $block;
}

//製作 menu 區塊內容
function mk_content($TDC)
{

    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $font_size = empty($TDC['font_size']) ? $default['font_size'] : (int) $TDC['font_size'];
    $text_align = empty($TDC['text_align']) ? $default['text_align'] : $myts->htmlSpecialChars($TDC['text_align']);

    $url = XOOPS_URL;

    $content = <<<"EOD"
<link href="http://www.bsjh.tc.edu.tw/modules/rafaeltools/css/hover-min.css" rel="stylesheet">
<link href="$url/modules/tad_blocks/type/toolbar/freq_toolbar.css" rel="stylesheet">
<div id="freq-link">
<ul>
EOD;

    foreach ($TDC['url'] as $key => $url) {
        if (empty($url)) {
            continue;
        }
        $text = !empty($TDC['text'][$key]) ? $TDC['text'][$key] : $url;
        $img = !empty($TDC['img'][$key]) ? $TDC['img'][$key] : '';

        $content .= <<<"EOD"
<li>
    <a href="$url" target="_blank"><img src="$img" alt="$text" class="hvr-float-shadow"><p>$text</p></a>
</li>
EOD;
    }
    $content .= "</ul>
    </div>";
    $content = $myts->addSlashes($content);
    return $content;
}

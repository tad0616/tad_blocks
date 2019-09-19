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
        $arr = ['groups', 'text', 'url'];
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

    $show_type = empty($TDC['show_type']) ? $default['show_type'] : $TDC['show_type'];

    $url = XOOPS_URL;

    if ($show_type == 'ul') {
        $content = '<ul style="list-style-position:inside;">';
    } elseif ($show_type == 'ol') {
        $content = '<ol style="list-style-position:inside;">';
    } elseif ($show_type == 'table') {
        $content = '<table class="table table-bordered table-condensed table-hover">';
    } else {
        $content = '<ul class="vertical_menu">';
    }

    foreach ($TDC['url'] as $key => $url) {
        if (empty($url)) {
            continue;
        }
        $text = !empty($TDC['text'][$key]) ? $TDC['text'][$key] : $url;

        if ($show_type == 'ul' or $show_type == 'ol') {
            $content .= <<<"EOD"
<li><a href="$url" target="_blank">{$text}</a></li>
EOD;
        } elseif ($show_type == 'table') {
            $content .= <<<"EOD"
<tr><td><a href="$url" target="_blank">{$text}</a></td></tr>
EOD;

        } else {
            $content .= <<<"EOD"
<li><a href="$url" target="_blank">{$text}</a></li>
EOD;
        }
    }

    if ($show_type == 'ul') {
        $content .= '</ul>';
    } elseif ($show_type == 'ol') {
        $content .= '</ol>';
    } elseif ($show_type == 'table') {
        $content .= '</table>';
    } else {
        $content .= '</ul>';
    }

    $content = $myts->addSlashes($content);
    return $content;
}

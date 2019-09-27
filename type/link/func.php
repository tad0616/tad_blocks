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
        $arr = ['groups', 'text', 'url', 'target', 'img_url'];
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
    Utility::add_migrate();

    return $block;
}

//製作 menu 區塊內容
function mk_content($TDC)
{
    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $show_type = empty($TDC['show_type']) ? $default['show_type'] : $TDC['show_type'];
    $item_css = empty($TDC['item_css']) ? $default['item_css'] : $TDC['item_css'];

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
        $target = !empty($TDC['target'][$key]) ? $TDC['target'][$key] : '_blank';
        $icon = !empty($TDC['img_url'][$key]) ? '<img src="' . $TDC['img_url'][$key] . '" alt="' . $text . '" style="margin-right: 4px;">' : '';

        if ($show_type == 'ul' or $show_type == 'ol') {
            $content .= <<<"EOD"
<li style="$item_css"><a href="$url" target="{$target}">{$icon}{$text}</a></li>
EOD;
        } elseif ($show_type == 'table') {
            $content .= <<<"EOD"
<tr><td style="$item_css"><a href="$url" target="{$target}">{$icon}{$text}</a></td></tr>
EOD;

        } else {
            $content .= <<<"EOD"
<li style="$item_css"><a href="$url" target="{$target}">{$icon}{$text}</a></li>
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

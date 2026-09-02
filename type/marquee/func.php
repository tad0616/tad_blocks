<?php
use XoopsModules\Tadtools\MColorPicker;
use XoopsModules\Tadtools\TadDataCenter;

function get_content($bid = 0)
{
    global $xoopsTpl;
    require __DIR__ . "/config.php";
    foreach ($default as $k => $v) {
        $xoopsTpl->assign($k, $v);
    }
    $xoopsTpl->assign('default', $default);

    // 傳回陣列的項目
    if ($bid) {
        $arr           = ['groups', 'content', 'url', 'target'];
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
    $MColorPicker = new MColorPicker('.color-picker');
    $MColorPicker->render('bootstrap-sm');
    return $block;
}
//製作 marquee 區塊內容
function mk_content($bid, $TDC)
{
    require __DIR__ . "/config.php";
    $marquees = [];
    foreach ($TDC['content'] as $key => $item) {
        $marquee            = [];
        $marquee['type']    = 'text';
        $marquee['content'] = $item;

        if (!empty($TDC['url'][$key])) {
            $marquee['link']      = $TDC['url'][$key];
            $marquee['target']    = $TDC['target'][$key];
            $marquee['rel']       = 'noopener noreferrer';
            $marquee['ariaLabel'] = $marquee['target'] == '_blank' ? "前往 {$item}（另開新視窗）" : "前往 {$item}";
        }
        $marquees[] = $marquee;
    }
    $items = json_encode($marquees, 256);

    $font_size    = empty($TDC['font_size']) ? $default['font_size'] : (int) $TDC['font_size'];
    $text_color   = empty($TDC['text_color']) ? $default['text_color'] : addslashes($TDC['text_color']);
    $bg_color     = empty($TDC['bg_color']) ? $default['bg_color'] : addslashes($TDC['bg_color']);
    $padding_y    = empty($TDC['padding_y']) ? $default['padding_y'] : (int) $TDC['padding_y'];
    $border_size  = empty($TDC['border_size']) ? $default['border_size'] : (int) $TDC['border_size'];
    $border_type  = empty($TDC['border_type']) ? $default['border_type'] : addslashes($TDC['border_type']);
    $border_color = empty($TDC['border_color']) ? $default['border_color'] : addslashes($TDC['border_color']);

    $font_size_em = round($font_size / 16, 2);
    $height       = $font_size_em * 2;

    $content = "<link href='" . XOOPS_URL . "/modules/tadtools/tad_marquee/tad_marquee.css' rel='stylesheet' type='text/css'>\n";
    $content .= "<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/tad_marquee/tad_marquee.js'></script>\n";
    $content .= "<div id='tad_blocks_marquee_{$bid}' style='width:100%; height:{$height}rem;' class='dont-print'></div>\n";
    $content .= "<script>\n";
    $content .= "    const marquee = new TadMarquee('tad_blocks_marquee_{$bid}', {\n";
    $content .= "        direction: 'left',\n";
    $content .= "        speed: 50,\n";
    $content .= "        pauseButtonPosition: 'right',\n";
    $content .= "        containerStyle: 'background-color: $bg_color; border: {$border_size}px {$border_type} {$border_color};',\n";
    $content .= "        itemStyle: 'font-size: {$font_size_em}em; color: {$text_color}; padding: {$padding_y}px 5px;',\n";
    $content .= "        items: {$items}\n";
    $content .= "    });\n";
    $content .= "</script>\n";

    return $content;
}

<?php
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\MColorPicker;

//取得 menu 區塊DataCenter內容
function get_content($bid = 0)
{
    global $xoopsTpl;

    // 傳回陣列的項目
    if ($bid) {
        $arr = ['groups', 'text', 'url', 'icon', 'color'];
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
    $MColorPicker = new MColorPicker('.color');
    $MColorPicker->render();
    return $block;
}

//製作 menu 區塊內容
function mk_content($TDC)
{
    $myts = \MyTextSanitizer::getInstance();

    $font_size = !empty($TDC['font_size']) ? (int) $TDC['font_size'] : 20;
    $text_color = !empty($TDC['text_color']) ? $myts->addSlashes($TDC['text_color']) : '#000000';
    $bg_color = !empty($TDC['bg_color']) ? $myts->addSlashes($TDC['bg_color']) : '#f9ffbf';
    $padding_y = !empty($TDC['padding_y']) ? (int) $TDC['padding_y'] : 4;
    $border_size = !empty($TDC['border_size']) ? (int) $TDC['border_size'] : 1;
    $border_type = !empty($TDC['border_type']) ? $myts->addSlashes($TDC['border_type']) : 'solid';
    $border_color = !empty($TDC['border_color']) ? $myts->addSlashes($TDC['border_color']) : '#000000';
    $height = $font_size + ($padding_y * 2) + ($border_size * 2);

    $url = XOOPS_URL;
    $content = '<link href="' . $url . '/modules/tad_blocks/type/menu/r_menu.css" rel="stylesheet" type="text/css">';
    foreach ($TDC['url'] as $key => $url) {
        $content .= <<<"EOD"
<div class="img-responsive">
    <a href="$url" class="a_link" target="_blank">
        <div class="R_menu_bg">
            <div class="R_menu_bot" style="background-color: #00afae">
                <div class="shadow"></div>
                <div class="icon"><i class="fa fa-star"></i></div>
                <div class="word"><strong>{$TDC['text'][$key]}</strong></div>
            </div>
        </div>
    </a>
</div>
EOD;
    }

    $content = $myts->addSlashes($content);
    return $content;
}

<?php
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\MColorPicker;

function get_content($bid = 0)
{
    global $xoopsTpl;

    // 傳回陣列的項目
    if ($bid) {
        $arr=['groups','content'];
        $TadDataCenter = new TadDataCenter('tad_blocks');
        $TadDataCenter->set_col('bid', $bid);
        $block = $TadDataCenter->getData();

        foreach ($block as $k => $v) {
            if (in_array($k,$arr)) {
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
//製作 marquee 區塊內容
function mk_content($TDC)
{
    $myts = \MyTextSanitizer::getInstance();
    $marquee = '';
    foreach ($TDC['content'] as $key => $item) {
        $marquee .= '<li>' . $item . '</li>';
    }

    $font_size = !empty($TDC['font_size']) ? (int) $TDC['font_size'] : 20;
    $text_color = !empty($TDC['text_color']) ? $myts->addSlashes($TDC['text_color']) : '#000000';
    $bg_color = !empty($TDC['bg_color']) ? $myts->addSlashes($TDC['bg_color']) : '#f9ffbf';
    $padding_y = !empty($TDC['padding_y']) ? (int) $TDC['padding_y'] : 4;
    $border_size = !empty($TDC['border_size']) ? (int) $TDC['border_size'] : 1;
    $border_type = !empty($TDC['border_type']) ? $myts->addSlashes($TDC['border_type']) : 'solid';
    $border_color = !empty($TDC['border_color']) ? $myts->addSlashes($TDC['border_color']) : '#000000';
    $height = $font_size + ($padding_y * 2) + ($border_size * 2);

    $content = '<link href="' . XOOPS_URL . '/modules/tad_blocks/type/marquee/jquery.marquee/css/jquery.marquee.css" rel="stylesheet" type="text/css">';
    $content .= '<script type="text/javascript" src="' . XOOPS_URL . '/modules/tad_blocks/type/marquee/jquery.marquee/lib/jquery.marquee.js"></script>';
    $content .= '<style type="text/css" media="screen">';
    $content .= 'ul#tad_blocks_marquee2 {';
    $content .= '    width: 100%;';
    $content .= '    height: ' . $height . 'px;';
    $content .= '    background-color: ' . $bg_color . ';';
    $content .= '    border: ' . $border_size . 'px ' . $border_type . ' ' . $border_color . ';';
    $content .= '}';
    $content .= 'ul#tad_blocks_marquee2 li {';
    $content .= '    font-size: ' . $font_size . 'px;';
    $content .= '    color: ' . $text_color . ';';
    $content .= '    padding: ' . $padding_y . 'px 5px;';
    $content .= '}';
    $content .= '</style>';
    $content .= '<script type="text/javascript">';
    $content .= '$(document).ready(function (){';
    $content .= '    $("#tad_blocks_marquee2").marquee2({yScroll: "bottom"});';
    $content .= '});';
    $content .= '</script>';
    $content .= '<ul id="tad_blocks_marquee2">';
    $content .= $marquee;
    $content .= '</ul>';

    $content = $myts->addSlashes($content);
    return $content;
}

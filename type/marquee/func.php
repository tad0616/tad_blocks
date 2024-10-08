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
        $arr = ['groups', 'content', 'url', 'target'];
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
    $myts = \MyTextSanitizer::getInstance();
    $marquee = '';
    foreach ($TDC['content'] as $key => $item) {
        if (!empty($TDC['url'][$key])) {
            $marquee .= '<li><a href="' . $TDC['url'][$key] . '" target="' . $TDC['target'][$key] . '">' . $item . '</a></li>';
        } else {
            $marquee .= '<li>' . $item . '</li>';
        }
    }

    $font_size = empty($TDC['font_size']) ? $default['font_size'] : (int) $TDC['font_size'];
    $text_color = empty($TDC['text_color']) ? $default['text_color'] : $myts->addSlashes($TDC['text_color']);
    $bg_color = empty($TDC['bg_color']) ? $default['bg_color'] : $myts->addSlashes($TDC['bg_color']);
    $padding_y = empty($TDC['padding_y']) ? $default['padding_y'] : (int) $TDC['padding_y'];
    $border_size = empty($TDC['border_size']) ? $default['border_size'] : (int) $TDC['border_size'];
    $border_type = empty($TDC['border_type']) ? $default['border_type'] : $myts->addSlashes($TDC['border_type']);
    $border_color = empty($TDC['border_color']) ? $default['border_color'] : $myts->addSlashes($TDC['border_color']);
    $height = $font_size + ($padding_y * 2) + ($border_size * 2);

    $font_size_em = round($font_size / 16, 2);

    $content = '<link href="' . XOOPS_URL . '/modules/tad_blocks/type/marquee/jquery.marquee/css/jquery.marquee.css" rel="stylesheet" type="text/css">';
    $content .= '<script type="text/javascript" src="' . XOOPS_URL . '/modules/tad_blocks/type/marquee/jquery.marquee/lib/jquery.marquee.js"></script>';
    $content .= '<style type="text/css" media="screen">';
    $content .= 'ul#tad_blocks_marquee_' . $bid . ' {';
    $content .= '    width: 100%;';
    $content .= '    height: ' . $height . 'px;';
    $content .= '    background-color: ' . $bg_color . ';';
    $content .= '    border: ' . $border_size . 'px ' . $border_type . ' ' . $border_color . ';';
    $content .= '}';
    $content .= 'ul#tad_blocks_marquee_' . $bid . ' li {';
    $content .= '    font-size: ' . $font_size_em . 'em;';
    $content .= '    color: ' . $text_color . ';';
    $content .= '    padding: ' . $padding_y . 'px 5px;';
    $content .= '}';
    $content .= 'ul#tad_blocks_marquee_' . $bid . ' li>a {';
    $content .= '    color: ' . $text_color . ';';
    $content .= '}';
    $content .= '</style>';
    $content .= '<script type="text/javascript">';
    $content .= '$(document).ready(function (){';
    $content .= '    $("#tad_blocks_marquee_' . $bid . '").marquee2({yScroll: "bottom"});';
    $content .= '});';
    $content .= '</script>';
    $content .= '<ul id="tad_blocks_marquee_' . $bid . '" class="tad_blocks_marquee">';
    $content .= $marquee;
    $content .= '</ul>';

    return $content;
}

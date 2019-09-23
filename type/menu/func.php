<?php
use XoopsModules\Tadtools\MColorPicker;
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
        $arr = ['groups', 'text', 'url', 'icon', 'm_color'];
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
    $MColorPicker->render();
    $migrate = Utility::add_migrate('return');
    $xoopsTpl->assign('migrate', $migrate);
    return $block;
}

//製作 menu 區塊內容
function mk_content($TDC)
{
    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $font_size = empty($TDC['font_size']) ? $default['font_size'] : (int) $TDC['font_size'];
    $text_align = empty($TDC['text_align']) ? $default['text_align'] : $myts->htmlSpecialChars($TDC['text_align']);
    $left = $text_align == 'left' ? $font_size + 10 : 0;
    $url = XOOPS_URL;

    $content = <<<"EOD"
<link href="$url/modules/tad_blocks/type/menu/r_menu.css" rel="stylesheet" type="text/css">
<style>
.word {
    font-size: {$font_size}px;
    text-align: {$text_align};
    left: {$left}px;
}
.icon {
    width: 100%;
    height: 45px;
    top: -45px;
    left: 4px;
    font-size: {$font_size}px;
}
</style>
EOD;

    foreach ($TDC['url'] as $key => $url) {
        if (empty($url)) {
            continue;
        }
        // $m_color = $myts->displayTarea($TDC['m_color'][$key], 1, 0, 0, 0, 0);
        $m_color = empty($TDC['m_color'][$key]) ? $default['m_color'] : $myts->htmlSpecialChars($TDC['m_color'][$key]);
        $icon = empty($TDC['icon'][$key]) ? $default['icon'] : $myts->htmlSpecialChars($TDC['icon'][$key]);
        $text = empty($TDC['text'][$key]) ? $url : $myts->htmlSpecialChars($TDC['text'][$key]);

        $content .= <<<"EOD"
<div class="img-responsive">
    <a href="$url" class="a_link" target="_blank">
        <div class="R_menu_bg">
            <div class="R_menu_bot" style="background-color: {$m_color}">
                <div class="shadow"></div>
                <div class="icon"><i class="fa {$icon}"></i></div>
                <div class="word"><strong>{$text}</strong></div>
            </div>
        </div>
    </a>
</div>
EOD;
    }

    $content = $myts->addSlashes($content);
    return $content;
}

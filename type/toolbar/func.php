<?php
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Utility;

//取得 toolbar 區塊DataCenter內容
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
        $arr           = ['groups', 'text', 'url', 'img_url', 'target'];
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

    $CkEditor = new CkEditor('tad_blocks', "content", $content);
    $CkEditor->setHeight(350);
    $CkEditor->setVar('wcag', false);
    // $CkEditor->setToolbarSet('mySimple');
    $editor = $CkEditor->render();
    $xoopsTpl->assign('editor', $editor);
    Utility::add_migrate();
    return $block;
}

//製作 toolbar 區塊內容
function mk_content($bid, $TDC)
{

    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $font_size  = empty($TDC['font_size']) ? $default['font_size'] : (int) $TDC['font_size'];
    $text_align = empty($TDC['text_align']) ? $default['text_align'] : $myts->htmlSpecialChars($TDC['text_align']);
    $hvr        = empty($TDC['hvr']) ? $default['hvr'] : $myts->htmlSpecialChars($TDC['hvr']);

    $url          = XOOPS_URL;
    $font_size_em = round($font_size / 16, 2);

    $content = <<<"EOD"
<link href="$url/modules/tad_blocks/type/toolbar/hover-min.css" rel="stylesheet">
<link href="$url/modules/tad_blocks/type/toolbar/freq_toolbar.css?t=20260410" rel="stylesheet">
<div id="freq-link_{$bid}" class="freq-link">
    <ul class="text-{$text_align}">
EOD;

    foreach ($TDC['url'] as $key => $url) {
        if (empty($url)) {
            continue;
        }
        $text    = !empty($TDC['text'][$key]) ? $TDC['text'][$key] : $url;
        $img_url = !empty($TDC['img_url'][$key]) ? $TDC['img_url'][$key] : $default['img_url'];
        $target  = !empty($TDC['target'][$key]) ? $TDC['target'][$key] : '_blank';

        $opensNewWindow = ($target && ($target === '_blank' || $target === '_new'));
        $fileExtension  = Utility::fileExtensions($url);

        if ($fileExtension && $opensNewWindow) {
            // 同時是檔案且開新視窗
            $title = "title='{$fileExtension}格式（另開新視窗）'";
        } elseif ($fileExtension) {
            // 只是檔案
            $title = "title='{$fileExtension}格式'";
        } elseif ($opensNewWindow) {
            // 只是開新視窗
            $title = "title='另開新視窗'";
        }

        $content .= <<<"EOD"
        <li>
            <a href="$url" target="{$target}" {$title} style="font-size: {$font_size_em}em;"><img src="$img_url" alt="" class="$hvr"><p>$text</p></a>
        </li>
EOD;
    }
    $content .= "   </ul>";
    $content .= "</div>";
    return $content;
}

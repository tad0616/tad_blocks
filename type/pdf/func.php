<?php
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Utility;

//取得 pdf 區塊DataCenter內容
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
        $arr = ['groups'];
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

//製作 pdf 區塊內容
function mk_content($bid, $TDC)
{

    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $rate = empty($TDC['rate']) ? $default['rate'] : $myts->htmlSpecialChars($TDC['rate']);
    $pdf_url = empty($TDC['pdf_url']) ? $default['pdf_url'] : $myts->htmlSpecialChars($TDC['pdf_url']);
    $scrolling = empty($TDC['scrolling']) ? $default['scrolling'] : $myts->htmlSpecialChars($TDC['scrolling']);

    $url = XOOPS_URL;
    $title = strip_tags($TDC['title']);
    $title = $title ? $title : 'iframe';

    $content = <<<"EOD"
<link href="$url/modules/tad_blocks/type/pdf/embed-responsive.css" rel="stylesheet">
<div class="embed-responsive embed-responsive-{$rate} ratio ratio-{$rate}">
    <iframe id="tad_block_menu_"$bid" title="$title" class="embed-responsive-item" src="{$pdf_url}" allowfullscreen scrolling="{$scrolling}"></iframe>
</div>
EOD;

    return $content;
}

<?php
use XoopsModules\Tadtools\TadDataCenter;

//取得 iframe 區塊DataCenter內容
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

    return $block;
}

//製作 iframe 區塊內容
function mk_content($bid, $TDC)
{
    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $iframe_url = $myts->htmlSpecialChars($TDC['iframe_url']);
    $title = strip_tags($TDC['title']);
    $title = $title ? $title : 'iframe';

    $iframe_ratios5 = $TDC['iframe_ratios'];
    $iframe_ratios4 = str_replace('x', 'by', $iframe_ratios5);

    $content = <<<"EOD"
<div id="tad_block_iframe_{$bid}" class="embed-responsive embed-responsive-$iframe_ratios4 ratio ratio-$iframe_ratios5">
    <iframe title="$title" class="embed-responsive-item" src="{$iframe_url}" allowfullscreen></iframe>
</div>
EOD;

    return $content;
}

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
function mk_content($TDC)
{
    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $iframe_width = empty($TDC['iframe_width']) ? (int) $default['iframe_width'] : (int) $TDC['iframe_width'];
    $iframe_height = empty($TDC['iframe_height']) ? (int) $default['iframe_height'] : (int) $TDC['iframe_height'];
    $rate = round($iframe_height / $iframe_width,4) *100;
    $url = XOOPS_URL;
    $iframe_url = $myts->htmlSpecialChars($TDC['iframe_url']);

    $content = <<<"EOD"
<div class="embed-responsive" style="padding-bottom: $rate%;">
    <iframe class="embed-responsive-item" src="{$iframe_url}" allowfullscreen></iframe>
</div>
EOD;

    $content = $myts->addSlashes($content);
    return $content;
}

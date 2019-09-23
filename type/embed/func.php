<?php
use XoopsModules\Tadtools\CodeMirror;
use XoopsModules\Tadtools\TadDataCenter;

//取得 embed 區塊DataCenter內容
function get_content($bid = 0)
{
    global $xoopsTpl;

    require __DIR__ . "/config.php";
    foreach ($default as $k => $v) {
        $xoopsTpl->assign($k, $v);
    }
    // 傳回陣列的項目
    if ($bid) {
        $arr = ['groups', 'content'];
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

    $CodeMirror = new CodeMirror('content_code');
    $CodeMirror->render();
    return $block;
}

//製作 embed 區塊內容
function mk_content($TDC)
{
    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();
    $content = $myts->addSlashes($TDC['content']);
    return $content;
}

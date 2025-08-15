<?php
use XoopsModules\Tadtools\CodeMirror;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Utility;

//取得 embed 區塊DataCenter內容
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
        $arr           = ['groups', 'content'];
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
    $block['content'][0] = stripslashes($block['content'][0]);
    // Utility::dd($block);
    return $block;
}

//製作 embed 區塊內容
function mk_content($bid, $TDC)
{
    require __DIR__ . "/config.php";
    // $myts = \MyTextSanitizer::getInstance();
    // $content = addslashes($TDC['content']);
    // return $content;
    Utility::test($TDC['content'], 'content', 'dd');
    return $TDC['content'];
}

<?php
use XoopsModules\Tadtools\TadDataCenter;

//取得 embed 區塊DataCenter內容
function get_content($bid = 0)
{
    global $xoopsTpl;

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
    return $block;
}

//製作 embed 區塊內容
function mk_content($TDC)
{
    $myts = \MyTextSanitizer::getInstance();
    $content = $myts->addSlashes($TDC['content']);
    return $content;
}

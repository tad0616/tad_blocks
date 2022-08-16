<?php
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

//取得 download 區塊 DataCenter 內容
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

    $file_col_sn = $block['file_col_sn'][0] ? $block['file_col_sn'][0] : $default['file_col_sn'];

    $TadUpFiles = new TadUpFiles("tad_blocks");
    $TadUpFiles->set_col('download', $file_col_sn);
    $xoopsTpl->assign('file_col_sn', $file_col_sn);

    // $TadUpFiles->set_var('require', true); //必填
    $TadUpFiles->set_var("show_tip", false); //不顯示提示
    $upform = $TadUpFiles->upform(true, 'download_files');
    $xoopsTpl->assign('upform', $upform);

    return $block;
}

//製作 download 區塊內容
function mk_content($TDC)
{

    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $mode = empty($TDC['mode']) ? $default['mode'] : $myts->htmlSpecialChars($TDC['mode']);
    $file_col_sn = empty($TDC['file_col_sn']) ? $default['file_col_sn'] : $TDC['file_col_sn'];
    $desc_height = empty($TDC['desc_height']) ? $default['desc_height'] : $TDC['desc_height'];
    $mode = empty($TDC['mode']) ? $default['mode'] : $TDC['mode'];

    if ($mode === 'small') {
        $content = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/iconize.css">';
    } elseif ($mode === 'filename') {
        $content = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/rounded-list.css">';
    } else {
        $fancybox = new FancyBox(".fancybox_download", '1920', '1080');
        $content = ($mode === 'file_text_url' or $show_mode === 'file_url') ? '' : $fancybox->render(false, null, null, null, true);
    }

    $TadUpFiles = new TadUpFiles("tad_blocks");
    $TadUpFiles->set_col('download', $file_col_sn);
    $TadUpFiles->upload_file('download_files', null, null, null, null, true);

    $TadUpFiles->set_var('desc_height', $desc_height);
    $content .= $TadUpFiles->show_files('download_files', true, $mode, true, false, null, null, false);

    //show_files($upname="",$thumb=true,$show_mode="",$show_description=false,$show_dl=false,$limit=NULL,$path=NULL,$hash=false,$playSpeed=5000)

    $content = $myts->addSlashes($content);
    return $content;
}

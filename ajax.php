<?php

/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
if (!$_SESSION['tad_blocks_adm']) {
    redirect_header('index.php', 3, _MD_TAD_BLOCKS_NO_PERMISSION);
}
/*-----------功能函數區--------------*/

//列出所有區塊
function change_newblock($bid, $col, $val)
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr;

    $sql = "update " . $xoopsDB->prefix("newblocks") . " set `$col`='{$val}' where bid='{$bid}'";
    if ($xoopsDB->queryF($sql)) {
        exit;
    } else {
        die($sql);
    }
}

function update_newblock($bid, $side, $weight)
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr;

    $sql = "update " . $xoopsDB->prefix("newblocks") . " set `side`='{$side}',`weight`='{$weight}'  where bid='{$bid}'";
    if (!$xoopsDB->queryF($sql)) {
        die($sql);
    } else {
        die("update $bid OK");
    }
}

//列出所有區塊
function change_block_module_link($bid, $module_id)
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr;

    $sql = "update " . $xoopsDB->prefix("block_module_link") . " set `module_id`='{$module_id}' where block_id='{$bid}'";
    if ($xoopsDB->queryF($sql)) {
        exit;
    } else {
        die($sql);
    }
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$bid = system_CleanVars($_REQUEST, 'bid', '', 'int');
$module_id = system_CleanVars($_REQUEST, 'module_id', '', 'string');
$col = system_CleanVars($_REQUEST, 'col', '', 'string');
$val = system_CleanVars($_REQUEST, 'val', '', 'string');
$weight = system_CleanVars($_REQUEST, 'weight', '', 'int');
$side = system_CleanVars($_REQUEST, 'side', '', 'int');

switch ($op) {

    case "update_newblock":
        update_newblock($bid, $side, $weight);
        exit;

    case "change_block_module_link":
        change_block_module_link($bid, $module_id);
        exit;

    case "change_newblock":
        change_newblock($bid, $col, $val);
        exit;

    case "visible":
        change_newblock($bid, 'visible', 1);
        exit;

    case "invisible":
        change_newblock($bid, 'visible', 0);
        exit;

}

/*-----------秀出結果區--------------*/

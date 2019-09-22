<?php
use XoopsModules\Tadtools\Utility;
/**
 *  module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package
 * @since
 * @author
 * @version    $Id $
 **/

/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'tad_blocks_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
if (!$_SESSION['tad_blocks_adm']) {
    redirect_header('index.php', 3, _MD_TAD_BLOCKS_NO_PERMISSION);
}

/*-----------功能函數區--------------*/

//列出所有區塊
function all_blocks()
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr;

    tad_themes_setup();
    $all_blocks = [];
    $sql = "select a.*, b.module_id, c.name as mod_name, c.dirname from " . $xoopsDB->prefix("newblocks") . " as a
    left join " . $xoopsDB->prefix("block_module_link") . " as b on a.bid=b.block_id
    left join " . $xoopsDB->prefix("modules") . " as c on a.mid=c.mid
    order by a.side, a.weight";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
    while ($all = $xoopsDB->fetchArray($result)) {
        $side = $all['side'];
        $all_blocks[$side][] = $all;
    }
    // dd($all_blocks);
    $xoopsTpl->assign('all_blocks', $all_blocks);
    Utility::get_jquery(true);
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$TDC = system_CleanVars($_REQUEST, 'TDC', array(), 'array');
$type = system_CleanVars($_REQUEST, 'type', '', 'string');
$bid = system_CleanVars($_REQUEST, 'bid', '', 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/
    case "block_form":
        block_form($type, $bid);
        break;

    case "block_save":
        block_save($type, $TDC, $bid);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    case "block_del":
        block_del($bid);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    default:
        all_blocks();
        $op = 'all_blocks';
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_blocks/css/module.css');
include_once XOOPS_ROOT_PATH . '/footer.php';

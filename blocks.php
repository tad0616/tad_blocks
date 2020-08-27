<?php
use Xmf\Request;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Jeditable;
use XoopsModules\Tadtools\MColorPicker;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
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
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr, $tags;

    $jeditable = new Jeditable();
    tad_themes_setup();
    $all_blocks = $alldir = [];

    $sql = "select a.*, b.module_id, c.name as mod_name, c.dirname from " . $xoopsDB->prefix("newblocks") . " as a
    left join " . $xoopsDB->prefix("block_module_link") . " as b on a.bid=b.block_id
    left join " . $xoopsDB->prefix("modules") . " as c on a.mid=c.mid
    order by a.side, a.weight";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
    while ($all = $xoopsDB->fetchArray($result)) {
        $side    = $all['side'];
        $dirname = $all['dirname'];

        if (empty($dirname)) {
            $alldir['custom'] = _MD_TAD_BLOCKS_CUSTOM_BLOCK;
        } else {
            $alldir[$dirname] = $dirname;
        }

        foreach ($tags as $tag) {
            $start = strpos($all['title'], "[$tag]");
            if ($start !== false) {
                $all['title'] = substr($all['title'], 0, $start);
                $all[$tag]    = true;
            } else {
                $all[$tag] = false;
            }
        }

        $jeditable->setTextCol("#b-title-{$all['bid']}", "ajax.php", '50%', '20px', "{'bid': {$all['bid']},'op' : 'update_title'}", "Click to edit");

        $all_blocks[$side][] = $all;
    }
    $xoopsTpl->assign('alldir', $alldir);

    $xoopsTpl->assign('all_blocks', $all_blocks);
    Utility::get_jquery(true);

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    $MColorPicker = new MColorPicker('.color');
    $MColorPicker->render();

    $TadUpFontFiles = new TadUpFiles('tad_themes', '/fonts');
    $TadUpFontFiles->set_col('logo_fonts', 0);
    $fontUpForm = $TadUpFontFiles->upform(true, 'font');
    $xoopsTpl->assign('fontUpForm', $fontUpForm);
    $fonts = $TadUpFontFiles->get_file();
    $xoopsTpl->assign('fonts', $fonts);

    $TadDataCenter = new TadDataCenter('tad_blocks');
    $TadDataCenter->set_col('block_logo', 0);
    $logo_setting = $TadDataCenter->getData();
    if ($logo_setting) {
        foreach ($logo_setting as $key => $value) {
            $xoopsTpl->assign($key, $value[0]);
        }
    } else {
        $f        = array_keys($fonts);
        $data_arr = [
            'size'         => [24],
            'border_size'  => [1],
            'shadow_size'  => [1],
            'color'        => ['#ffffff'],
            'border_color' => ['#005f86'],
            'shadow_color' => ['#3b3b3b'],
            'shadow_x'     => [1],
            'shadow_y'     => [1],
            'font_file_sn' => [$f[0]],
        ];
        $TadDataCenter->saveCustomData($data_arr);
        foreach ($data_arr as $key => $value) {
            $xoopsTpl->assign($key, $value[0]);
        }
    }

    $jeditable->render();

    $fancybox = new FancyBox('.block_setting', '50%');
    $fancybox->render(true);
    // $fancybox->renderForm('ajax.php',false);
}

function save_and_re_build_logo()
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr, $tags;

    $TadDataCenter = new TadDataCenter('tad_blocks');
    $TadDataCenter->set_col('block_logo', 0);
    $TadDataCenter->saveData();

    $sql    = "select bid,title from " . $xoopsDB->prefix("newblocks") . " where visible='1'";
    $result = $xoopsDB->query($sql) or die($sql);
    while (list($bid, $title) = $xoopsDB->fetchRow($result)) {
        foreach ($tags as $tag) {
            $start = strpos($title, "[$tag]");
            if ($start !== false) {
                $title = substr($title, 0, $start);
            }
        }
        $TadDataCenter = new TadDataCenter('tad_blocks');
        $TadDataCenter->set_col('block_logo', 0);
        $logo_setting = $TadDataCenter->getData();
        if ($logo_setting) {
            foreach ($logo_setting as $key => $value) {
                $$key = $value[0];
            }
        }

        mkTitlePic($bid, $title, $size, $border_size, $color, $border_color, $font_file_sn, $shadow_color, $shadow_x, $shadow_y, $shadow_size, false);
    }
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$TDC = system_CleanVars($_REQUEST, 'TDC', '', 'array');
$op  = Request::getString('op');
// $TDC = Request::getArray('TDC');
$type = Request::getString('type');
$bid  = Request::getInt('bid');

switch ($op) {

    case 'save_and_re_build_logo':
        save_and_re_build_logo();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

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

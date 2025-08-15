<?php
use Xmf\Request;
use XoopsModules\Tadtools\Bootstrap3Editable;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\FormValidator;
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
if (!$tad_blocks_adm) {
    redirect_header('index.php', 3, _MD_TAD_BLOCKS_NO_PERMISSION);
}

/*-----------執行動作判斷區----------*/
$op   = Request::getString('op');
$TDC  = Request::getVar('TDC', [], null, 'array', 2);
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

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu, false, $interface_icon));
$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign('show_build_logo', $xoopsModuleConfig['show_build_logo']);

$xoTheme->addStylesheet('modules/tad_blocks/css/module.css');
include_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------功能函數區--------------*/

//列出所有區塊
function all_blocks()
{
    global $xoopsDB, $xoopsTpl, $tags;

    $Bootstrap3Editable     = new Bootstrap3Editable();
    $Bootstrap3EditableCode = $Bootstrap3Editable->render('.editable', 'ajax.php');
    $xoopsTpl->assign('Bootstrap3EditableCode', $Bootstrap3EditableCode);

    tad_themes_setup();
    $all_blocks = $alldir = [];

    $sql = 'SELECT a.*, b.module_id, c.name AS mod_name, c.dirname, c.name FROM `' . $xoopsDB->prefix('newblocks') . '` AS a
    LEFT JOIN `' . $xoopsDB->prefix('block_module_link') . '` AS b ON a.bid=b.block_id
    LEFT JOIN `' . $xoopsDB->prefix('modules') . '` AS c ON a.mid=c.mid
    WHERE c.`isactive`=1 OR a.mid=0
    ORDER BY a.side, a.weight';
    $result = Utility::query($sql) or Utility::web_error($sql);

    while ($all = $xoopsDB->fetchArray($result)) {
        $side    = $all['side'];
        $dirname = $all['dirname'];
        $name    = $all['name'];

        if (empty($dirname)) {
            $alldir['custom'] = _MD_TAD_BLOCKS_CUSTOM_BLOCK;
        } else {
            $alldir[$dirname] = $name;
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

        // $jeditable->setTextCol("#b-title-{$all['bid']}", "ajax.php", '50%', '20px', "{'bid': {$all['bid']},'op' : 'update_title'}", "Click to edit");

        $all_blocks[$side][] = $all;
    }
    $xoopsTpl->assign('alldir', $alldir);

    $xoopsTpl->assign('all_blocks', $all_blocks);
    Utility::get_jquery(true);

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    $MColorPicker = new MColorPicker('.color-picker');
    $MColorPicker->render('bootstrap');

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
            'size' => [24],
            'border_size' => [1],
            'shadow_size' => [1],
            'color' => ['#ffffff'],
            'border_color' => ['#005f86'],
            'shadow_color' => ['#3b3b3b'],
            'shadow_x' => [1],
            'shadow_y' => [1],
            'font_file_sn' => [$f[0]],
        ];
        $TadDataCenter->saveCustomData($data_arr);
        foreach ($data_arr as $key => $value) {
            $xoopsTpl->assign($key, $value[0]);
        }
    }

    // $jeditable->render();

    $fancybox = new FancyBox('.block_setting', '50%');
    $fancybox->set_type('iframe');
    $fancybox->render(true);
    // $fancybox->renderForm('ajax.php',false);
}

function save_and_re_build_logo()
{
    global $xoopsDB, $tags;

    $TadDataCenter = new TadDataCenter('tad_blocks');
    $TadDataCenter->set_col('block_logo', 0);
    $TadDataCenter->saveData();

    $sql    = 'SELECT `bid`, `title` FROM `' . $xoopsDB->prefix('newblocks') . '` WHERE `visible`=?';
    $result = Utility::query($sql, 'i', [1]) or die($sql);

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

        Utility::mkTitlePic('/uploads/bid', $bid, $title, $size, $border_size, $color, $border_color, $font_file_sn, $shadow_color, $shadow_x, $shadow_y, $shadow_size, 0, 0, false);
    }
}

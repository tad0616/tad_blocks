<?php
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadDataCenter;
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

/*-----------功能函數區--------------*/

//
function my_blocks()
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr;
    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;
    $TadDataCenter = new TadDataCenter($module_dirname);
    $my_blocks = [];
    $sql = "select * from " . $xoopsDB->prefix("tad_blocks") . " where `uid`='{$uid}' order by create_date desc";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
    while ($all = $xoopsDB->fetchArray($result)) {

        $sql2 = "select max(weight) from " . $xoopsDB->prefix("newblocks") . " where  bid='{$all['bid']}'";
        $result2 = $xoopsDB->queryF($sql2) or Utility::web_error($sql2);
        list($weight) = $xoopsDB->fetchRow($result2);

        $TadDataCenter->set_col('bid', $all['bid']);
        $block = $TadDataCenter->getData();
        $all['position'] = $position_arr[$block['side'][0]];
        $all['type'] = $type_arr[$all['type']];
        $all['block'] = $block;
        $all['weight'] = $weight;
        $my_blocks[] = $all;
    }

    if (empty($my_blocks)) {
        header("location:index.php?op=block_form#block_setup");
        exit;
    } else {
        $SweetAlert = new SweetAlert();
        $SweetAlert->render("block_del", "index.php?op=block_del&bid=", 'bid');
        $xoopsTpl->assign('position_arr', $position_arr);
        $xoopsTpl->assign('my_blocks', $my_blocks);
    }
}

//區塊編輯表單
function block_form($type = '', $bid = '')
{

    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $type_arr;
    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $and_uid = $_SESSION['tad_blocks_adm'] ? '' : "and uid='{$uid}'";

    $xoopsTpl->assign('type', $type);

    //判斷目前使用者是否有：建立自訂區塊
    $add_block = Utility::power_chk($module_dirname, 1);
    $xoopsTpl->assign('add_block', $add_block);
    $block = $all = [];

    if ($add_block) {

        if ($bid) {
            $sql = "select * from " . $xoopsDB->prefix("tad_blocks") . " where `bid`='{$bid}' $and_uid ";
            $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
            $all = $xoopsDB->fetchArray($result);
            foreach ($all as $k => $v) {
                $$k = $v;
                // echo "$$k = $v<br>";
                $xoopsTpl->assign($k, $v);
            }

            $sql2 = "select title,max(weight) from " . $xoopsDB->prefix("newblocks") . " where  bid='{$all['bid']}'";
            $result2 = $xoopsDB->queryF($sql2) or Utility::web_error($sql2);
            list($title, $weight) = $xoopsDB->fetchRow($result2);
            $xoopsTpl->assign('weight', $weight);
        }

        if ($type) {
            require __DIR__ . "/type/{$type}/func.php";
            $block = get_content($bid);
        } else {
            // 傳回陣列的項目
            $arr = ['groups', 'content'];
            $TadDataCenter = new TadDataCenter('tad_blocks');
            $TadDataCenter->set_col('bid', $bid);
            $block = $TadDataCenter->getData();
            $xoopsTpl->assign('title', $block['title'][0]);
            // ddd($block);
            $CkEditor = new CkEditor($module_dirname, "TDC[content]", $block['content'][0]);
            $CkEditor->setHeight(350);
            $editor = $CkEditor->render();
            $xoopsTpl->assign('editor', $editor);
        }

        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        $groups = $block['groups'] ? $block['groups'] : [1, 2, 3];
        $sel_grp = new \XoopsFormSelectCheckGroup('groups', "TDC[groups]", $groups);
        $xoopsTpl->assign('sel_grp', $sel_grp->render());

        $xoopsTpl->assign('type_arr', $type_arr);

        tad_themes_setup();
    }
}

//儲存並建立區塊
function block_save($type = '', $TDC = array(), $bid = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser, $tags;

    $mk_pic = ['pic', 'img'];
    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $myts = \MyTextSanitizer::getInstance();

    $title = $myts->addSlashes($TDC['title']);
    $side = $myts->addSlashes($TDC['side']);
    $weight = (int) $TDC['weight'];

    if (!empty($type)) {
        require __DIR__ . "/type/{$type}/func.php";
        $content = mk_content($TDC);

    } else {
        $content = $myts->addSlashes($TDC['content']);
    }

    $last_modified = time();

    if (empty($bid)) {

        $sql = "select max(weight) from " . $xoopsDB->prefix("newblocks") . " where  side='{$side}' and visible=1 and isactive=1";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
        list($weight) = $xoopsDB->fetchRow($result);

        $weight++;

        // 新增區塊
        $sql = "insert into " . $xoopsDB->prefix("newblocks") . " (mid, func_num, options, name, title, content, side, weight, visible, block_type, c_type, isactive, bcachetime, last_modified) values('0', '0', '', '自訂區塊（HTML）', '{$title}', '{$content}', '{$side}', '{$weight}', '1', 'C', 'H', '1', '0', '{$last_modified}')";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        $bid = $xoopsDB->getInsertId();

        if ($bid) {
            // 新增區塊顯示方式
            $sql = "insert into " . $xoopsDB->prefix("block_module_link") . " (block_id, module_id) values('{$bid}', '{$TDC['display']}')";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);

            // 新增區塊設定
            $sql = "insert into " . $xoopsDB->prefix("tad_blocks") . " (bid, type, uid, create_date) values('{$bid}','{$type}', '{$uid}', now())";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);

            // 新增區塊讀取權限
            foreach ($_POST['TDC']['groups'] as $group_id) {
                $sql = "insert into " . $xoopsDB->prefix("group_permission") . " (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) values('$group_id', '{$bid}', '1', 'block_read')";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);
            }

            $TadDataCenter = new TadDataCenter($module_dirname);
            $TadDataCenter->set_col('bid', $bid);
            $TadDataCenter->set_var('auto_col_id', true);
            $TadDataCenter->saveData();

            // $TadUpFiles = new TadUpFiles($module_dirname);
            // $TadUpFiles->set_col('bid', $bid);
            // if (!empty($_FILES['TDC']['tmp_name'])) {
            //     foreach ($_FILES['TDC']['tmp_name'] as $name => $items) {
            //         foreach ($items as $sort => $tmp_name) {
            //             $TadUpFiles->upload_one_file($_FILES['TDC']['name'][$name][$sort], $tmp_name, $_FILES['TDC']['type'][$name][$sort], $_FILES['TDC']['size'][$name][$sort], $width, $thumb_width, $files_sn, $desc, true);
            //         }
            //     }
            // }
        }

    } else {

        $sql = "select * from " . $xoopsDB->prefix("newblocks") . " where  bid='{$bid}'";
        $result = $xoopsDB->query($sql) or die($sql);
        $block = $xoopsDB->fetchArray($result);
        $old_tag = '';
        foreach ($tags as $tag) {
            $start = strpos($block['title'], "[$tag]");
            if ($start !== false) {
                if (!empty($title) and in_array($tag, $mk_pic)) {
                    $TadDataCenter = new TadDataCenter('tad_blocks');
                    $TadDataCenter->set_col('block_logo', 0);
                    $logo_setting = $TadDataCenter->getData();
                    if ($logo_setting) {
                        foreach ($logo_setting as $key => $value) {
                            $$key = $value[0];
                        }
                    }
                    $tag2 = "[$tag]" . mkTitlePic($bid, $title, $size, $border_size, $color, $border_color, $font_file_sn, $shadow_color, $shadow_x, $shadow_y, $shadow_size);
                } else {
                    $tag2 = substr($block['title'], $start);
                }
            }
        }

        $and_uid = $_SESSION['tad_blocks_adm'] ? '' : "and uid='{$uid}'";

        // 更新區塊設定
        $sql = "update " . $xoopsDB->prefix("tad_blocks") . " set create_date=now() where bid='{$bid}' $and_uid";
        if ($xoopsDB->queryF($sql)) {
            // 更新區塊
            $sql = "update " . $xoopsDB->prefix("newblocks") . " set title='{$title}{$tag2}', content='{$content}', side='{$side}', weight='{$weight}', last_modified='{$last_modified}' where bid='$bid'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);

            // 更新區塊顯示方式
            $sql = "update " . $xoopsDB->prefix("block_module_link") . " set module_id='{$TDC['display']}' where block_id='$bid'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);

            // 刪除區塊權限
            $sql = "delete from " . $xoopsDB->prefix("group_permission") . "  where gperm_itemid='{$bid}' and gperm_modid=1 and gperm_name='block_read'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);

            // 更新區塊讀取權限
            foreach ($_POST['TDC']['groups'] as $group_id) {
                $sql = "insert into " . $xoopsDB->prefix("group_permission") . " (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) values('$group_id', '{$bid}', '1', 'block_read')";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);
            }

            $TadDataCenter = new TadDataCenter($module_dirname);
            $TadDataCenter->set_col('bid', $bid);
            $TadDataCenter->set_var('auto_col_id', true);
            $TadDataCenter->saveData();

        } else {
            Utility::web_error($sql);
        }
    }

}

//刪除區塊
function block_del($bid = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;

    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $and_uid = $_SESSION['tad_blocks_adm'] ? '' : "and uid='{$uid}'";

    // 刪除區塊設定
    $sql = "delete from " . $xoopsDB->prefix("tad_blocks") . "  where bid='{$bid}' $and_uid";
    if ($xoopsDB->queryF($sql)) {

        $TadDataCenter = new TadDataCenter($module_dirname);
        $TadDataCenter->set_col('bid', $bid);
        $TadDataCenter->delData();

        // 刪除區塊
        $sql = "delete from  " . $xoopsDB->prefix("newblocks") . " where bid='{$bid}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);

        // 刪除區塊顯示方式
        $sql = "delete from " . $xoopsDB->prefix("block_module_link") . " where block_id='{$bid}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);

        // 刪除區塊權限
        $sql = "delete from " . $xoopsDB->prefix("group_permission") . "  where gperm_itemid='{$bid}' and gperm_modid=1 and gperm_name='block_read'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);

    } else {
        Utility::web_error($sql);
    }

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
        my_blocks();
        $op = 'my_blocks';
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_blocks/css/module.css');
include_once XOOPS_ROOT_PATH . '/footer.php';

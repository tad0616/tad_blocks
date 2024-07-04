<?php
use Xmf\Request;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\Wcag;

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

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$TDC = Request::getVar('TDC', [], null, 'array', 2);
$type = Request::getString('type');
$bid = Request::getInt('bid');
$bbid = Request::getInt('bbid');
$files_sn = Request::getInt('files_sn');

switch ($op) {

    case "tufdl":
        $TadUpFiles = new TadUpFiles("tad_blocks");
        $TadUpFiles->add_file_counter($files_sn);
        exit;

    case "block_form":
        block_form($type, $bid, $bbid);
        break;

    case "block_save":
        block_save($type, $TDC, $bid, $bbid);
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

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_blocks/css/module.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/my-input.css');
include_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------功能函數區--------------*/

//
function my_blocks()
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $position_arr, $type_arr, $tags;

    $show_file = ['pic', 'img', 'icon'];
    $show_link = ['link'];

    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;
    $TadDataCenter = new TadDataCenter($module_dirname);
    $my_blocks = [];
    $where_uid = $_SESSION['tad_blocks_adm'] ? '' : "where a.`uid`='{$uid}'";
    $sql = "select a.type, a.bid as bbid , b.* from " . $xoopsDB->prefix("tad_blocks") . " as a
    left join " . $xoopsDB->prefix("newblocks") . " as b on a.bid=b.bid
    $where_uid order by a.bid desc";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
    while ($all = $xoopsDB->fetchArray($result)) {
        $TadDataCenter->set_col('bid', $all['bid']);
        $block = $TadDataCenter->getData();
        $all['position'] = $position_arr[$all['side']];
        $all['type'] = $type_arr[$all['type']];
        $all['block'] = $block;
        $all['clean_title'] = $all['title'];
        $all['pic'] = '';
        foreach ($tags as $tag) {
            $start = strpos($all['title'], "[$tag]");
            if ($start !== false) {
                $all['tag'] = "<span class='badge badge-success bg-success'>$tag</span>";
                $all['clean_title'] = substr($all['title'], 0, $start);
                if (in_array($tag, $show_file)) {
                    $start = $start + strlen("[$tag]");
                    $pic = substr($all['title'], $start);
                    $all['pic'] = "<img src='{$pic}' alt='[$tag]'>";
                }
            }
        }
        $my_blocks[] = $all;
    }

    if (empty($my_blocks)) {
        header("location:index.php?op=block_form");
        exit;
    } else {
        $SweetAlert = new SweetAlert();
        $SweetAlert->render("block_del", "index.php?op=block_del&bid=", 'bid');
        $xoopsTpl->assign('position_arr', $position_arr);
        $xoopsTpl->assign('my_blocks', $my_blocks);
    }
}

//區塊編輯表單
function block_form($type = '', $bid = 0, $bbid = 0)
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $type_arr, $tags;
    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $and_uid = $_SESSION['tad_blocks_adm'] ? '' : "and uid='{$uid}'";

    //判斷目前使用者是否有：建立自訂區塊
    $add_block = Utility::power_chk($module_dirname, 1);
    $xoopsTpl->assign('add_block', $add_block);
    $block = $all = [];

    $myts = \MyTextSanitizer::getInstance();

    if ($add_block) {
        $TadDataCenter = new TadDataCenter('tad_blocks');
        if ($bid or $bbid) {
            if ($bid) {
                $sql = "select `title`,`weight`,`side`,`content`,`visible` from " . $xoopsDB->prefix("newblocks") . " where  bid='{$bid}'";
                $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
                list($title, $weight, $side, $content, $visible) = $xoopsDB->fetchRow($result);

                foreach ($tags as $tag) {
                    $start = strpos($title, "[$tag]");
                    if ($start !== false) {
                        $title = substr($title, 0, $start);
                        break;
                    }
                }
                $xoopsTpl->assign('bid', $bid);
            } else {
                $xoopsTpl->assign('bbid', $bbid);
                $bid = $bbid;
            }

            $sql = "select type from " . $xoopsDB->prefix("tad_blocks") . " where `bid`='{$bid}' $and_uid ";
            $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
            list($type) = $xoopsDB->fetchRow($result);
            if (empty($type)) {
                $sql = "replace into " . $xoopsDB->prefix("tad_blocks") . " (bid, type, uid, create_date) values('{$bid}','{$type}', '{$uid}', now())";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);

                $TadDataCenter->set_col('bid', $bid);
                $TadDataCenter->set_var('auto_col_id', true);
                $data_arr['title'][0] = $title;
                $data_arr['content'][0] = $content;
                $TadDataCenter->saveCustomData($data_arr);
            }
        } else {
            $sql = "select max(weight) from " . $xoopsDB->prefix("newblocks") . " where  side='{$side}' and visible=1 and isactive=1";
            $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
            list($weight) = $xoopsDB->fetchRow($result);

            $weight++;
        }

        if ($type) {
            require __DIR__ . "/type/{$type}/func.php";
            $block = get_content($bid);
        } else {
            // 傳回陣列的項目
            $arr = ['groups', 'content'];
            if ($bid) {
                $TadDataCenter->set_col('bid', $bid);
                $block = $TadDataCenter->getData();
            }
            $CkEditor = new CkEditor($module_dirname, "TDC[content]", $block['content'][0]);
            $CkEditor->setHeight(350);
            $editor = $CkEditor->render();
            $xoopsTpl->assign('editor', $editor);
        }

        $xoopsTpl->assign('title', $title);
        $xoopsTpl->assign('side', $side);
        $xoopsTpl->assign('weight', $weight);
        $xoopsTpl->assign('type', $type);
        $xoopsTpl->assign('visible', $visible);
        $xoopsTpl->assign('display', $block['display'][0]);

        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        $groups = $block['groups'] ? $block['groups'] : [1, 2, 3];
        // $sel_grp = new \XoopsFormSelectCheckGroup('groups', "TDC[groups]", $groups);
        $sel_grp = new \XoopsFormSelectGroup('groups', "TDC[groups]", true, $groups, 6, true);
        $xoopsTpl->assign('sel_grp', $sel_grp->render());

        $xoopsTpl->assign('type_arr', $type_arr);

        tad_themes_setup();
    }
}

//儲存並建立區塊
function block_save($type = '', $TDC = array(), $bid = '', $bbid = '')
{
    global $xoopsDB, $xoopsUser, $tags;

    $mk_pic = ['pic', 'img'];
    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $myts = \MyTextSanitizer::getInstance();

    $title = $myts->addSlashes($TDC['title']);
    $side = $myts->addSlashes($TDC['side']);
    $weight = (int) $TDC['weight'];

    if (!empty($type)) {
        require __DIR__ . "/type/{$type}/func.php";
        $content = mk_content($bid, $TDC);

    } else {
        $content = $myts->addSlashes($TDC['content']);
    }

    $content = Wcag::amend($content);
    $last_modified = time();

    if (empty($bid)) {

        // 新增區塊
        $sql = "replace into " . $xoopsDB->prefix("newblocks") . " (mid, func_num, options, name, title, content, side, weight, visible, block_type, c_type, isactive, bcachetime, last_modified) values('0', '0', '', '自訂區塊（HTML）', '{$title}', '{$content}', '{$side}', '{$weight}', '1', 'C', 'H', '1', '0', '{$last_modified}')";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        $bid = $xoopsDB->getInsertId();

        if ($bid) {
            // 新增區塊顯示方式
            $sql = "replace into " . $xoopsDB->prefix("block_module_link") . " (block_id, module_id) values('{$bid}', '{$TDC['display']}')";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);

            // 新增區塊讀取權限
            foreach ($_POST['TDC']['groups'] as $group_id) {
                $sql = "replace into " . $xoopsDB->prefix("group_permission") . " (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) values('$group_id', '{$bid}', '1', 'block_read')";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);
            }

            $TadDataCenter = new TadDataCenter($module_dirname);

            // 從舊設定來新增模組
            if (!empty($bbid)) {
                // 新增區塊設定
                $sql = "update " . $xoopsDB->prefix("tad_blocks") . " set bid='{$bid}', type='{$type}', uid='{$uid}', create_date=now() where bid='{$bbid}'";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);

                $TadDataCenter->set_col('bid', $bid);
                $TadDataCenter->set_var('auto_col_id', true);
                $TadDataCenter->saveData();

                $TadDataCenter->set_col('bid', $bbid);
                $TadDataCenter->delData();

            } else {
                // 新增區塊設定
                $sql = "replace into " . $xoopsDB->prefix("tad_blocks") . " (bid, type, uid, create_date) values('{$bid}','{$type}', '{$uid}', now())";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);

                $TadDataCenter->set_col('bid', $bid);
                $TadDataCenter->set_var('auto_col_id', true);
                $TadDataCenter->saveData();
            }
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
                } elseif ($tag == 'hide') {
                    $tag2 = '[hide]';
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
                $sql = "replace into " . $xoopsDB->prefix("group_permission") . " (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) values('$group_id', '{$bid}', '1', 'block_read')";
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

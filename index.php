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
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu, false, $interface_icon));
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet('modules/tad_blocks/css/module.css');
$xoTheme->addStylesheet('modules/tadtools/css/my-input.css');
include_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------功能函數區--------------*/

//
function my_blocks()
{
    global $xoopsDB, $xoopsTpl, $tad_blocks_adm, $xoopsUser, $position_arr, $type_arr, $tags;

    $show_file = ['pic', 'img', 'icon'];
    $show_link = ['link'];

    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;
    $TadDataCenter = new TadDataCenter($module_dirname);
    $my_blocks = [];
    $where_uid = $tad_blocks_adm ? '' : "where a.`uid`='{$uid}'";
    $sql = 'SELECT a.`type`, a.`bid` as `bbid`, b.* FROM `' . $xoopsDB->prefix('tad_blocks') . '` as a LEFT JOIN `' . $xoopsDB->prefix('newblocks') . '` as b ON a.`bid`=b.`bid` ' . $where_uid . ' ORDER BY a.`bid` DESC';
    $result = Utility::query($sql) or Utility::web_error($sql);

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
    global $xoopsDB, $xoopsTpl, $xoopsUser, $type_arr, $tags, $tad_blocks_adm;
    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $and_uid = $tad_blocks_adm ? '' : "AND `uid`={$uid}";

    //判斷目前使用者是否有：建立自訂區塊
    $add_block = Utility::power_chk($module_dirname, 1);

    $xoopsTpl->assign('add_block', $add_block);
    $block = [];

    if ($add_block) {
        $TadDataCenter = new TadDataCenter('tad_blocks');
        if ($bid or $bbid) {
            if ($bid) {
                $sql = 'SELECT `title`, `weight`, `side`, `content`, `visible` FROM `' . $xoopsDB->prefix('newblocks') . '` WHERE `bid` = ?';
                $result = Utility::query($sql, 'i', [$bid]) or Utility::web_error($sql);

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

            $sql = 'SELECT `type` FROM `' . $xoopsDB->prefix('tad_blocks') . '` WHERE `bid`=? ' . $and_uid;
            $result = Utility::query($sql, 'i', [$bid]) or Utility::web_error($sql);

            list($type) = $xoopsDB->fetchRow($result);
            if (empty($type)) {
                $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_blocks') . '` (`bid`, `type`, `uid`, `create_date`) VALUES (?, ?, ?, NOW())';
                Utility::query($sql, 'isi', [$bid, (string) $type, $uid]) or Utility::web_error($sql);

                $TadDataCenter->set_col('bid', $bid);
                $TadDataCenter->set_var('auto_col_id', true);
                $data_arr['title'][0] = $title;
                $data_arr['content'][0] = $content;
                $TadDataCenter->saveCustomData($data_arr);
            }
        } else {
            $side = 0;
            $weight = 0;
        }

        if ($type) {
            require __DIR__ . "/type/{$type}/func.php";
            $block = get_content($bid);
        } else {
            // 傳回陣列的項目
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
    global $xoopsDB, $xoopsUser, $tags, $tad_blocks_adm;

    $mk_pic = ['pic', 'img'];
    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $title = $TDC['title'];
    $side = $TDC['side'];
    $weight = (int) $TDC['weight'];

    if (!empty($type)) {
        require __DIR__ . "/type/{$type}/func.php";
        $content = mk_content($bid, $TDC);

    } else {
        $content = $TDC['content'];
    }

    $content = Wcag::amend($content);
    $last_modified = time();

    if (empty($bid)) {

        // 新增區塊
        $sql = 'REPLACE INTO `' . $xoopsDB->prefix('newblocks') . '` (`mid`, `func_num`, `options`, `name`, `title`, `content`, `side`, `weight`, `visible`, `block_type`, `c_type`, `isactive`, `bcachetime`, `last_modified`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        Utility::query($sql, 'iissssiiissiii', [0, 0, '', _MD_TAD_BLOCKS_CUSTOMIZED, $title, $content, $side, $weight, 1, 'C', 'H', 1, 0, $last_modified]) or Utility::web_error($sql);
        $bid = $xoopsDB->getInsertId();

        if ($bid) {
            // 新增區塊顯示方式
            $sql = 'REPLACE INTO `' . $xoopsDB->prefix('block_module_link') . '` (`block_id`, `module_id`) VALUES (?, ?)';
            Utility::query($sql, 'ii', [$bid, $TDC['display']]) or Utility::web_error($sql);

            // 新增區塊讀取權限
            foreach ($_POST['TDC']['groups'] as $group_id) {
                $sql = 'REPLACE INTO `' . $xoopsDB->prefix('group_permission') . '` (`gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES (?, ?, 1, ?)';
                Utility::query($sql, 'iis', [$group_id, $bid, 'block_read']) or Utility::web_error($sql);

            }

            $TadDataCenter = new TadDataCenter($module_dirname);

            // 從舊設定來新增模組
            if (!empty($bbid)) {
                // 新增區塊設定
                $sql = 'UPDATE `' . $xoopsDB->prefix('tad_blocks') . '` SET `bid`=?, `type`=?, `uid`=?, `create_date`=now() WHERE `bid`=?';
                Utility::query($sql, 'isii', [$bid, $type, $uid, $bbid]) or Utility::web_error($sql);

                $TadDataCenter->set_col('bid', $bid);
                $TadDataCenter->set_var('auto_col_id', true);
                $TadDataCenter->saveData();

                $TadDataCenter->set_col('bid', $bbid);
                $TadDataCenter->delData();

            } else {
                // 新增區塊設定
                $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_blocks') . '` (`bid`, `type`, `uid`, `create_date`) VALUES (?, ?, ?, NOW())';
                Utility::query($sql, 'isi', [$bid, $type, $uid]) or Utility::web_error($sql);

                $TadDataCenter->set_col('bid', $bid);
                $TadDataCenter->set_var('auto_col_id', true);
                $TadDataCenter->saveData();
            }
        }

    } else {

        $sql = 'SELECT * FROM `' . $xoopsDB->prefix('newblocks') . '` WHERE `bid`=?';
        $result = Utility::query($sql, 'i', [$bid]) or die($sql);

        $block = $xoopsDB->fetchArray($result);

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
                    $tag2 = "[$tag]" . Utility::mkTitlePic('/uploads/bid', $bid, $title, $size, $border_size, $color, $border_color, $font_file_sn, $shadow_color, $shadow_x, $shadow_y, $shadow_size);
                } elseif ($tag == 'hide') {
                    $tag2 = '[hide]';
                } else {
                    $tag2 = substr($block['title'], $start);
                }
            }
        }

        $and_uid = $tad_blocks_adm ? '' : "AND `uid`={$uid}";

        // 更新區塊設定
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_blocks') . '` SET `create_date`=NOW() WHERE `bid`=? ' . $and_uid;

        if (Utility::query($sql, 'i', [$bid])) {
            // 更新區塊
            $sql = 'UPDATE `' . $xoopsDB->prefix('newblocks') . '` SET `title`=?, `content`=?, `side`=?, `weight`=?, `last_modified`=? WHERE `bid`=?';
            Utility::query($sql, 'ssiiii', [$title . $tag2, $content, $side, $weight, $last_modified, $bid]) or Utility::web_error($sql);

            // 更新區塊顯示方式
            $sql = 'UPDATE `' . $xoopsDB->prefix('block_module_link') . '` SET `module_id`=? WHERE `block_id`=?';
            Utility::query($sql, 'ii', [$TDC['display'], $bid]) or Utility::web_error($sql);

            // 刪除區塊權限
            $sql = 'DELETE FROM `' . $xoopsDB->prefix('group_permission') . '` WHERE `gperm_itemid`=? AND `gperm_modid`=1 AND `gperm_name`=?';
            Utility::query($sql, 'is', [$bid, 'block_read']) or Utility::web_error($sql);

            // 更新區塊讀取權限
            foreach ($_POST['TDC']['groups'] as $group_id) {
                $sql = 'REPLACE INTO `' . $xoopsDB->prefix('group_permission') . '` (`gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES (?, ?, 1, ?)';
                Utility::query($sql, 'iis', [$group_id, $bid, 'block_read']) or Utility::web_error($sql);

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
    global $xoopsDB, $xoopsUser, $tad_blocks_adm;

    $module_dirname = 'tad_blocks';
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;

    $and_uid = $tad_blocks_adm ? '' : "AND `uid`={$uid}";

    // 刪除區塊設定
    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_blocks') . '` WHERE `bid`=? ' . $and_uid;

    if (Utility::query($sql, 'i', [$bid])) {

        $TadDataCenter = new TadDataCenter($module_dirname);
        $TadDataCenter->set_col('bid', $bid);
        $TadDataCenter->delData();

        // 刪除區塊
        $sql = 'DELETE FROM `' . $xoopsDB->prefix('newblocks') . '` WHERE `bid` = ?';
        Utility::query($sql, 'i', [$bid]) or Utility::web_error($sql);

        // 刪除區塊顯示方式
        $sql = 'DELETE FROM `' . $xoopsDB->prefix('block_module_link') . '` WHERE `block_id` = ?';
        Utility::query($sql, 'i', [$bid]) or Utility::web_error($sql);

        // 刪除區塊權限
        $sql = 'DELETE FROM `' . $xoopsDB->prefix('group_permission') . '` WHERE `gperm_itemid` = ? AND `gperm_modid` = 1 AND `gperm_name` = ?';
        Utility::query($sql, 'is', [$bid, 'block_read']) or Utility::web_error($sql);

    } else {
        Utility::web_error($sql);
    }

}

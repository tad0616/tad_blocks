<?php
use Xmf\Request;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
if (!$_SESSION['tad_blocks_adm']) {
    redirect_header('index.php', 3, _MD_TAD_BLOCKS_NO_PERMISSION);
}

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$bid = !empty($_REQUEST['pk']) ? Request::getInt('pk') : Request::getInt('bid');
$module_id = Request::getString('module_id');
$col = Request::getString('col');
$val = Request::getString('val');
$weight = Request::getInt('weight');
$side = Request::getInt('side');
$title = !empty($_REQUEST['value']) ? Request::getString('value') : Request::getString('title');
$tag = Request::getString('tag');
$link_url = Request::getString('link_url');

switch ($op) {

    case "update_newblock":
        update_newblock($bid, $side, $weight);
        exit;

    case "change_block_module_link":
        change_block_module_link($bid, $module_id);
        exit;

    case "change_newblock":
        change_newblock($bid, $col, $val);
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit;

    case "visible":
        change_newblock($bid, 'visible', 1);
        exit;

    case "invisible":
        change_newblock($bid, 'visible', 0);
        exit;

    case "update_title":
        update_title($bid, $title, $tag, $link_url);
        exit;

    case "setting_form":
        $form = setting_form($bid);
        die($form);

    case "echo":
        die("<img src='$val'>");

    case "save_sort":
        save_sort();
        exit;

}

/*-----------秀出結果區--------------*/

/*-----------功能函數區--------------*/

//列出所有區塊
function change_newblock($bid, $col, $val)
{
    global $xoopsDB;

    $sql = 'UPDATE `' . $xoopsDB->prefix('newblocks') . '` SET `' . $col . '`=? WHERE `bid`=?';
    if (Utility::query($sql, 'si', [$val, $bid])) {
        return;
    } else {
        die($sql);
    }
}

function update_newblock($bid, $side, $weight)
{
    global $xoopsDB;

    $sql = 'UPDATE `' . $xoopsDB->prefix('newblocks') . '` SET `side`=?, `weight`=? WHERE `bid`=?';
    if (!Utility::query($sql, 'iii', [$side, $weight, $bid])) {
        die($sql);
    } else {
        die("update $bid OK");
    }
}

//列出所有區塊
function change_block_module_link($bid, $module_id)
{
    global $xoopsDB;

    $sql = 'UPDATE `' . $xoopsDB->prefix('block_module_link') . '` SET `module_id`=? WHERE `block_id`=?';
    if (Utility::query($sql, 'ii', [$module_id, $bid])) {
        exit;
    } else {
        die($sql);
    }
}

function setting_form($bid)
{
    global $xoopsDB, $tags;

    $show_file = ['pic', 'img', 'icon'];
    $show_link = ['link'];
    $show_help = ['pic', 'img'];

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('newblocks') . '` WHERE `bid` = ?';
    $result = Utility::query($sql, 'i', [$bid]) or die($sql);

    $block = $xoopsDB->fetchArray($result);
    $save = _TAD_SAVE;

    $title = $block['title'];
    $display_link = $display_file = $display_help = 'style="display:none;"';
    $jquery = Utility::get_jquery(false, 'return');
    foreach ($tags as $tag) {
        $start = strpos($block['title'], "[$tag]");
        $selected_tag = "selected_{$tag}";
        if ($start !== false) {
            $title = substr($block['title'], 0, $start);
            $old_tag = "[$tag]";
            $$selected_tag = 'selected';
            $display_file = in_array($tag, $show_file) ? '' : $display_file;
            $display_link = in_array($tag, $show_link) ? '' : $display_link;
            $display_help = in_array($tag, $show_help) ? '' : $display_help;
        } else {
            $$selected_tag = '';
        }
    }

    $url = XOOPS_URL;
    $choose = _MD_TAD_BLOCKS_CHOOSE;
    $hide = _MD_TAD_BLOCKS_TITLE_HIDE;
    $pic = _MD_TAD_BLOCKS_TITLE_PIC;
    $img = _MD_TAD_BLOCKS_TITLE_IMG;
    $icon = _MD_TAD_BLOCKS_TITLE_ICON;
    $link = _MD_TAD_BLOCKS_TITLE_LINK;
    $upload = _MD_TAD_BLOCKS_UPLOAD_PIC;
    $help = _MD_TAD_BLOCKS_LOGO_HELP;

    $form = <<<"EOD"
$jquery
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/tad_blocks/css/module.css">

<h4>{$block['title']}</h4>
<form action="ajax.php" method="post" enctype="multipart/form-data">
    <input type="text" name="value" value="$title">
    <select name="tag" id="tag">
        <option value="" $selected>$choose</option>
        <option value="hide" $selected_hide>[hide]$hide</option>
        <option value="pic" $selected_pic>[pic]$pic</option>
        <option value="img" $selected_img>[img]$img</option>
        <option value="icon" $selected_icon>[icon]$icon</option>
        <option value="link" $selected_link>[link]$link</option>
    </select>
    <input type="text" name="link_url" id="link"  placeholder="http://" $display_link>
    <input type="file" name="tag2" id="file" placeholder="$upload" $display_file>
    <input type="hidden" name="bid" value="$bid">
    <button type="submit" name="op" value="update_title">$save</button>
    <div id="help" $display_help>$help</div>
</form>
<script>
$(document).ready(function(){
    $('#tag').change(function(){
        var tag=$('#tag').val();
        if(tag=='hide' || tag==''){
            $('#link').hide();
            $('#file').hide();
            $('#help').hide();
        }else if(tag=='icon'){
            $('#link').hide();
            $('#file').show();
            $('#help').hide();
        }else if(tag=='pic' || tag=='img'){
            $('#link').hide();
            $('#file').show();
            $('#help').show();
        }else if(tag=='link'){
            $('#link').show();
            $('#file').hide();
            $('#help').hide();
        }
    });
});
</script>
EOD;

    return $form;
}

function update_title($bid, $title = '', $need_tag = '', $link_url = '')
{

    $file_up = ['pic', 'img', 'icon'];
    $have_link = ['link'];
    $new_tag_url = '';
    // 圖片類的
    if (in_array($need_tag, $file_up)) {
        // 自行上傳的
        if ($_FILES['tag2']['name']) {
            $TadUpFiles = new TadUpFiles("tad_blocks");
            $TadUpFiles->set_col($need_tag, $bid);
            $files_sn = $TadUpFiles->upload_one_file($_FILES['tag2']['name'], $_FILES['tag2']['tmp_name'], $_FILES['tag2']['type'], $_FILES['tag2']['size'], null, null, null, null, true);
            $new_tag_url = $TadUpFiles->get_pic_file('images', 'url', $files_sn);
        } else {
            // 沒上傳，自動產生的
            $TadDataCenter = new TadDataCenter('tad_blocks');
            $TadDataCenter->set_col('block_logo', 0);
            $logo_setting = $TadDataCenter->getData();
            if ($logo_setting) {
                foreach ($logo_setting as $key => $value) {
                    $$key = $value[0];
                }
            }
            $new_tag_url = Utility::mkTitlePic('/uploads/bid', $bid, $title, $size, $border_size, $color, $border_color, $font_file_sn, $shadow_color, $shadow_x, $shadow_y, $shadow_size);
        }
    } elseif (in_array($need_tag, $have_link)) {
        // 連結類
        $new_tag_url = $link_url;
    }

    $new_title = $need_tag ? "{$title}[$need_tag]{$new_tag_url}" : $title;
    change_newblock($bid, 'title', $new_title);
    die($title);
}

function save_sort()
{
    global $xoopsDB;
    $bid = (int) $_POST['bid'];
    foreach ($_POST['col'] as $col) {
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_blocks_data_center') . '` SET `data_sort`= `data_sort` + 10000 WHERE `col_name`=? AND `col_sn`=? AND `data_name`=?';
        Utility::query($sql, 'sis', ['bid', $bid, $col]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')' . $sql);

    }

    $sort = 1;
    foreach ($_POST['form'] as $item) {
        $old_sort = (int) str_replace('data', '', $item) + 10000;
        foreach ($_POST['col'] as $col) {
            $sql = 'UPDATE `' . $xoopsDB->prefix('tad_blocks_data_center') . '` SET `data_sort`=? WHERE `col_name`=? AND `col_sn`=? AND `data_name`=? AND `data_sort`=?';
            Utility::query($sql, 'siisi', ['bid', $sort, $bid, $col, $old_sort]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')' . $sql);

        }
        $sort++;
    }
    die(_TAD_SORTED . "(" . date("Y-m-d H:i:s") . ")");
}

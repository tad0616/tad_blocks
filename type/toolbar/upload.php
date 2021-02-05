<?php
use XoopsModules\Tadtools\TadUpFiles;
if (!class_exists('XoopsModules\Tadtools\TadUpFiles')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

require_once '../../../../mainfile.php';
$TadUpFiles = new TadUpFiles('tad_blocks');

$op = isset($_POST['op']) ? $_POST['op'] : '';
$sort = isset($_POST['sort']) ? (int) $_POST['sort'] : 0;

$rand = mt_rand(0, 999999);
$TadUpFiles->set_col('toolbar', $rand, 1);

$files_sn = $TadUpFiles->upload_one_file($_FILES['img']['name'][$sort], $_FILES['img']['tmp_name'][$sort], $_FILES['img']['type'][$sort], $_FILES['img']['size'][$sort], 64, 32);

$img = $TadUpFiles->get_pic_file('images', 'url', $files_sn);

echo $img;

<?php
use Xmf\Request;
use XoopsModules\Tadtools\TadUpFiles;

require_once '../../../../mainfile.php';

$op = Request::getString('op');
$sort = Request::getInt('sort');

require_once '../../../../mainfile.php';
$TadUpFiles = new TadUpFiles('tad_blocks');

$rand = mt_rand(0, 999999);
$TadUpFiles->set_col('toolbar', $rand, 1);

$files_sn = $TadUpFiles->upload_one_file($_FILES['img']['name'][$sort], $_FILES['img']['tmp_name'][$sort], $_FILES['img']['type'][$sort], $_FILES['img']['size'][$sort], 64, 32);

$img = $TadUpFiles->get_pic_file('images', 'url', $files_sn);

echo $img;

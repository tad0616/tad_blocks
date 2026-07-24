<?php
use Xmf\Request;
use XoopsModules\Tadtools\TadUpFiles;

require_once '../../../../mainfile.php';

$sort = Request::getInt('sort');

$TadUpFiles = new TadUpFiles('tad_blocks');
$rand       = mt_rand(0, 999999);
$TadUpFiles->set_col('link', $rand, 1);

$files_sn = $TadUpFiles->upload_one_file($_FILES['img']['name'][$sort], $_FILES['img']['tmp_name'][$sort], $_FILES['img']['type'][$sort], $_FILES['img']['size'][$sort]);

$img = $TadUpFiles->get_pic_file('images', 'url', $files_sn);

echo $img;

<?php
use XoopsModules\Tadtools\TadUpFiles;

require_once '../../../../mainfile.php';
$TadUpFiles = new TadUpFiles('tad_blocks');

$rand = mt_rand(0, 999999);
$TadUpFiles->set_col('download', $rand, 1);

$files_sn = $TadUpFiles->upload_one_file($_FILES['file']['name'], $_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['size'], null, null, null, null, true);

$file = $TadUpFiles->get_pic_file('file', 'url', $files_sn);

echo $file;

<?php
use XoopsModules\Tadtools\TadUpFiles;

require_once '../../../../mainfile.php';
$TadUpFiles = new TadUpFiles('tad_blocks');

$rand = mt_rand(0, 999999);
$TadUpFiles->set_col('pdf', $rand, 1);

$files_sn = $TadUpFiles->upload_one_file($_FILES['pdf']['name'], $_FILES['pdf']['tmp_name'], $_FILES['pdf']['type'], $_FILES['pdf']['size'], null, null, null, null, true);

$pdf = $TadUpFiles->get_pic_file('file', 'url', $files_sn);

echo $pdf;

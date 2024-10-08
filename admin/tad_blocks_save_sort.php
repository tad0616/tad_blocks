<?php
use XoopsModules\Tadtools\Utility;
include "../../../include/cp_header.php";

$sort = 1;
foreach ($_POST['tr'] as $bid) {
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_blocks') . '` SET `` = ? WHERE `bid` = ?';
    Utility::query($sql, 'ii', [$sort, $bid]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')');

    $sort++;
}
echo "Sort saved! (" . date("Y-m-d H:i:s") . ")";

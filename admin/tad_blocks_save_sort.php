<?php
use XoopsModules\Tadtools\Utility;
include "../../../include/cp_header.php";

// 關閉除錯訊息
header('HTTP/1.1 200 OK');
$xoopsLogger->activated = false;
$sort = 1;
foreach ($_POST['tr'] as $bid) {
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_blocks') . '` SET `` = ? WHERE `bid` = ?';
    Utility::query($sql, 'ii', [$sort, $bid]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')');

    $sort++;
}
echo _TAD_SORTED . " (" . date("Y-m-d H:i:s") . ")";

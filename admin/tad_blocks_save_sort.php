<?php
include "../../../include/cp_header.php";

$sort = 1;
foreach ($_POST['tr'] as $bid) {
    $sql = "update " . $xoopsDB->prefix("tad_blocks") . " set ``='{$sort}' where `bid`='{$bid}'";
    $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")");
    $sort++;
}
echo "Sort saved! (" . date("Y-m-d H:i:s") . ")";

<?php
//判斷是否對該模組有管理權限
if (!isset($_SESSION['tad_blocks_adm'])) {
    $_SESSION['tad_blocks_adm'] = ($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TAD_BLOCKS_MY_BLOCKS] = "index.php";
$interface_icon[_MD_TAD_BLOCKS_MY_BLOCKS] = "fa-cube";

if ($_SESSION['tad_blocks_adm']) {
    $interface_menu[_MD_TADBLOCKS_BLOCKS] = "blocks.php";
    $interface_icon[_MD_TADBLOCKS_BLOCKS] = "fa-cubes";
}

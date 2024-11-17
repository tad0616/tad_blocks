<?php
//判斷是否對該模組有管理權限
if (!isset($tad_blocks_adm)) {
    $tad_blocks_adm = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TAD_BLOCKS_MY_BLOCKS] = "index.php";
$interface_icon[_MD_TAD_BLOCKS_MY_BLOCKS] = "fa-cube";

if ($tad_blocks_adm or $_SERVER['PHP_SELF'] == '/admin.php') {
    $interface_menu[_MD_TADBLOCKS_BLOCKS] = "blocks.php";
    $interface_icon[_MD_TADBLOCKS_BLOCKS] = "fa-cubes";
}

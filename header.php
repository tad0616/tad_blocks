<?php
/**
 * Tad Blocks module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Tad Blocks
 * @since      2.5
 * @author     tad
 * @version    $Id $
 **/

include_once "../../mainfile.php";
include_once "function.php";

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

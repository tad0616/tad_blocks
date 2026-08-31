<?php
use XoopsModules\Tad_blocks\Update;

if (!class_exists('XoopsModules\Tad_blocks\Update')) {
    require dirname(__DIR__) . '/preloads/autoloader.php';
}

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

function xoops_module_update_tad_blocks($module, $old_version)
{
    global $xoopsDB;

    // data_center 加入 sort
    $res1 = Update::fix_dc_sort();

    $res2 = Update::add_files_center_index();

    // 修改資料庫編碼為 utf8mb4_general_ci 並將引擎改為 InnoDB
    $res3 = Update::fix_innoDB_utf8mb4_general_ci();

    return $res1 && $res2 && $res3;
}

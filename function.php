<?php
use XoopsModules\Tadtools\Utility;
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

/********************* 自訂函數 *********************/
$position_arr = [
    0 => _MD_TAD_BLOCKS_LEFT,
    1 => _MD_TAD_BLOCKS_RIGHT,
    5 => _MD_TAD_BLOCKS_TOP_CENTER,
    3 => _MD_TAD_BLOCKS_TOP_LEFT,
    4 => _MD_TAD_BLOCKS_TOP_RIGHT,
    9 => _MD_TAD_BLOCKS_BOTTOM_CENTER,
    7 => _MD_TAD_BLOCKS_BOTTOM_LEFT,
    8 => _MD_TAD_BLOCKS_BOTTOM_RIGHT,
    10 => _MD_TAD_BLOCKS_FOOTER_LEFT,
    12 => _MD_TAD_BLOCKS_FOOTER_CENTER,
    11 => _MD_TAD_BLOCKS_FOOTER_RIGHT,
];

$type_arr[] = '一般圖文';

$dir = XOOPS_ROOT_PATH . "/modules/tad_blocks/type/";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (filetype($dir . $file) == 'dir' and substr($file, 0, 1) != '.') {
                require $dir . $file . '/config.php';
                $type_arr[$file] = $default['title'];
            }
        }
        closedir($dh);
    }
}

function dd($array = [])
{
    Utility::dd($array);
}

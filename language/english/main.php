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

xoops_loadLanguage('main', 'tadtools');
xoops_loadLanguage('admin/blocksadmin', 'system');
define('_TAD_NEED_TADTOOLS', "This module needs TadTools module. You can download TadTools from <a href='http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1' target='_blank'>XOOPS Easy Go</a>.");
define('_MD_TAD_BLOCKS_LEFT', 'Left');
define('_MD_TAD_BLOCKS_RIGHT', 'Right');
define('_MD_TAD_BLOCKS_TOP_CENTER', 'Upper');
define('_MD_TAD_BLOCKS_TOP_LEFT', 'Upper left');
define('_MD_TAD_BLOCKS_TOP_RIGHT', 'Upper Right');
define('_MD_TAD_BLOCKS_BOTTOM_CENTER', 'Under Middle');
define('_MD_TAD_BLOCKS_BOTTOM_LEFT', 'Bottom left');
define('_MD_TAD_BLOCKS_BOTTOM_RIGHT', 'Bottom right');
define('_MD_TAD_BLOCKS_FOOTER_LEFT', 'footer left');
define('_MD_TAD_BLOCKS_FOOTER_CENTER', 'footer in');
define('_MD_TAD_BLOCKS_FOOTER_RIGHT', 'footer right');
define('_MD_TAD_BLOCKS_SAVE', 'Save and create block');
define('_MD_TAD_ADD_ONE', 'Add a new item');
define('_MD_TAD_BLOCKS_MY_BLOCKS', 'My custom block');
define('_MD_TAD_BLOCKS_ADD_BLOCK', 'Add custom block');
define('_MD_TAD_BLOCKS_TITLE', 'Block title');
define('_MD_TAD_BLOCKS_TYPE', 'Block type');
define('_MD_TAD_BLOCKS_POSITION', 'Block location');
define('_MD_TAD_BLOCKS_DISPLAY', 'Display Type');
define('_MD_TAD_BLOCKS_ONLY_HOME', 'Home only');
define('_MD_TAD_BLOCKS_ALL_PAGES', 'All pages');
define('_MD_TAD_BLOCKS_MODIFY', 'Modify block:');
define('_MD_TAD_BLOCKS_NEW', 'Create a new block:');
define('_MD_TAD_BLOCKS_ADD_TITLE', 'Please enter the block title');
define('_MD_TAD_BLOCKS_SORT', 'Sort');
define('_MD_TAD_BLOCKS_WHO_CAN_SEE', 'Who can see?');
define('_MD_TAD_BLOCKS_NO_PERMISSION', "You don't have permission!");
define('_MD_TADBLOCKS_BLOCKS', 'Block Management');
define('_MD_TAD_BLOCKS_ONLY_VISIBLE', 'Only visible');
define('_MD_TAD_BLOCKS_TO_ENABLE', 'Enable this block');
define('_MD_TAD_BLOCKS_TO_UNABLE', 'Close the block');

$dir = XOOPS_ROOT_PATH . "/modules/tad_blocks/type/";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (filetype($dir . $file) == 'dir' and substr($file, 0, 1) != '.') {
                if (file_exists($dir . $file . '/english.php')) {
                    require $dir . $file . '/english.php';
                }
            }
        }
        closedir($dh);
    }
}

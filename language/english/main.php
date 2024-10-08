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

// xoops_loadLanguage('admin', 'tad_themes');
xoops_loadLanguage('main', 'tadtools');
xoops_loadLanguage('admin', 'system');
xoops_loadLanguage('admin/blocksadmin', 'system');
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
define('_MD_TAD_BLOCKS_SETTING', 'Fast setting');
define('_MD_TAD_ADD_ONE', 'Add a new item');
define('_MD_TAD_BLOCKS_MY_BLOCKS', 'My custom block');
define('_MD_TAD_BLOCKS_ADD_BLOCK', 'Add custom block');
define('_MD_TAD_BLOCKS_CUSTOM_BLOCK', 'Custom block');
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
define('_MD_TAD_BLOCKS_LOGO_DESIGN', 'Block title picture setting');
define('_MD_TAD_BLOCKS_LOGO_INPUT_TEXT', 'Enter text');
define('_MD_TAD_BLOCKS_LOGO_TEXT_COLOR', 'Text Color');
define('_MD_TAD_BLOCKS_LOGO_BORDER_COLOR', 'Border Color');
define('_MD_TAD_BLOCKS_LOGO_TEXT_SIZE', 'Text size');
define('_MD_TAD_BLOCKS_LOGO_BORDER_SIZE', 'outline size');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_COLOR', 'Shadow Color');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_SIZE', 'Shadow Size');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_X', 'Shadow X');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_Y', 'Shadow Y');
define('_MD_TAD_BLOCKS_LOGO_SELECT_FONT', 'Select font');
define('_MD_TAD_BLOCKS_LOGO_NEED_FONT', 'Please <a href="' . XOOPS_URL . '/modules/tad_themes/admin/font2pic.php">upload</a> at least one font');
define('_MD_TAD_BLOCKS_LOGO_MAKE_PNG', 'Save settings and generate title images for all blocks.');
define('_MD_TAD_BLOCKS_LOGO_SAVE_AS_LOGO', 'Save Picture');
define('_MD_TAD_BLOCKS_LOGO_DEMO_BGCOLOR', 'Example Background Color:');
define('_MD_TAD_BLOCKS_LOGO_HELP', 'If the file is not uploaded, the system will automatically generate the corresponding image according to the settings below.');
define('_MD_TAD_BLOCKS_CHOOSE', 'please choose');
define('_MD_TAD_BLOCKS_TITLE_HIDE', 'Hide title');
define('_MD_TAD_BLOCKS_TITLE_PIC', 'Generate a picture instead of a title');
define('_MD_TAD_BLOCKS_TITLE_IMG', 'Generate a picture to replace the title and apply the title format');
define('_MD_TAD_BLOCKS_TITLE_ICON', 'Put a small icon to the left of the text title');
define('_MD_TAD_BLOCKS_TITLE_LINK', 'Add title link');
define('_MD_TAD_BLOCKS_UPLOAD_PIC', 'Please upload image');
define('_MD_TAD_BLOCKS_WYSIWYG', 'CkEditor');
define('_MD_TAD_BLOCKS_OPEN_WIDTH_TB', 'Open edit with this module');
define('_MD_TAD_BLOCKS_ONLY', 'Only: ');
define('_MD_TAD_BLOCKS_CUSTOMIZED', 'Custom Blocks (HTML)');

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

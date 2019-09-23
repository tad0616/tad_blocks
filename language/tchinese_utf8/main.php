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

xoops_loadLanguage('admin', 'tad_themes');
xoops_loadLanguage('main', 'tadtools');
xoops_loadLanguage('admin/blocksadmin', 'system');
define('_TAD_NEED_TADTOOLS', '需要 tadtools 模組，可至<a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS輕鬆架</a>下載。');
define('_MD_TAD_BLOCKS_LEFT', '左');
define('_MD_TAD_BLOCKS_RIGHT', '右');
define('_MD_TAD_BLOCKS_TOP_CENTER', '上中');
define('_MD_TAD_BLOCKS_TOP_LEFT', '上左');
define('_MD_TAD_BLOCKS_TOP_RIGHT', '上右');
define('_MD_TAD_BLOCKS_BOTTOM_CENTER', '下中');
define('_MD_TAD_BLOCKS_BOTTOM_LEFT', '下左');
define('_MD_TAD_BLOCKS_BOTTOM_RIGHT', '下右');
define('_MD_TAD_BLOCKS_FOOTER_LEFT', '尾左');
define('_MD_TAD_BLOCKS_FOOTER_CENTER', '尾中');
define('_MD_TAD_BLOCKS_FOOTER_RIGHT', '尾右');
define('_MD_TAD_BLOCKS_SAVE', '儲存並建立區塊');
define('_MD_TAD_BLOCKS_SETTING', '快速設定');
define('_MD_TAD_ADD_ONE', '新增一組');
define('_MD_TAD_BLOCKS_MY_BLOCKS', '我的自訂區塊');
define('_MD_TAD_BLOCKS_ADD_BLOCK', '新增自訂區塊');
define('_MD_TAD_BLOCKS_TITLE', '區塊標題');
define('_MD_TAD_BLOCKS_TYPE', '區塊類型');
define('_MD_TAD_BLOCKS_POSITION', '區塊位置');
define('_MD_TAD_BLOCKS_DISPLAY', '顯示型態');
define('_MD_TAD_BLOCKS_ONLY_HOME', '僅首頁');
define('_MD_TAD_BLOCKS_ALL_PAGES', '全部頁面');
define('_MD_TAD_BLOCKS_MODIFY', '修改區塊：');
define('_MD_TAD_BLOCKS_NEW', '建立新區塊：');
define('_MD_TAD_BLOCKS_ADD_TITLE', '請輸入區塊標題');
define('_MD_TAD_BLOCKS_SORT', '排序');
define('_MD_TAD_BLOCKS_WHO_CAN_SEE', '誰可以看到');
define('_MD_TAD_BLOCKS_NO_PERMISSION', '您沒有權限喔！');
define('_MD_TADBLOCKS_BLOCKS', '區塊管理');
define('_MD_TAD_BLOCKS_ONLY_VISIBLE', '僅顯示啟用');
define('_MD_TAD_BLOCKS_TO_ENABLE', '關閉中，點擊啟用之');
define('_MD_TAD_BLOCKS_TO_UNABLE', '啟用中，點擊關閉之');
define('_MD_TAD_BLOCKS_TO_ONLY_HOME', '全部頁面，改為：僅首頁');
define('_MD_TAD_BLOCKS_TO_ALL_PAGES', '僅首頁，改為：全部頁面');
define('_MD_TAD_BLOCKS_LOGO_DESIGN', '區塊標題圖設定');
define('_MD_TAD_BLOCKS_LOGO_INPUT_TEXT', '輸入文字');
define('_MD_TAD_BLOCKS_LOGO_TEXT_COLOR', '文字顏色');
define('_MD_TAD_BLOCKS_LOGO_BORDER_COLOR', '邊框顏色');
define('_MD_TAD_BLOCKS_LOGO_TEXT_SIZE', '文字大小');
define('_MD_TAD_BLOCKS_LOGO_BORDER_SIZE', '外框粗細');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_COLOR', '陰影顏色');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_SIZE', '陰影大小');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_X', '陰影左右位置');
define('_MD_TAD_BLOCKS_LOGO_SHADOW_Y', '陰影上下位置');
define('_MD_TAD_BLOCKS_LOGO_SELECT_FONT', '選擇字型');
define('_MD_TAD_BLOCKS_LOGO_MAKE_PNG', '根據底下設定產生並套用所有區塊的標題圖片');
define('_MD_TAD_BLOCKS_LOGO_NEED_FONT', '請至少先上傳一個字型');
define('_MD_TAD_BLOCKS_LOGO_SAVE_PIC', '儲存圖片');
define('_MD_TAD_BLOCKS_LOGO_SAVE_AS_LOGO', '存為logo');
define('_MD_TAD_BLOCKS_LOGO_DEMO_BGCOLOR', '範例背景色：');
$dir = XOOPS_ROOT_PATH . "/modules/tad_blocks/type/";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (filetype($dir . $file) == 'dir' and substr($file, 0, 1) != '.') {
                if (file_exists($dir . $file . '/tchinese.php')) {
                    require $dir . $file . '/tchinese.php';
                }
            }
        }
        closedir($dh);
    }
}

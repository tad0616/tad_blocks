<?php
use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\TadUpFiles')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
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

$tags = ['hide', 'pic', 'img', 'link', 'icon'];
$type_arr[] = _MD_TAD_BLOCKS_WYSIWYG;

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

// tad_themes 的設定
function tad_themes_setup()
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig;
    $sql = 'SELECT `theme_id`, `theme_type`, `theme_width`, `lb_width`, `cb_width`, `rb_width`, `base_color`, `lb_color`, `cb_color`, `rb_color`, `font_color` FROM `' . $xoopsDB->prefix('tad_themes') . '` WHERE `theme_name`=?';
    $result = Utility::query($sql, 's', [$xoopsConfig['theme_set']]) or Utility::web_error($sql);

    list($theme_id, $theme_type, $theme_width, $lb_width, $cb_width, $rb_width, $base_color, $lb_color, $cb_color, $rb_color, $font_color) = $xoopsDB->fetchRow($result);

    $sql = 'SELECT `value` FROM `' . $xoopsDB->prefix('tad_themes_config2') . '` WHERE `theme_id`=? AND `name`=?';
    $result = Utility::query($sql, 'is', [$theme_id, 'footer_color']) or Utility::web_error($sql);

    list($footer_color) = $xoopsDB->fetchRow($result);

    $sql = 'SELECT `value` FROM `' . $xoopsDB->prefix('tad_themes_config2') . '` WHERE `theme_id` =? AND `name`=?';
    $result = Utility::query($sql, 'is', [$theme_id, 'footer_bgcolor']) or Utility::web_error($sql);

    list($footer_bgcolor) = $xoopsDB->fetchRow($result);

    if ($lb_width == 'auto') {
        $cw = round(($cb_width / $theme_width) * 100, 1);
        $lw = $rw = (100 - $cw) / 2;
    } else {
        $lw = round(($lb_width / $theme_width) * 100, 1);
        $cw = round(($cb_width / $theme_width) * 100, 1);
        $rw = round(($rb_width / $theme_width) * 100, 1);
    }
    $xoopsTpl->assign('lw', $lw);
    $xoopsTpl->assign('cw', $cw);
    $xoopsTpl->assign('rw', $rw);
    $xoopsTpl->assign('font_color', $font_color);
    $xoopsTpl->assign('base_color', $base_color);
    $xoopsTpl->assign('lb_color', $lb_color);
    $xoopsTpl->assign('cb_color', $cb_color);
    $xoopsTpl->assign('rb_color', $rb_color);
    $xoopsTpl->assign('footer_color', $footer_color);
    $xoopsTpl->assign('footer_bgcolor', $footer_bgcolor);
    $xoopsTpl->assign('theme_type', $theme_type);
}

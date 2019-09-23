<?php
use XoopsModules\Tadtools\TadUpFiles;
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

// 除錯
function dd($array = [])
{
    Utility::dd($array);
}

// tad_themes 的設定
function tad_themes_setup()
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsUser, $type_arr;
    $sql = "select theme_id,theme_type,theme_width,lb_width,cb_width,rb_width,base_color,lb_color,cb_color,rb_color,font_color from " . $xoopsDB->prefix("tad_themes") . " where theme_name='{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
    list($theme_id, $theme_type, $theme_width, $lb_width, $cb_width, $rb_width, $base_color, $lb_color, $cb_color, $rb_color, $font_color) = $xoopsDB->fetchRow($result);

    $sql = "select `value` from " . $xoopsDB->prefix("tad_themes_config2") . " where `theme_id`='{$theme_id}' and `name`='footer_color'";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
    list($footer_color) = $xoopsDB->fetchRow($result);

    $sql = "select `value` from " . $xoopsDB->prefix("tad_themes_config2") . " where `theme_id`='{$theme_id}' and `name`='footer_bgcolor'";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql);
    list($footer_bgcolor) = $xoopsDB->fetchRow($result);

    if ($lw == 'auto') {
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

//製作logo圖
function mkTitlePic($bid = '', $title = '', $size = 24, $border_size = 2, $color = '#00a3a8', $border_color = '#FFFFFF', $font_file_sn = 0, $shadow_color = '#000000', $shadow_x = 1, $shadow_y = 1, $shadow_size = 3, $echo = true)
{
    $TadUpFontFiles = new TadUpFiles('tad_themes', '/fonts');
    $TadUpFontFiles->set_col('logo_fonts', 0);
    $font = $TadUpFontFiles->get_file($font_file_sn);

    //找字數
    if (function_exists('mb_strlen')) {
        $n = mb_strlen($title);
    } else {
        $n = strlen($title) / 3;
    }

    if (empty($size)) {
        return;
    }

    $width = $size * 1.4 * $n;
    $height = $size * 2;

    $x = 2;
    $y = $size * 1.5;
    list($color_r, $color_g, $color_b) = sscanf($color, '#%02x%02x%02x');
    list($border_color_r, $border_color_g, $border_color_b) = sscanf($border_color, '#%02x%02x%02x');
    list($shadow_color_r, $shadow_color_g, $shadow_color_b) = sscanf($shadow_color, '#%02x%02x%02x');

    header('Content-type: image/png');
    $im = imagecreatetruecolor($width, $height);
    imagesavealpha($im, true);

    $trans_colour = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $trans_colour);

    $text_color = imagecolorallocate($im, $color_r, $color_g, $color_b);
    $text_border_color = imagecolorallocatealpha($im, $border_color_r, $border_color_g, $border_color_b, 50);
    $text_shadow_color = imagecolorallocatealpha($im, $shadow_color_r, $shadow_color_g, $shadow_color_b, 50);

    $gd = gd_info();
    if ($gd['JIS-mapped Japanese Font Support']) {
        $title = iconv('UTF-8', 'shift_jis', $title);
    }
    // die('shadow_size='.$shadow_size);
    // if ($shadow_size > 0) {
    $sx = $shadow_x > 0 ? $shadow_x + $border_size : $shadow_x - $border_size;
    $sy = $shadow_y > 0 ? $shadow_y + $border_size : $shadow_y - $border_size;

    imagettftextblur($im, $size, 0, $x + $sx, $y + $sy, $text_shadow_color, $font[$font_file_sn]['physical_file_path'], $title, $shadow_size);
    // }

    imagettftext($im, $size, 0, $x, $y, $text_color, $font[$font_file_sn]['physical_file_path'], $title);

    if ('transparent' !== $border_color) {
        imagettftextoutline($im, $size, 0, $x, $y, $text_color, $text_border_color, $font[$font_file_sn]['physical_file_path'], $title, $border_size);
    }

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/bid');
    imagepng($im, XOOPS_ROOT_PATH . "/uploads/bid/{$bid}.png");
    imagedestroy($im);

    if ($echo) {
        header("location: ajax.php?op=echo&val=" . XOOPS_URL . "/uploads/bid/{$bid}.png?date=" . time());
        return XOOPS_URL . "/uploads/bid/{$bid}.png";
    }
}

function imagettftextoutline(&$im, $size, $angle, $x, $y, &$col, &$outlinecol, $fontfile, $text, $width)
{
    // For every X pixel to the left and the right
    for ($xc = $x - abs($width); $xc <= $x + abs($width); $xc++) {
        // For every Y pixel to the top and the bottom
        for ($yc = $y - abs($width); $yc <= $y + abs($width); $yc++) {
            // Draw the text in the outline color
            $text1 = imagettftext($im, $size, $angle, $xc, $yc, $outlinecol, $fontfile, $text);
        }
    }
    // Draw the main text
    $text2 = imagettftext($im, $size, $angle, $x, $y, $col, $fontfile, $text);
}

function imagettftextblur(&$im, $size, $angle, $x, $y, $color, $fontfile, $text, $blur_intensity = 0, $blur_filter = IMG_FILTER_GAUSSIAN_BLUR)
{
    $blur_intensity = (int) $blur_intensity;
    // $blur_intensity needs to be an integer greater than zero; if it is not we
    // treat this function call identically to imagettftext
    if (is_int($blur_intensity) && $blur_intensity > 0) {
        // $return_array will be returned once all calculations are complete
        $return_array = [
            imagesx($im), // lower left, x coordinate
            -1, // lower left, y coordinate
            -1, // lower right, x coordinate
            -1, // lower right, y coordinate
            -1, // upper right, x coordinate
            imagesy($im), // upper right, y coordinate
            imagesx($im), // upper left, x coordinate
            imagesy($im), // upper left, y coordinate
        ];
        // $temporary_image is a GD image that is the same size as our
        // original GD image
        $temporary_image = imagecreatetruecolor(
            imagesx($im),
            imagesy($im)
        );
        // fill $temporary_image with a black background
        imagefill(
            $temporary_image,
            0,
            0,
            imagecolorallocate($temporary_image, 0x00, 0x00, 0x00)
        );
        // add white text to $temporary_image with the function call's
        // parameters
        imagettftext(
            $temporary_image,
            $size,
            $angle,
            $x,
            $y,
            imagecolorallocate($temporary_image, 0xFF, 0xFF, 0xFF),
            $fontfile,
            $text
        );
        // execute the blur filters
        for ($blur = 1; $blur <= $blur_intensity; $blur++) {
            imagefilter($temporary_image, $blur_filter);
        }
        // set $color_opacity based on $color's transparency
        $color_opacity = imagecolorsforindex($im, $color)['alpha'];
        $color_opacity = (127 - $color_opacity) / 127;
        // loop through each pixel in $temporary_image
        for ($_x = 0; $_x < imagesx($temporary_image); $_x++) {
            for ($_y = 0; $_y < imagesy($temporary_image); $_y++) {
                // $visibility is the grayscale of the current pixel multiplied
                // by $color_opacity
                $visibility = (imagecolorat(
                    $temporary_image,
                    $_x,
                    $_y
                ) & 0xFF) / 255 * $color_opacity;
                // if the current pixel would not be invisible then add it to
                // $im
                if ($visibility > 0) {
                    // we know we are on an affected pixel so ensure
                    // $return_array is updated accordingly
                    $return_array[0] = min($return_array[0], $_x);
                    $return_array[1] = max($return_array[1], $_y);
                    $return_array[2] = max($return_array[2], $_x);
                    $return_array[3] = max($return_array[3], $_y);
                    $return_array[4] = max($return_array[4], $_x);
                    $return_array[5] = min($return_array[5], $_y);
                    $return_array[6] = min($return_array[6], $_x);
                    $return_array[7] = min($return_array[7], $_y);
                    // set the current pixel in $im
                    imagesetpixel(
                        $im,
                        $_x,
                        $_y,
                        imagecolorallocatealpha(
                            $im,
                            ($color >> 16) & 0xFF,
                            ($color >> 8) & 0xFF,
                            $color & 0xFF,
                            (1 - $visibility) * 127
                        )
                    );
                }
            }
        }
        // destroy our $temporary_image
        imagedestroy($temporary_image);
        return $return_array;
    } else {
        return imagettftext(
            $im,
            $size,
            $angle,
            $x,
            $y,
            $color,
            $fontfile,
            $text
        );
    }
}

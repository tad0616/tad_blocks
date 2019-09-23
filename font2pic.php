<?php
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\MColorPicker;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_themes_adm_font2pic.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

$TadUpFontFiles = new TadUpFiles('tad_themes', '/fonts');
$TadUpFontFiles->set_col('logo_fonts', 0);
/*-----------function區--------------*/
function tad_themes_logo_form()
{
    global $TadUpFontFiles, $xoopsTpl;

    if (isset($_SESSION['font_config'])) {
        $fc = json_decode($_SESSION['font_config'], true);
    }

    $pic = isset($_GET['name']) ? XOOPS_URL . "/uploads/tmp_logo/{$_GET['name']}.png" : '';

    $xoopsTpl->assign('pic', $pic);

    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $xoopsTpl->assign('name', $name);

    $title = isset($fc['title']) ? $fc['title'] : '';
    $xoopsTpl->assign('title', $title);

    $size = isset($fc['size']) ? $fc['size'] : '16';
    $xoopsTpl->assign('size', $size);

    $border_size = isset($fc['border_size']) ? $fc['border_size'] : '2';
    $xoopsTpl->assign('border_size', $border_size);

    $color = isset($fc['color']) ? $fc['color'] : '#00a3a8';
    $color = str_replace('#', '', $color);
    $xoopsTpl->assign('color', $color);

    $border_color = isset($fc['border_color']) ? $fc['border_color'] : '#ffffff';
    $border_color = str_replace('#', '', $border_color);
    $xoopsTpl->assign('border_color', $border_color);

    $font_file_sn = isset($fc['font_file_sn']) ? $fc['font_file_sn'] : 0;
    $xoopsTpl->assign('font_file_sn', $font_file_sn);

    $bg_color = !empty($fc['bg_color']) ? $fc['bg_color'] : '#3c3c3c';
    $xoopsTpl->assign('bg_color', $bg_color);

    $shadow_color = !empty($fc['shadow_color']) ? $fc['shadow_color'] : '#000000';
    $shadow_color = str_replace('#', '', $shadow_color);
    $xoopsTpl->assign('shadow_color', $shadow_color);

    $shadow_x = isset($fc['shadow_x']) ? $fc['shadow_x'] : '1';
    $xoopsTpl->assign('shadow_x', $shadow_x);

    $shadow_y = isset($fc['shadow_y']) ? $fc['shadow_y'] : '1';
    $xoopsTpl->assign('shadow_y', $shadow_y);

    $shadow_size = isset($fc['shadow_size']) ? $fc['shadow_size'] : '3';
    $xoopsTpl->assign('shadow_size', $shadow_size);

    $fontUpForm = $TadUpFontFiles->upform(true, 'font');
    $xoopsTpl->assign('fontUpForm', $fontUpForm);

    $fonts = $TadUpFontFiles->get_file();
    $xoopsTpl->assign('fonts', $fonts);

    $MColorPicker = new MColorPicker('.color');
    $MColorPicker->render();

    $dir   = XOOPS_ROOT_PATH . '/uploads/logo/';
    $logos = [];
    // Open a known directory, and proceed to read its contents
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (false !== ($file = readdir($dh))) {
                if (false !== mb_strpos($file, '.png')) {
                    $logos[] = $file;
                }
            }
            closedir($dh);
        }
    }
    arsort($logos);
    $xoopsTpl->assign('logos', $logos);

    $SweetAlert = new SweetAlert();
    $SweetAlert->render('del_logo', 'font2pic.php?op=del_logo&logo=', 'logo');

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();
}

function strLength($str, $charset = 'utf-8')
{
    if ($charset === 'utf-8') {
        $str = iconv('utf-8', 'big5', $str);
    }

    $num   = strlen($str);
    $cnNum = 0;
    for ($i = 0; $i < $num; $i++) {
        if (ord(substr($str, $i, 1)) > 127) {
            $cnNum++;
        }
    }
    $enNum  = $num - ($cnNum * 2);
    $number = ($enNum / 2) + $cnNum;
    return ceil($number);
}



function delete_dirfile($dirname)
{
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    }

    if (!$dir_handle) {
        return false;
    }

    while ($file = readdir($dir_handle)) {
        if ('.' !== $file && '..' !== $file) {
            if (!is_dir($dirname . '/' . $file)) {
                unlink($dirname . '/' . $file);
            } else {
                delete_dirfile($dirname . '/' . $file);
            }
        }
    }
    closedir($dir_handle);

    return true;
}

function save_to_logo($name = '')
{
    global $xoopsConfig, $xoopsDB;
    $theme_id = get_theme_id($xoopsConfig['theme_set']);
    import_file(XOOPS_ROOT_PATH . "/uploads/tmp_logo/{$name}.png", 'logo', $theme_id);
    $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set logo_img='" . XOOPS_URL . "/uploads/tad_themes/{$xoopsConfig['theme_set']}/logo/{$name}.png' where theme_id='{$theme_id}'";
    $xoopsDB->queryF($sql);
    delete_dirfile(XOOPS_ROOT_PATH . '/uploads/tmp_logo');
}

/*-----------執行動作判斷區----------*/
require_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op           = system_CleanVars($_REQUEST, 'op', '', 'string');
$theme_id     = system_CleanVars($_REQUEST, 'theme_id', 0, 'int');
$files_sn     = system_CleanVars($_REQUEST, 'files_sn', 0, 'int');
$title        = system_CleanVars($_REQUEST, 'title', '', 'string');
$size         = system_CleanVars($_REQUEST, 'size', 24, 'int');
$color        = system_CleanVars($_REQUEST, 'color', '#00a3a8', 'string');
$border_color = system_CleanVars($_REQUEST, 'border_color', '#ffffff', 'string');
$font_file_sn = system_CleanVars($_REQUEST, 'font_file_sn', 0, 'int');
$border_size  = system_CleanVars($_REQUEST, 'border_size', 2, 'int');
$name         = system_CleanVars($_REQUEST, 'name', '', 'string');
$bg_color     = system_CleanVars($_REQUEST, 'bg_color', '', 'string');
$logo         = system_CleanVars($_REQUEST, 'logo', '', 'string');
$sav_to_logo  = system_CleanVars($_REQUEST, 'sav_to_logo', 0, 'int');
$shadow_color = system_CleanVars($_REQUEST, 'shadow_color', '#000000', 'string');
$shadow_x     = system_CleanVars($_REQUEST, 'shadow_x', 1, 'int');
$shadow_y     = system_CleanVars($_REQUEST, 'shadow_y', 1, 'int');
$shadow_size  = system_CleanVars($_REQUEST, 'shadow_size', 3, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    case 'del_logo':
        unlink(XOOPS_ROOT_PATH . "/uploads/logo/{$logo}");
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    case 'save_pic':
        Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/logo');
        if ($sav_to_logo == 1) {
            save_to_logo($name);
            header("location: main.php#themeTab4");
        } else {
            copy(XOOPS_ROOT_PATH . "/uploads/tmp_logo/{$name}.png", XOOPS_ROOT_PATH . "/uploads/logo/{$name}.png");
            delete_dirfile(XOOPS_ROOT_PATH . '/uploads/tmp_logo');
            header("location: font2pic.php");
        }
        exit;

    case 'save_font':
        $TadUpFontFiles->upload_file('font', null, null, $files_sn, null, true);
        header("location: " . \Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'));
        exit;


    //預設動作
    default:
        tad_themes_logo_form();
        $op = 'tad_themes_logo_form';
        break;
        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_themes/css/module.css');
require_once __DIR__ . '/footer.php';

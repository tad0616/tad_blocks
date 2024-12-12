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

$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_TADBLOCKS_NAME;
$modversion['version'] = $_SESSION['xoops_version'] >= 20511 ? '3.0.0-Stable' : '3.0';
// $modversion['version'] = '2.6';
$modversion['description'] = _MI_TADBLOCKS_DESC;
$modversion['author'] = _MI_TADBLOCKS_AUTHOR;
$modversion['credits'] = _MI_TADBLOCKS_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GPL see LICENSE';
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2024-12-12';
$modversion['module_website_url'] = 'https://www.tad0616.net';
$modversion['module_website_name'] = _MI_TADBLOCKS_AUTHOR_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://www.tad0616.net';
$modversion['author_website_name'] = _MI_TADBLOCKS_AUTHOR_WEB;
$modversion['min_php'] = '5.4';
$modversion['min_xoops'] = '2.5.10';

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---安裝設定---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'] = [
    "tad_blocks_files_center",
    "tad_blocks_data_center",
    "tad_blocks",
];

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---後台管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/main.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---//
$modversion['templates'] = [
    ['file' => 'tad_blocks_adm_main.tpl', 'description' => 'tad_blocks_adm_main.tpl'],
    ['file' => 'tad_blocks_index.tpl', 'description' => 'tad_blocks_index.tpl'],
];

//---偏好設定---//
$modversion['config'] = [
    [
        'name' => 'show_save_and_re_build_logo',
        'title' => '_MI_TADBLOCKS_SHOW_BUILD_LOGO',
        'description' => '_MI_TADBLOCKS_SHOW_BUILD_LOGO_DESC',
        'formtype' => 'yesno',
        'valuetype' => 'int',
        'default' => 0,
    ],
];

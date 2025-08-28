<?php
namespace XoopsModules\Tad_blocks;

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

/**
 * Class Update
 */
class Update
{
    public static function add_files_center_index()
    {
        global $xoopsDB;

        $table = $xoopsDB->prefix('tad_blocks_files_center');

        // 1. 檢查欄位長度
        $sql = "SELECT CHARACTER_MAXIMUM_LENGTH
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = '{$table}'
            AND COLUMN_NAME = 'col_name'";
        $result       = $xoopsDB->queryF($sql);
        list($length) = $xoopsDB->fetchRow($result);

        if ($length > 100) {
            $alter = "ALTER TABLE `{$table}`
                CHANGE `col_name` `col_name` VARCHAR(100)
                NOT NULL DEFAULT ''
                COMMENT '欄位名稱' AFTER `files_sn`";
            if (!$xoopsDB->queryF($alter)) {
                return false;
            }
        }

        // 2. 檢查索引是否存在
        $sql    = "SHOW INDEX FROM `{$table}` WHERE Key_name = 'col_name_col_sn'";
        $result = $xoopsDB->queryF($sql);
        if ($xoopsDB->getRowsNum($result) == 0) {
            $alter = "ALTER TABLE `{$table}`
                ADD INDEX `col_name_col_sn` (`col_name`, `col_sn`)";
            if (!$xoopsDB->queryF($alter)) {
                return false;
            }
        }
        return true;
    }

    //data_center 加入 sort
    public static function chk_dc_sort()
    {
        global $xoopsDB;
        $sql    = 'select count(`sort`) from ' . $xoopsDB->prefix('tad_blocks_data_center');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    public static function go_dc_sort()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_blocks_data_center') . " ADD `sort` mediumint(9) unsigned COMMENT '顯示順序' after `col_id`";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_blocks/admin/index.php', 30, $xoopsDB->error());
    }

}

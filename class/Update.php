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

    // 修改 tad_blocks_files_center、tad_blocks_data_center、tad_blocks 資料表編碼為 utf8mb4_general_ci 並將引擎改為 InnoDB
    public static function fix_innoDB_utf8mb4_general_ci()
    {
        global $xoopsDB;

        $tables = [
            $xoopsDB->prefix('tad_blocks_files_center'),
            $xoopsDB->prefix('tad_blocks_data_center'),
            $xoopsDB->prefix('tad_blocks'),
        ];

        foreach ($tables as $table) {

            // 檢查資料表是否存在
            $check  = "SHOW TABLES LIKE '{$table}'";
            $result = $xoopsDB->queryF($check);
            if ($xoopsDB->getRowsNum($result) === 0) {
                continue;
            }

            // 檢查目前的引擎與編碼
            $sql = "SELECT ENGINE, TABLE_COLLATION
                    FROM INFORMATION_SCHEMA.TABLES
                    WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = '{$table}'";
            $result                   = $xoopsDB->queryF($sql);
            list($engine, $collation) = $xoopsDB->fetchRow($result);

            // 引擎已是 InnoDB 且編碼已是 utf8mb4_general_ci，則跳過
            if (strtolower($engine) === 'innodb' && $collation === 'utf8mb4_general_ci') {
                continue;
            }

            // 同時轉換字元集、定序並變更引擎
            $alter = "ALTER TABLE `{$table}`
                    CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
                    ENGINE = InnoDB";
            if (!$xoopsDB->queryF($alter)) {
                return false;
            }
        }

        return true;
    }

    public static function add_files_center_index()
    {
        global $xoopsDB;

        $table = $xoopsDB->prefix('tad_blocks_files_center');

        // 1. 檢查 col_name 欄位長度
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

        // 2. 檢查 col_sn 欄位長度
        $sql = "SELECT CHARACTER_MAXIMUM_LENGTH
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = '{$table}'
            AND COLUMN_NAME = 'col_sn'";
        $result       = $xoopsDB->queryF($sql);
        list($length) = $xoopsDB->fetchRow($result);

        if ($length > 100) {
            $alter = "ALTER TABLE `{$table}`
                CHANGE `col_sn` `col_sn` VARCHAR(100)
                NOT NULL DEFAULT ''
                COMMENT '欄位序號' AFTER `col_name`";
            if (!$xoopsDB->queryF($alter)) {
                return false;
            }
        }

        // 3. 檢查索引是否存在
        $sql    = "SHOW INDEX FROM `{$table}` WHERE Key_name = 'col_name_col_sn'";
        $result = $xoopsDB->queryF($sql);
        if ($xoopsDB->getRowsNum($result) == 0) {
            $alter = "ALTER TABLE `{$table}`
                ADD INDEX `col_name_col_sn` (`col_name`, `col_sn`)";
            if (!$xoopsDB->queryF($alter)) {
                return false;
            }
        }
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

    // data_center 加入 sort
    public static function fix_dc_sort()
    {
        global $xoopsDB;

        $table = $xoopsDB->prefix('tad_blocks_data_center');

        // 檢查 sort 欄位是否已存在
        $sql = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = '{$table}'
                AND COLUMN_NAME = 'sort'";
        $result      = $xoopsDB->queryF($sql);
        list($count) = $xoopsDB->fetchRow($result);

        // 不存在才新增欄位
        if ($count == 0) {
            $alter = "ALTER TABLE `{$table}` ADD `sort` mediumint(9) unsigned COMMENT '顯示順序' AFTER `col_id`";
            if (!$xoopsDB->queryF($alter)) {
                redirect_header(XOOPS_URL . '/modules/tad_blocks/admin/index.php', 30, $xoopsDB->error());
                return false;
            }
        }

        return true;
    }
}

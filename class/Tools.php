<?php
namespace XoopsModules\Tad_blocks;

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

/**
 * Class Tools
 */
class Tools
{
    public static function update_newblock($bid, $side, $weight)
    {
        global $xoopsDB;

        $sql = 'UPDATE `' . $xoopsDB->prefix('newblocks') . '` SET `side`=?, `weight`=? WHERE `bid`=?';
        if (!Utility::query($sql, 'iii', [$side, $weight, $bid])) {
            die($sql);
        } else {
            die("update $bid OK");
        }
    }

    //修改block_module_link
    public static function change_block_module_link($bid, $module_id)
    {
        global $xoopsDB;

        $sql = 'UPDATE `' . $xoopsDB->prefix('block_module_link') . '` SET `module_id`=? WHERE `block_id`=?';
        if (Utility::query($sql, 'ii', [$module_id, $bid])) {
            exit;
        } else {
            die($sql);
        }
    }

    //修改區塊
    public static function change_newblock($bid, $col, $val)
    {
        global $xoopsDB;

        $col = Utility::check_string($col);
        $val = $xoopsDB->escape($val);

        $sql = 'UPDATE `' . $xoopsDB->prefix('newblocks') . '` SET `' . $col . '`=? WHERE `bid`=?';
        if (Utility::query($sql, 'si', [$val, $bid])) {
            return;
        } else {
            die('UPDATE error');
        }
    }

}

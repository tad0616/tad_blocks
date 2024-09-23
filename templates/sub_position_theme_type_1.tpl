<table id="block-position" style="background: <{$base_color|default:''}>; color:<{$font_color|default:''}>;">
    <tr>
        <td rowspan=2 style="width: <{$lw|default:''}>%; background: <{$lb_color|default:''}>;">
            <!-- 左 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_0.tpl"}>
        </td>
        <td colspan=2 style="width: <{$cw|default:''}>%; background: <{$cb_color|default:''}>;">
            <!-- 上中 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_5.tpl"}>
        </td>
    </tr>
    <tr>
        <td>
            <!-- 上中左 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_3.tpl"}>
        </td>
        <td>
            <!-- 上中右 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_4.tpl"}>
        </td>
    </tr>
    <tr>
        <td rowspan=2 style="background: <{$lb_color|default:''}>;">
            <!-- 右 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_1.tpl"}>
        </td>
        <td colspan=2 style="background: <{$cb_color|default:''}>;">
            <!-- 下中 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_9.tpl"}>
        </td>
    </tr>
    <tr>
        <td style="background: <{$cb_color|default:''}>;">
            <!-- 下中左 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_7.tpl"}>
        </td>
        <td style="background: <{$cb_color|default:''}>;">
            <!-- 下中右 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_8.tpl"}>
        </td>
    </tr>
    <tr>
        <td style="background: <{$footer_bgcolor|default:''}>; color: <{$footer_color|default:''}>;">
            <!-- 頁尾左 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_10.tpl"}>
        </td>
        <td style="background: <{$footer_bgcolor|default:''}>; color: <{$footer_color|default:''}>;">
            <!-- 頁尾中 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_12.tpl"}>
        </td>
        <td style="background: <{$footer_bgcolor|default:''}>; color: <{$footer_color|default:''}>;">
            <!-- 頁尾右 -->
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/radio_side_11.tpl"}>
        </td>
    </tr>
</table>
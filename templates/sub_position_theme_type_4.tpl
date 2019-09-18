<table id="block-position" style="background: <{$base_color}>; color:<{$font_color}>;">
    <tr>
        <td colspan=2 style="width: <{$cw}>%; background: <{$cb_color}>;">
            <!-- 上中 -->
            <label for="side_5">
                <input type="radio" name="TDC[side]" id="side_5" value="5" <{if $side==5}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_TOP_CENTER}>
            </label>
        </td>
        <td rowspan=4 style="width: <{$lw}>%; background: <{$lb_color}>;">
            <!-- 左 -->
            <label for="side_0">
                <input type="radio" name="TDC[side]" id="side_0" value="0" <{if $side==0}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_LEFT}>
            </label>
        </td>
    </tr>
    <tr>
        <td>
            <!-- 上中左 -->
            <label for="side_3" style="background: <{$cb_color}>;">
                <input type="radio" name="TDC[side]" id="side_3" value="3" <{if $side==3}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_TOP_LEFT}>
            </label>
        </td>
        <td>
            <!-- 上中右 -->
            <label for="side_4" style="background: <{$cb_color}>;">
                <input type="radio" name="TDC[side]" id="side_4" value="4" <{if $side==4}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_TOP_RIGHT}>
            </label>
        </td>
    </tr>
    <tr>
        <td colspan=2 style="background: <{$cb_color}>;">
            <!-- 下中 -->
            <label for="side_9">
                <input type="radio" name="TDC[side]" id="side_9" value="9" <{if $side==9}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_BOTTOM_CENTER}>
            </label>
        </td>
    </tr>
    <tr>
        <td style="background: <{$cb_color}>;">
            <!-- 下中左 -->
            <label for="side_7">
                <input type="radio" name="TDC[side]" id="side_7" value="7" <{if $side==7}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_BOTTOM_LEFT}>
            </label>
        </td>
        <td style="background: <{$cb_color}>;">
            <!-- 下中右 -->
            <label for="side_8">
                <input type="radio" name="TDC[side]" id="side_8" value="8" <{if $side==8}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_BOTTOM_RIGHT}>
            </label>
        </td>
    </tr>
    <tr>
        <td colspan=3 style="background: <{$rb_color}>;">
            <!-- 右 -->
            <label for="side_1">
                <input type="radio" name="TDC[side]" id="side_1" value="1" <{if $side==1}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_RIGHT}>
            </label>
        </td>
    </tr>
    <tr>
        <td style="background: <{$footer_bgcolor}>; color: <{$footer_color}>;">
            <!-- 頁尾左 -->
            <label for="side_10">
                <input type="radio" name="TDC[side]" id="side_10" value="10" <{if $side==10}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_FOOTER_LEFT}>
            </label>
        </td>
        <td style="background: <{$footer_bgcolor}>; color: <{$footer_color}>;">
            <!-- 頁尾中 -->
            <label for="side_12">
                <input type="radio" name="TDC[side]" id="side_12" value="12" <{if $side==12}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_FOOTER_CENTER}>
            </label>
        </td>
        <td style="background: <{$footer_bgcolor}>; color: <{$footer_color}>;">
            <!-- 頁尾右 -->
            <label for="side_11">
                <input type="radio" name="TDC[side]" id="side_11" value="11" <{if $side==11}>checked<{/if}>>
                <{$smarty.const._MD_TAD_BLOCKS_FOOTER_RIGHT}>
            </label>
        </td>
    </tr>
</table>
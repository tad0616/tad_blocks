<!-- 下中左 -->
<{if $all_blocks|default:false}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_BOTTOM_LEFT}></h4>
    <div class="droppable" id="side-7" data-side="7">
        <{foreach from=$all_blocks.7 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_7">
        <input type="radio" name="TDC[side]" id="side_7" value="7" <{if $side==7}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_BOTTOM_LEFT}></span>
    </label>
<{/if}>
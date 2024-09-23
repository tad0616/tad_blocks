<!-- 下中 -->
<{if $all_blocks.9|default:false}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_BOTTOM_CENTER}></h4>
    <div class="droppable" id="side-9" data-side="9">
        <{foreach from=$all_blocks.9 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_9">
        <input type="radio" name="TDC[side]" id="side_9" value="9" <{if $side|default:''==9}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_BOTTOM_CENTER}></span>
    </label>
<{/if}>
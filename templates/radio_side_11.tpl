<!-- 頁尾右 -->
<{if $all_blocks}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_FOOTER_RIGHT}></h4>
    <div class="droppable" id="side-11" data-side="11">
        <{foreach from=$all_blocks.11 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_11">
        <input type="radio" name="TDC[side]" id="side_11" value="11" <{if $side==11}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_FOOTER_RIGHT}></span>
    </label>
<{/if}>
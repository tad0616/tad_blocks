<!-- 右 -->
<{if $all_blocks}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_RIGHT}></h4>
    <div class="droppable" id="side-1" data-side="1">
        <{foreach from=$all_blocks.1 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_1">
        <input type="radio" name="TDC[side]" id="side_1" value="1" <{if $side==1}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_RIGHT}></span>
    </label>
<{/if}>
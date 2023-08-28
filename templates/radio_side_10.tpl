<!-- 頁尾左 -->
<{if $all_blocks}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_FOOTER_LEFT}></h4>
    <div class="droppable" id="side-10" data-side="10">
        <{foreach from=$all_blocks.10 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_10">
        <input type="radio" name="TDC[side]" id="side_10" value="10" <{if $side==10}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_FOOTER_LEFT}></span>
    </label>
<{/if}>
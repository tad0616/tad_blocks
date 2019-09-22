<!-- 左 -->
<{if $all_blocks}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_LEFT}></h4>
    <div class="droppable" id="side-0" data-side="0">
        <{foreach from=$all_blocks.0 item=b}>
            <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_0">
        <input type="radio" name="TDC[side]" id="side_0" value="0" <{if $side==0}>checked<{/if}>>
        <{$smarty.const._MD_TAD_BLOCKS_LEFT}>
    </label>
<{/if}>
<!-- 下中左 -->
<{if $all_blocks}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_BOTTOM_LEFT}></h4>
    <div class="droppable" id="side-7" data-side="7">
        <{foreach from=$all_blocks.7 item=b}>
            <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_7">
        <input type="radio" name="TDC[side]" id="side_7" value="7" <{if $side==7}>checked<{/if}>>
        <{$smarty.const._MD_TAD_BLOCKS_BOTTOM_LEFT}>
    </label>
<{/if}>
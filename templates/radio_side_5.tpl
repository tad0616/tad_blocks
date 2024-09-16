<!-- 上中 -->
<{if $all_blocks|default:false}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_TOP_CENTER}></h4>
    <div class="droppable" id="side-5" data-side="5">
        <{foreach from=$all_blocks.5 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_5">
        <input type="radio" name="TDC[side]" id="side_5" value="5" <{if $side==5}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_TOP_CENTER}></span>
    </label>
<{/if}>
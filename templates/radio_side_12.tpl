<!-- 頁尾中 -->
<{if $all_blocks.12|default:false}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_FOOTER_CENTER}></h4>
    <div class="droppable" id="side-12" data-side="12">
        <{foreach from=$all_blocks.12 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_12">
        <input type="radio" name="TDC[side]" id="side_12" value="12" <{if $side|default:''==12}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_FOOTER_CENTER}></span>
    </label>
<{/if}>
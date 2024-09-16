<!-- 下中右 -->
<{if $all_blocks|default:false}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_BOTTOM_RIGHT}></h4>
    <div class="droppable" id="side-8" data-side="8">
        <{foreach from=$all_blocks.8 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_8">
        <input type="radio" name="TDC[side]" id="side_8" value="8" <{if $side==8}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_BOTTOM_RIGHT}></sapn>
    </label>
<{/if}>
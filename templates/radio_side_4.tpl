<!-- 上中右 -->
<{if $all_blocks.4|default:false || $smarty.get.op|default:''!='block_form'}>
    <h4 class="block_side"><{$smarty.const._MD_TAD_BLOCKS_TOP_RIGHT}></h4>
    <div class="droppable" id="side-4" data-side="4">
        <{foreach from=$all_blocks.4 item=b}>
            <{include file="$xoops_rootpath/modules/tad_blocks/templates/block_tool.tpl"}>
        <{/foreach}>
    </div>
<{else}>
    <label for="side_4" style="background: <{$cb_color|default:''}>;">
        <input type="radio" name="TDC[side]" id="side_4" value="4" <{if $side|default:''==4}>checked<{/if}>>
        <span class="position_title"><{$smarty.const._MD_TAD_BLOCKS_TOP_RIGHT}></span>
    </label>
<{/if}>
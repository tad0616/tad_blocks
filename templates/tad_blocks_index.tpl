<{$toolbar|default:''}>
<{$Bootstrap3EditableCode|default:''}>
<h2 style="display:none;"><{$smarty.const._MD_TADBLOCKS_BLOCKS}></h2>
<{if $now_op|default:false}>
    <{include file="$xoops_rootpath/modules/tad_blocks/templates/op_`$now_op`.tpl"}>
<{/if}>
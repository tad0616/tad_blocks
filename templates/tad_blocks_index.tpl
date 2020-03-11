<{$toolbar}>
<h2 style="display:none;"><{$smarty.const._MD_TADBLOCKS_BLOCKS}></h2>
<{if $now_op}>
    <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/op_`$now_op`.tpl"}>
<{/if}>
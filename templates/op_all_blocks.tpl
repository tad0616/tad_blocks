
<h3><{$smarty.const._MD_TADBLOCKS_BLOCKS}></h3>

<{if $theme_type}>
    <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_`$theme_type`.tpl"}>
<{else}>
    <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_theme_type_5.tpl"}>
<{/if}>
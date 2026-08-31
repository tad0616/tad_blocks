<div id="bid-<{$b.bid}>" data-bid="<{$b.bid}>" class="b-item <{if $b.visible==1}>visible_block <{if $b.block_type=="D"}>clone<{/if}> <{if $b.c_type=="P"}>php<{elseif $b.block_type=="C"}>html<{/if}><{else}>invisible_block<{/if}> <{if $b.dirname|default:false}><{$b.dirname}><{else}>custom<{/if}> text-left text-start ">
    <{if $b.visible==1}>
        <img src="images/yes.png" alt="<{$smarty.const._MD_TAD_BLOCKS_TO_UNABLE}>" data-toggle="tooltip" title="<{$smarty.const._MD_TAD_BLOCKS_TO_UNABLE}>" data-bid="<{$b.bid}>" class="change_visible">
    <{else}>
        <img src="images/no.png" alt="<{$smarty.const._MD_TAD_BLOCKS_TO_ENABLE}>" data-toggle="tooltip" title="<{$smarty.const._MD_TAD_BLOCKS_TO_ENABLE}>" data-bid="<{$b.bid}>" class="change_visible">
    <{/if}>

    <{if $b.module_id==-1}>
        <img src="images/home.png" alt="<{$smarty.const._MD_TAD_BLOCKS_ONLY_HOME}>" data-toggle="tooltip" title="<{$smarty.const._MD_TAD_BLOCKS_TO_ALL_PAGES}>" id="display-<{$b.bid}>" data-bid="<{$b.bid}>" data-val="<{$b.module_id}>" class="module_id">
    <{else}>
        <img src="images/coding.png" alt="<{$smarty.const._MD_TAD_BLOCKS_ALL_PAGES}>" data-toggle="tooltip" title="<{$smarty.const._MD_TAD_BLOCKS_TO_ONLY_HOME}>" id="display-<{$b.bid}>" data-bid="<{$b.bid}>" data-val="<{$b.module_id}>" class="module_id">
    <{/if}>

    <span class="editable mx-2" id="b-title-<{$b.bid}>" data-name="title" data-type="text" data-pk="<{$b.bid}>" data-title="Enter title" data-params="{op: 'update_title'}" title="<{$b.weight}>-<{if $b.mod_name|default:false && $b.name!=$b.mod_name}><{$b.mod_name}>/<{/if}><{$b.name}> (<{if $b.c_type=="P"}><{$smarty.const._MD_TAD_BLOCKS_PHP}><{elseif $b.block_type=="C"}><{$smarty.const._MD_TAD_BLOCKS_HTML}><{else}><{$b.func_file}><{/if}>)"><{$b.title}></span>

    <{if $b.hide|default:false}>
        <span class="bt-tag">[hide]</span>
    <{elseif $b.pic}>
        <span class="bt-tag">[pic]</span>
    <{elseif $b.img}>
        <span class="bt-tag">[img]</span>
    <{elseif $b.link}>
        <span class="bt-tag">[link]</span>
    <{elseif $b.icon}>
        <span class="bt-tag">[icon]</span>
    <{/if}>

    <{if $b.block_type=="D"}>
        (<{$smarty.const._MD_TAD_BLOCKS_CLONE}>)
    <{else}>
        <a href="<{$xoops_url}>/modules/system/admin.php?fct=blocksadmin&op=clone&bid=<{$b.bid}>" aria-label="<{$smarty.const._MD_TAD_BLOCKS_COPY}>"><img src="images/copy.png" alt="<{$smarty.const._TAD_EDIT}>" data-toggle="tooltip" title="<{$smarty.const._MD_TAD_BLOCKS_COPY}>"></a>
    <{/if}>

    <a href="<{$xoops_url}>/modules/system/admin.php?fct=blocksadmin&op=edit&bid=<{$b.bid}>" target="_blank" aria-label="<{$smarty.const._TAD_EDIT}> <{$b.title}> (opens in new window)"><img src="images/wrench.png" alt="<{$smarty.const._TAD_EDIT}>" data-toggle="tooltip" title="<{$smarty.const._TAD_EDIT}>"></a>

    <{if $b.dirname=='' and $b.c_type=='H'}>
        <a href="index.php?op=block_form&bid=<{$b.bid}>" aria-label="<{$smarty.const._MD_TAD_BLOCKS_OPEN_WIDTH_TB}> <{$b.title}>"><img src="images/pencil.png" alt="<{$smarty.const._MD_TAD_BLOCKS_OPEN_WIDTH_TB}>" data-toggle="tooltip" title="<{$smarty.const._MD_TAD_BLOCKS_OPEN_WIDTH_TB}>"></a>
    <{/if}>


    <a href="ajax.php?op=setting_form&bid=<{$b.bid}>"  data-fancybox-type="iframe" class="block_setting" aria-label="<{$smarty.const._MD_TAD_BLOCKS_SETTING}> <{$b.title}>">
        <img src="images/setting.png" alt="<{$smarty.const._MD_TAD_BLOCKS_SETTING}>" data-toggle="tooltip" title="<{$smarty.const._MD_TAD_BLOCKS_SETTING}>">
    </a>

</div>
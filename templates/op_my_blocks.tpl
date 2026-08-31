<h3>
    <{$smarty.const._MD_TAD_BLOCKS_MY_BLOCKS}>
    <a href="index.php?op=block_form" class="btn btn-primary"><{$smarty.const._MD_TAD_BLOCKS_ADD_BLOCK}></a>
</h3>

<table class="table">
    <caption><{$smarty.const._MD_TADBLOCKS_BLOCKS}></caption>
    <thead>
        <tr>
            <th scope="col"><{$smarty.const._MD_TAD_BLOCKS_TITLE}></th>
            <th scope="col"><{$smarty.const._MD_TAD_BLOCKS_TYPE}></th>
            <th scope="col"><{$smarty.const._MD_TAD_BLOCKS_POSITION}></th>
            <th scope="col"><{$smarty.const._MD_TAD_BLOCKS_DISPLAY}></th>
            <th scope="col"><{$smarty.const._TAD_FUNCTION}></th>
        </tr>
    </thead>
    <tbody>
        <{foreach from=$my_blocks key=i item=b}>
            <tr>
                <td>
                    <{if $b.bid|default:false}>
                        <{if $b.visible=='1'}>
                            <a href="ajax.php?op=change_newblock&bid=<{$b.bid}>&col=visible&val=0" aria-label="<{$smarty.const._MD_TAD_BLOCKS_TO_UNABLE}>"><img src="images/yes.gif" alt="<{$smarty.const._MD_TAD_BLOCKS_TO_UNABLE}>"></a>
                        <{else}>
                            <a href="ajax.php?op=change_newblock&bid=<{$b.bid}>&col=visible&val=1" aria-label="<{$smarty.const._MD_TAD_BLOCKS_TO_ENABLE}>"><img src="images/no.gif" alt="<{$smarty.const._MD_TAD_BLOCKS_TO_ENABLE}>"></a>
                        <{/if}>
                        <span class="badge badge-info bg-info"><{$b.bid}></span>
                        <{$b.clean_title}>
                        <{$b.tag}>
                        <{$b.pic}>
                    <{else}>
                        已刪除 <{$b.bbid}> <{$smarty.const._MD_TAD_BLOCKS_CUSTOM_BLOCK}>
                    <{/if}>
                </td>
                <td>
                    <{$b.type}>
                </td>
                <td><{$b.position}><{$b.weight}></td>
                <td>
                    <{if $b.block.display.0==-1}>
                        <{$smarty.const._MD_TAD_BLOCKS_ONLY_HOME}>
                    <{else}>
                        <{$smarty.const._MD_TAD_BLOCKS_ALL_PAGES}>
                    <{/if}>
                </td>
                <td>
                    <{if $b.bid|default:false}>
                        <a href="javascript:block_del(<{$b.bid}>)" class="btn btn-sm btn-danger" aria-label="<{$smarty.const._TAD_DEL}> <{$b.clean_title}>"><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                        <a href="index.php?op=block_form&bid=<{$b.bid}>" class="btn btn-sm btn-warning" aria-label="<{$smarty.const._TAD_EDIT}> <{$b.clean_title}>"><i class="fa fa-pencil" aria-hidden="true"></i>  <{$smarty.const._TAD_EDIT}></a>
                    <{else}>
                        <a href="javascript:block_del(<{$b.bbid}>)" class="btn btn-sm btn-danger" aria-label="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                        <a href="index.php?op=block_form&bbid=<{$b.bbid}>" class="btn btn-sm btn-warning" aria-label="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil" aria-hidden="true"></i>  <{$smarty.const._TAD_EDIT}></a>
                    <{/if}>
                </td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
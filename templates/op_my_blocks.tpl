<h3>
    <{$smarty.const._MD_TAD_BLOCKS_MY_BLOCKS}>
    <a href="index.php?op=block_form" class="btn btn-primary"><{$smarty.const._MD_TAD_BLOCKS_ADD_BLOCK}></a>
</h3>

<table class="table">
    <thead>
        <tr>
            <th><{$smarty.const._MD_TAD_BLOCKS_TITLE}></th>
            <th><{$smarty.const._MD_TAD_BLOCKS_TYPE}></th>
            <th><{$smarty.const._MD_TAD_BLOCKS_POSITION}></th>
            <th><{$smarty.const._MD_TAD_BLOCKS_DISPLAY}></th>
            <th><{$smarty.const._TAD_FUNCTION}></th>
        </tr>
    </thead>
    <tbody>
        <{foreach from=$my_blocks key=i item=b}>
            <tr>
                <td>
                    <{if $b.bid|default:false}>
                        <{if $b.visible=='1'}>
                            <a href="ajax.php?op=change_newblock&bid=<{$b.bid}>&col=visible&val=0"><img src="images/yes.gif" alt="enable"></a>
                        <{else}>
                            <a href="ajax.php?op=change_newblock&bid=<{$b.bid}>&col=visible&val=1"><img src="images/no.gif" alt="unable"></a>
                        <{/if}>
                        <span class="badge badge-info bg-info"><{$b.bid}></span>
                        <{$b.clean_title}>
                        <{$b.tag}>
                        <{$b.pic}>
                    <{else}>
                        已刪除 <{$b.bbid}> 自訂區塊
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
                        <a href="javascript:block_del(<{$b.bid}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                        <a href="index.php?op=block_form&bid=<{$b.bid}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                    <{else}>
                        <a href="javascript:block_del(<{$b.bbid}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                        <a href="index.php?op=block_form&bbid=<{$b.bbid}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                    <{/if}>
                </td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
<h3>
    <{$smarty.const._MD_TAD_BLOCKS_MY_BLOCKS}>
    <a href="index.php?op=block_form#block_setup" class="btn btn-primary"><{$smarty.const._MD_TAD_BLOCKS_ADD_BLOCK}></a>
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
                    <span class="badge badge-info"><{$b.bid}></span>
                    <{$b.title}>
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
                    <a href="javascript:block_del(<{$b.bid}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                    <a href="index.php?op=block_form&bid=<{$b.bid}>#block_setup" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                </td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
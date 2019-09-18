<h3>
    我的自訂區塊
    <a href="index.php?op=block_form" class="btn btn-primary">新增自訂區塊</a>
</h3>
<table class="table">
    <thead>
        <tr>
            <th>區塊標題</th>
            <th>區塊類型</th>
            <th>區塊位置</th>
            <th>顯示型態</th>
            <th>功能</th>
        </tr>
    </thead>
    <tbody>
        <{foreach from=$my_blocks key=i item=b}>
            <tr>
                <td>
                    <span class="badge badge-info"><{$b.bid}></span>
                    <{$b.block.title.0}>
                </td>
                <td>
                    <{$b.type}>
                </td>
                <td><{$b.position}></td>
                <td>
                    <{if $b.block.display.0==-1}>
                        僅首頁
                    <{else}>
                        全部頁面
                    <{/if}>
                </td>
                <td>
                    <a href="javascript:block_del(<{$b.bid}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                    <a href="index.php?op=block_form&bid=<{$b.bid}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                </td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
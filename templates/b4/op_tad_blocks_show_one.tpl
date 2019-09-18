<{if $smarty.session.tad_blocks_adm}>
    <{$delete_tad_blocks_func}>
<{/if}>


<!--使用者-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MA_TADBLOCKS_UID}>
    </label>
    <div class="col-sm-9">
        <{$uid}>
    </div>
</div>

<!--日期-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MA_TADBLOCKS_CREATE_DATE}>
    </label>
    <div class="col-sm-9">
        <{$create_date}>
    </div>
</div>


<div class="text-right">
    <{if $smarty.session.tad_blocks_adm}>
        <a href="javascript:delete_tad_blocks_func(<{$bid}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/tad_blocks?op=tad_blocks_form&bid=<{$bid}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$xoops_url}>/modules/tad_blocks?op=tad_blocks_form" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$action}>" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
</div>

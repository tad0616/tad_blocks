<{if $all_tad_blocks}>
    <{if $smarty.session.tad_blocks_adm}>
        <{$delete_tad_blocks_func}>
        
    <{/if}>

    <div id="tad_blocks_save_msg"></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr class="info">
                
                <!--使用者-->
                <th>
                    <{$smarty.const._MD_TADBLOCKS_UID}>
                </th>
                <!--日期-->
                <th>
                    <{$smarty.const._MD_TADBLOCKS_CREATE_DATE}>
                </th>
                <{if $smarty.session.tad_blocks_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="tad_blocks_sort">
            <{foreach from=$all_tad_blocks item=data}>
                <tr id="tr_<{$data.bid}>">
                    
                    <!--使用者-->
                    <td>
                        <{$data.uid}>
                    </td>

                    <!--日期-->
                    <td>
                        <{$data.create_date}>
                    </td>

                    <{if $smarty.session.tad_blocks_adm}>
                        <td>
                            <a href="javascript:delete_tad_blocks_func(<{$data.bid}>);" class="btn btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
                            <a href="<{$xoops_url}>/modules/tad_blocks?op=tad_blocks_form&bid=<{$data.bid}>" class="btn btn-xs btn-warning"><{$smarty.const._TAD_EDIT}></a>
                            
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>


    <{if $smarty.session.tad_blocks_adm}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/tad_blocks?op=tad_blocks_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.tad_blocks_adm}>
            <a href="<{$xoops_url}>/modules/tad_blocks?op=tad_blocks_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>

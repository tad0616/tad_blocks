<!-- 判斷目前使用者是否有：建立自訂區塊 -->
<{if $add_block|default:false}>
    <!-- 有權限時要做的事 -->
    <form method="post" action="index.php" id="block_setup" enctype="multipart/form-data">
        <h3 class="my">
            <{if $bid|default:false}>
                <{if $visible=='1'}>
                    <a href="ajax.php?op=change_newblock&bid=<{$bid|default:''}>&col=visible&val=0"><img src="images/yes.gif" alt="enable"></a>
                <{else}>
                    <a href="ajax.php?op=change_newblock&bid=<{$bid|default:''}>&col=visible&val=1"><img src="images/no.gif" alt="unable"></a>
                <{/if}>

                <{$smarty.const._MD_TAD_BLOCKS_MODIFY}>
                <{$title|default:''}>
                <input type="hidden" name="type" value="<{$type|default:''}>">
            <{else}>
                <{$smarty.const._MD_TAD_BLOCKS_NEW}>
                <select name="type" onchange="location.href='index.php?op=block_form&type='+this.value+''">
                    <{foreach from=$type_arr key=val item=txt}>
                        <option value="<{$val|default:''}>" <{if $type==$val}>selected<{/if}>><{$txt|default:''}></option>
                    <{/foreach}>
                </select>

            <{/if}>
        </h3>
        <div class="form-group mb-3">
            <div class="input-group">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text"><{$smarty.const._MD_TAD_BLOCKS_TITLE}></span>
                </div>
                <input type="text" class="form-control" name="TDC[title]" placeholder="<{$smarty.const._MD_TAD_BLOCKS_ADD_TITLE}>" value="<{if $title|default:false}><{$title|default:''}><{else}><{$default.title}><{/if}>">
            </div>
        </div>
        <div class="form-group">
            <{if $type|default:false}>
                <{include file="$xoops_rootpath/modules/tad_blocks/type/`$type`/sub_type_form.tpl"}>
            <{else}>
                <{$editor|default:''}>
            <{/if}>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h4><{$smarty.const._MD_TAD_BLOCKS_POSITION}></h4>
                <{if $theme_type|default:false}>
                    <{include file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_`$theme_type`.tpl"}>
                <{else}>
                    <{include file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_theme_type_5.tpl"}>
                <{/if}>
            </div>
            <div class="col-sm-4">

                <h4><{$smarty.const._MD_TAD_BLOCKS_SORT}></h4>
                <input class="form-control" type="number" name="TDC[weight]" value="<{$weight|default:''}>">

                <h4 class="mt-3"><{$smarty.const._MD_TAD_BLOCKS_DISPLAY}></h4>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="TDC[display]" id="display_all" value="0" <{if $display==0}>checked<{/if}>>
                            <{$smarty.const._MD_TAD_BLOCKS_ALL_PAGES}>
                        </label>
                    </div>
                    <div class="form-check ">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="TDC[display]" id="display_home" value="-1"  <{if $display==-1}>checked<{/if}>>
                            <{$smarty.const._MD_TAD_BLOCKS_ONLY_HOME}>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <h4><{$smarty.const._MD_TAD_BLOCKS_WHO_CAN_SEE}></h4>
                <{$sel_grp|default:''}>
            </div>
        </div>

        <div class="text-center" style="margin:30px auto;">
            <input type="hidden" name="bid" value="<{$bid|default:''}>">
            <input type="hidden" name="bbid" value="<{$bbid|default:''}>">
            <input type="hidden" name="op" value="block_save">
            <button type="submit" class="btn btn-primary"><{$smarty.const._MD_TAD_BLOCKS_SAVE}></button>
        </div>

    </form>
<{else}>
    <!-- 沒有權限時要做的事 -->
    <div class="alert alert-danger" role="alert">
        <{$smarty.const._MD_TAD_BLOCKS_NO_PERMISSION}>
    </div>
<{/if}>
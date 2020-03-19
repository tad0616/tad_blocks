<!-- 判斷目前使用者是否有：建立自訂區塊 -->
<{if $add_block}>
    <!-- 有權限時要做的事 -->
    <form method="post" action="index.php" id="block_setup" enctype="multipart/form-data">
        <h3>
            <{if $bid}>
                <{$smarty.const._MD_TAD_BLOCKS_MODIFY}>
                <{$title}>
                <input type="hidden" name="type" value="<{$type}>">
            <{else}>
                <{$smarty.const._MD_TAD_BLOCKS_NEW}>
                <select name="type" onchange="location.href='index.php?op=block_form&type='+this.value+'#block_setup'">
                    <{foreach from=$type_arr key=val item=txt}>
                        <option value="<{$val}>" <{if $type==$val}>selected<{/if}>><{$txt}></option>
                    <{/foreach}>
                </select>

            <{/if}>
        </h3>
        <div class="form-group">
            <input type="text" class="form-control" name="TDC[title]" placeholder="<{$smarty.const._MD_TAD_BLOCKS_ADD_TITLE}>" value="<{$title}>">
        </div>
        <div class="form-group">
            <{if $type}>
                <{includeq file="$xoops_rootpath/modules/tad_blocks/type/`$type`/sub_type_form.tpl"}>
            <{else}>
                <{$editor}>
            <{/if}>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h4><{$smarty.const._MD_TAD_BLOCKS_POSITION}></h4>
                <{if $theme_type}>
                    <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_`$theme_type`.tpl"}>
                <{else}>
                    <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_theme_type_5.tpl"}>
                <{/if}>
            </div>
            <div class="col-sm-4">

                <{if $bid}>
                    <h4><{$smarty.const._MD_TAD_BLOCKS_SORT}></h4>
                    <input class="form-control" type="number" name="TDC[weight]" value="<{$weight}>">
                <{/if}>

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
                <{$sel_grp}>
            </div>
        </div>

        <div class="text-center" style="margin:30px auto;">
            <input type="hidden" name="bid" value="<{$bid}>">
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
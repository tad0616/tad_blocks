<!-- 判斷目前使用者是否有：建立自訂區塊 -->
<{if $add_block}>
    <!-- 有權限時要做的事 -->
    <form method="post" action="index.php" id="block_setup" enctype="multipart/form-data">
        <h3>
            <{if $bid}>
                修改「<{$title}>」區塊
                <input type="hidden" name="type" value="<{$type}>">
            <{else}>
                建立
                <select name="type" onchange="location.href='index.php?op=block_form&type='+this.value">
                    <{foreach from=$type_arr key=val item=txt}>
                        <option value="<{$val}>" <{if $type==$val}>selected<{/if}>><{$txt}></option>
                    <{/foreach}>
                </select>
                新區塊
            <{/if}>
        </h3>
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    <input type="text" class="form-control" name="TDC[title]" placeholder="請輸入區塊標題" value="<{$title}>">
                </div>
                <div class="form-group">
                    <{if $type}>
                        <{includeq file="$xoops_rootpath/modules/tad_blocks/type/`$type`/sub_type_form.tpl"}>
                    <{else}>
                        <{$editor}>
                    <{/if}>
                </div>

                <div class="text-center">
                    <input type="hidden" name="bid" value="<{$bid}>">
                    <input type="hidden" name="op" value="block_save">
                    <button type="submit" class="btn btn-primary"><{$smarty.const._MD_TAD_BLOCKS_SAVE}></button>
                </div>
            </div>
            <div class="col-sm-3">
                <h4>顯示位置</h4>
                <{if $theme_type}>
                    <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_`$theme_type`.tpl"}>
                <{else}>
                    <{includeq file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_theme_type_5.tpl"}>
                <{/if}>

                <{if $bid}>
                    <h4 class="mt-3">排序</h4>
                    <input class="form-control" type="number" name="TDC[weight]" value="<{$weight}>">
                <{/if}>

                <h4 class="mt-3">顯示型態</h4>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="TDC[display]" id="display_all" value="0" <{if $display==0}>checked<{/if}>>
                            全部頁面
                        </label>
                    </div>
                    <div class="form-check ">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="TDC[display]" id="display_home" value="-1"  <{if $display==-1}>checked<{/if}>>
                            首頁
                        </label>
                    </div>
                </div>
                <h4 class="mt-3">誰可以看到</h4>
                <{$sel_grp}>
            </div>
        </div>
    </form>
<{else}>
    <!-- 沒有權限時要做的事 -->
    <div class="alert alert-danger" role="alert">
        您沒有權限喔！
    </div>
<{/if}>
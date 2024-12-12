<h3>
    <{$smarty.const._MD_TAD_BLOCKS_LOGO_DESIGN}>
</h3>
<{if $fonts|default:false}>
    <form action="blocks.php" id="myForm" method="post" role="form" class="form-horizontal">
        <div class="alert alert-success">
            <div class="form-group row mb-3">
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_TEXT_SIZE}></label>
                <div class="col-sm-2">
                    <input type="number" class="form-control validate[required]" name="TDC[size]" id="size" placeholder="<{$smarty.const._MD_TAD_BLOCKS_LOGO_TEXT_SIZE}>" value="<{$size|default:''}>">
                </div>
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_BORDER_SIZE}></label>
                <div class="col-sm-2">
                    <input type="number" class="form-control validate[required]" name="TDC[border_size]" id="border_size" placeholder="<{$smarty.const._MD_TAD_BLOCKS_LOGO_BORDER_SIZE}>" value="<{$border_size|default:''}>">
                </div>
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_SHADOW_SIZE}></label>
                <div class="col-sm-2">
                    <input type="number" class="form-control validate[required]" name="TDC[shadow_size]" id="shadow_size" placeholder="<{$smarty.const._MD_TAD_BLOCKS_LOGO_SHADOW_SIZE}>" value="<{$shadow_size|default:''}>">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_TEXT_COLOR}></label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" name="TDC[color]" class="form-control color-picker" value="<{$color|default:''}>" id="font_color" data-hex="true">
                    </div>
                </div>
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_BORDER_COLOR}></label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" name="TDC[border_color]" class="form-control color-picker" value="<{$border_color|default:''}>" id="border_color" data-hex="true">
                    </div>
                </div>
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_SHADOW_COLOR}></label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" name="TDC[shadow_color]" class="col-sm-10 form-control color-picker" value="<{$shadow_color|default:''}>" id="shadow_color" data-hex="true">
                    </div>
                </div>
            </div>


            <div class="form-group row mb-3">
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_SELECT_FONT}></label>
                <div class="col-sm-2">
                    <select name="TDC[font_file_sn]" id="font_file_sn" class="form-control form-select">
                        <{foreach from=$fonts key=file_sn item=font name=f}>
                            <option value="<{$file_sn|default:''}>" <{if $font_file_sn==$file_sn or ($font_file_sn == 0 and $smarty.foreach.f.index == 0) }>selected<{/if}>>
                                <{$font.description}>
                            </option>
                        <{/foreach}>
                    </select>
                </div>
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_SHADOW_X}></label>
                <div class="col-sm-2">
                    <input type="number" name="TDC[shadow_x]" class="col-sm-10 form-control" value="<{$shadow_x|default:''}>" id="shadow_x">
                </div>
                <label class="col-sm-2 control-label col-form-label text-sm-right text-sm-end"><{$smarty.const._MD_TAD_BLOCKS_LOGO_SHADOW_Y}></label>
                <div class="col-sm-2">
                    <input type="number" name="TDC[shadow_y]" class="col-sm-10 form-control" value="<{$shadow_y|default:''}>" id="shadow_y">
                </div>
            </div>
        </div>

        <div class="text-center" style="margin: 30px auto;">
            <button type="submit" class="btn btn-primary" name="op" value="save_and_re_build_logo"><{$smarty.const._MD_TAD_BLOCKS_LOGO_MAKE_PNG}></button>
        </div>
    </form>
<{else}>
    <div class="alert alert-danger"><{$smarty.const._MD_TAD_BLOCKS_LOGO_NEED_FONT}></div>
<{/if}>

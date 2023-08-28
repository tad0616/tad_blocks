<div class="alert alert-warning my-3">
    <{$upform}>
    <input type="hidden" name="TDC[pic_col_sn]" value="<{$pic_col_sn}>">
</div>

<div class="alert alert-info my-4">
    <{$smarty.const._GALLERY_SHOW_DESC}><{$smarty.const._TAD_FOR}>
    <div class="form-check-inline radio-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="TDC[show_desc]" value="1" <{if $show_desc=='1'}>checked<{/if}>>
                <{$smarty.const._YES}>
        </label>
    </div>
    <div class="form-check-inline radio-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="TDC[show_desc]" value="0" <{if $show_desc!='1'}>checked<{/if}>>
                <{$smarty.const._NO}>
        </label>
    </div>

    <br>
    <{$smarty.const._GALLERY_SHOW_WIDTH}><{$smarty.const._TAD_FOR}><input type="number" name="TDC[show_width]" id="show_width" value="<{$show_width}>" placeholder="<{$smarty.const._GALLERY_SHOW_WIDTH}>" style="width: 80px;"> x
    <{$smarty.const._GALLERY_SHOW_HEIGHT}><{$smarty.const._TAD_FOR}><input type="number" name="TDC[show_height]" id="show_height" value="<{$show_height}>" placeholder="<{$smarty.const._GALLERY_SHOW_HEIGHT}>" style="width: 80px;">
    <br>
    <{$smarty.const._GALLERY_DESC_HEIGHT}><{$smarty.const._TAD_FOR}><input type="number" name="TDC[desc_height]" id="desc_height" value="<{$desc_height}>" placeholder="<{$smarty.const._GALLERY_DESC_HEIGHT}>" style="width: 80px;">
    <br>
    <{$smarty.const._GALLERY_THUMB_CSS}><{$smarty.const._TAD_FOR}><input type="text" name="TDC[thumb_css]" id="thumb_css" value="<{$thumb_css}>" placeholder="<{$smarty.const._GALLERY_THUMB_CSS}>" style="width: 80%;">


    <br>
    <{$smarty.const._GALLERY_BG_SIZE}><{$smarty.const._TAD_FOR}><select name="TDC[bg_size]" id="bg_size" class="my-input">
        <option value="contain" <{if $bg_size=='contain'}>selected<{/if}>><{$smarty.const._GALLERY_BG_SIZE_CONTAIN}></option>
        <option value="cover" <{if $bg_size=='cover'}>selected<{/if}>><{$smarty.const._GALLERY_BG_SIZE_COVER}></option>
    </select>

    <br>
    <{$smarty.const._GALLERY_MODE}><{$smarty.const._TAD_FOR}><select name="TDC[mode]]" id="mode" class="my-input">
        <option value="thumbs" <{if $mode=='thumbs'}>selected<{/if}>><{$smarty.const._GALLERY_MODE_THUMBS}></option>
        <option value="slide" <{if $mode=='slide'}>selected<{/if}>><{$smarty.const._GALLERY_MODE_SLIDE}></option>
        <option value="marquee" <{if $mode=='marquee'}>selected<{/if}>><{$smarty.const._GALLERY_MODE_MARQUEE}></option>
    </select>
</div>

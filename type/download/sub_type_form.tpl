<div class="alert alert-warning my-3">
    <{$upform|default:''}>
    <input type="hidden" name="TDC[file_col_sn]" value="<{$file_col_sn|default:''}>">
</div>

<div class="alert alert-info my-4">
    <div class="my-1">
        <{$smarty.const._DOWNLOAD_HEIGHT}><{$smarty.const._TAD_FOR}>
        <input type="number" name="TDC[desc_height]" class="my-input" id="desc_height" value="<{$desc_height|default:''}>" placeholder="<{$smarty.const._DOWNLOAD_HEIGHT}>" style="width: 80px;">
    </div>
    <div class="my-1">
        <{$smarty.const._DOWNLOAD_MODE}><{$smarty.const._TAD_FOR}>
        <select name="TDC[mode]]" id="mode" class="my-input">
        <option value="icons" <{if $mode=='icons'}>selected<{/if}>><{$smarty.const._DOWNLOAD_ICONS}></option>
        <option value="filename" <{if $mode=='filename'}>selected<{/if}>><{$smarty.const._DOWNLOAD_FILENAME}></option>
        <option value="small" <{if $mode=='small'}>selected<{/if}>><{$smarty.const._DOWNLOAD_SMALL}></option>
        </select>
    </div>
    <div class="my-1">
        <{$smarty.const._DOWNLOAD_FONT_SIZE}><{$smarty.const._TAD_FOR}>
        <input type="text" name="TDC[font_size]" class="my-input" id="font_size" value="<{$font_size|default:'1rem'}>" placeholder="<{$smarty.const._DOWNLOAD_FONT_SIZE}>" style="width: 80px;">
    </div>
</div>

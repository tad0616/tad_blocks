<div class="alert alert-warning my-3">
    <{$upform}>
    <input type="hidden" name="TDC[file_col_sn]" value="<{$file_col_sn}>">
</div>

<div class="alert alert-info my-4">
    <{$smarty.const._DOWNLOAD_HEIGHT}> <input type="number" name="TDC[desc_height]" id="desc_height" value="<{$desc_height}>" placeholder="<{$smarty.const._DOWNLOAD_HEIGHT}>" style="width: 80px;">
    <br>
    <{$smarty.const._DOWNLOAD_MODE}><select name="TDC[mode]]" id="mode" class="my-input">
    <option value="icons" <{if $mode=='icons'}>selected<{/if}>><{$smarty.const._DOWNLOAD_ICONS}></option>
    <option value="filename" <{if $mode=='filename'}>selected<{/if}>><{$smarty.const._DOWNLOAD_FILENAME}></option>
    <option value="small" <{if $mode=='small'}>selected<{/if}>><{$smarty.const._DOWNLOAD_SMALL}></option>
    </select>
</div>

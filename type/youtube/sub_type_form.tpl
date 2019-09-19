<input name="TDC[video_url]" id="video_url" class="form-control" value="<{$video_url}>" placeholder="<{$smarty.const._YOUTUBE_URL}>">

<div class="alert alert-info my-4">
    <{$smarty.const._YOUTUBE_RATIO}><select name="TDC[rate]" id="rate">
    <option value="16by9" <{if $text_align=='16by9'}>selected<{/if}>>16:9</option>
    <option value="4by3" <{if $text_align=='4by3'}>selected<{/if}>>4:3</option>
    <option value="21by9" <{if $text_align=='21by9'}>selected<{/if}>>21:9</option>
    </select>
</div>

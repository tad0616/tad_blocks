<input name="TDC[video_url]" id="video_url" class="form-control" value="<{$video_url}>" placeholder="<{$smarty.const._YOUTUBE_URL}>">

<div class="alert alert-info my-4">
    <{$smarty.const._YOUTUBE_RATIO}>
    <select name="TDC[youtube_ratios]" id="youtube_ratios" class="form-control validate[required]">
        <option value="4x3" <{if $youtube_ratios == '4x3'}>selected<{/if}>>4:3</option>
        <option value="16x9" <{if $youtube_ratios == '16x9'}>selected<{/if}>>16:9</option>
        <option value="1x1" <{if $youtube_ratios == '1x1'}>selected<{/if}>>1:1</option>
        <option value="21x9" <{if $youtube_ratios == '21x9'}>selected<{/if}>>21:9</option>
    </select>
</div>

<input name="TDC[iframe_url]" id="iframe_url" class="form-control" value="<{$iframe_url|default:''}>" placeholder="<{$smarty.const._IFRAME_URL}>">

<div class="alert alert-info my-4">
    <{$smarty.const._IFRAME_WIDTH_HEIGHT}>
    <select name="TDC[iframe_ratios]" id="iframe_ratios" class="form-control validate[required]">
        <option value="1x1" <{if $iframe_ratios == '1x1'}>selected<{/if}>>1:1</option>
        <option value="4x3" <{if $iframe_ratios == '4x3'}>selected<{/if}>>4:3</option>
        <option value="16x9" <{if $iframe_ratios == '16x9'}>selected<{/if}>>16:9</option>
        <option value="21x9" <{if $iframe_ratios == '21x9'}>selected<{/if}>>21:9</option>
    </select>
</div>

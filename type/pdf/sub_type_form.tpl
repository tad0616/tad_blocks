<input type="file" name="pdf" id="pdf">
<input type="hidden" name="TDC[pdf_url]" id="pdf_url" value="<{$pdf_url|default:''}>">
<div id="demo_pdf"><{$pdf_url|default:''}></div>
<div class="alert alert-info my-4">
    <div class="my-1">
        <{$smarty.const._PDF_RATIO}>
        <select name="TDC[rate]" id="rate" class="my-input">
        <option value="210by297" <{if $text_align=='210by297'}>selected<{/if}>><{$smarty.const._PDF_210BY297}></option>
        <option value="297by210" <{if $text_align=='297by210'}>selected<{/if}>><{$smarty.const._PDF_297BY210}></option>
        </select>
    </div>
    <div class="my-1">
        <{$smarty.const._PDF_SCROLLING}>
        <select name="TDC[scrolling]" id="scrolling" class="my-input">
        <option value="auto" <{if $scrolling=='auto'}>selected<{/if}>><{$smarty.const._PDF_AUTO}></option>
        <option value="no"" <{if $scrolling=='no'}>selected<{/if}>><{$smarty.const._PDF_NO}></option>
        </select>
    </div>
</div>

<script type="text/javascript" src="<{$xoops_url}>/modules/tad_blocks/type/pdf/jquery.upload-1.0.2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#pdf').on('change', function() {
            $(this).upload('<{$xoops_url}>/modules/tad_blocks/type/pdf/upload.php',{op:'upload'}, function(pdf_url) {
                console.log(pdf_url);
                $('#demo_pdf').html(pdf_url);
                $('#pdf_url').val(pdf_url);
            }, 'html');
        });
    });
</script>
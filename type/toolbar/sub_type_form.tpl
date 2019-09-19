<table class="table" id="new_form">
    <{if $text}>
        <{foreach from=$text key=i item=text}>
            <tr id="form_data<{$i}>">
                <td style="width:40px;">
                    <button type="button" id="<{$i}>" class="btn btn-sm btn-danger remove_me"><{$smarty.const._TAD_DEL}></button>
                </td>
                <td style="width: 32px;">
                    <div id="demo_pic<{$i}>" style="width:32px;height:32px;border:1px solid gray;background-image:url('<{$img_url.$i}>');background-size:cover;"></div>
                </td>
                <td>
                    <input type="text" name="TDC[url][<{$i}>]" id="url<{$i}>" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_URL}>" value="<{$url.$i}>">
                </td>
                <td>
                    <input type="text" name="TDC[text][<{$i}>]" id="text<{$i}>" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_TEXT}>" value="<{$text}>">
                </td>
                <td style="width: 140px;">
                    <input type="file" name="img[<{$i}>]" id="img<{$i}>" data-id="<{$i}>" class="upload" style="width: 140px;">
                    <input type="hidden" name="TDC[img_url][<{$i}>]" id="img_url<{$i}>" value="<{$img_url.$i}>">
                </td>
            </tr>
        <{/foreach}>
    <{/if}>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td style="width: 40px;">
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" ><{$smarty.const._TAD_DEL}></button>
        </td>
        <td style="width: 32px;">
            <div id="demo_pic" style="width:32px;height:32px;border:1px solid gray;background-size:cover;"></div>
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_URL}>">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_TEXT}>">
        </td>
        <td style="width: 140px;">
            <input type="file" data-name="img" data-id="<{$i}>" id="img" class="upload" style="width: 140px;">
            <input type="hidden" data-name="TDC[img_url]" id="img_url">
        </td>
    </tr>
</table>

<div class="text-right">
    <a href="#block_setup" id="add_form" class="btn btn-success"><{$smarty.const._MD_TAD_ADD_ONE}></a>
</div>

<div class="alert alert-info my-4">
    <{$smarty.const._TOOLBAR_FONT_SIZE}><input type="number" name="TDC[font_size]" id="font_size" value="<{$font_size}>"> px<br>
    <{$smarty.const._TOOLBAR_TEXT_ALIGN}><select name="TDC[text_align]" id="text_align">
    <option value="left" <{if $text_align=='left'}>selected<{/if}>><{$smarty.const._TOOLBAR_LEFT}></option>
    <option value="center" <{if $text_align=='center'}>selected<{/if}>><{$smarty.const._TOOLBAR_CENTER}></option>
    <option value="right" <{if $text_align=='right'}>selected<{/if}>><{$smarty.const._TOOLBAR_RIGHT}></option>
    </select>
</div>

<script type="text/javascript" src="<{$xoops_url}>/modules/tad_blocks/type/toolbar/jquery.upload-1.0.2.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        <{if $text}>
            var form_index=<{$i}>;
        <{else}>
            var form_index=0;
            form_index = clone_form(form_index);
        <{/if}>

        $("#add_form").click(function(){
            form_index = clone_form(form_index);
        });

        $(".remove_me").click(function(){
            $(this).closest("#form_data" + $(this).prop("id")).remove();
        });

        d = new Date();
        $('.upload').change(function() {
            console.log($(this).data("id"));
            $(this).upload('<{$xoops_url}>/modules/tad_blocks/type/toolbar/upload.php',{op:'upload', sort: $(this).data("id")}, function(img_url) {
                console.log(img_url);
                $('#demo_pic' + $(this).data("id")).css('background-image','url('+img_url+'?'+d.getTime()+')');
                $('#img_url' + $(this).data("id")).val(img_url);
            }, 'html');
        });
    });



    function clone_form(form_index){

        form_index++;
        //複製一份IP設定表單
        $("#new_form").append($("#form_data").clone().prop("id","form_data" + form_index));

        $("#form_data" + form_index + "  input").each(function(){
            $(this).prop("name",$(this).data("name") + "[" + form_index+"]");
            $(this).prop("id",$(this).prop("id") + form_index);
        });


        $("#form_data" + form_index + "  div").each(function(){
            $(this).prop("id",$(this).prop("id") + form_index);
        });

        $("#form_data" + form_index + "  button").each(function(){
            $(this).prop("id",$(this).data("name") + form_index);
        });

        $("#remove_me" + form_index).click(function(){
            $(this).closest("#form_data" + form_index).remove();
        });

        d = new Date();
        $("#img" + form_index).change(function() {
            console.log(form_index);
            $(this).upload('<{$xoops_url}>/modules/tad_blocks/type/toolbar/upload.php',{op:'upload' , sort: form_index}, function(img_url) {
                console.log(img_url);
                $('#demo_pic' + form_index).css('background-image','url('+img_url+'?'+d.getTime()+')');
                $('#img_url' + form_index).val(img_url);
            }, 'html');
        });
        return form_index;
    }

</script>
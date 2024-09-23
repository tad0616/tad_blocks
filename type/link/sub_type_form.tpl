<div id="save_msg"></div>
<table class="table" id="new_form">
    <tbody id="sort">
        <{if $text|default:false}>
            <{foreach from=$text key=i item=text}>
                <tr id="form_data<{$i|default:''}>">
                    <td>
                        <button type="button" id="<{$i|default:''}>" class="btn btn-sm btn-danger remove_me" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </td>
                    <td>
                        <div id="demo_pic<{$i|default:''}>" style="width:32px;height:32px;border:1px solid #cfcfcf;background-image:url('<{$img_url.$i}>');background-size:cover;"></div>
                    </td>
                    <td style="width: 120px;">
                        <input type="file" name="img[<{$i|default:''}>]" id="img<{$i|default:''}>" data-id="<{$i|default:''}>" class="upload_img" style="width: 120px;">
                        <input type="hidden" name="TDC[img_url][<{$i|default:''}>]" id="img_url<{$i|default:''}>" value="<{$img_url.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[url][<{$i|default:''}>]" id="url<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_URL}>" value="<{$url.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[text][<{$i|default:''}>]" id="text<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TEXT}>" value="<{$text|default:''}>">
                    </td>
                    <td>
                        <select name="TDC[target][<{$i|default:''}>]" id="target<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TARGET}>">
                            <option value="_self" <{if $target.$i == '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_SELF}></option>
                            <option value="_blank" <{if $target.$i != '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_BLANK}></option>
                        </select>
                    </td>
                </tr>
            <{/foreach}>
        <{/if}>
    </tbody>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td>
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-times" aria-hidden="true"></i></button>
        </td>
        <td>
            <div id="demo_pic" style="width:32px;height:32px;border:1px solid #cfcfcf;background-image:url('<{$default.img_url}>');background-size:cover;"></div>
        </td>
        <td style="width: 120px;">
            <input type="file" data-name="img" id="img" class="upload" style="width: 120px;">
            <input type="hidden" data-name="TDC[img_url]" id="img_url">
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="<{$smarty.const._LINK_ADD_URL}>">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TEXT}>">
        </td>
        <td>
            <select data-name="TDC[target]" id="target" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TARGET}>">
                <option value="_self"><{$smarty.const._LINK_ADD_TARGET_SELF}></option>
                <option value="_blank"><{$smarty.const._LINK_ADD_TARGET_BLANK}></option>
            </select>
        </td>
    </tr>
</table>

<div class="text-right text-end">
    <a href="#xoops_contents" id="add_form" class="btn btn-success"><{$smarty.const._MD_TAD_ADD_ONE}></a>
</div>

<div class="alert alert-info my-4">
    <{$smarty.const._LINK_SHOW_TYPE}><select name="TDC[show_type]]" id="show_type" class="my-input">
    <option value="default" <{if $show_type=='default'}>selected<{/if}>><{$smarty.const._LINK_DEFAULT}></option>
    <option value="none" <{if $show_type=='none'}>selected<{/if}>><{$smarty.const._LINK_NONE}></option>
    <option value="ul" <{if $show_type=='ul'}>selected<{/if}>><{$smarty.const._LINK_UL}></option>
    <option value="ol" <{if $show_type=='ol'}>selected<{/if}>><{$smarty.const._LINK_OL}></option>
    <option value="table" <{if $show_type=='table'}>selected<{/if}>><{$smarty.const._LINK_TABLE}></option>
    <option value="image" <{if $show_type=='image'}>selected<{/if}>><{$smarty.const._LINK_IMAGE}></option>
    </select><br>

    <{$smarty.const._LINK_HIDE_PIC}><select name="TDC[hide_pic]]" id="hide_pic" class="my-input">
    <option value="show" <{if $hide_pic=='show'}>selected<{/if}>><{$smarty.const._NO}></option>
    <option value="hide" <{if $hide_pic=='hide'}>selected<{/if}>><{$smarty.const._YES}></option>
    </select>

    <br>
    <{$smarty.const._LINK_ITEM_CSS}><input type="text" name="TDC[item_css]" id="item_css" value="<{$item_css|default:''}>" style="width:80%;" class="my-input">
    <br>
    <{$smarty.const._LINK_IMG_CSS}><input type="text" name="TDC[img_css]" id="img_css" value="<{$img_css|default:''}>" style="width:80%;" class="my-input">
    <br>
    <{$smarty.const._LINK_TXT_CSS}><input type="text" name="TDC[txt_css]" id="txt_css" value="<{$txt_css|default:''}>" style="width:80%;" class="my-input">
    <br>
    <{$smarty.const._LINK_PIC_WIDTH}><input type="number" name="TDC[pic_width]" id="pic_width" value="<{$pic_width|default:''}>"  class="my-input">px
    <{$smarty.const._LINK_PIC_DESC}>
    <br>
</div>


<script type="text/javascript" src="<{$xoops_url}>/modules/tad_blocks/type/link/jquery.upload-1.0.2.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        <{if $bid|default:false}>
            $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
                var order = $(this).sortable('serialize');
                order = order + '&col[]=text&col[]=url&col[]=target&col[]=img_url&op=save_sort&bid=<{$bid|default:''}>';
                console.log(order);
                $.post('ajax.php', order, function(theResponse){
                    $('#save_msg').html(theResponse);
                });
                }
            });
        <{/if}>

        <{if $text|default:false}>
            var form_index=<{$i|default:''}>;
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

        $('.upload_img').change(function() {
            console.log($(this).data("id"));
            $(this).upload('<{$xoops_url}>/modules/tad_blocks/type/link/upload.php',{op:'upload', sort: $(this).data("id")}, function(img_url) {
                console.log(img_url);
                $('#demo_pic' + $(this).data("id")).css('background-image','url('+img_url+')');
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
            $(this).data("id", form_index);
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

        $("#img" + form_index).change(function() {
            console.log(form_index);
            $(this).upload('<{$xoops_url}>/modules/tad_blocks/type/link/upload.php',{op:'upload' , sort: form_index}, function(img_url) {
                console.log(img_url);
                $('#demo_pic' + form_index).css('background-image','url('+img_url+')');
                $('#img_url' + form_index).val(img_url);
            }, 'html');
        });

        return form_index;
    }

</script>
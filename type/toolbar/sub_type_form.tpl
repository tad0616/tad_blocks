<div id="save_msg"></div>
<table class="table" id="new_form">
    <tbody id="sort">
        <{if $text|default:false}>
            <{foreach from=$text key=i item=data}>
                <tr id="form_data<{$i|default:''}>">
                    <td style="width: 2.5rem;">
                        <button type="button" id="<{$i|default:''}>" class="btn btn-sm btn-danger remove_me" aria-label="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </td>
                    <td style="width: 2rem;">
                        <div id="demo_pic<{$i|default:''}>" style="width:2rem;height:2rem;border:0.0625rem solid #cfcfcf;background-image:url('<{$img_url.$i}>');background-size:cover;"></div>
                    </td>
                    <td style="width: 7.5rem;">
                        <input type="file" name="img[<{$i|default:''}>]" id="img<{$i|default:''}>" data-id="<{$i|default:''}>" class="upload_img" style="width: 7.5rem;">
                        <input type="hidden" name="TDC[img_url][<{$i|default:''}>]" id="img_url<{$i|default:''}>" value="<{$img_url.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[url][<{$i|default:''}>]" id="url<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_URL}>" value="<{$url.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[text][<{$i|default:''}>]" id="text<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_TEXT}>" value="<{$data|default:''}>">
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
        <td style="width: 2.5rem;">
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" aria-label="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
        <td style="width: 2rem;">
            <div id="demo_pic" style="width:2rem;height:2rem;border:0.0625rem solid #cfcfcf;background-image:url('<{$default.img_url}>');background-size:cover;"></div>
        </td>
        <td style="width: 7.5rem;">
            <input type="file" data-name="img" id="img" class="upload" style="width: 7.5rem;">
            <input type="hidden" data-name="TDC[img_url]" id="img_url">
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_URL}>">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="<{$smarty.const._TOOLBAR_ADD_TEXT}>">
        </td>
        <td>
            <select data-name="TDC[target][<{$i|default:''}>]" id="target<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TARGET}>">
                <option value="_self" <{if $default.target == '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_SELF}></option>
                <option value="_blank" <{if $default.target != '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_BLANK}></option>
            </select>
        </td>
    </tr>
</table>

<div class="text-right text-end">
    <a href="#xoops_contents" id="add_form" class="btn btn-success"><{$smarty.const._MD_TAD_ADD_ONE}></a>
</div>


<{include file="$xoops_rootpath/modules/tad_blocks/templates/sub_batch_import.tpl"}>

<div class="alert alert-info my-4">
    <div class="my-1">
        <{$smarty.const._TOOLBAR_FONT_SIZE}>
        <input type="number" name="TDC[font_size]" id="font_size" value="<{$font_size|default:''}>" class="my-input" style="width: 6rem"> px
    </div>
    <div class="my-1">
        <{$smarty.const._TOOLBAR_TEXT_ALIGN}>
        <select name="TDC[text_align]" id="text_align" class="my-input">
            <option value="left" <{if $text_align=='left'}>selected<{/if}>><{$smarty.const._TOOLBAR_LEFT}></option>
            <option value="center" <{if $text_align=='center'}>selected<{/if}>><{$smarty.const._TOOLBAR_CENTER}></option>
            <option value="right" <{if $text_align=='right'}>selected<{/if}>><{$smarty.const._TOOLBAR_RIGHT}></option>
        </select>
    </div>
    <div class="my-1">
        <{$smarty.const._TOOLBAR_HVR}>
        <select name="TDC[hvr]" id="hvr" class="my-input">
            <option value="hvr-wobble-vertical" <{if $hvr=='hvr-wobble-vertical'}>selected<{/if}>>Wobble Vertical</option>
            <option value="hvr-wobble-top" <{if $hvr=='hvr-wobble-top'}>selected<{/if}>>Wobble Top</option>
            <option value="hvr-wobble-bottom" <{if $hvr=='hvr-wobble-bottom'}>selected<{/if}>>Wobble Bottom</option>
            <option value="hvr-buzz-out" <{if $hvr=='hvr-buzz-out'}>selected<{/if}>>Buzz Out</option>
            <option value="hvr-grow-shadow" <{if $hvr=='hvr-grow-shadow'}>selected<{/if}>>Grow Shadow</option>
            <option value="hvr-float-shadow" <{if $hvr=='hvr-float-shadow'}>selected<{/if}>>Float Shadow</option>
        </select>
    </div>
    <div class="my-1">
        <{$smarty.const._TOOLBAR_MAX_WIDTH}>
        <input type="number" name="TDC[max_width]" id="max_width" value="<{$max_width|default:''}>" class="my-input" style="width: 6rem"> px
    </div>
    <div class="my-1">
        <{$smarty.const._TOOLBAR_TEXT_HEIGHT}>
        <input type="number" name="TDC[text_height]" id="text_height" value="<{$text_height|default:''}>" class="my-input" style="width: 6rem"> rem
    </div>
    <div class="my-1">
        <{$smarty.const._TOOLBAR_IMG_WIDTH}>
        <input type="number" name="TDC[img_width]" id="img_width" value="<{$img_width|default:''}>" class="my-input" style="width: 6rem"> px
    </div>
    <div class="my-1">
        <{$smarty.const._TOOLBAR_IMG_HEIGHT}>
        <input type="number" name="TDC[img_height]" id="img_height" value="<{$img_height|default:''}>" class="my-input" style="width: 6rem"> rem
    </div>

</div>

<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jquery/jquery.upload.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        <{if $bid|default:false}>
            $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
                var $sortable = $(this);
                $sortable.sortable('disable');
                var order = $sortable.sortable('serialize');
                order = order + '&col[]=img_url&col[]=url&col[]=text&col[]=target&op=save_sort&bid=<{$bid|default:''}>';
                console.log(order);
                $.post('ajax.php', order, function(theResponse){
                    $('#save_msg').html(theResponse);
                    if (theResponse.indexOf('<{$smarty.const._TAD_SORTED}>') === 0) {
                        $sortable.children('tr').each(function(index) {
                            var new_sort = index + 1;
                            var $row = $(this);
                            $row.attr('id', 'form_data' + new_sort);
                            $row.find('[id]').each(function() {
                                this.id = this.id.replace(/\d+$/, new_sort);
                            });
                            $row.find('[name]').each(function() {
                                this.name = this.name.replace(/\[\d+\]$/, '[' + new_sort + ']');
                            });
                            $row.find('input[type="file"]').each(function() {
                                $(this).attr('data-id', new_sort).data('id', new_sort);
                            });
                            form_index = Math.max(form_index, new_sort);
                        });
                    }
                    $sortable.sortable('enable');
                }).fail(function(xhr, status, error) {
                    $('#save_msg').text('排序儲存失敗：' + error);
                    $sortable.sortable('enable');
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
            var $this = $(this);
            var id = $this.prop("id");

            $.post(
                "<{$xoops_url}>/modules/tad_blocks/ajax.php",
                {
                    op: "del_data",
                    col_name: "bid",
                    data_sort: id,
                    col_sn: <{$bid|default:0}>
                }
            ).done(function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                $this.closest("#form_data" + id).remove();
            }).fail(function(xhr, status, error) {
                console.log("刪除失敗：", error);
            });
        });

        $('.upload_img').on('change', function() {
            var sort = $(this).data("id");
            console.log(sort);
            $(this).upload('<{$xoops_url}>/modules/tad_blocks/type/toolbar/upload.php',{op:'upload', sort: sort}, function(img_url) {
                console.log(img_url);
                $('#demo_pic' + sort).css('background-image','url('+img_url+')');
                $('#img_url' + sort).val(img_url);
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
            $(this).closest("tr").remove();
        });

        $("#img" + form_index).on('change', function() {
            var sort = $(this).data("id");
            console.log(sort);
            $(this).upload('<{$xoops_url}>/modules/tad_blocks/type/toolbar/upload.php',{op:'upload' , sort: sort}, function(img_url) {
                console.log(img_url);
                $('#demo_pic' + sort).css('background-image','url('+img_url+')');
                $('#img_url' + sort).val(img_url);
            }, 'html');
        });
        return form_index;
    }

</script>
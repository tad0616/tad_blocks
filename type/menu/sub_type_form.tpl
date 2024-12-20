<{$migrate|default:''}>
<link href="<{$xoops_url}>/modules/tad_blocks/type/menu/fontawesome-iconpicker/css/fontawesome-iconpicker.css" rel="stylesheet">
<script src="<{$xoops_url}>/modules/tad_blocks/type/menu/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js"></script>
<div id="save_msg"></div>
<table class="table" id="new_form">
    <tbody id="sort">
        <{if $text|default:false}>
            <{foreach from=$text key=i item=data}>
                <tr id="form_data<{$i|default:''}>">
                    <td style="width:40px;">
                        <button type="button" id="<{$i|default:''}>" class="btn btn-sm btn-danger remove_me"><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></button>
                    </td>
                    <td style="width:100px;">
                        <input type="text" name="TDC[icon][<{$i|default:''}>]" id="icon<{$i|default:''}>" class="icp demo form-control" value="<{$icon.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[url][<{$i|default:''}>]" id="url<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._MENU_ADD_URL}>" value="<{$url.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[text][<{$i|default:''}>]" id="text<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._MENU_ADD_TEXT}>" value="<{$data|default:''}>">
                    </td>
                    <td>
                        <select name="TDC[target][<{$i|default:''}>]" id="target<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TARGET}>">
                            <option value="_self" <{if $target.$i == '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_SELF}></option>
                            <option value="_blank" <{if $target.$i != '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_BLANK}></option>
                        </select>
                    </td>
                    <td style="width: 130px">
                        <div class="d-inline-block">
                            <div class="input-group">
                                <input type="text" name="TDC[m_color][<{$i|default:''}>]" id="m_color<{$i|default:''}>" class="form-control color-picker" data-hex="true" value="<{$m_color.$i}>">
                            </div>
                        </div>
                    </td>
                </tr>
            <{/foreach}>
        <{/if}>
    </tbody>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td style="width:40px;">
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></button>
        </td>
        <td style="width:100px;">
            <input type="text" data-name="TDC[icon]" id="icon" class="icp demo form-control" value="<{$default.icon}>">
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="<{$smarty.const._MENU_ADD_URL}>">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="<{$smarty.const._MENU_ADD_TEXT}>">
        </td>
        <td>
            <select data-name="TDC[target][<{$i|default:''}>]" id="target<{$i|default:''}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TARGET}>">
                <option value="_self" <{if $target.$i == '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_SELF}></option>
                <option value="_blank" <{if $target.$i != '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_BLANK}></option>
            </select>
        </td>
        <td style="width: 130px">
            <div class="d-inline-block">
                <div class="input-group">
                    <input type="text" data-name="TDC[m_color]" id="m_color" class="form-control color-picker" value="<{$default.m_color}>">
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="text-right text-end">
    <a href="#xoops_contents" id="add_form" class="btn btn-success"><{$smarty.const._MD_TAD_ADD_ONE}></a>
</div>

<div class="alert alert-info my-4">
    <div class="my-1">
        <{$smarty.const._MENU_FONT_SIZE}>
        <input type="number" name="TDC[font_size]" id="font_size" value="<{$font_size|default:''}>" class="my-input"> px
    </div>
    <div class="my-1">
        <{$smarty.const._MENU_TEXT_ALIGN}>
        <select name="TDC[text_align]" id="text_align" class="my-input">
            <option value="left" <{if $text_align=='left'}>selected<{/if}>><{$smarty.const._MENU_LEFT}></option>
            <option value="center" <{if $text_align=='center'}>selected<{/if}>><{$smarty.const._MENU_CENTER}></option>
            <option value="right" <{if $text_align=='right'}>selected<{/if}>><{$smarty.const._MENU_RIGHT}></option>
        </select>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        <{if $bid|default:false}>
            $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
                var order = $(this).sortable('serialize');
                order = order + '&col[]=icon&col[]=url&col[]=text&col[]=target&col[]=m_color&op=save_sort&bid=<{$bid|default:''}>';
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

        $('.demo').iconpicker({animation: false});
    });



    function clone_form(form_index){

        form_index++;
        //複製一份IP設定表單
        $("#new_form").append($("#form_data").clone().prop("id","form_data" + form_index));

        $("#form_data" + form_index + "  input").each(function(){
            $(this).prop("name",$(this).data("name") + "[" + form_index+"]");
            $(this).prop("id",$(this).prop("id") + form_index);
        });

        $("#form_data" + form_index + "  button").each(function(){
            $(this).prop("id",$(this).data("name") + form_index);
        });

        $("#remove_me" + form_index).click(function(){
            $(this).closest("#form_data" + form_index).remove();
        });

        $("#m_color" + form_index).mColorPicker({
            imageFolder: '<{$xoops_url}>/modules/tadtools/mColorPicker/images/'
        });

        $("#icon" + form_index).iconpicker({animation: false});

        return form_index;
    }

</script>
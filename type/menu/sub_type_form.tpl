<{$migrate|default:''}>

<div id="save_msg"></div>
<table class="table" id="new_form">
    <tbody id="sort">
        <{if $text|default:false}>
            <{foreach from=$text key=i item=data}>
                <tr id="form_data<{$i}>">
                    <td style="width:40px;">
                        <button type="button" id="<{$i}>" class="btn btn-sm btn-danger remove_me"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </td>
                    <td style="width:120px;" >
                        <input type="text" name="TDC[icon][<{$i}>]" id="icon<{$i}>" class="selectpicker form-control" value="<{$icon.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[url][<{$i}>]" id="url<{$i}>" class="form-control" placeholder="<{$smarty.const._MENU_ADD_URL}>" value="<{$url.$i}>">
                    </td>
                    <td>
                        <input type="text" name="TDC[text][<{$i}>]" id="text<{$i}>" class="form-control" placeholder="<{$smarty.const._MENU_ADD_TEXT}>" value="<{$data|default:''}>">
                    </td>
                    <td>
                        <select name="TDC[target][<{$i}>]" id="target<{$i}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TARGET}>">
                            <option value="_self" <{if $target.$i == '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_SELF}></option>
                            <option value="_blank" <{if $target.$i != '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_BLANK}></option>
                        </select>
                    </td>
                    <td style="width: 200px">
                        <div class="d-inline-block">
                            <div class="input-group">
                                <input type="text" name="TDC[m_color][<{$i}>]" id="m_color<{$i}>" class="form-control color-picker" data-hex="true" value="<{$m_color.$i}>">
                                <span class="input-group-text contrast-ratio" id="contrast<{$i}>"></span>
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
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
        <td style="width:100px;">
            <input type="text" data-name="TDC[icon]" id="icon" class="selectpicker icon-picker-input form-control" value="<{$default.icon}>">
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="<{$smarty.const._MENU_ADD_URL}>">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="<{$smarty.const._MENU_ADD_TEXT}>">
        </td>
        <td>
            <select data-name="TDC[target][<{$i}>]" id="target<{$i}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TARGET}>">
                <option value="_self" <{if $target.$i == '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_SELF}></option>
                <option value="_blank" <{if $target.$i != '_self'}>selected<{/if}>><{$smarty.const._LINK_ADD_TARGET_BLANK}></option>
            </select>
        </td>
        <td style="width: 200px">
            <div class="d-inline-block">
                <div class="input-group">
                    <input type="text" data-name="TDC[m_color]" id="m_color" class="form-control">
                    <span class="input-group-text contrast-ratio" id="contrast"></span>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="text-right text-end">
    <a href="#xoops_contents" id="add_form" class="btn btn-success"><{$smarty.const._MD_TAD_ADD_ONE}></a>
</div>


<{include file="$xoops_rootpath/modules/tad_blocks/templates/sub_batch_import.tpl"}>

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

<style>
.contrast-ratio {
    font-size: 0.825rem !important;
}
</style>


<script type="text/javascript">

    function getRelativeLuminance(color) {
        var r = parseInt(color.substr(1,2),16);
        var g = parseInt(color.substr(3,2),16);
        var b = parseInt(color.substr(5,2),16);
        r = r / 255;
        g = g / 255;
        b = b / 255;
        r = r <= 0.03928 ? r / 12.92 : Math.pow((r + 0.055) / 1.055, 2.4);
        g = g <= 0.03928 ? g / 12.92 : Math.pow((g + 0.055) / 1.055, 2.4);
        b = b <= 0.03928 ? b / 12.92 : Math.pow((b + 0.055) / 1.055, 2.4);
        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    }

    function getContrastRatio(color1, color2) {
        var l1 = getRelativeLuminance(color1);
        var l2 = getRelativeLuminance(color2);
        var lighter = Math.max(l1, l2);
        var darker = Math.min(l1, l2);
        return (lighter + 0.05) / (darker + 0.05);
    }

    function rgbToHex(rgb) {
        var result = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        if (result) {
            var r = parseInt(result[1]).toString(16);
            var g = parseInt(result[2]).toString(16);
            var b = parseInt(result[3]).toString(16);
            r = r.length == 1 ? "0" + r : r;
            g = g.length == 1 ? "0" + g : g;
            b = b.length == 1 ? "0" + b : b;
            return "#" + r + g + b;
        }
        return rgb; // 如果不是 RGB 格式，返回原值
    }

    function updateContrast(index) {
        var color = $("#m_color" + index).val();
        var contrastSpan = $("#contrast" + index);
        if(color) {
            if(color.startsWith('rgb')) {
                color = rgbToHex(color);
            }
            if(color.startsWith('#')) {
                var contrast = getContrastRatio(color, '#ffffff').toFixed(2);
                contrastSpan.text(contrast + ':1');
                if(parseFloat(contrast) < 4.5) {
                    contrastSpan.css('color', 'red');
                } else {
                    contrastSpan.css('color', 'darkblue');
                }
            } else {
                contrastSpan.text('').css('color', '');
            }
        } else {
            contrastSpan.text('').css('color', '');
        }
    }

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
            var form_index=<{$i}>;
            <{foreach from=$text key=i item=data}>
                updateContrast(<{$i}>);
                $("#m_color<{$i}>").change(function(){
                    updateContrast(<{$i}>);
                });
            <{/foreach}>
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

        $('.selectpicker').iconPicker('<{$xoops_url}>/modules/tadtools/fontawesome6-picker/', {
            showIconName: false  // 不顯示圖示名稱
        });
    });



    function clone_form(form_index) {
        form_index++;
        //複製一份IP設定表單
        $("#new_form").append($("#form_data").clone().prop("id","form_data" + form_index));
        $("#form_data" + form_index + "  input").each(function(){
            $(this).prop("name",$(this).data("name") + "[" + form_index+"]");
            $(this).prop("id",$(this).prop("id") + form_index);
            if ($(this).data("name") === "TDC[m_color]") {
                $(this).addClass("color-picker");
            }
        });
        $("#form_data" + form_index + "  button").each(function(){
            $(this).prop("id",$(this).data("name") + form_index);
        });
        $("#form_data" + form_index + "  span").each(function(){
            if($(this).prop("id") == "contrast") {
                $(this).prop("id", "contrast" + form_index);
            }
        });
        $("#remove_me" + form_index).click(function(){
            $(this).closest("#form_data" + form_index).remove();
        });
        $("#m_color" + form_index).mColorPicker({
            imageFolder: '<{$xoops_url}>/modules/tadtools/mColorPicker/images/',
            hex: true,
            showPicker: 'bootstrap'
        });
        updateContrast(form_index);
        $("#m_color" + form_index).change(function(){
            updateContrast(form_index);
        });
        $.fn.iconPicker.reinitialize();
        return form_index;
    }


</script>
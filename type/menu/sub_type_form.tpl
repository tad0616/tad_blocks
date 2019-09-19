<{$migrate}>
<link href="<{$xoops_url}>/modules/tad_blocks/type/menu/fontawesome-iconpicker/css/fontawesome-iconpicker.css" rel="stylesheet">
<script src="<{$xoops_url}>/modules/tad_blocks/type/menu/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js"></script>

<table class="table" id="new_form">
    <{if $text}>
        <{foreach from=$text key=i item=text}>
            <tr id="form_data<{$i}>">
                <td style="width:40px;">
                    <button type="button" id="<{$i}>" class="btn btn-sm btn-danger remove_me">移除</button>
                </td>
                <td style="width:100px;">
                    <input type="text" name="TDC[icon][<{$i}>]" id="icon<{$i}>" class="icp demo form-control" value="<{$icon.$i}>">
                </td>
                <td>
                    <input type="text" name="TDC[url][<{$i}>]" id="url<{$i}>" class="form-control" placeholder="請輸入網址" value="<{$url.$i}>">
                </td>
                <td>
                    <input type="text" name="TDC[text][<{$i}>]" id="text<{$i}>" class="form-control" placeholder="請輸入選項文字" value="<{$text}>">
                </td>
                <td style="width: 130px">
                    <input type="text" name="TDC[m_color][<{$i}>]" id="m_color<{$i}>" class="form-control color-picker" data-hex="true" value="<{$m_color.$i}>">
                </td>
            </tr>
        <{/foreach}>
    <{/if}>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td style="width:40px;">
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" >移除</button>
        </td>
        <td style="width:100px;">
            <input type="text" data-name="TDC[icon]" id="icon" class="icp demo form-control">
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="請輸入網址">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="請輸入項目文字">
        </td>
        <td style="width: 130px">
            <input type="text" data-name="TDC[m_color]" id="m_color" class="form-control color-picker">
        </td>
    </tr>
</table>

<div class="text-right">
    <a href="#" id="add_form" class="btn btn-success">新增一組</a>
</div>

<div class="alert alert-info my-4">
    文字大小：<input type="number" name="TDC[font_size]" id="font_size" value="<{$font_size}>"> px<br>
    對齊方向：<select name="TDC[text_align]" id="text_align">
    <option value="left" <{if $text_align=='left'}>selected<{/if}>>靠左對齊</option>
    <option value="center" <{if $text_align=='center'}>selected<{/if}>>置中對齊</option>
    <option value="right" <{if $text_align=='right'}>selected<{/if}>>靠右對齊</option>
    </select>
</div>

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
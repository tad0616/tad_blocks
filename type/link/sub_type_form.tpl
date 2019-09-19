<table class="table" id="new_form">
    <{if $text}>
        <{foreach from=$text key=i item=text}>
            <tr id="form_data<{$i}>">
                <td style="width:40px;">
                    <button type="button" id="<{$i}>" class="btn btn-sm btn-danger remove_me">移除</button>
                </td>
                <td>
                    <input type="text" name="TDC[url][<{$i}>]" id="url<{$i}>" class="form-control" placeholder="請輸入網址" value="<{$url.$i}>">
                </td>
                <td>
                    <input type="text" name="TDC[text][<{$i}>]" id="text<{$i}>" class="form-control" placeholder="請輸入選項文字" value="<{$text}>">
                </td>
            </tr>
        <{/foreach}>
    <{/if}>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td style="width:80px;">
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" >移除</button>
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="請輸入網址">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="請輸入項目文字">
        </td>
    </tr>
</table>

<div class="text-right">
    <a href="#" id="add_form" class="btn btn-success">新增一組</a>
</div>

<div class="alert alert-info my-4">
    顯示類型：<select name="TDC[show_type]]" id="show_type">
    <option value="default"" <{if $show_type=='default'}>selected<{/if}>>預設</option>
    <option value="ul" <{if $show_type=='ul'}>selected<{/if}>>無序清單</option>
    <option value="ol" <{if $show_type=='ol'}>selected<{/if}>>數字清單</option>
    <option value="table" <{if $show_type=='table'}>selected<{/if}>>表格</option>
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

        return form_index;
    }

</script>
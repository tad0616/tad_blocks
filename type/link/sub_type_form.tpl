
<table class="table" id="new_form">
     <{if $content}>
        <{foreach from=$content key=i item=marquee}>
            <tr id="form_data<{$i}>">
                <td style="width:80px;">
                    <button type="button" id="<{$i}>" class="btn btn-sm btn-danger remove_me">移除</button>
                </td>
                <td>
                    <input type="text" name="TDC[content][<{$i}>]" id="TDC[content]<{$i}>" class="form-control" placeholder="請輸入跑馬燈內容" value="<{$marquee}>">
                </td>
            </tr>
        <{/foreach}>
    <{/if}>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td style="width:80px;">
            <button type="button" id="remove_me" class="btn btn-sm btn-danger" >移除</button>
        </td>
        <td>
            <input type="text" id="TDC[content]" class="form-control" placeholder="請輸入跑馬燈內容">
        </td>
    </tr>
</table>

<div class="text-right">
    <a href="#" id="add_form" class="btn btn-success">新增一組</a>
</div>

<div class="alert alert-info my-4">
    文字大小：<input type="number" name="TDC[font_size]" id="font_size" value="<{$font_size}>"> px<br>
    文字顏色：<input type="text" name="TDC[text_color]" id="text_color" value="<{$text_color}>" class="color" data-hex="true"><br>
    背景顏色：<input type="text" name="TDC[bg_color]" id="bg_color" value="<{$bg_color}>" class="color" data-hex="true"><br>
    上下內距：<input type="number" name="TDC[padding_y]" id="padding_y" value="<{$padding_y}>"> px<br>
    框線粗細：<input type="number" name="TDC[border_size]]" id="border_size" value="<{$border_size}>"> px<br>
    框線種類：<select name="TDC[border_type]" id="border_type">
    <option value="solid" <{if $border_type=='solid'}>selected<{/if}>>實線</option>
    <option value="dotted" <{if $border_type=='dotted'}>selected<{/if}>>點線</option>
    <option value="dashed" <{if $border_type=='dashed'}>selected<{/if}>>虛線</option>
    <option value="double" <{if $border_type=='double'}>selected<{/if}>>雙線</option>
    <option value="groove" <{if $border_type=='groove'}>selected<{/if}>>凹線</option>
    <option value="ridge" <{if $border_type=='ridge'}>selected<{/if}>>凸線</option>
    <option value="inset" <{if $border_type=='inset'}>selected<{/if}>>嵌入線</option>
    <option value="outset" <{if $border_type=='outset'}>selected<{/if}>>浮出線</option>
    </select><br>
    框線顏色：<input type="text" name="TDC[border_color]" id="border_color" value="<{$border_color}>" class="color" data-hex="true">
</div>

<script type="text/javascript">

    $(document).ready(function(){
        <{if $content}>
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
            $(this).prop("name",$(this).prop("id") + "[" + form_index+"]");
            $(this).prop("id",$(this).prop("id") + form_index);
        });

        $("#form_data" + form_index + "  button").each(function(){
            $(this).prop("id",$(this).prop("id") + form_index);
            $(this).prop("name",$(this).prop("name") + form_index);
        });

        $("#remove_me" + form_index).click(function(){
            $(this).closest("#form_data" + $(this).prop("name")).remove();
        });


        return form_index;
    }

</script>
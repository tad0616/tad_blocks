
<table class="table" id="new_form">
     <{if $content}>
        <{foreach from=$content key=i item=marquee}>
            <tr id="form_data<{$i}>">
                <td style="width:40px;">
                    <button type="button" id="<{$i}>" class="btn btn-sm btn-danger remove_me"><{$smarty.const._TAD_DEL}></button>
                </td>
                <td>
                    <input type="text" name="TDC[content][<{$i}>]" id="TDC[content]<{$i}>" class="form-control" placeholder="<{$smarty.const._MARQUEE_ADD_CONTENT}>" value="<{$marquee}>">
                </td>
            </tr>
        <{/foreach}>
    <{/if}>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td style="width:40px;">
            <button type="button" id="remove_me" class="btn btn-sm btn-danger" ><{$smarty.const._TAD_DEL}></button>
        </td>
        <td>
            <input type="text" id="TDC[content]" class="form-control" placeholder="<{$smarty.const._MARQUEE_ADD_CONTENT}>">
        </td>
    </tr>
</table>

<div class="text-right">
    <a href="#block_setup" id="add_form" class="btn btn-success"><{$smarty.const._MD_TAD_ADD_ONE}></a>
</div>

<div class="alert alert-info my-4">
    <{$smarty.const._MARQUEE_FONT_SIZE}><input type="number" name="TDC[font_size]" id="font_size" value="<{$font_size}>"> px<br>
    <{$smarty.const._MARQUEE_FONT_COLOR}><input type="text" name="TDC[text_color]" id="text_color" value="<{$text_color}>" class="color" data-hex="true"><br>
    <{$smarty.const._MARQUEE_BG_COLOR}><input type="text" name="TDC[bg_color]" id="bg_color" value="<{$bg_color}>" class="color" data-hex="true"><br>
    <{$smarty.const._MARQUEE_PADDING}><input type="number" name="TDC[padding_y]" id="padding_y" value="<{$padding_y}>"> px<br>
    <{$smarty.const._MARQUEE_BORDER_SIZE}><input type="number" name="TDC[border_size]]" id="border_size" value="<{$border_size}>"> px<br>
    <{$smarty.const._MARQUEE_BORDER_TYPE}><select name="TDC[border_type]" id="border_type">
    <option value="solid" <{if $border_type=='solid'}>selected<{/if}>><{$smarty.const._MARQUEE_SOLID}></option>
    <option value="dotted" <{if $border_type=='dotted'}>selected<{/if}>><{$smarty.const._MARQUEE_DOTTED}></option>
    <option value="dashed" <{if $border_type=='dashed'}>selected<{/if}>><{$smarty.const._MARQUEE_DASHED}></option>
    <option value="double" <{if $border_type=='double'}>selected<{/if}>><{$smarty.const._MARQUEE_DOUBLE}></option>
    <option value="groove" <{if $border_type=='groove'}>selected<{/if}>><{$smarty.const._MARQUEE_GROOVE}></option>
    <option value="ridge" <{if $border_type=='ridge'}>selected<{/if}>><{$smarty.const._MARQUEE_RIDGE}></option>
    <option value="inset" <{if $border_type=='inset'}>selected<{/if}>><{$smarty.const._MARQUEE_INSET}></option>
    <option value="outset" <{if $border_type=='outset'}>selected<{/if}>><{$smarty.const._MARQUEE_OUTSET}></option>
    </select><br>
    <{$smarty.const._MARQUEE_BORDER_COLOR}><input type="text" name="TDC[border_color]" id="border_color" value="<{$border_color}>" class="color" data-hex="true">
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
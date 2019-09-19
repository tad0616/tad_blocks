<table class="table" id="new_form">
    <{if $text}>
        <{foreach from=$text key=i item=text}>
            <tr id="form_data<{$i}>">
                <td style="width:40px;">
                    <button type="button" id="<{$i}>" class="btn btn-sm btn-danger remove_me"><{$smarty.const._TAD_DEL}></button>
                </td>
                <td>
                    <input type="text" name="TDC[url][<{$i}>]" id="url<{$i}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_URL}>" value="<{$url.$i}>">
                </td>
                <td>
                    <input type="text" name="TDC[text][<{$i}>]" id="text<{$i}>" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TEXT}>" value="<{$text}>">
                </td>
            </tr>
        <{/foreach}>
    <{/if}>
</table>

<!--表單樣板-->
<table style="display:none;">
    <tr id="form_data">
        <td style="width:80px;">
            <button type="button" data-name="remove_me" class="btn btn-sm btn-danger" ><{$smarty.const._TAD_DEL}></button>
        </td>
        <td>
            <input type="text" data-name="TDC[url]" id="url" class="form-control" placeholder="<{$smarty.const._LINK_ADD_URL}>">
        </td>
        <td>
            <input type="text" data-name="TDC[text]" id="text" class="form-control" placeholder="<{$smarty.const._LINK_ADD_TEXT}>">
        </td>
    </tr>
</table>

<div class="text-right">
    <a href="#block_setup" id="add_form" class="btn btn-success"><{$smarty.const._MD_TAD_ADD_ONE}></a>
</div>

<div class="alert alert-info my-4">
    <{$smarty.const._LINK_SHOW_TYPE}><select name="TDC[show_type]]" id="show_type">
    <option value="default"" <{if $show_type=='default'}>selected<{/if}>><{$smarty.const._LINK_DEFAULT}></option>
    <option value="ul" <{if $show_type=='ul'}>selected<{/if}>><{$smarty.const._LINK_UL}></option>
    <option value="ol" <{if $show_type=='ol'}>selected<{/if}>><{$smarty.const._LINK_OL}></option>
    <option value="table" <{if $show_type=='table'}>selected<{/if}>><{$smarty.const._LINK_TABLE}></option>
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
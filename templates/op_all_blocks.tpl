
<h3>
<{$smarty.const._MD_TADBLOCKS_BLOCKS}>
    <a href="index.php?op=block_form" class="btn btn-primary"><{$smarty.const._MD_TAD_BLOCKS_ADD_BLOCK}></a></h3>

<form class="form-inline">
    <label for="only_mod"><{$smarty.const._MD_TAD_BLOCKS_ONLY}></label>
    <select id="only_mod" class="form-select" style="max-width: 20rem;">
        <option value=""></option>
        <{foreach from=$alldir key=dirname item=name}>
            <option value="<{$dirname|default:''}>"><{$name|default:''}> (<{$dirname|default:''}>)</option>
        <{/foreach}>
    </select>

    <div class="form-check-inline checkbox-inline">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" id="only_visible" checked>
            <{$smarty.const._MD_TAD_BLOCKS_ONLY_VISIBLE}>
        </label>
    </div>
</form>

<div class="mb-5">
    <{if $theme_type|default:false}>
        <{include file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_`$theme_type`.tpl"}>
    <{else}>
        <{include file="$xoops_rootpath/modules/tad_blocks/templates/sub_position_theme_type_5.tpl"}>
    <{/if}>
</div>

<{if $xoopsModuleConfig.show_save_and_re_build_logo|default:false}>
    <{include file="$xoops_rootpath/modules/tad_blocks/templates/sub_logo_form.tpl"}>
<{/if}>

<script>

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        var side_arr = {0:'#side-0', 1:'#side-1', 3:'#side-3', 4:'#side-4', 5:'#side-5', 7:'#side-7', 8:'#side-8', 9:'#side-9', 10:'#side-10', 11:'#side-11', 12:'#side-12'};

        $('#side-0, #side-1, #side-3, #side-4, #side-5, #side-7, #side-8, #side-9, #side-10, #side-11, #side-12').sortable({
            connectWith: ".droppable",
            placeholder: "side-highlight",
            distance: 5,
            opacity: 0.6,
            cursor: 'move',
            update:function() {
                $.each(side_arr, function(index,val) {
                    var sort = 0;
                    $(val).children('.b-item').each(function(){
                        //console.log(index + '=>' + $(this).data('bid'));
                        $.post("<{$xoops_url}>/modules/tad_blocks/ajax.php", { op: "update_newblock", bid: $(this).data('bid'), side: index, weight: sort}, function(err) {
                            if(err)console.log(err);
                        });
                        sort++;
                    });
                });
            }
        }).disableSelection();


        invisible_block();

        $('#only_visible').change(function(){
            invisible_block();
        });


        $('#only_mod').change(function(){
            invisible_block();
        });



        $('.module_id').click(function(){
            var bid=$(this).data('bid');
            if($(this).prop("src")=="<{$xoops_url}>/modules/tad_blocks/images/home.png"){
                $(this).attr("src","<{$xoops_url}>/modules/tad_blocks/images/coding.png");
                $(this).attr("alt","<{$smarty.const._MD_TAD_BLOCKS_TO_ONLY_HOME}>");
                $(this).attr("title","<{$smarty.const._MD_TAD_BLOCKS_TO_ONLY_HOME}>");
                $(this).attr("data-val","0");
                $(this).attr("data-original-title","<{$smarty.const._MD_TAD_BLOCKS_TO_ONLY_HOME}>");
                $.post("<{$xoops_url}>/modules/tad_blocks/ajax.php", { op: "change_block_module_link", bid: bid, module_id:'0'}, function(err) {if(err)console.log(err);});
            }else{
                $(this).attr("src","<{$xoops_url}>/modules/tad_blocks/images/home.png");
                $(this).attr("alt","<{$smarty.const._MD_TAD_BLOCKS_TO_ALL_PAGES}>");
                $(this).attr("title","<{$smarty.const._MD_TAD_BLOCKS_TO_ALL_PAGES}>");
                $(this).attr("data-val","-1");
                $(this).attr("data-original-title","<{$smarty.const._MD_TAD_BLOCKS_TO_ALL_PAGES}>");
                $.post("<{$xoops_url}>/modules/tad_blocks/ajax.php", { op: "change_block_module_link", bid: bid, module_id:'-1'}, function(err) {if(err)console.log(err);});
            }
        });


        $('.change_visible').click(function(){
            var bid=$(this).data('bid');
            console.log(bid);
            if($('#bid-'+bid).hasClass('visible_block')){
                $('#bid-'+bid).removeClass("visible_block");
                $('#bid-'+bid).addClass("invisible_block");
            }else{
                $('#bid-'+bid).removeClass("invisible_block");
                $('#bid-'+bid).addClass("visible_block");
            }

            if($(this).prop("src")=="<{$xoops_url}>/modules/tad_blocks/images/no.png"){
                // 啟動
                $(this).prop("src","<{$xoops_url}>/modules/tad_blocks/images/yes.png");
                $(this).attr("alt","<{$smarty.const._MD_TAD_BLOCKS_TO_UNABLE}>");
                $(this).attr("title","<{$smarty.const._MD_TAD_BLOCKS_TO_UNABLE}>");
                $(this).attr("data-original-title","<{$smarty.const._MD_TAD_BLOCKS_TO_UNABLE}>");
                $.post("<{$xoops_url}>/modules/tad_blocks/ajax.php", { op: "visible", bid: bid}, function(err) {
                    if(err)console.log(err);
                });
            }else{
                // 關閉
                $(this).prop("src","<{$xoops_url}>/modules/tad_blocks/images/no.png");
                $(this).attr("alt","<{$smarty.const._MD_TAD_BLOCKS_TO_ENABLE}>");
                $(this).attr("title","<{$smarty.const._MD_TAD_BLOCKS_TO_ENABLE}>");
                $(this).attr("data-original-title","<{$smarty.const._MD_TAD_BLOCKS_TO_ENABLE}>");
                $.post("<{$xoops_url}>/modules/tad_blocks/ajax.php", { op: "invisible", bid: bid}, function(err) {
                    if(err)console.log(err);
                });
            }
        });

    });

    function invisible_block(){

        var only_mod=$('#only_mod').val();
        var only_visible=$('#only_visible').prop('checked');

        if(only_mod!='' && only_visible==true){
            $('.b-item').hide();
            $('.visible_block.'+only_mod).show();
        }else if(only_mod!='' && only_visible!=true){
            $('.b-item').hide();
            $('.'+only_mod).show();
        }else if(only_mod=='' && only_visible==true){
            $('.b-item').show();
            $('.invisible_block').hide();
        }else{
            $('.b-item').show();
        }

    }
</script>
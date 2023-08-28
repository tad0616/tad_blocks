<?php
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

//取得 gallery 區塊 DataCenter 內容
function get_content($bid = 0)
{
    global $xoopsTpl;

    require __DIR__ . "/config.php";
    foreach ($default as $k => $v) {
        $xoopsTpl->assign($k, $v);
    }
    $xoopsTpl->assign('default', $default);
    // 傳回陣列的項目
    if ($bid) {
        $arr = ['groups'];
        $TadDataCenter = new TadDataCenter('tad_blocks');
        $TadDataCenter->set_col('bid', $bid);
        $block = $TadDataCenter->getData();

        foreach ($block as $k => $v) {
            if (in_array($k, $arr)) {
                $xoopsTpl->assign($k, $v);
            } else {
                $xoopsTpl->assign($k, $v[0]);
            }
        }
    }

    $pic_col_sn = $block['pic_col_sn'][0] ? $block['pic_col_sn'][0] : $default['pic_col_sn'];

    $TadUpFiles = new TadUpFiles("tad_blocks");
    $TadUpFiles->set_col('gallery', $pic_col_sn);
    $xoopsTpl->assign('pic_col_sn', $pic_col_sn);

    // $TadUpFiles->set_var('require', true); //必填
    $TadUpFiles->set_var("show_tip", false); //不顯示提示
    $upform = $TadUpFiles->upform(true, 'gallery_files');
    $xoopsTpl->assign('upform', $upform);

    return $block;
}

//製作 gallery 區塊內容
function mk_content($TDC)
{

    require __DIR__ . "/config.php";
    $myts = \MyTextSanitizer::getInstance();

    $mode = empty($TDC['mode']) ? $default['mode'] : $myts->htmlSpecialChars($TDC['mode']);
    $show_desc = empty($TDC['show_desc']) ? $default['show_desc'] : (int) $TDC['show_desc'];
    $bg_size = empty($TDC['bg_size']) ? $default['bg_size'] : $myts->htmlSpecialChars($TDC['bg_size']);
    $pic_col_sn = empty($TDC['pic_col_sn']) ? $default['pic_col_sn'] : (int) $TDC['pic_col_sn'];
    $show_width = empty($TDC['show_width']) ? $default['show_width'] : (int) $TDC['show_width'];
    $show_height = empty($TDC['show_height']) ? $default['show_height'] : (int) $TDC['show_height'];
    $desc_height = empty($TDC['desc_height']) ? $default['desc_height'] : (int) $TDC['desc_height'];
    $thumb_css = empty($TDC['thumb_css']) ? $default['thumb_css'] : $myts->htmlSpecialChars($TDC['thumb_css']);
    $thumb_css .= "background-size: $bg_size";
    $TadUpFiles = new TadUpFiles("tad_blocks");
    $TadUpFiles->set_col('gallery', $pic_col_sn);
    $TadUpFiles->upload_file('gallery_files', null, null, null, null, true);

    $fancybox = new FancyBox(".fancybox_gallery" . $pic_col_sn, '1920', '1080');
    $content = $fancybox->render(false, null, null, null, true);

    if ($mode === 'thumbs') {

        $TadUpFiles->set_var('thumb_css', $thumb_css);
        $TadUpFiles->set_var('show_width', $show_width);
        $TadUpFiles->set_var('show_height', $show_height);
        $TadUpFiles->set_var('desc_height', $desc_height);
        $content .= "
        <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . XOOPS_URL . "/modules/tad_blocks/type/gallery/thumbs.css'>";
        $content .= $TadUpFiles->show_files('gallery_files', true, $mode, $show_desc, false, null, null, false);

        //show_files($upname="",$thumb=true,$show_mode="",$show_description=false,$show_dl=false,$limit=NULL,$path=NULL,$hash=false,$playSpeed=5000)

    } elseif ($mode === 'marquee') {

        $file_arr = $TadUpFiles->get_file(null, null, null, false, true);

        $content .= "
        <script src='" . XOOPS_URL . "/modules/tad_blocks/type/gallery/grouploop-1.0.3.min.js'></script>
        <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . XOOPS_URL . "/modules/tad_blocks/type/gallery/marquee.css'>
        <div class='promo-carousel' id='grouploop-example'>
        <div class='item-wrap'>
        ";
        foreach ($file_arr as $files_sn => $pic) {
            $content .= "
            <div class='item'>
                <a href='{$pic['path']}' title='{$pic['description']}' rel='fgallery{$pic_col_sn}' class='fancybox_gallery{$pic_col_sn}'><img src='{$pic['tb_path']}' alt='{$pic['description']}' title='{$pic['description']}'></a>
            </div>";
        }

        $content .= "
        </div>
      </div>
      <script>
      $(document).ready(function(){
            $('#grouploop-example').grouploop({
                velocity: 1,
                forward: false,
                pauseOnHover: true,
                childNode: '.item',
                childWrapper: '.item-wrap'
            });
        });
        </script>
      ";
    } elseif ($mode === 'slide') {

        $file_arr = $TadUpFiles->get_file(null, null, null, false, true);

        $content .= "
        <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/ResponsiveSlides/reset.css' >
        <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/ResponsiveSlides/responsiveslides.css'>
        <script language='javascript' type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/ResponsiveSlides/responsiveslides.js'></script>

        <script type='text/javascript'>
            $(document).ready( function(){
                $('#slide_{$pic_col_sn}').responsiveSlides({
                    auto: true,
                    pager: false,
                    nav: true,
                    timeout: 5000,
                    pause: true,
                    pauseControls: true,
                    namespace: 'callbacks'
                });
            });
        </script>
        <div class='callbacks'>
            <ul class='rslides' id='slide_{$pic_col_sn}'>
        ";

        foreach ($file_arr as $files_sn => $pic) {

            $caption = ($pic['description']) ? "
            <div class='caption_txt'>
                {$pic['description']}
            </div>" : '';

            $content .= "
                <li>
                    <img src='{$pic['path']}' alt='{$pic['description']}'>
                    $caption
                </li>
            ";

            $i++;
        }

        $content .= "
            </ul>
        </div>
        <div class=\"clearfix\"></div>
      ";
    }

    $content = $myts->addSlashes($content);
    return $content;
}

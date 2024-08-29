<?php
use XoopsModules\Tadtools\TadDataCenter;

//取得 youtube 區塊DataCenter內容
function get_content($bid = 0)
{
    global $xoopsTpl;

    require __DIR__ . "/config.php";
    foreach ($default as $k => $v) {
        $xoopsTpl->assign($k, $v);
    }
    $xoopsTpl->assign('default', $default);
    $block = [];
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
    return $block;
}

//製作 youtube 區塊內容
function mk_content($bid, $TDC)
{

    require __DIR__ . "/config.php";

    $youtube_id = getYouTubeId($TDC['video_url']);

    $title = strip_tags($TDC['title']);
    $title = $title ? $title : 'iframe';

    $youtube_ratios5 = $TDC['youtube_ratios'];
    $youtube_ratios4 = str_replace('x', 'by', $youtube_ratios5);
    $content = <<<"EOD"
<div id="tad_block_youtube_{$bid}" class="embed-responsive embed-responsive-{$youtube_ratios4} ratio ratio-{$youtube_ratios5}">
    <iframe title="$title" class="embed-responsive-item" src="https://www.youtube.com/embed/{$youtube_id}" allowfullscreen></iframe>
</div>
EOD;

    return $content;
}

//抓取 Youtube ID
function getYouTubeId($ytURL = '')
{
    if (0 === mb_strpos($ytURL, 'https://youtu.be/')) {
        return mb_substr($ytURL, 16);
    }
    parse_str(parse_url($ytURL, PHP_URL_QUERY), $params);

    return $params['v'];
}

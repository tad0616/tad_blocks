
<!-- 批次匯入 -->
 <div class="text-right text-end my-2">
    <button type="button" id="toggle_batch_import" class="btn btn-warning">
        <i class="fa fa-upload" aria-hidden="true"></i> 批次匯入
    </button>
</div>


<div id="batch_import" class="disabled-section" style="display: none;">
    <link rel="stylesheet" href="css/check_url.css">
    <div class="form-group">
        <label class="form-label">直接從網頁複製連結並貼到這裡（支援 HTML 格式），貼上後按下方的分析連結按鈕即可</label>
        <{$editor}>
    </div>

    <button id="analyzeBtn" class="btn btn-primary my-2">
        <i class="fa-solid fa-list-check"></i> 開始分析連結
    </button>

    <div id="results" class="results hidden">
        <div class="results-header">
            <h3>分析結果 (<span id="resultCount">0</span> 個連結)</h3>
            <{*
            <button type="button" id="copyBtn" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg><span id="copyBtnText">複製 JSON</span>
            </button>
            *}>
        </div>

        <div id="linkList" class="link-list"></div>

        <div class="json-preview">
            <h3>分析結果</h3>
            <textarea id="jsonCode" name="TDC[url_json_code]" class="form-control json-code" rows="10" aria-label="分析結果"></textarea>
        </div>
    </div>
    <script src="<{$xoops_url}>/modules/tad_blocks/class/check_url.js?t=<{$smarty.now}>" charset="utf-8" type="text/javascript"></script>
</div>


<script type="text/javascript">
    $(document).ready(function(){

        $("#toggle_batch_import").click(function(){
            var batchImport = $("#batch_import");
            batchImport.toggle();
            batchImport.toggleClass("disabled-section", !batchImport.is(":visible"));
            $(this).toggleClass("btn-warning btn-secondary");
        });

    });
</script>
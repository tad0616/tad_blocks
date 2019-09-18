<link href="<{$xoops_url}>/modules/tadtools/CodeMirror/lib/codemirror.css" rel="stylesheet" type="text/css">
<link href="<{$xoops_url}>/modules/tadtools/CodeMirror/theme/material.css" rel="stylesheet" type="text/css">
<link href="<{$xoops_url}>/modules/tadtools/CodeMirror/addon/display/fullscreen.css" rel="stylesheet" type="text/css">
<!-- 引入CodeMirror核心文件 -->
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/lib/codemirror.js"></script>

<!-- CodeMirror支持不同语言，根据需要引入JS文件 -->
<!-- 因为HTML混合语言依赖Javascript、XML、CSS语言支持，所以都要引入 -->
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/mode/javascript/javascript.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/mode/xml/xml.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/mode/css/css.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>

<!-- 下面分别为显示行数、括号匹配和全屏插件 -->
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/addon/selection/active-line.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/addon/edit/matchbrackets.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/CodeMirror/addon/display/fullscreen.js"></script>


<textarea name="TDC[content]" id="content_code" class="form-control" rows="10"><{$content}></textarea>

<script>
$(document).ready(function(){
    var editor = CodeMirror.fromTextArea(document.getElementById("content_code"), {
        lineNumbers: true,     // 显示行数
        indentUnit: 4,         // 缩进单位为4
        styleActiveLine: true, // 当前行背景高亮
        matchBrackets: true,   // 括号匹配
        mode: 'htmlmixed',     // HMTL混合模式
        lineWrapping: true,    // 自动换行
        theme: 'material',      // 使用monokai模版
    });
    editor.setOption("extraKeys", {
        // Tab键换成4个空格
        Tab: function(cm) {
            var spaces = Array(cm.getOption("indentUnit") + 1).join(" ");
            cm.replaceSelection(spaces);
        },
        // F11键切换全屏
        "F11": function(cm) {
            cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        },
        // Esc键退出全屏
        "Esc": function(cm) {
            if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        }
    });
});
</script>
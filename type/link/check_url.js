const analyzeBtn = document.getElementById('analyzeBtn');
const results = document.getElementById('results');
const linkList = document.getElementById('linkList');
const jsonCode = document.getElementById('jsonCode');
const copyBtn = document.getElementById('copyBtn');
const resultCount = document.getElementById('resultCount');

let analysisResults = [];
let editorInstance = null;

// 在 CKEditor 準備好後初始化
document.addEventListener('DOMContentLoaded', function() {
    // 檢查 CKEDITOR 是否存在
    if (typeof CKEDITOR !== 'undefined') {
        // 等待 CKEditor 實例準備好
        CKEDITOR.on('instanceReady', function(event) {
            if (event.editor.name === 'editor_content') {
                editorInstance = event.editor;
                console.log('CKEditor 實例已準備好');
            }
        });
    } else {
        console.error('找不到 CKEDITOR 對象，請確保 CKEditor 已正確載入');
    }
});

function shouldSkipUrl(url) {
    return /\.(jpg|jpeg|png|gif)(?:[?#]|$)/i.test(url) || url.includes('modules/tad_link/index.php?link_sn=');
}

// 從 HTML 提取連結
function extractLinksFromHTML(html) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const links = doc.querySelectorAll('a[href]');

    const extractedLinks = [];
    const seenLinks = new Set();

    links.forEach(link => {
        const url = link.href;
        const title = link.textContent.trim() || link.getAttribute('title') || '';

        const img = link.querySelector('img');
        const logo = img ? img.src : '';

        // 建立一個唯一標識符，結合網址與標題
        const linkKey = `${url}|${title}`;

        if (url && url.startsWith('http') && !shouldSkipUrl(url) && !seenLinks.has(linkKey)) {
            extractedLinks.push({ url, title, logo });
            seenLinks.add(linkKey);
        }
    });

    return extractedLinks;
}

// 檢查連結狀態
async function checkLinkStatus(url) {
    try {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000);

        const response = await fetch(url, {
            method: 'HEAD',
            mode: 'no-cors',
            signal: controller.signal
        });

        clearTimeout(timeoutId);
        return { status: true, statusCode: 'OK' };
    } catch (error) {
        if (error.name === 'AbortError') {
            return { status: false, statusCode: 'Timeout' };
        }
        return { status: false, statusCode: 'Error' };
    }
}

// 渲染連結項目
function renderLinkItem(result) {
    const item = document.createElement('div');
    item.className = 'link-item';

    const statusIcon = result.isActive
        ? '<svg class="status-ok" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
        : '<svg class="status-error" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';

    const logoHTML = result.logo
        ? `<img src="${result.logo}" class="link-logo" onerror="this.style.display='none'">`
        : '';

    item.innerHTML = `
        <div class="link-content">
            ${logoHTML}
            <div class="link-info">
                <div class="link-title">
                    ${statusIcon}
                    <span>${result.title || '無標題'}</span>
                </div>
                <a href="${result.url}" target="_blank" rel="noopener noreferrer" class="link-url">
                    ${result.url}
                </a>
                <div class="link-status">狀態: ${result.statusCode}</div>
            </div>
        </div>
    `;

    return item;
}

// 分析按鈕點擊事件
analyzeBtn.addEventListener('click', async () => {
    // 檢查 CKEditor 實例是否存在
    if (!editorInstance) {
        // 嘗試直接從 CKEDITOR 全局對象獲取實例
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.editor_content) {
            editorInstance = CKEDITOR.instances.editor_content;
        } else {
            alert('編輯器尚未準備好，請稍後再試');
            return;
        }
    }

    // 使用 CKEditor API 獲取內容
    const content = editorInstance.getData();

    console.log('獲取到的內容:', content); // 調試用

    if (!content.trim()) {
        alert('請先貼上包含連結的內容！');
        return;
    }

    analyzeBtn.disabled = true;
    analyzeBtn.innerHTML = `
        <svg class="spinner" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        分析中...
    `;

    const links = extractLinksFromHTML(content);

    if (links.length === 0) {
        alert('未找到任何連結！');
        analyzeBtn.disabled = false;
        analyzeBtn.innerHTML = '<i class="fa-solid fa-list-check"></i> 開始分析連結';
        return;
    }

    analysisResults = [];
    linkList.innerHTML = '';
    results.classList.remove('hidden');

    for (const link of links) {
        const linkStatus = await checkLinkStatus(link.url);
        const result = {
            url: link.url,
            title: link.title,
            logo: link.logo || null,
            isActive: linkStatus.status,
            statusCode: linkStatus.statusCode
        };

        analysisResults.push(result);
        linkList.appendChild(renderLinkItem(result));

        resultCount.textContent = analysisResults.length;
        // 使用 value 屬性而不是 textContent，因為現在是 textarea
        jsonCode.value = JSON.stringify(analysisResults, null, 2);
    }

    analyzeBtn.disabled = false;
    analyzeBtn.innerHTML = '<i class="fa-solid fa-list-check"></i> 開始分析連結';
});

// 複製 JSON 按鈕
copyBtn.addEventListener('click', () => {
    const json = JSON.stringify(analysisResults, null, 2);
    navigator.clipboard.writeText(json).then(() => {
        copyBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            已複製
        `;

        setTimeout(() => {
            copyBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            `;
        }, 2000);
    });
});
<?php 

foreach (array(
    'app',
    'redirect',
    'redirect_alt',
    'session_token',
) as $v) {
    $$v = $data[$v];
}

?>

<form 
    class="row"
    onsubmit="this.querySelector('button').disabled=true; return true;"
    target="_top"
    method="post"
    action="<?php echo($app->url('route', 'note/store?redirect=:redirect&redirect_alt=:redirect_alt', array(':redirect' => $redirect, ':redirect_alt' => $redirect_alt))); ?>" 
>
    <input type="hidden" name="session_token" value="<?php echo $app->htmlEncode($session_token); ?>">

    <div class="row" style="margin: 0.5em 0;">
        <div class="col end">
            <button tabindex="1">Save</button>
        </div>
        <div class="col">
            <input type="text" name="note[filename]" placeholder="Filename" required>
        </div>
    </div>

    <div class="row">
        <textarea id="content" name="note[content]" placeholder="Content" style="height: 20em; width: 100%; resize: vertical;"></textarea>
    </div>
</form>

<br class="row">
<br class="row">

<style>
    .no-js .edit-preview {
        display: none;
    }
</style>

<iframe class="row edit-preview" id="edit-preview" sandbox="allow-scripts" scrolling="no"
        style="width:100%;border:0;display:none;height:80px;overflow:hidden"></iframe>

<script>
(function () {
    const ta = document.getElementById('content');
    const fn = document.querySelector('[name="note[filename]"]');
    const p  = document.getElementById('edit-preview');

    const STYLE = '';

    let currentRender = 0;     // bump per srcdoc write, so stale messages are ignored
    let lastHeight = 0;
    let pendingH = null;
    let rafId = 0;

    function isHtml() {
        return /\.(html?|svg)$/i.test(fn.value);
    }

    let timer;
    function schedule() {
        clearTimeout(timer);
        timer = setTimeout(render, 150);
    }

    function applyHeight(h) {
        // Only ever grow, never shrink from observer messages — prevents clunk.
        if (h <= lastHeight) return;
        lastHeight = h;
        p.style.height = h + 'px';
    }

    function render() {
        if (!isHtml()) {
            p.style.display = 'none';
            lastHeight = 0;
            return;
        }
        p.style.display = '';
        lastHeight = 80;
        p.style.height = '80px';

        const renderId = ++currentRender;

        if (!ta.value.trim()) {
            p.srcdoc = `
                <style>
                    html,body{margin:0;overflow:hidden}
                    body { min-height:80px; display:flex; align-items:center; justify-content:center;
                           font:14px/1.5 system-ui; color:#999; background:#fff; }
                </style>
                <div>Nothing to preview yet - start typing HTML above.</div>`;
            return;
        }

        p.srcdoc = STYLE + ta.value + `
            <style>html,b
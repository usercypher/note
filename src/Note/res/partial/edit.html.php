<?php 

foreach (array(
    'app',
    'redirect',
    'redirect_alt',
    'session_token',
    'note'
) as $v) {
    $$v = $data[$v];
}

?>
<form 
    class="row"
    onsubmit="this.querySelector('button').disabled=true; return true;"
    target="_top"
    method="post"
    action="<?php echo($app->url('route', 'note/update?redirect=:redirect&redirect_alt=:redirect_alt', array(':redirect' => $redirect, ':redirect_alt' => $redirect_alt))); ?>" 
>
    <input type="hidden" name="session_token" value="<?php echo $app->htmlEncode($session_token); ?>">
    <input type="hidden" name="note_old[filename]" value="<?php echo($app->htmlEncode($note['filename'])); ?>">

    <div class="row" style="margin: 0.5em 0;">
        <div class="col end">
            <button tabindex="1">Save</button>
        </div>
        <div class="col">
            <input type="text" name="note[filename]" placeholder="Filename" required value="<?php echo($app->htmlEncode($note['filename'])); ?>">
        </div>
    </div>

    <div class="row">
        <textarea id="content" name="note[content]" placeholder="Content" style="height: 20em; width: 100%; resize: vertical;"><?php echo($app->htmlEncode($note['content'])); ?></textarea>
    </div>
</form>

<br class="row">
<br class="row">

<style>
    .no-js .edit-preview {
        display: none;
    }
</style>

<iframe class="row" id="edit-preview" sandbox="allow-scripts" style="width:100%;border:0;display:none"></iframe>

<script>
(function () {
    const ta = document.getElementById('content');
    const fn = document.querySelector('[name="note[filename]"]');
    const p  = document.getElementById('edit-preview');

    const STYLE = '';

    function isHtml() {
        return /\.(html?|svg)$/i.test(fn.value);
    }

    let timer;
    function schedule() {
        clearTimeout(timer);
        timer = setTimeout(render, 150);
    }

    function render() {
        if (!isHtml()) {
            p.style.display = 'none';
            return;
        }
        p.style.display = '';

        if (!ta.value.trim()) {
            p.srcdoc = `
                <style>
                    body { margin:0; height:100vh; display:flex; align-items:center; justify-content:center;
                           font:14px/1.5 system-ui; color:#999; background:#fff; }
                </style>
                <div>Nothing to preview yet - start typing HTML above.</div>`;
            p.style.height = '80px';
            return;
        }

        p.srcdoc = STYLE + ta.value + `
            <script>
                const post = () =>
                    parent.postMessage({ t: 'h', h: document.documentElement.scrollHeight }, '*');
                addEventListener('load', post);
                new ResizeObserver(post).observe(document.documentElement);
            <\/script>`;
    }

    window.addEventListener('message', function (e) {
        if (e.data && e.data.t === 'h') {
            p.style.height = e.data.h + 'px';
        }
    });

    ta.addEventListener('input', schedule);
    fn.addEventListener('input', schedule);
    render();
})();
</script> 
<?php 

foreach (array(
    'route',
    'flash'
) as $v) {
    $$v = $data[$v];
}

?>

<?php if ($flash && $route === (isset($flash[0]['data']['route']) ? $flash[0]['data']['route'] : '')) : ?>
<div class="flash-messages" style="margin-top: 0.5em;">
    <details open>
        <summary>
            <b>Messages (<?php echo count($flash); ?>)</b>
        </summary>
        <ul>
            <?php foreach ($flash as $item) : ?>
                <li>
                    <?php echo isset($item['data']['field']) ? htmlspecialchars($item['data']['field'], ENT_QUOTES, 'UTF-8') : ''; ?>
                    <?php echo isset($item['data']['content']) ? htmlspecialchars($item['data']['content'], ENT_QUOTES, 'UTF-8') : ''; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </details>
</div>
<?php endif; ?>
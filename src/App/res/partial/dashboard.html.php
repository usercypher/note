<?php

foreach (array(
    'app',
    'title',
    'is_logged_in',
    'slot',
) as $v) {
    $$v = $data[$v];
}

?>
<html lang="en" class="no-js" data-js="js" id="top">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <script>document.documentElement.className = document.documentElement.getAttribute('data-js') || 'js';</script>

    <link rel="icon" type="image/x-icon" href="<?php echo $app->url('web', 'favicon.svg') ;?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo $app->url('web', 'favicon.svg') ;?>">

    <link rel="stylesheet" href="<?php echo $app->url('web', 'asset/css/uc.css') ;?>">

    <style>

    </style>
</head>
<body>
    <div class="row w12" style="border-bottom: 1px solid ButtonFace;">
        <div class="col">
            <span class="f2"><?php echo $title; ?></span>
        </div>

        <?php if ($is_logged_in): ?>

        <form method="GET" action="<?php echo $app->url('route', 'user/session-unset'); ?>">
        <div class="col end" style="margin: 0.5em 0; ">
            <a class="button" href="<?php echo $app->url('route', 'note/list'); ?>">Note List</a>
            <a class="button" href="<?php echo $app->url('route', 'settings'); ?>">Settings</a>
            
            <div style="display: inline-block; border: 1px solid ButtonFace;">
            <input style="margin: 0.5em;" type="checkbox" required>
            <button>logout</button>
            </div>
        </div>
        </form>

        <?php else: ?>
        
        <div class="col end" style="margin: 1em 0; ">
            <a class="button" href="<?php echo $app->url('route', ''); ?>">Home</a>
        </div>

        <?php endif; ?>

    </div>
    <div class="row w12" style="margin-bottom: 5em;">
        <?php echo $slot; ?>
    </div>
    <div class="row" style="position: fixed; z-index: 998; bottom: 0; right: 0; width: auto;">
        <div class="col end">
            <div style="margin: 0.5em;">
                <a href="#top" class="button" tabindex="999" style="display: block; padding-top: 1em; padding-bottom: 1em;" aria-label="Scroll to top"><div style="font-size: 2em;" class="shape-arrow-up"></div></a>
            </div>
        </div>
    </div>
</body>
</html>
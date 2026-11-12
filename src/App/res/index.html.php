<?php

foreach (array(
    'app',
    't',
    'languages',
    'lang',
    'partial_user_session',
    'partial_user_session_flash',
    'partial_user_create',
    'partial_user_create_flash',
) as $v) {
    $$v = $data[$v];
}

?>
<html lang="<?= $lang ?>" class="no-js" data-js="js" id="top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="normal">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="">
    <meta property="og:type" content="website">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:description" content="">
    <meta property="og:site_name" content="l">
    <meta property="og:locale" content="en_US">

    <meta name="twitter:card" content="summary">

    <title></title>

    <script>document.documentElement.className = document.documentElement.getAttribute('data-js') || 'js';</script>

    <link rel="canonical" href="https://example.com/page">

    <link rel="icon" type="image/x-icon" href="<?php echo $app->url('web', 'favicon.svg') ;?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo $app->url('web', 'favicon.svg') ;?>">

    <link rel="stylesheet" href="<?php echo $app->url('web', 'asset/css/uc.css') ;?>">

    <style>

    </style>
</head>
<body>
    <div class="row w12">
        <div class="col w7">
            <div class="w6 center" style="margin-top: 5em; height: 30em;">
                <h1>Note</h1>
                <p>Save notes online, and make it public for easy access</p>
                <a href="#login" class="button">Login</a>
                <a href="#features" class="button">Features</a>
                <a href="#register" class="button">Register</a>
                <a href="#contact" class="button">Contact</a>
                
                <center>
                    <p style="margin-top: 5em;">Search by username for list here:</p>
                    <form method="GET" action="<?php echo $app->url('route', 'note/list'); ?>">
                        <input name="username" />
                        <button style="font-size: 1.4em;">
                            <div class="shape-arrow-right"></div>
                        </button>
                    </form>
                </center>
            </div>
        </div>
        <div id="login" class="col w5">
            <div style="margin-top: 5em; padding: 2em; border-left: 4px solid ButtonFace">
            
            <h2>Login</h2>

            <?php echo $partial_user_session_flash; ?>
            <br>

            <?php echo $partial_user_session; ?>
            <br>
            <p>Don't have an account? <a href="#register">Register</a></p>

            </div>
        </div>
    </div>
    
    <hr class="row">

    <div id="features" class="row w12" style="margin: 2em 0;">
        <center class="col w4" style="margin-top: 2em;">
            <div class="w3">
            <h2>Directory index</h2>
            <p>Visit your user name via note.lmd.dedyne.io/n/username/ and get directory listing.
            </div>
        </center>
        <center class="col w4 end" style="margin-top: 2em;">
            <div class="w3">
            <h2>Public access</h2>
            <p>No need to login to view your notes</p>
            </div>
        </center>
        <center class="col w4" style="margin-top: 2em;">
            <div class="w3">
            <h2>Selfhost</h2>
            <p>The repo is public you can get it in <a href="https://github.com/usercypher/note/">https://github.com/usercypher/note/</a></p>
            </div>
        </center>
    </div>

    <hr class="row">
    
    <div id="register" class="row w12">
        <div class="w4 center" style="margin: 2em auto;">
            <center><h2>Register</h2></center>
            <?php echo $partial_user_create_flash; ?>
            <br>
            <center>
            <?php echo $partial_user_create; ?>
            <br>
            <p>Already have an account? <a href="#login">Login</a></p>
            </center>
        </div>
    </div>
    
    <hr class="row">
    
    <div id="contact" class="row" role="contentinfo" style="margin-bottom: 5em;">
        <p>&copy; <?php echo date('Y'); ?> Lloyd Miles M. Bersabe. All rights reserved.</p>
        <address>
            Email: <a href="mailto:&#108;&#108;&#111;&#121;&#100;&#98;&#101;&#114;&#115;&#97;&#98;&#101;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;">&#108;&#108;&#111;&#121;&#100;&#98;&#101;&#114;&#115;&#97;&#98;&#101;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;</a><br>
            Phone: <a href="&#116;&#101;&#108;&#58;&#43;&#54;&#51;&#57;&#54;&#55;&#54;&#53;&#55;&#51;&#55;&#57;&#52;">&#48;&#57;&#54;&#55;&#54;&#53;&#55;&#51;&#55;&#57;&#52;</a><br>
            Github: <a href="https://github.com/usercypher">https://github.com/usercypher</a><br>
            LinkedIn: <a href="https://www.linkedin.com/in/lloyd-miles-bersabe" target="_blank" rel="noopener">https://www.linkedin.com/in/lloyd-miles-bersabe</a>
        </address>
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
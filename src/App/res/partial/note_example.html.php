<?php

foreach (array(
    'app',
    'user',
) as $v) {
    $$v = $data[$v];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <h1>Title</h1>
    <p>sample sentence in a paragraph</p>

    <ul>
        <li>sample list</li>
        <li><a href="https://google.com">sample link that go to google.com</a></li>
    </ul>

    <p>
        <a href="<?php echo $app->url('route', 'note/list/:username', array(':username' => $user['username'])) ;?>">Go back</a>
    </p>
</body>
</html>

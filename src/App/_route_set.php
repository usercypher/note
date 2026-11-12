<?php

// GET
// ==========
$group = array(
    'prepend' => array(
        'Shared_Pipe_SessionTokenGenerate',
        'User_Pipe_Init',
        'User_Pipe_Lang'
    ),
    'append' => array(
        'Shared_Pipe_OutputCompression'
    ),
);

$app->routeGroup($group, 'GET', '', array(
    'User_Pipe_IsNotAuth', 'App_Pipe_Index'
));

$app->routeGroup($group, 'GET', 'settings', array(
    'User_Pipe_IsAuth', 'App_Pipe_Settings'
));

<?php

// GET
// ==========
$group = array(
    'prepend' => array('Shared_Pipe_SessionTokenGenerate', 'User_Pipe_Init', 'User_Pipe_IsAuth'),
    'append' => array('Shared_Pipe_OutputCompression')
);

$app->routeSet('GET', 'note/list/:username', array(
    'Shared_Pipe_SessionTokenGenerate', 'User_Pipe_Init', 'Note_Pipe_List', 'Shared_Pipe_OutputCompression'
));

$app->routeGroup($group, 'GET', 'dashboard', array(
    'Note_Pipe_List'
));

$app->routeGroup($group, 'GET', 'note/create', array(
    'Note_Pipe_Create'
));

$app->routeGroup($group, 'GET', 'note/edit/:filename', array(
    'Note_Pipe_Edit'
));

// POST
// ==========
$group = array(
    'prepend' => array('Shared_Pipe_SessionTokenValidate')
);

$app->routeGroup($group, 'POST', 'note/store', array(
    'Note_Pipe_Store'
));

$app->routeGroup($group, 'POST', 'note/update', array(
    'Note_Pipe_Update'
));

$app->routeGroup($group, 'POST', 'note/delete', array(
    'Note_Pipe_Delete'
));

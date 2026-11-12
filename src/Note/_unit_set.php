<?php

/**
 * ------------------------------------------------------------------------
 * Repo
 * ------------------------------------------------------------------------
 */
$group = array(
    'args_prepend' => array('App', 'Shared_Lib_Cast_Standard'),
);
$app->unitGroup($group, 'Note_Repo');

/**
 * ------------------------------------------------------------------------
 * Pipe
 * ------------------------------------------------------------------------
 */


$group = array(
    'args_prepend' => array('App', 'Shared_Lib_Session')
);

$app->unitGroup($group, 'Note_Pipe_Store', array('args' => array('Note_Repo')));
$app->unitGroup($group, 'Note_Pipe_Update', array('args' => array('Note_Repo')));
$app->unitGroup($group, 'Note_Pipe_Delete', array('args' => array('Note_Repo')));

$app->unitGroup($group, 'Note_Pipe_Edit', array('args' => array('Note_Repo')));
$app->unitGroup($group, 'Note_Pipe_List', array('args' => array('Note_Repo')));

$app->unitGroup($group, 'Note_Pipe_Create');


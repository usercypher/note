<?php

/**
 * ------------------------------------------------------------------------
 * Pipe
 * ------------------------------------------------------------------------
 */
$app->unitSet('App_Pipe_Index', array(
    'args' => array(
        'App',
        'Shared_Lib_Translator',
        'Shared_Lib_Session'
    )
));

$app->unitSet('App_Pipe_Settings', array(
    'args' => array(
        'App',
        'Shared_Lib_Translator',
        'Shared_Lib_Session',
        'User_Repo'
    )
));

$app->unitSet('App_Pipe_Lang', array(
    'base' => 'Shared_Pipe_Lang',
    'args' => array(
        'App',
        'Shared_Lib_Translator',
        $app->unitArgData('app'),
        $app->unitArgData('en'),
        $app->unitArgData(array(
            'en', 'es', 'fr', 'de', 'pt'
        )),
        $app->unitArgData('src/App/res/lang/'),
    ),
    'cache' => true
));

/**
 * ------------------------------------------------------------------------
 * Event
 * ------------------------------------------------------------------------
 */

$app->unitSet('App_Pipe_UserEventUserStoreSession', array(
    'args' => array(
        'App',
        'Shared_Lib_Session',
        'User_Repo'
    )
));

$app->unitSet('App_Pipe_UserEventCreateNote', array(
    'args' => array(
        'App',
        'Shared_Lib_Session',
        'Note_Repo'
    )
));

$app->unitSet('App_Pipe_UserEventDeleteNoteDir', array(
    'args' => array(
        'App',
        'Shared_Lib_Session',
    )
));

$app->unitSet('App_Pipe_UserEventUpdateNoteDir', array(
    'args' => array(
        'App',
    )
));

$group = array(
    'base' => 'Shared_Pipe_Event',
);

$app->unitGroup($group, 'App_Pipe_UserStoreEvent', array(
    'args' => array(
        'App_Pipe_UserEventUserStoreSession',
        'App_Pipe_UserEventCreateNote'
    )
));
$app->unitGroup($group, 'App_Pipe_UserUpdateEvent', array(
    'args' => array(
        'App_Pipe_UserEventUpdateNoteDir',
    )
));
$app->unitGroup($group, 'App_Pipe_UserDeleteEvent', array(
    'args' => array(
        'App_Pipe_UserEventDeleteNoteDir'
    )
));


$app->unitSet('User_Pipe_StoreEvent', array(
    'bind' => 'App_Pipe_UserStoreEvent'
));

$app->unitSet('User_Pipe_UpdateEvent', array(
    'bind' => 'App_Pipe_UserUpdateEvent'
));

$app->unitSet('User_Pipe_DeleteEvent', array(
    'bind' => 'App_Pipe_UserDeleteEvent'
));
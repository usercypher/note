<?php

class App_Pipe_UserEventUpdateNoteDir {
    private $app;

    public function args($args) {
        list(
            $this->app,
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;
        $event = $input->data['user_event'];
        $oldpath = $this->app->dir('note', $event['user_old']['username']);
        $newpath = $this->app->dir('note', $event['user']['username']);
        $this->app->pathMove($oldpath, $newpath);
        return array($input, $output, $success);
    }
}
<?php

class App_Pipe_UserEventDeleteNoteDir {
    private $app, $session;

    public function args($args) {
        list(
            $this->app,
            $this->session,
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;
        $user = $this->session->get('user');
        $this->app->pathDrop($this->app->dir('note', $user['username']), true, true);
        return array($input, $output, $success);
    }
}
<?php

class App_Pipe_UserEventUserStoreSession {
    private $app, $session, $userRepo;

    public function args($args) {
        list(
            $this->app,
            $this->session,
            $this->userRepo
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;
        $user = $input->frame['user'];
        $this->session->set("user", $this->userRepo->one('WHERE username = ? OR email = ?', array($user['username'], $user['username'])));
        return array($input, $output, $success);
    }
}
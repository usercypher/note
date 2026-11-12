<?php

class App_Pipe_UserEventCreateNote {
    private $app, $session, $noteRepo;

    public function args($args) {
        list(
            $this->app,
            $this->session,
            $this->noteRepo,
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;

        $user = $this->session->get('user');
 
        $this->noteRepo->insert(array(
            'filename' => 'example.html',
            'content' => $this->app->template($this->app->dir('root', 'src/App/res/partial/note_example.html.php'), array(
                'app' => $this->app,
                'user' => $user
            ))
        ), $user);

        $this->noteRepo->insert(array(
            'filename' => 'example.txt',
            'content' => $this->app->template($this->app->dir('root', 'src/App/res/partial/note_example.txt.php'))
        ), $user);

        return array($input, $output, $success);
    }
}
<?php

class Note_Pipe_Create {
    private $app, $session;

    public function args($args) {
        list(
            $this->app,
            $this->session,
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;

        $flash = $this->session->remove('flash');
        $user = $this->session->get('user');
        $isLoggedIn = (bool) $user;

        $flashTpl = $this->app->template($this->app->dir('root', 'src/Shared/res/partial/flash.html.php'), array(
            'route' => 'note/store',
            'flash' => $flash,
        ));

        if (trim($flashTpl)) {
            $flashTpl = '<div style="height: 0.5em;"></div>' . $flashTpl;
        }

        $createTpl = $this->app->template($this->app->dir('root', 'src/Note/res/partial/create.html.php'), array(
            'app' => $this->app,
            'redirect' => $input->route,
            'redirect_alt' => 'note/list',
            'session_token' => $this->session->get('session_token')
        ));

        $output->content = $this->app->template($this->app->dir('root', 'src/App/res/partial/dashboard.html.php'), array(
            'app' => $this->app,
            'title' => 'Dashboard - Note Create',
            'is_logged_in' => $isLoggedIn,
            'slot' => $flashTpl . $createTpl,
        ));

        return array($input, $output, $success);
    }
}
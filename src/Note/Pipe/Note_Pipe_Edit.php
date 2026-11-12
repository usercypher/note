<?php

class Note_Pipe_Edit {
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

        $flash = $this->session->remove('flash');
        $user = $this->session->get('user');
        $isLoggedIn = (bool) $user;
        $filename = isset($input->param['filename']) ? $input->param['filename'] : null;

        $flashTpl = $this->app->template($this->app->dir('root', 'src/Shared/res/partial/flash.html.php'), array(
            'route' => 'note/update',
            'flash' => $flash,
        ));

        if (trim($flashTpl)) {
            $flashTpl = '<div style="height: 0.5em;"></div>' . $flashTpl;
        }

        $editTpl = '<h1 style="margin-top: 0.5em;">Not Found</h1><p>404. Note not found. <a href="/">Go to homepage</a></p>';

        if ($note = $this->noteRepo->get($filename, $user)) {
            $editTpl = $this->app->template($this->app->dir('root', 'src/Note/res/partial/edit.html.php'), array(
                'app' => $this->app,
                'redirect' => $input->route,
                'redirect_alt' => 'note/edit/:filename',
                'session_token' => $this->session->get('session_token'),
                'note' => $note
            ));
        }

        $output->content = $this->app->template($this->app->dir('root', 'src/App/res/partial/dashboard.html.php'), array(
            'app' => $this->app,
            'title' => 'Dashboard - Note Edit',
            'is_logged_in' => $isLoggedIn,
            'slot' => $flashTpl . $editTpl,
        ));

        return array($input, $output, $success);
    }
}
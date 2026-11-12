<?php

class App_Pipe_Settings {
    private $app, $translator, $session, $userRepo;

    public function args($args) {
        list(
            $this->app,
            $this->translator,
            $this->session,
            $this->userRepo
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;

        $flash = $this->session->remove('flash');
        $user = $this->session->get('user');
        $userTranslator = $this->translator->get('user');
        $sessionToken = $this->session->get('session_token');

        $flashUserUpdateTpl = $this->app->template($this->app->dir('root', 'src/Shared/res/partial/flash.html.php'), array(
            'route' => 'user/update',
            'flash' => $flash,
        ));

        $flashUserDeleteTpl = $this->app->template($this->app->dir('root', 'src/Shared/res/partial/flash.html.php'), array(
            'route' => 'user/delete',
            'flash' => $flash,
        ));

        $output->content = $this->app->template($this->app->dir('root', 'src/App/res/partial/dashboard.html.php'), array(
            'app' => $this->app,
            'title' => 'Dashboard - Settings',
            'is_logged_in' => (bool) $user,
            'slot' => $this->app->template($this->app->dir('root', 'src/App/res/partial/settings.html.php'), array(
                'app' => $this->app,
                'partial_edit_account' => $this->app->template($this->app->dir('root', 'src/App/res/partial/edit_account.html.php'), array(
                    'app' => $this->app,
                    't' => $userTranslator,
                    'session_token' => $sessionToken,
                    'redirect' => $input->route,
                    'redirect_alt' => $input->route,
                    'user' => $user,
                )),
                'flash_edit' => $flashUserUpdateTpl,
                'partial_edit_password' => $this->app->template($this->app->dir('root', 'src/User/res/partial/edit_password.html.php'), array(
                    'app' => $this->app,
                    't' => $userTranslator,
                    'session_token' => $sessionToken,
                    'redirect' => $input->route,
                    'redirect_alt' => $input->route,
                    'user' => $user,
                )),
                'partial_delete' => $this->app->template($this->app->dir('root', 'src/User/res/partial/delete.html.php'), array(
                    'app' => $this->app,
                    't' => $userTranslator,
                    'session_token' => $sessionToken,
                    'redirect' => $input->route,
                    'redirect_alt' => 'user/session-unset',
                    'user' => $user,
                )),
                'flash_delete' => $flashUserDeleteTpl,
                
            )),
        ));

        return array($input, $output, $success);
    }
}
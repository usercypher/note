<?php

class App_Pipe_Index {
    private $app, $translator, $session;

    public function args($args) {
        list(
            $this->app,
            $this->translator,
            $this->session
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;

        $appLanguages = $input->data['app:languages'];
        $appLang = $input->data['app:lang'];
        $appTranslator = $this->translator->get('user');
        $flash = $this->session->remove('flash');

        $output->content = $this->app->template($this->app->dir('root', 'src/App/res/index.html.php'), array(
            'app' => $this->app,
            't' => $appTranslator,
            'languages' => $appLanguages,
            'lang' => $appLang,
            'partial_user_session_flash' => $this->app->template($this->app->dir('root', 'src/Shared/res/partial/flash.html.php'), array(
                'route' => 'user/session-verify',
                'flash' => $flash,
            )),
            'partial_user_create_flash' => $this->app->template($this->app->dir('root', 'src/Shared/res/partial/flash.html.php'), array(
                'route' => 'user/store',
                'flash' => $flash,
            )),
            'partial_user_session' => $this->app->template($this->app->dir('root', 'src/User/res/partial/session.html.php'), array(
                'app' => $this->app,
                't' => $appTranslator,
                'session_token' => $this->session->get('session_token'),
                'redirect' => $input->route . rawurlencode('#login'),
                'redirect_alt' => 'dashboard'
            )),
            'partial_user_create' => $this->app->template($this->app->dir('root', 'src/App/res/partial/create.html.php'), array(
                'app' => $this->app,
                't' => $appTranslator,
                'session_token' => $this->session->get('session_token'),
                'redirect' => $input->route . rawurlencode('#register'),
                'redirect_alt' => $input->route,
                'user_roles' => $input->data['user_roles'],
            )),
        ));

        return array($input, $output, $success);
    }
}
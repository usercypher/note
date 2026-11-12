<?php

class Note_Pipe_Store {
    private $app, $session;
    private $noteRepo;

    public function args($args) {
        list(
            $this->app, 
            $this->session, 
            $this->noteRepo,
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;

        $route = $input->query['redirect'];
        $note = isset($input->frame['note']) ? $input->frame['note'] : array();
        $userSession = $this->session->get('user');

        $error = array();

        list($note, $error) = $this->app->cast($note, $this->noteRepo->getSchema('insert', array(
            'user' => $userSession,
        )));

        if ($error) {
            foreach ($error as $e) {
                $this->noteRepo->addMessage('error', $e['data']['content'], $e['data']);
            }
        } elseif ($this->noteRepo->insert($note, $userSession)) {
            $route = $input->query['redirect_alt'];
            $this->noteRepo->addMessage('success', 'note created successfully');
        }

        $flash = array();
        foreach (array(
            $this->noteRepo->getMessages(),
        ) as $messages) {
            foreach ($messages as $m) {
                $m['data']['route'] = $input->route;
                $flash[] = $m;
            }
        }

        $this->session->set('flash', $flash);

        $output->header['location'] = $this->app->url('route', $route);

        return array($input, $output, $success);
    }
}
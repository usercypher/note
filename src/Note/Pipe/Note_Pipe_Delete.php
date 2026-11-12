<?php

class Note_Pipe_Delete {
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
        $note = $input->frame['note'];
        $userSession = $this->session->get('user');

        $error = array();

        if (!isset($input->frame['confirm'])) {
            $error[] = array(
                'data' => array(
                    'content' => 'confirm checkbox is unchecked',
                )
            );
        }

        if (!$error) {
           list($note, $error) = $this->app->cast($note, $this->noteRepo->getSchema('delete', array('user' => $userSession)));
        }

        if ($error) {
            foreach ($error as $e) {
                $this->noteRepo->addMessage('error', $e['data']['content'], $e['data']);
            }
        } elseif ($this->noteRepo->delete($note['filename'], $userSession)) {
            $route = $input->query['redirect_alt'];
            $this->noteRepo->addMessage('success', 'note deleted successfully');
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
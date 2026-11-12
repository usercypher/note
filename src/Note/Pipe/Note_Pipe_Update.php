<?php

class Note_Pipe_Update {
    private $app, $session;
    private $noteRepo;

    public function args($args) {
        list(
            $this->app, 
            $this->session, 
            $this->noteRepo
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;

        $route = $input->query['redirect'];
        $note = $input->frame['note'];
        $noteOld = $input->frame['note_old'];
        $userSession = $this->session->get('user');

        list($note, $error) = $this->app->cast($note, $this->noteRepo->getSchema('update', array_merge(array(
            'user' => $userSession,
            'note_old' => $noteOld
        ))));


        if ($error) {
            foreach ($error as $e) {
                $this->noteRepo->addMessage('error', $e['data']['content'], $e['data']);
            }
        } elseif ($this->noteRepo->update($note, $userSession, $noteOld)) {
            $route = $input->query['redirect_alt'];
            $this->noteRepo->addMessage('success', 'note updated successfully');
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

        $output->header['location'] = $this->app->url('route', $route, $error ? array() : array(':filename' => $note['filename']));

        return array($input, $output, $success);
    }
}
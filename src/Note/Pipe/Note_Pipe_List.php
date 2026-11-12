<?php

class Note_Pipe_List {
    private $app, $session, $noteRepo;

    public function args($args) {
        list(
            $this->app,
            $this->session,
            $this->noteRepo
        ) = $args;
    } 

    public function call($input, $output) {
        $success = true;

        $flash = $this->session->remove('flash');
        $user = $this->session->get('user');
        $isLoggedIn = (bool) $user;
        if (!$isLoggedIn && (!empty($input->param['username']) || !empty($input->query['username']))) {
            $user = array(
                'username' => !empty($input->param['username']) ? $input->param['username'] : $input->query['username']
            );
        }
        $sessionToken = $this->session->get('session_token');
        $notes = array();
        $listExists = false;
        if ($user && $listExists = $this->app->pathExists($this->app->dir('note', $user['username'])) && $dh = $this->app->dopen($this->app->dir('note', $user['username']))) {
            while ($item = $this->app->dread($dh)) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $notes[] = basename($item);
            }
            $this->app->dclose($dh);
        }

        $flashTpl = $this->app->template($this->app->dir('root', 'src/Shared/res/partial/flash.html.php'), array(
            'route' => 'note/delete',
            'flash' => $flash,
        ));

        if (trim($flashTpl)) {
            $flashTpl = '<div style="height: 0.5em;"></div>' . $flashTpl;
        }

        $listTpl = '<h1 style="margin-top: 0.5em;">Not Found</h1><p>404. Note not found. <a href="/">Go to homepage</a></p>';

        if ($listExists) {
            $listTpl = $this->app->template($this->app->dir('root', 'src/Note/res/partial/list.html.php'), array(
                'app' => $this->app,
                'notes' => $notes,
                'user' => $user,
                'session_token' => $sessionToken,
                'redirect' => $input->route,
                'redirect_alt' => $input->route,
                'is_logged_in' => $isLoggedIn,
                'total_size' => $this->humanFilesize($this->noteRepo->getDirSize($user)),
                'server_total' => $this->humanFilesize(diskfreespace('.'))
            ));
        }

        $output->content = $this->app->template($this->app->dir('root', 'src/App/res/partial/dashboard.html.php'), array(
            'app' => $this->app,
            'title' => 'Dashboard - Note List',
            'is_logged_in' => $isLoggedIn,
            'slot' => $flashTpl . $listTpl,
        ));

        return array($input, $output, $success);
    }

    function humanFilesize($bytes, $decimals = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

        if ($bytes == 0) {
            return '0 B';
        }

        $factor = 0;
        while ($bytes >= 1024 && $factor < count($units) - 1) {
            $bytes /= 1024;
            $factor++;
        }

        return sprintf("%.{$decimals}f %s", $bytes, $units[$factor]);
    }
}
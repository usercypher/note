<?php

class Note_Repo {
    private $app, $castStandard, $messages = array();
    var $table = 'note';

    public function args($args) {
        list(
            $this->app,
            $this->castStandard,
        ) = $args;
    }

    function addMessage($type, $message, $meta = array()) {
        $this->messages[] = array('type' => 'system:message:' . $type, 'data' => array('content' => $message, 'table' => $this->table) + $meta);
    }

    function getMessages() {
        return $this->messages;
    }

    public function getSchema($action, $context = array()) {
        $std = $this->castStandard;
        $s = array();

        if (in_array($action, array('insert', 'update'))) {
            $s = array(
                'filename' => array(
                    $std->toString(),
                    $std->defaultValue('.'),
                    $std->urlUnreserved(50),
                    $std->lengthMax(50),
                ),
                'content' => array(
                    $std->toString(),
                    $std->defaultValue(''),
                    $this->quota($context['user'], 512000)
                ),
            );
        }

        if (in_array($action, array('delete'))) {
            $s['filename'][] = $this->fileExists($context['user']['username']);
        }

        if ($action === 'insert') {
            $s['filename'][] = $this->fileNotExists($context['user']['username']);
            
        }

        if ($action === 'update') {
            $s['filename'][] = $this->fileNotExists($context['user']['username'], $context['note_old']['filename']);
        }

        return $s;
    }

    function insert($note, $user) {
        $success = true;
        $file = $this->app->dir('note', $user['username'] . '/' . $note['filename']);
        if ($this->app->pathMake($file, false, true)) {
            if ($note['filename'] !== '.' && $note['filename'] !== '..') {
                $this->app->fileWrite($file, $note['content']);
            } else {
                $success = false;
                $this->addMessage('error', 'failed to write content to file');
            }
        } else {
            $success = false;
            $this->addMessage('error', 'failed to create file: ' . $note['filename']);
        }
        return $success;
    }

    function update($note, $user, $noteold) {
        $newfile = $this->app->dir('note', $user['username'] . '/' . $note['filename']);
        $oldfile = $this->app->dir('note', $user['username'] . '/' . $noteold['filename']);
        $this->app->pathMove($oldfile, $newfile);
        $this->app->fileWrite($newfile, $note['content']);
        return true;
    }

    function delete($filename, $user) {
        return $this->app->pathDrop($this->app->dir('note', $user['username'] . '/' . $filename));
    }

    function get($filename, $user) {
        $file = $this->app->dir('note', $user['username'] . '/' . $filename);

        if (!$this->app->pathExists($file)) {
            $this->addMessage('error', 'file not found: ' . $filename);
            return;
        }

        return array(
            'filename' => $filename,
            'content' => $this->app->fileRead($file)
        );
    }

    function getDirSize($user) {
        $dirSize = 0;
        $path = $this->app->dir('note', $user['username']);
        if ($dh = $this->app->dopen($path)) {
            while ($item = $this->app->dread($dh)) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $dirSize += (float) $this->app->pathSize($path . '/' . $item);
            }
        }
        return $dirSize;
    }

    function fileExists($username) {
        $o = new Note_Repo_CastFileExists;
        $o->app = $this->app;
        $o->username = $username;
        return $o;
    }

    function fileNotExists($username, $oldfilename = null) {
        $o = new Note_Repo_CastFileNotExists;
        $o->app = $this->app;
        $o->username = $username;
        $o->oldfilename = $oldfilename;
        return $o;
    }

    function quota($user, $max) {
        $o = new Note_Repo_CastQuota;
        $o->app = $this->app;
        $o->user = $user;
        $o->max = $max;
        return $o;
    }
}

class Note_Repo_CastFileExists {
    var $app, $username;

    function call($value) {
        if (!$this->app->pathExists($this->app->dir('note', $this->username . '/' . $value))) {
            return array($value, 'file not exists: ' . $value);
        } 

        return array($value, null);
    }
}

class Note_Repo_CastFileNotExists {
    var $app, $username, $oldfilename;

    function call($value) {
        if ((!$this->oldfilename || $value !== $this->oldfilename) && $this->app->pathExists($this->app->dir('note', $this->username . '/' . $value))) {
            return array($value, 'file already exists: ' . $value);
        } 

        return array($value, null);
    }
}

class Note_Repo_CastQuota {
    var $app, $user, $max;

    function call($value, $data) {
        $user = $this->user;
        $dirSize = 0;
        $path = $this->app->dir('note', $user['username']);
        if ($dh = $this->app->dopen($path)) {
            while ($item = $this->app->dread($dh)) {
                if ($item === '.' || $item === '..' || $data['filename'] === $item) {
                    continue;
                }
                $dirSize += (float) $this->app->pathSize($path . '/' . $item);
            }
        }

        $dirSize += (float) strlen($value);

        if ($dirSize > $this->max) {
            $overageKb = ($dirSize - $this->max) / 1024;
            return array($value, sprintf(
                'Content too large: exceeds storage quota by %.2f KB',
                $overageKb
            ));
        }

        if (strlen($value) > diskfreespace('.')) {
            return array($value, 'Server storage has run out');
        }

        return array($value, null);
    }
}

?>

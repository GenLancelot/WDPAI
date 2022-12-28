<?php

require_once  'AppController.php';

class SettingsController extends AppController
{
    const MAX_FILE_SIZE = 2048*2048;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIR = '/public/photos/';

    private $message = [];

    public function settings_edit()
    {
        if($this->isPost() && is_uploaded_file($_FILES['background-file']['tmp_name']) && $this->validate($_FILES['background-file'])){

            move_uploaded_file($_FILES['background-file']['tmp_name'], dirname(__DIR__).self::UPLOAD_DIR.$_FILES['background-file']['tmp_name']);

            return $this->render("settings", ['messages' => $this->messages]);
        }

        $this->render('settings_edit', ['messages' => $this->messages]);
    }

    private function validate(array $file) : bool
    {
        if($file['size'] > self::MAX_FILE_SIZE){
            $this->messages = 'File is too large!';
            echo 'File too large!';
            return false;
        }

        if(!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)){
            $this->messages = 'Unsupported filetype!';
            echo 'Unsupported filetype!';
            return false;
        }

        return true;
    }
}
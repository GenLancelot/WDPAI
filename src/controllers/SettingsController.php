<?php

require_once  'AppController.php';

class SettingsController extends AppController
{
    const MAX_FILE_SIZE = 2048*2048;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIR = '/../public/photos/';

    private $message = [];

    public function settings_edit()
    {
        $this->render('settings_edit', ['messages' => $this->messages]);
    }

    public function settings_file_edit()
    {
        $email = 'test@test.pl';
        $userRepository = new UserRepository();
        $user = $userRepository->getUser($email);

        if($this->isPost() && is_uploaded_file($_FILES['background-file']['tmp_name']) && $this->validate($_FILES['background-file'])){

            move_uploaded_file($_FILES['background-file']['tmp_name'], dirname(__DIR__).self::UPLOAD_DIR.$_FILES['background-file']['name']);
            $userRepository->updateUserBackground($user, $_FILES['background-file']['name']);
        }

        if($this->isPost() && is_uploaded_file($_FILES['icon-file']['tmp_name']) && $this->validate($_FILES['icon-file'])){
            move_uploaded_file($_FILES['icon-file']['tmp_name'], dirname(__DIR__).self::UPLOAD_DIR.$_FILES['icon-file']['name']);
            $userRepository->updateUserIcon($user, $_FILES['icon-file']['name']);
        }

        $this->render('settings_edit', ['messages' => $this->messages]);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }
}
<?php

require_once  'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{

    public function login()
    {

        if (!$this->isPost()){
            return $this->render('login');
        }


        $email = $_POST["email"];
        $password = $_POST["password"];

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($email);

        if(!$user){
            return $this->render('login', ['messages'=> ['user not exits!']]);
        }

        if ($user->getEmail() !== $email){
            return $this->render('login', ['messages'=> ['user with this email not exits!']]);
        }

        if ($user->getPassword() !== $password){
            return $this->render('login', ['messages'=> ['password incorrect!']]);
        }

        return $this->render('main_chat');
    }

    public function registration()
    {

        if (!$this->isPost()){
            return $this->render('registration');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $name = "test";
        $surname = "test";
        $user = new User($email, $password, $name, $surname);
        $userRepository = new UserRepository();
        $userRepository->addUser($user);

        return $this->render('main_chat');
    }
}
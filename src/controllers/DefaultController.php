<?php

require_once 'AppController.php';

class DefaultController extends AppController{
   
    public function index(){
        if(isset($_COOKIE['user'])) {
            $this->redirect('/main');
            return;
        }
        $this->render('login' , ['message' => "hello world"]);
   }

    public function profile(){
        $email = $_COOKIE['user'];
        $userRepository = new UserRepository();
        $user = $userRepository->getUser($email);
        $images = $userRepository->getUserImages($user);
        $games = $userRepository->getUserGames($user);
        $this->render('profile', ['user' => $user, 'games' => $games, 'icon'=>$images['icon'], 'bg' => $images['background']]);
    }

    public function main(){
        $this->render('main');
    }

    public function chat(){
        $this->render('main_chat');
    }
}
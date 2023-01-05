<?php

require_once 'AppController.php';

class DefaultController extends AppController{
   
    public function index(){
        if(isset($_COOKIE['user'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: ${url}/chat");
        }
        $this->render('login' , ['message' => "hello world"]);
   }

    public function profile(){
        if(isset($_COOKIE['user'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: ${url}/chat");
        }
        $email = 'test@test.pl';
        $userRepository = new UserRepository();
        $user = $userRepository->getUser($email);
        $images = $userRepository->getUserImages($user);
        $games = $userRepository->getUserGames($user);
        $this->render('profile', ['user' => $user, 'games' => $games, 'icon'=>$images['icon'], 'bg' => $images['background']]);
    }
}
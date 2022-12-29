<?php

require_once  'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{

    public function login()
    {

        if(isset($_COOKIE['user'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: ${url}/chat");
        }

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

        $user_cookie = 'user';
        $cookie_value = $email;
        setcookie($user_cookie, $cookie_value, time() + (60 * 30), "/");

        Routing::run('games');
    }

    public function registration()
    {

        if (!$this->isPost()){
            return $this->render('registration');
        }

        if(isset($_COOKIE['user'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: ${url}/chat");
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $user = new User($email, $password);
        $userRepository = new UserRepository();
        $userRepository->addUser($user);

        $user_cookie = 'user';
        $cookie_value = $email;
        setcookie($user_cookie, $cookie_value, time() + (60 * 30), "/");

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/settings_edit");
    }

    public function logout()
    {
        setcookie('user', $_COOKIE['user'], time() - 10, "/");
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/index");
    }

    public function chat(){
        $this->render('main_chat');
    }

    public function gameselection(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        $decoded = "";
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');

            $email = 'test@test.pl';
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($email);
            $userRepository->addUserPrioritizedGame($user, $decoded['selected']);

            http_response_code(200);
        }
    }
}
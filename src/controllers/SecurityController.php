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

        if (!password_verify($password, $user->getPassword())){
            return $this->render('login', ['messages'=> ['password incorrect!']]);
        }

        $user_cookie = 'user';
        $cookie_value = $email;
        setcookie($user_cookie, $cookie_value, time() + (60 * 30), "/");

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/games");
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
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
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
        header("Location: {$url}/login");
    }

    public function chat(){
        $this->render('main_chat');
    }

    public function gameselection(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
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

    public function getusergames(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            header('Content-type: application/json');

            $email = 'test@test.pl';
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($email);

            http_response_code(200);
            echo json_encode($userRepository->getUserGames($user));
        }
    }

    public function getnotusergames(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            header('Content-type: application/json');

            $email = 'test@test.pl';
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($email);

            http_response_code(200);
            echo json_encode($userRepository->getNotUserGames($user));
        }
    }

    public function addNewUserGame(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            header('Content-type: application/json');

            $email = 'test@test.pl';
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($email);
            $decoded = json_decode($content, true);
            $gamename = $decoded['gamename'];
            if ($gamename == 'Select Game') {
                http_response_code(200);
                return;
            }
            http_response_code(200);
            $userRepository->addNewUserGame($user, $gamename);
        }
    }

    public function retrieveNewUserData(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            header('Content-type: application/json');

            $email = 'test@test.pl';
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($email);
            $decoded = json_decode($content, true);
            $userRepository->updateUserInfo($user, $decoded);

            http_response_code(200);
        }
    }

    public function main(){
        $this->render('main');
    }

    public function getnextuser(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            header('Content-type: application/json');

            $email = 'test@test.pl';
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($email);
            $decoded = json_decode($content, true);
            if($decoded != null){
                $userRepository->addFriendshipStatus($user, $decoded['action'], $decoded['email']);
            }
            $nextUser = $userRepository->getNextUserToShow($user);

            echo json_encode($nextUser);
            http_response_code(200);
        }
    }
}
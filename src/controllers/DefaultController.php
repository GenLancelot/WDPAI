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

   public function settings(){
       if(isset($_COOKIE['user'])) {
           $url = "http://$_SERVER[HTTP_HOST]";
           header("Location: ${url}/chat");
       }
        $this->render('settings');
   }

}
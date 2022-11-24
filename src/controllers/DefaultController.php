<?php

require_once 'AppController.php';

class DefaultController extends AppController{
   
    public function index(){
        $this->render('login' , ['message' => "hello world"]);
   }
   
   public function chat(){
        $this->render('main_chat');
   }

   public function settings(){
        $this->render('settings');
   }
}
<?php

class AppController {
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isPost():bool
    {
        return $this->request === 'POST';
    }

    protected function isGet():bool
    {
        return $this->request === 'GET';
    }

    protected function render(string $template = null, array $variables = []){
        if (!($template === 'registartion' || $template === 'login') && !isset($_COOKIE["user"])){
            $this->redirect('/login');
            return;
        }
        elseif(isset($_COOKIE["user"])){
            $userRepository = new UserRepository();
            if($userRepository->checkIfAdmin($_COOKIE["user"])){
                if($template !== 'admin'){
                    $this->redirect('/admin');
                }
            }
            elseif($template === 'admin'){
                $this->redirect('main');
            }
        }
        $templatePath = 'public/views/'.$template.'.php';
        $output = "File not found! $templatePath";

        if(file_exists($templatePath)){
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }

    protected function redirect(string $destination){
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/{$destination}");
    }
}
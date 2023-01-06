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
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
            return;
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
}
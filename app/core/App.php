<?php

class App{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parse_url();

        if(file_exists('../app/controllers/'.$url[0].'.php'))
        {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once'../app/controllers/'.$this->controller.'.php';
        $this->controller = new $this->controller;
        
        if(isset($url[1]))
        {
            if(method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if(!empty($url))
        {
            $this->params = array_values($url);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parse_url()//method yg digunalan untuk memparsing url
    {
        //jika ada urlnya maka
        if(isset($_GET['url'])){//ambil url tersebut
            $url = rtrim($_GET['url'], '/'); //hilangkan tanda slash diakhir
            $url = filter_var($url, FILTER_SANITIZE_URL);//bersihkan url dari karakter2 aneh
            $url = explode('/', $url); //pecah string-stringnya berdasarkan tanda slash yang berdasar url
            return $url;
        }
    }

}
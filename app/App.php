<?php

namespace App;

use App\Exceptions\RouteNotFoundException;

class App
{
    private static $db;
    protected array $request;
    protected Router $router;
    protected RouterAPI $routerAPI;
    protected Config $config;

    public function __construct(Router              $router,
                                RouterAPI $routerAPI,
                                array               $request,
                                Config    $config)
    {
        $this->config = $config;
        $this->routerAPI = $routerAPI;
        $this->router = $router;
        $this->request = $request;

        static::$db = new DB($config->db ?? []);
    }

    private function isAPI() {
        $isApi = mb_substr($this->request['uri'],0,5);
        return $isApi === "/api" || $isApi === "/api/"? true:false;
    }
    private function ApiAllow() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    }


    public static function db()
    {
        return static::$db;
    }

    public function run()
    {
        
        try {
            if($this->isAPI() === false) {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
            } else {
               $this->ApiAllow();
                echo $this->routerAPI->resolve($this->request['uri'], strtolower($this->request['method']));
            }
        } catch (RouteNotFoundException $ex) {
            http_response_code(404);

            //echo View::make('error/404');
        }
    }

}
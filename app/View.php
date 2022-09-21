<?php

namespace App;
use App\Exceptions\ViewNotFoundException;

class View
{
    protected array $params = [];
    protected string $view;

    public function __construct(
        string $view,
        array $params = [])
    {
        $this->view = $view;
        $this->params = $params;
    }

    public function render(bool $includeLayout)
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';
        $layout = LAYOUT_VIEW_PATH;
        $content = $viewPath;

        if(!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }
        if ($includeLayout) {
            ob_start();

            include $layout;

            return (string)ob_get_clean();
        } else {
            ob_start();

            include $content;

            return (string)ob_get_clean();
        }
    }
    public static function  make(string $view, array $params = []) {

        return new static($view,$params);

    }
    public function __get(string $name)
    {
        return $this -> params[$name]?? null;
    }
}
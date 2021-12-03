<?php


class Router
{

    //$routes - масив в котором будут храниться маршруты
    private $routes;

    //конструктор который заполняет массив $routes
    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /* метод получения строки запроса
     * return 'string'
     * */
    private function getUrl()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    //run() - будет принимать управление от FRONT CONTROLLER. Отвечает за анализ запроса и дальнейшую передачу.
    public function run()
    {

        //получить строку запроса от пользователя(Url)
        $url = $this->getUrl();

        //проверить наличие такого запроса в routes.php
        foreach ($this->routes as $urlPattern => $path) {
            //Сравниваем запрос пользователя с нашими маршрутами с $routes
            if (preg_match("~$urlPattern~", $url)) {

                //Получаем внутренний путь из внешнего URL запроса правилу описаному routes
                $internalRoute = preg_replace("~$urlPattern~", $path, $url);

                //Определить какой контроллер и action обрабатывают запрос
                $segments = explode('/', $internalRoute);

                //достаем имя контроллера(имя класса)
                $controllerName = array_shift($segments) . 'Controller';

                //Данные в переменной задаем с заглавной буквы
                $controllerName = ucfirst($controllerName);

                //достаем имя экшена(имя метода)
                $actionName = 'action' . ucfirst(array_shift($segments));

                //записываем оставшиеся параметры в переменную(массив)
                $parameters = $segments;

                //Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                //Создать объект, вызвать метод и прервать дальнейшее сравнение запроса
                $controllerObject = new $controllerName;

                //callback фун-ция вызывающая метод объекта и передает ему маасив с параметрами
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }
}


<?php
// routes/web.php
require_once __DIR__ . '/../src/Helpers/Database.php';
require_once __DIR__ . '/../src/Controllers/UserController.php';
require_once __DIR__ . '/../src/Controllers/TaskController.php';


$routes = [
    '/' => ['controller' => 'HomeController', 'method' => 'index', 'request'=>'get' ],
    '/login' => ['controller' => 'UserController', 'method' =>'showLoginForm', 'request' => 'get'],
    '/register' => ['controller' => 'UserController', 'method' => 'register', 'request' => 'get'],
    '/logout' => ['controller' => 'UserController', 'method' => 'logout', 'request' => 'get'],
    '/tasks' => ['controller' => 'TaskController', 'method' =>'index', 'request' => 'get'],
    '/tasks/create' => ['controller' => 'TaskController', 'method' =>'create', 'request' => 'get'],
    '/tasks/edit/{id}' => ['controller' => 'TaskController', 'method' =>'edit', 'request' => 'get'],
    '/tasks/delete/{id}' => ['controller' => 'TaskController', 'method' => 'delete', 'request' => 'get'],
    '/tasks/save/{id}' => ['controller' => 'TaskController', 'method' =>'save', 'request' => 'post'],
    // Otras rutas...
];

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$foundRoute = false;
$requestUri = str_replace(BASE_URL,'', $requestUri);
//var_dump($requestUri);die();
foreach ($routes as $route => $action) {
    $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route);
    if (preg_match("#^{$routePattern}$#", $requestUri, $matches)) {
        $foundRoute = true;
        array_shift($matches);
        $controllerName = $action['controller'];
        $methodName = $action['method'];
        $controller = new $controllerName();
        call_user_func_array([$controller, $methodName], $matches);
        break;
    }
}
if (!$foundRoute) {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
    exit();
}
die();



<?php
include_once "vendor/autoload.php";
include_once "env.php";
//Directiva para insertar o utilizar la clase RouteCollector
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;

//instancia una variable de la clase RouteCollector
$router = new RouteCollector();

//Definir las rutas de mi aplicación

$router ->get('/',function (){
    return 'Esto corresponde a la página principal';
});

$router ->get('/vistas',function (){
    include_once "views/welcome.php";
});

$router ->get('/pass',function (){
    echo "se va a generar una contraseña";
    include_once "auxiliar/funciones.php";
    var_dump($_GET);

    if (isset($_GET['num1'])){
        echo generatePassword($_GET['num1']);
    }else{
        echo "Tienes que pasarme un parámetro llamado num1";
    }

});





//Resolver la ruta que debemos cargar
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
try{
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (HttpRouteNotFoundException $e){
    include_once "views/404.html";
}


// Print out the value returned from the dispatched function
echo $response;
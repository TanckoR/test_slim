<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 10.12.2020
 * Time: 12:23
 */

require __DIR__ . '/../vendor/autoload.php';

session_start();

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        /*параметры подлкючения к бд*/
        'db' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'pet_project',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => 'pet_',
        ],
    ],

]);

$container = $app->getContainer();



/*подключение к бд*/
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use($capsule){
  return $capsule;
};

$container['auth'] = function($container){
    return new App\Auth\Auth;
};

/*переопределение стандартного view на twig view*/
$container['view'] = function ($container){
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/views',[
        'cache' =>false,
    ]);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    $view->getEnvironment()->addGlobal('auth',[
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);

    return $view;
};





/*подключение Middleware*/
$app->add( new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add( new \App\Middleware\OldInputMiddleware($container));


/*подключение валидаторов*/
$container['validator'] = function($container){
    return new App\Validation\Validator;
};

/*подключение контроллеров*/
$container['HomeController'] = function($container){
    return new \App\Controllers\HomeController($container);
};

$container['AdminController'] = function($container){
    return new \App\Controllers\AdminController($container);
};

$container['AuthController'] = function($container){
    return new \App\Controllers\Auth\AuthController($container);
};

/*подключение дополнительных файлов*/
require __DIR__ . '/../app/routes.php';
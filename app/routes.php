<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 10.12.2020
 * Time: 12:18
 */


$app->get('/','HomeController:index')->setName('home');


$app->group('/auth', function() use ($app) {
    /* роуты для регистрации */
    $app->get('/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $app->post('/signup', 'AuthController:postSignUp');

    /*роуты для авторизации*/
    $app->get('/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $app->post('/signin', 'AuthController:postSignIn');

    $app->get('/forget', 'AuthController:getUpdatePass')->setName('auth.user.forget');
    $app->post('/forget', 'AuthController:postUpdatePass');

    $app->post('/check_code', 'AuthController:postCheckCode')->setName('auth.user.check');

    $app->get('/success','AuthController:getSuccess')->setName('auth.user.update.success');

    $app->get('/logout', 'AuthController:getSignOut')->setName('auth.logout');
});

$app->group('/admin', function() use ($app){
    $app->get('/','AdminController:index')->setName('admin.index');
    $app->get('/get_user','AdminController:get_user')->setName('admin.get_users');
    $app->get('/get_sessions','AdminController:get_sessions')->setName('admin.get_sessions');


    $app->get('/getusers','AdminController:getUsers')->setName('admin.users');
    $app->get('/getuserssessions','AdminController:getUserSession')->setName('admin.users.sessions');
    $app->post('/unsetuser','AdminController:unsetUser')->setName('admin.user.logout');
    $app->post('/deleteuser','AdminController:deleteUser')->setName('admin.user.delete');
})->add( new \App\Middleware\AdminCheckMiddleware($container));;

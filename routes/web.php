<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'middleware' => 'client'], function () use ($router) {
//    $router->get('carbon-offset-schedule',  function () use ($router){
//        return $router->app->version();
//    });
    $router->get('carbon-offset-schedule', 'ScheduleController@carbonOffsetSchedule');
});

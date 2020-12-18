<?php

require __DIR__.'/app/init.php';
require __DIR__.'/vendor/autoload.php';

date_default_timezone_set('Europe/Istanbul');

$routeExplode = explode('?' , $_SERVER['REQUEST_URI']);
$route = array_filter(explode('/' , $routeExplode[0]));

if (SUBFOLDER === true){
    array_shift($route);
}
if (!route(0)){
    $route[0] = 'index';
}
if (!file_exists(controller(route(0)))){
    $route[0] = '404';
    header('Location:' . site_url('404'));
}
if (setting('maintenance_mode') == 'yes' && route(0) != 'admin'){
    $route[0] = 'maintenance_mode';
}

if (post('submit-sign-up') || post('submit-login') || post('forget-password')) {
    require __DIR__ . '/app/register.php';
}

require controller(route(0));

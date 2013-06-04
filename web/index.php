<?php
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/views',
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../logs/silex/development.log',
));

$app->get('/', function() {
    return "Hello World!";
});
$app->get('/hello/{name}', function ($name) use($app) {
    return $app['twig']->render('hello.twig', array(
        'name' => $name,
    ));
});
$app->get('/users', function () use($app) {

    return $app['twig']->render('users.twig', array(
    	'users' => $users,
    ));
});
$app->run();
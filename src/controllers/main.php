<?php
require_once __DIR__.'/../../vendor/autoload.php'; 




$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../../src/views',
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../../logs/silex/development.log',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
    'driver'   => 'pdo_mysql',
    'host' => '10.11.12.2',
    'user' => 'silex',
    'password' => 'silex',
    'dbname' => 'silex'
    ),
));
$app['debug'] = true;

$app->get('/', function() use($app) {
    return $app['twig']->render('index.twig');
})
->bind('homepage');

$app->get('/hello/{name}', function ($name) use($app) {
    return $app['twig']->render('hello.twig', array(
        'name' => $name,
    ));
});


$sql = "SELECT id, firstname, lastname FROM users";
$users = $app['db']->fetchAll($sql);
/*
$users = array(
    1 => array(
    	'id' => '1',
        'firstname' => 'Julien',
        'lastname'  => 'Grossiord'
    ),
    2 => array(
    	'id' => '2',
        'firstname' => 'John',
        'lastname'  => 'Doe'
    )
);*/



$app->get('/users', function () use($app, $users) {
    return $app['twig']->render('users.twig', array(
    	'users' => $users,
    ));
})
->bind('users');

$app->get('/users/{id_user}', function ($id_user) use($app, $users) {
    return $app['twig']->render('user.twig', array(
    	'user' => $users[$id_user],
    ));
})
->bind('user');



return $app;

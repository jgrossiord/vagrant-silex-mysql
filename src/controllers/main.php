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

$app->get('/users', function () use($app) {
    //@TODO Autoload
    require_once(__DIR__.'/../models/Users.php');
    $users = new Models\Users($app['db']);
    return $app['twig']->render('users.twig', array(
    	'users' => $users->users(),
    ));
})
->bind('users');

$app->get('/favicon.ico', function() {
    return 1;
});

$app->get('/user/{id_user}', function($id_user) use($app) {
    //@TODO Autoload
    require_once(__DIR__.'/../models/User.php');
	$user = new Models\User($id_user, $app['db']);
    return $app['twig']->render('user.twig', array(
        'user' => $user->user()
    ));
})
->bind('user');

return $app;
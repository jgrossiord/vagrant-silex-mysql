<?php
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/views',
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../logs/silex/development.log',
));

$app->get('/', function() use($app) {
    return $app['twig']->render('index.twig');
});
$app->get('/hello/{name}', function ($name) use($app) {
    return $app['twig']->render('hello.twig', array(
        'name' => $name,
    ));
});

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
);
$app->get('/users', function () use($app, $users) {
    return $app['twig']->render('users.twig', array(
    	'users' => $users,
    ));
});
$app->get('/users/{id_user}', function ($id_user) use($app, $users) {
    return $app['twig']->render('user.twig', array(
    	'user' => $users[$id_user],
    ));
});
	$foo = new \Foo\Foo();

$app->get('/{q}', function() use ($app, $foo) {
    return $foo->routeDumper($app['routes']->getIterator());
});

$app->run();
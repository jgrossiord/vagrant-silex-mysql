<?php
$app = require_once __DIR__.'/../src/controllers/main.php'; 

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
$app->run();
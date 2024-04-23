<?php

include 'Router.php';
include '../src/ORM/DBProviderInterface.php';
include '../src/ORM/SQLiteProvider.php';
include '../src/Entity/EntityInterface.php';
include '../src/Entity/AddressesBook.php';
include '../src/ORM/AddressesRepository.php';
include '../src/View/Render.php';
include '../src/Controller/AddressesBookController.php';


use Controller\AddressesBookController;
use ORM\SQLiteProvider;
use ORM\AddressesRepository;
use View\Render;


$SQLiteProvider = new SQLiteProvider('../database/db.sqlite');
$container = [
    'AddressesRepository' => new AddressesRepository($SQLiteProvider),
    'Render' => new Render()
];
$controller = new AddressesBookController($container);
$route = new Router($controller);

$url = $_SERVER['SCRIPT_URL'];
$get = $_GET;
echo $route->call($url, $get);
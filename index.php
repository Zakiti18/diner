<?php

// turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require needed files
require_once('vendor/autoload.php');

// start a session AFTER the autoload
session_start();

// :: invoke static method, -> invoke instance method
// instantiate Fat-Free and controller
$f3 = Base::instance();
$con = new Controller($f3);

// define routes
// default route
$f3->route('GET /', function (){
    $GLOBALS["con"]->home();
});

$f3->route('GET /breakfast', function (){
    // display the breakfast page
    $view = new Template();
    echo $view->render('views/breakfast.html');
});

$f3->route('GET /lunch', function (){
    // display the lunch page
    $view = new Template();
    echo $view->render('views/lunch.html');
});

$f3->route('GET|POST /order1', function (){
    $GLOBALS['con']->order1();
});

$f3->route('GET|POST /order2', function (){
    $GLOBALS['con']->order2();
});

$f3->route('GET /summary', function (){
    $GLOBALS['con']->summary();
});

// run Fat-Free
$f3->run();
<?php

// this is my controller for the diner project

// turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

// require autoload file
require_once('vendor/autoload.php');
require_once('model/dataLayer.php');
require_once('model/validation.php');

// :: invoke static method, -> invoke instance method
// instantiate Fat-Free
$f3 = Base::instance();

// define routes
// default route
$f3->route('GET /', function (){
    // display the home page
    $view = new Template();
    echo $view->render('views/home.html');
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

$f3->route('GET|POST /order1', function ($f3){
    // reinitialize session array
    $_SESSION = array();

    // if the form has been submitted, add data to session
    // and send user to next form
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // if food is valid store data
        if(validFood($_POST['food'])) {
            $_SESSION['food'] = $_POST['food'];
        }
        // otherwise set an error variable in the hive
        else{
            $f3->set('errors["food"]', 'Please enter a food');
        }

        // if meal is valid store data
        if(isset($_POST['meal']) && validFood($_POST['meal'])) {
            $_SESSION['meal'] = $_POST['meal'];
        }
        // otherwise set an error variable in the hive
        else{
            $f3->set('errors["meal"]', 'Invalid meal selected');
        }

        // if there are no errors, redierct to order 2
        if(empty($f3->get('errors'))) {
            header('location: order2');
        }
    }

    // get the data from the model
    $f3->set('meals', getMeals());

    // display the first order form
    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

$f3->route('GET|POST /order2', function ($f3){
    // if the form has been submitted, add data to session
    // and send user to summary
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['conds'])){
            // data validation goes here
            if(validCondiments($_POST['conds'])){
                $_SESSION['conds'] = implode(", ", $_POST['conds']);
            }
            else{
                $f3->set('errors["conds"]', 'Invalid selection(s)');
            }
        }

        // if the error array is empty, redirect to summary page
        if(empty($f3->get('errors'))){
            header('location: summary');
        }
    }

    // get the data from the model
    $f3->set('conds', getCondiments());

    // display the second order form
    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

$f3->route('GET /summary', function (){
    // display the order summary
    $view = new Template();
    echo $view->render('views/summary.html');
});

// run Fat-Free
$f3->run();
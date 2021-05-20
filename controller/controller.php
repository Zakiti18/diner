<?php

class Controller
{
    private $_f3; // router

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        // display the home page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function order1()
    {
        // reinitialize session array
        $_SESSION = array();

        // instantiate an Order object
        $_SESSION['order'] = new Order();

        // initialize variables to store user input
        $userFood = "";
        $userMeal = "";

        // if the form has been submitted, add data to session
        // and send user to next form
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $userFood = $_POST['food'];
            $userMeal = $_POST['meal'];

            // if food is valid store data
            if(Validation::validFood($_POST['food'])) {
                $_SESSION['order']->setFood($userFood);
            }
            // otherwise set an error variable in the hive
            else{
                $this->_f3->set('errors["food"]', 'Please enter a food');
            }

            // if meal is valid store data
            if(!empty($userMeal) && Validation::validFood($userMeal)) {
                $_SESSION['order']->setMeal($userMeal);
            }
            // otherwise set an error variable in the hive
            else{
                $this->_f3->set('errors["meal"]', 'Invalid meal selected');
            }

            // if there are no errors, redierct to order 2
            if(empty($this->_f3->get('errors'))) {
                header('location: order2');
            }
        }

        // get the data from the model
        $this->_f3->set('meals', DataLayer::getMeals());

        // store the user input in the hive
        $this->_f3->set('userFood', $userFood);
        $this->_f3->set('userMeal', $userMeal);

        // display the first order form
        $view = new Template();
        echo $view->render('views/orderForm1.html');
    }

    function order2()
    {
        // initialize variables for user input
        $userConds = array();

        // if the form has been submitted, add data to session
        // and send user to summary
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['conds'])){
                // get user input
                $userConds = $_POST['conds'];

                // data validation goes here
                if(Validation::validCondiments($userConds)){
                    $_SESSION['order']->setCondiments(implode(", ", $userConds));
                }
                else{
                    $this->_f3->set('errors["conds"]', 'Invalid selection(s)');
                }
            }

            // if the error array is empty, redirect to summary page
            if(empty($this->_f3->get('errors'))){
                header('location: summary');
            }
        }

        // get the data from the model
        $this->_f3->set('conds', DataLayer::getCondiments());

        // add the user data to the hive
        $this->_f3->set('userConds', $userConds);

        // display the second order form
        $view = new Template();
        echo $view->render('views/orderForm2.html');
    }

    function summary()
    {
        // display the order summary
        $view = new Template();
        echo $view->render('views/summary.html');
    }
}
<?php

/*
 * dataLayer.php
 * Return data for the diner app
 */

class DataLayer
{
    // add a field for the database object
    private $_dbh;

    // define a constructor
    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    // saves an order to the database
    function saveOrder()
    {
        // 1. Define the query
        $sql = "INSERT INTO orders (food, meal, condiments)
                VALUES (:food,:meal, :condiments)";

        // 2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        // 3. Bind the parameters
        $order = $_SESSION['order'];
        $statement->bindParam(':food', $order->getFood(), PDO::PARAM_STR);
        $statement->bindParam(':meal', $order->getMeal(), PDO::PARAM_STR);
        $statement->bindParam(':condiments', $order->getCondiments(), PDO::PARAM_STR);

        // 4. Execute the query
        $statement->execute();

        // 5. Process the results (get OrderID)
        $id = $this->_dbh->lastInsertId();
        return $id;
    }

    // get the meals for the order form part 1
    static function getMeals()
    {
        return array("breakfast", "brunch", "lunch", "dinner");
    }

    // get the condiments for the order form part 2
    static function getCondiments()
    {
        return array("ketchup", "mustard", "sriracha");
    }
}
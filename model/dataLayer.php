<?php

/*
 * dataLayer.php
 * Return data for the diner app
 */

require_once ($_SERVER['DOCUMENT_ROOT'].'/../config.php');

class DataLayer
{
    // add a field for the database object
    private $_dbh;

    // define a constructor
    function __construct()
    {
        // connect to the database
        try{
            // instantiate a PDO database object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo "Connected"; // for debugging
        }
        catch (PDOException $e){
            //echo $e->getMessage(); // for debugging
            die("ERROR! Please call to place your order.");
        }
    }

    // saves an order to the database
    function saveOrder($order)
    {
        // 1. Define the query
        $sql = "INSERT INTO orders (food, meal, condiments)
                VALUES (:food,:meal, :condiments)";

        // 2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        // 3. Bind the parameters
        $statement->bindParam(':food', $order->getFood(), PDO::PARAM_STR);
        $statement->bindParam(':meal', $order->getMeal(), PDO::PARAM_STR);
        $statement->bindParam(':condiments', $order->getCondiments(), PDO::PARAM_STR);

        // 4. Execute the query
        $statement->execute();

        // 5. Process the results (get OrderID) (typically used for select statements)
        $id = $this->_dbh->lastInsertId();
        return $id;
    }

    function getOrders(){
        // 1. Define the query
        $sql = "SELECT order_id, food, meal, condiments, order_date FROM orders";

        // 2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        // 3. Bind the parameters

        // 4. Execute the query
        $statement->execute();

        // 5. Process the results (typically used for select statements)
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
<?php

/*
 * dataLayer.php
 * Return data for the diner app
 */

class DataLayer
{
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
<?php

/*
 * validation.php
 * validate data for the diner app
 */

class Validation
{
    // return true if a food is valid
    static function validFood($food)
    {
        return strlen(trim($food)) >= 2;
    }

    // return true if meal is valid
    static function validMeal($meal)
    {
        return in_array($meal, DataLayer::getMeals());
    }

    // return true if meal is valid
    static function validCondiments($conds)
    {
        // make sure each selected condiment is valid
        foreach ($conds as $cond) {
            if (!in_array($cond, DataLayer::getCondiments())) {
                return false;
            }
        }
        return true;
    }
}
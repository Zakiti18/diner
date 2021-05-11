<?php

/*
 * validation.php
 * validate data for the diner app
 */

// return true if a food is valid
function validFood($food)
{
    return strlen(trim($food)) >= 2;
}

// return true if meal is valid
function validMeal($meal)
{
    return in_array($meal, getMeals());
}

// return true if meal is valid
function validCondiments($conds)
{
    // make sure each selected condiment is valid
    foreach ($conds as $cond){
        if(!in_array($cond, getCondiments())){
            return false;
        }
    }
    return true;
}
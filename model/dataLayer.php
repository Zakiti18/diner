<?php

/*
 * dataLayer.php
 * Return data for the diner app
 */

// get the meals for the order form part 1
function getMeals(){
    return array("breakfast", "brunch", "lunch", "dinner");
}

// get the condiments for the order form part 2
function getCondiments(){
    return array("ketchup", "mustard", "sriracha");
}
<?php

/*
 * Acme Controller
 */

// Get or create session
session_start();

// Get the database connection file
require_once 'library/connections.php';
// Get the acme model for use as needed
require_once 'model/acme-model.php';
// Get the functions library
require_once 'library/functions.php';

// Get the array of categories
$categories = getCategories();

// call buildNav function
$navList = buildNav($categories);

// Check if the clientFirstname cookie exists, get its value
if (isset($_COOKIE['clientFirstname'])) {
    $cookieClientFirstname = filter_input(INPUT_COOKIE, 'clientFirstname', FILTER_SANITIZE_STRING);
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'home';
    }
}

switch ($action) {
    case 'something':

        break;
    default:
        include 'view/home.php';
}
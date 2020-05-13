<?php

/*
 * Accounts Controller
 */

// Get or create session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the acme model for use as needed
require_once '../model/acme-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';

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
}

switch ($action) {
    case 'Logout':
        session_unset();
        session_destroy();
        header("Location: ../index.php?action=home");
        break;
    case 'login':
        include '../view/login.php';
        break;
    case 'login_user':
        // Filter and store data
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if (empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form 
                       fields.<p>';
            include '../view/login.php';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        
        // Remove the clientFirstname cookie if it exists
        setcookie('clientFirstname', "", time() - 3600);

        // Send them to the admin view
        include '../view/admin.php';
        exit;
    case 'reg':
        include '../view/register.php';
        break;
    case 'register':
        // Filter and store data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Check for existing email address in the table
        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail) {
            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) ||
                empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form 
                       fields.<p>';
            include '../view/register.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {

            setcookie('clientFirstname', $clientFirstname, strtotime('+1 year'), '/');

            $message = "<p>Thanks for registering $clientFirstname. Please use
                       your email and password to log in.</p>";
            include '../view/login.php';
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed.
                       Please try again.</p>";
            include '../view/register.php';
            exit;
        }
        break;
    case 'update':
        $accountEmail = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
        $accountInfo = $_SESSION['clientData'];
        if (count($accountInfo) < 1) {
            $message = 'Sorry, no account information could be found.';
        }
        include '../view/client-update.php';
        break;
    case 'updateAccount':
        // Filter and store data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

//        $clientEmail = checkEmail($clientEmail);
        // Check for existing email address in the table
//        $existingEmail = checkExistingEmail($clientEmail);
//        if ($existingEmail) {
//            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
//            include '../view/login.php';
//            exit;
//        }
        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) ||
                empty($clientEmail) || empty($clientId)) {
            $message = '<p>Please provide information for all empty form 
                       fields.<p>';
            include '../view/client-update.php';
            exit;
        }

        // Send the data to the model
        $updateAccountOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

        // Check and report the result
        if ($updateAccountOutcome === 1) {

            setcookie('clientFirstname', $clientFirstname, strtotime('+1 year'), '/');

            $clientData = getClientById($clientId);
            $_SESSION['clientData'] = $clientData;

            $message = "<p>Thanks for updating $clientFirstname.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/accounts/');
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the update failed.
                       Please try again.</p>";
            include '../view/register.php';
            exit;
        }
        break;
    case 'updatePassword':
        // Filter and store data
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if (empty($clientId) || empty($checkPassword)) {
            $passwordUpdateMessage = "<p>The password did not meet the required criteria.<p>";
            include '../view/client-update.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $updateAccountPassword = updatePassword($hashedPassword, $clientId);

        // Check and report the result
        if ($updateAccountPassword === 1) {

            $message = "<p>Thanks for updating your password.";
            $_SESSION['message'] = $message;
            header('location: /acme/accounts/');
            exit;
        } else {
            $passwordUpdateMessage = "<p>Sorry $clientFirstname, but the password update failed.
                       Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }
        break;
    default:
        include '../view/admin.php';
        break;
}
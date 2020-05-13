<?php

/*
 * Accounts Model
 */

// Insert user registration data into the database
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword) {
    $db = acmeConnect();
    // Insert client SQL statement
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, 
            clientPassword)VALUES (:firstname, :lastname, :email, :password)';

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':firstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':lastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':password', $clientPassword, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();

    $stmt->closeCursor();

    return $rowsChanged;
}

function updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId) {
    $db = acmeConnect();
    // Insert client SQL statement
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname,
                               clientLastname = :clientLastname,
                               clientEmail = :clientEmail
                               WHERE
                                   clientId = :clientId';
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();

    $stmt->closeCursor();

    return $rowsChanged;
}

function updatePassword($clientPassword, $clientId) {
    $db = acmeConnect();
    // Insert client SQL statement
    $sql = 'UPDATE clients SET clientPassword = :clientPassword
                               WHERE
                                   clientId = :clientId';
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();

    $stmt->closeCursor();

    return $rowsChanged;
}

// Check for an existing email address
function checkExistingEmail($clientEmail) {
    $db = acmeConnect();
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if (empty($matchEmail)) {
        return 0;
        // echo 'Nothing found';
        // exit;
    } else {
        return 1;
        // echo 'Match found';
        // exit;
    }
}

// Get client data based on an email address
function getClient($email) {
    $db = acmeConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

function getClientById($clientId) {
    $db = acmeConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

<?php

/*
 * Categories Model
 */

// Insert new category into the database
function addCategory($categoryName) {
    $db = acmeConnect();
    // Insert client SQL statement
    $sql = 'INSERT INTO categories (categoryName) VALUES (:categoryName)';

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();

    $stmt->closeCursor();

    return $rowsChanged;
}

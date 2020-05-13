<?php

/*
 * Products Model
 */

// Insert new product into the database
function addProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle) {
    $db = acmeConnect();
    // Insert client SQL statement
    $sql = 'INSERT INTO inventory (invName, invDescription, invImage, 
                                   invThumbnail, invPrice, invStock, invSize,
                                   invWeight, invLocation, categoryId, 
                                   invVendor, invStyle) 
                                   VALUES 
                                   (:invName, :invDescription, :invImage, 
                                    :invThumbnail, :invPrice, :invStock, 
                                    :invSize, :invWeight, :invLocation, 
                                    :categoryId, :invVendor, :invStyle)';

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_STR);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_STR);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_STR);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();

    $stmt->closeCursor();

    return $rowsChanged;
}

function getProductBasics() {
    $db = acmeConnect();
    $sql = 'SELECT invName, invId FROM inventory ORDER BY invName ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

// Get product information by invId
function getProductInfo($invId) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

function updateProduct($catType, $invName, $invDescription, $invImg, $invThumb, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle, $invId) {
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'UPDATE inventory SET invName = :invName, 
                                 invDescription = :invDescription,
                                 invImage = :invImg,
                                 invThumbnail = :invThumb,
                                 invPrice = :invPrice,
                                 invStock = :invStock,
                                 invSize = :invSize,
                                 invWeight = :invWeight,
                                 invLocation = :invLocation,
                                 categoryId = :catType,
                                 invVendor = :invVendor,
                                 invStyle = :invStyle
                                 WHERE 
                                    invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':catType', $catType, PDO::PARAM_INT);
    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImg', $invImg, PDO::PARAM_STR);
    $stmt->bindValue(':invThumb', $invThumb, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function deleteProduct($invId) {
    $db = acmeConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function getProductsByCategory($categoryName) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :categoryName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

function clearFeaturedProduct() {
    $db = acmeConnect();
    $sql = 'UPDATE inventory SET invFeatured = NULL WHERE invFeatured = 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function setFeaturedProduct($invId) {
    $db = acmeConnect();
    $sql = 'UPDATE inventory SET invFeatured = 1 WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function getFeaturedProduct() {
    $db = acmeConnect();
    $sql = 'SELECT invId FROM inventory WHERE invFeatured = 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $featuredInvId = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $featuredInvId
;}
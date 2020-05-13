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
// Get the categories model
require_once '../model/categories-model.php';
// Get the Products model
require_once '../model/products-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the uploads model
require_once '../model/uploads-model.php';

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
    case 'newCat':
        include '../view/new-cat.php';
        break;
    case 'newProd':
        include '../view/new-prod.php';
        break;
    case 'addCat':
        // Filter and store data
        $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);

        // Check for missing data
        if (empty($categoryName)) {
            $message = '<p>Please provide information for all empty form 
                       fields.<p>';
            include '../view/new-cat.php';
            exit;
        }
        // Send the data to the model
        $addCatOutcome = addCategory($categoryName);

        // Check and report the result
        if ($addCatOutcome === 1) {

            $message = "<p>$categoryName nas been added.</p>";
            include '../view/new-cat.php';
            exit;
        } else {
            $message = "<p>Sorry $categoryName failed to add.
                       Please try again.</p>";
            include '../view/new-cat.php';
            exit;
        }
        break;
    case 'addProd':
        // Filter and store data
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_VALIDATE_FLOAT);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_VALIDATE_INT);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_VALIDATE_INT);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_VALIDATE_INT);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $catType = filter_input(INPUT_POST, 'catType', FILTER_VALIDATE_INT);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        // Check for missing data
        if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($catType) || empty($invVendor) || empty($invStyle)) {
            $message = '<p>Please provide information for all empty form fields.<p>';
            include '../view/new-prod.php';
            exit;
        }
        // Send the data to the model
        $addProdOutcome = addProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $catType, $invVendor, $invStyle);

        // Check and report the result
        if ($addProdOutcome === 1) {

            $message = "<p>$invName has been added.</p>";
            include '../view/new-prod.php';
            exit;
        } else {
            $message = "<p>Sorry $invName failed to add.
                       Please try again.</p>";
            include '../view/new-prod.php';
            exit;
        }
        break;
    case 'updateProd':
        // Filter and store data
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_VALIDATE_FLOAT);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_VALIDATE_INT);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_VALIDATE_INT);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_VALIDATE_INT);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $catType = filter_input(INPUT_POST, 'catType', FILTER_VALIDATE_INT);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($catType) || empty($invVendor) || empty($invStyle)) {
            $message = '<p>Please provide information for all empty form fields.<p>';
            include '../view/update-prod.php';
            exit;
        }
        // Send the data to the model
        $updateResult = updateProduct($catType, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle, $invId);

        // Check and report the result
        if ($updateResult === 1) {

            if ($updateResult) {
                $message = "<p class='notify'>Congratulations, $invName was successfully updated.</p>";
                $_SESSION['message'] = $message;
                header('location: /acme/products/');
                exit;
            }
        } else {
            $message = "<p>Sorry $invName failed to update.
                       Please try again.</p>";
            include '../view/update-prod.php';
            exit;
        }
        break;
    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if (count($prodInfo) < 1) {
            $message = 'Sorry, no product information could be found.';
        }
        include '../view/prod-update.php';
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if (count($prodInfo) < 1) {
            $message = 'Sorry, no product information could be found.';
        }
        include '../view/prod-delete.php';
        exit;
        break;
    case 'deleteProd':
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteProduct($invId);
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations, $invName was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/products/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invName was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/products/');
            exit;
        }
        break;
    case 'category':
        $categoryName = filter_input(INPUT_GET, 'categoryName', FILTER_SANITIZE_STRING);
        $products = getProductsByCategory($categoryName);
        if (!count($products)) {
            $message = "<p class='notice'>Sorry, no $categoryName products could be found.</p>";
        } else {
            $prodDisplay = buildProductsDisplay($products);
        }
        include '../view/category.php';
        break;
    case 'productDetails':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $product = getProductInfo($invId);
        $thumbnails = getThumbnails($invId);
        if ($product < 1) {
            $message = "<p class='notice'>Sorry, no product could be found.</p>";
        } else {
            $prodDetailsDisplay = buildProductDetailsDisplay($product);
        }
        if (isset($thumbnails)&& $product > 0) {
            $thumbnailDisplay = buildThumbnailsDisplay($thumbnails, $product);
        }
        include '../view/product-detail.php';
        break;
    case 'featureProduct':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        // Set old featured product message if there was one
        $currFeatured = getFeaturedProduct();
        if ($currFeatured > 1) {
            $oldFeatured = getProductInfo($currFeatured['invId']);
            $oldMessage = "<p class='notify'>$oldFeatured[invName] was previously featured</p>";
            clearFeaturedProduct();
        }
        
        // Set new featured product
        $setOutcome = setFeaturedProduct($invId);
        if ($setOutcome === 1) {
            $featuredProduct = getProductInfo($invId);
            $featuredMessage = "<p class='notify'>$featuredProduct[invName] is currently featured</p>";
        } else {
            $message = '<p class="notify">Sorry, the product could not be featured.</p>';
        }
        
        // Display product management list
        $products = getProductBasics();
        if (count($products) > 0) {
            $prodList = buildProdManagementList($products);
        } else {
            $message = '<p class="notify">Sorry, no products were returned.</p>';
        }
        
        include '../view/prod-mgmt.php';
        break;
    default:
        // Display current featured product
        $currFeatured = getFeaturedProduct();
        if ($currFeatured > 1) {
            $featuredProduct = getProductInfo($currFeatured['invId']);
            $featuredMessage = "<p class='notify'>$featuredProduct[invName] is currently featured</p>";
        } else {
            $featuredMessage = "<p class='notify'>No product is currently featured</p>";
        }
        
        // Display product management list
        $products = getProductBasics();
        if (count($products) > 0) {
            $prodList = buildProdManagementList($products);
        } else {
            $message = '<p class="notify">Sorry, no products were returned.</p>';
        }
        include '../view/prod-mgmt.php';
}
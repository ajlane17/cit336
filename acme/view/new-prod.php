<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] <= 1) {
    header("Location: ../index.php?action=home");
    exit;
}
//    // Build a category selection dropdown using the $categories array
//    $catList = '';
//    foreach ($categories as $category) {
//        $catList .= "<option value='$category[categoryId]'";
//        if(isset($catType)){
//            if($category['categoryId'] === $catType){
//                $catList .= ' selected';
//            }
//        }
//        $catList .= ">$category[categoryName]</option>";
//    }
// Build the categories option list
$catList = '<select name="catType" id="catType">';
$catList .= "<option>Choose a Category</option>";
foreach ($categories as $category) {
    $catList .= "<option value='$category[categoryId]'";
    if (isset($catType)) {
        if ($category['categoryId'] === $catType) {
            $catList .= ' selected ';
        }
    }
    $catList .= ">$category[categoryName]</option>";
}
$catList .= '</select>';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title> | ACME, Inc.</title>
        <link href="/acme/css/screen.css" rel="stylesheet" type="text/css" media="screen">
        <meta name="viewport" content="width=device-width">
    </head>

    <body class="home">
        <div id="wrapper">
            <header id="page-header">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </header>
            <nav id="page-nav">
                <?php // include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>
                <?php echo $navList; ?>
            </nav>

            <main id="content">
                <h1>Add Product</h1>
                <p>Add a new product below. All fields are required!</p>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form action="/acme/products/index.php" id="addProdForm" method="post">
                    <label for="catType">Category</label><br>
<!--                    <select name="catType" id="catType">
                        <option>Choose a category</option>
                    <?php
                    echo $catList;
                    ?>
                    </select><br>-->
                    <?php
                    echo $catList;
                    ?><br>
                    <label for="invName">Product Name</label><br>
                    <input type="text" name="invName" id="invName" <?php
                    if (isset($invName)) {
                        echo "value='$invName'";
                    }
                    ?> required><br>
                    <label for="invDescription">Product Description</label><br>
                    <textarea name="invDescription" id="invDescription" form="addProdForm" required><?php
                        if (isset($invDescription)) {
                            echo $invDescription;
                        }
                        ?></textarea><br>
                    <label for="invImage">Product Image (path to image)</label><br>
                    <input type="text" name="invImage" id="invImage" placeholder="/acme/images/products/no-image.png" <?php
                    if (isset($invImage)) {
                        echo "value='$invImage'";
                    }
                    ?> required><br>
                    <label for="invThumbnail">Product Thumbnail (path to thumbnail)</label><br>
                    <input type="text" name="invThumbnail" id="invThumbnail" placeholder="/acme/images/products/no-image.png" <?php
                    if (isset($invThumbnail)) {
                        echo "value='$invThumbnail'";
                    }
                    ?> required><br>
                    <label for="invPrice">Product Price</label><br>
                    <input type="number" name="invPrice" id="invPrice" placeholder="0.00" step="0.01" min="0" <?php
                    if (isset($invPrice)) {
                        echo "value='$invPrice'";
                    }
                    ?> required><br>
                    <label for="invStock"># in Stock</label><br>
                    <input type="number" name="invStock" id="invStock" placeholder="0" step="1" <?php
                    if (isset($invStock)) {
                        echo "value='$invStock'";
                    }
                    ?> required><br>
                    <label for="invSize">Product Size (W x H x L in inches)</label><br>
                    <input type="number" name="invSize" id="invSize" placeholder="0" step="1" <?php
                    if (isset($invSize)) {
                        echo "value='$invSize'";
                    }
                    ?> required><br>
                    <label for="invWeight">Product Weight (lbs.)</label><br>
                    <input type="number" name="invWeight" id="invWeight" placeholder="0" step="1" <?php
                    if (isset($invWeight)) {
                        echo "value='$invWeight'";
                    }
                    ?> required><br>
                    <label for="invLocation">Location (city name)</label><br>
                    <input type="text" name="invLocation" id="invLocation" <?php
                    if (isset($invLocation)) {
                        echo "value='$invLocation'";
                    }
                    ?> required><br>
                    <label for="invVendor">Product Vendor</label><br>
                    <input type="text" name="invVendor" id="invVendor" <?php
                    if (isset($invVendor)) {
                        echo "value='$invVendor'";
                    }
                    ?> required><br>
                    <label for="invStyle">Product Style</label><br>
                    <input type="text" name="invStyle" id="invStyle" <?php
                    if (isset($invStyle)) {
                        echo "value='$invStyle'";
                    }
                    ?> required><br>
                    <input type="submit" name="submit" value="Add Product">
                    <!-- Add the action key - value pair -->
                    <input type="hidden" name="action" value="addProd">
                </form>




            </main>
            <footer id="page-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <br>
                Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
            </footer>
        </div>
    </body>
</html>

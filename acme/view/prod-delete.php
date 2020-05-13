<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] <= 1) {
    header("Location: ../index.php?action=home");
    exit;
}
// Build the categories option list
//$catList = '<select name="catType" id="catType">';
//$catList .= "<option>Choose a Category</option>";
//foreach ($categories as $category) {
//    $catList .= "<option value='$category[categoryId]'";
//    if (isset($catType)) {
//        if ($category['categoryId'] === $catType) {
//            $catList .= ' selected ';
//        }
//    } elseif (isset($prodInfo['categoryId'])) {
//        if ($category['categoryId'] === $prodInfo['categoryId']) {
//            $catList .= ' selected ';
//        }
//    }
//    $catList .= ">$category[categoryName]</option>";
//}
//$catList .= '</select>';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php
            if (isset($prodInfo['invName'])) {
                echo "Delete $prodInfo[invName] ";
            } elseif (isset($invName)) {
                echo $invName;
            }
            ?> | ACME, Inc.</title>
        <link href="/acme/css/screen.css" rel="stylesheet" type="text/css" media="screen">
        <meta name="viewport" content="width=device-width">
    </head>

    <body class="home">
        <div id="wrapper">
            <header id="page-header">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </header>
            <nav id="page-nav">
                <?php // include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php';   ?>
                <?php echo $navList; ?>
            </nav>

            <main id="content">
                <h1><h1><?php
                        if (isset($prodInfo['invName'])) {
                            echo "Delete $prodInfo[invName] ";
                        } elseif (isset($invName)) {
                            echo $invName;
                        }
                        ?></h1></h1>
                <p>Delete the product below. All fields are required!</p>
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
                    <!--                    <?php
                    echo $catList;
                    ?><br>-->
                    <label for="invName">Product Name</label><br>
                    <input type="text" name="invName" id="invName" <?php
                    if (isset($invName)) {
                        echo "value='$invName'";
                    } elseif (isset($prodInfo['invName'])) {
                        echo "value='$prodInfo[invName]'";
                    }
                    ?> required readonly><br>
                    <label for="invDescription">Product Description</label><br>
                    <textarea name="invDescription" id="invDescription" form="addProdForm" required readonly><?php
                        if (isset($invDescription)) {
                            echo $invDescription;
                        } elseif (isset($prodInfo['invDescription'])) {
                            echo $prodInfo['invDescription'];
                        }
                        ?></textarea><br>
                    <input type="submit" name="submit" value="Delete Product">
                    <!-- Add the action key - value pair -->
                    <input type="hidden" name="action" value="deleteProd">
                    <input type="hidden" name="invId" value="<?php
                    if (isset($prodInfo['invId'])) {
                        echo $prodInfo['invId'];
                    } elseif (isset($invId)) {
                        echo $invId;
                    }
                    ?>">
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
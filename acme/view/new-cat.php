<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] <= 1) {
    header("Location: ../index.php?action=home");
    exit;
}
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
                <h1>Add Category</h1>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form action="/acme/products/index.php" method="post">
                    <label for="categoryName">New Category Name</label><br>
                    <input type="text" name="categoryName" id="categoryName" <?php
                    if (isset($categoryName)) {
                        echo "value='$categoryName'";
                    }
                    ?> required><br>
                    <input type="submit" name="submit" value="Add Category">
                    <!-- Add the action key - value pair -->
                    <input type="hidden" name="action" value="addCat">
                </form>

            </main>
            <footer id="page-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <br>
                Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
            </footer>
        </div>
    </body>

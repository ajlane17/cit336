<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] <= 1) {
    header("Location: ../index.php?action=home");
    exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
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
                <h1>Product Management</h1>
                <p>Welcome to the product management page. Please choose an option below:</p>
                <div id="prodMgmtList">
                    <ul>
                        <li><a href="/acme/products/index.php?action=newCat" id="newCatLink" title="Add a New Category">Add a New Category</a></li>
                        <li><a href="/acme/products/index.php?action=newProd" id="newProdLink" title="Add a New Product">Add a New Product</a></li>
                    </ul>
                </div>

                <?php
                if (isset($message)) {
                    echo $message;
                }
                
                if (isset($oldMessage)) {
                    echo $oldMessage;
                }
                
                if (isset($featuredMessage)) {
                    echo $featuredMessage;
                }
                
                if (isset($prodList)) {
                    echo $prodList;
                }
                ?>

            </main>
            <footer id="page-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <br>
                Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
            </footer>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?>
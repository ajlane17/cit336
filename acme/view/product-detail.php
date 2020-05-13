<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $product['invName']; ?> | Acme, Inc.</title>
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
                <h1><?php echo $product['invName']; ?></h1>

                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <?php
                if (isset($prodDetailsDisplay)) {
                    echo $prodDetailsDisplay;
                }
                ?>
                
                <?php
                if (isset($thumbnailDisplay)) {
                    echo $thumbnailDisplay;
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

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
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>
            </nav>

            <main id="content">
                <h1>Server Error</h1>
                <p>Sorry, the server experienced a problem.</p>
            </main>
            <footer id="page-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <br>
                Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
            </footer>
        </div>
    </body>

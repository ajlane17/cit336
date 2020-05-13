<?php
if (!isset($_SESSION['loggedin'])) {
    include '../view/login.php';
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
        <title><?php echo $_SESSION['clientData']['clientFirstname'] ?> | ACME, Inc.</title>
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
                <h1><?php echo ($_SESSION['loggedin']) ? $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname'] : '' ?></h1>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <section>
                    <p>You are logged in.</p>
                    <h3>User Details</h3>
                    <ul id="userDetails">
                        <li><?php echo ($_SESSION['loggedin']) ? 'First Name: ' . $_SESSION['clientData']['clientFirstname'] : '' ?></li>
                        <li><?php echo ($_SESSION['loggedin']) ? 'Last Name: ' . $_SESSION['clientData']['clientLastname'] : '' ?></li>
                        <li><?php echo ($_SESSION['loggedin']) ? 'Email: ' . $_SESSION['clientData']['clientEmail'] : '' ?></li>
                    </ul>
                    <?php
                    echo '<p><a href="/acme/accounts?action=update&email=' . $_SESSION['clientData']['clientEmail'] . '" title="Update account information">Update Account Information</a></p>';
                    ?>
                    <?php
                    if ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] > 1) {
                        echo '<p><a href="/acme/products/" title="Products">Product Management</a></p>';
                    }
                    ?>
                </section>
            </main>
            <footer id="page-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <br>
                Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
            </footer>
        </div>
    </body>

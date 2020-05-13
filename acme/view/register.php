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
                <h1>Acme Registration</h1>
                <p>All fields are required.</p>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form action="/acme/accounts/index.php" method="post">
                    <label for="clientFirstname">First name</label><br>
                    <input type="text" name="clientFirstname" id="clientFirstname" <?php
                    if (isset($clientFirstname)) {
                        echo "value='$clientFirstname'";
                    }
                    ?> required><br>
                    <label for="clientLastname">Last name</label><br>
                    <input type="text" name="clientLastname" id="clientLastname" <?php
                    if (isset($clientLastname)) {
                        echo "value='$clientLastname'";
                    }
                    ?> required><br>
                    <label for="clientEmail">Email address</label><br>
                    <input type="email" name="clientEmail" id="clientEmail" <?php
                    if (isset($clientEmail)) {
                        echo "value='$clientEmail'";
                    }
                    ?> required><br>
                    <label for="clientPassword">Password</label><br>
                    <p class="footnote">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
                    <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    <input type="submit" name="submit" value="Register">
                    <!-- Add the action key - value pair -->
                    <input type="hidden" name="action" value="register">
                </form>
            </main>
            <footer id="page-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
                <br>
                Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
            </footer>
        </div>
    </body>

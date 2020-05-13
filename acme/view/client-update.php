<?php
if (!isset($_SESSION['loggedin'])) {
    include '../view/login.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php
            if (isset($accountInfo['clientFirstname'])) {
                echo "Modify $accountInfo[clientFirstname] ";
            } elseif (isset($clientFirstname)) {
                echo $clientFirstname;
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
                <?php // include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>
                <?php echo $navList; ?>
            </nav>

            <main id="content">
                <h1>Update Account Information</h1>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form class="updateAccount" action="/acme/accounts/index.php" method="post">
                    <label for="clientFirstname">First name</label><br>
                    <input type="text" name="clientFirstname" id="clientFirstname" <?php
                    if (isset($clientFirstname)) {
                        echo "value='$clientFirstname'";
                    } elseif (isset($accountInfo['clientFirstname'])) {
                        echo "value='$accountInfo[clientFirstname]'";
                    }
                    ?> required><br>
                    <label for="clientLastname">Last name</label><br>
                    <input type="text" name="clientLastname" id="clientLastname" <?php
                    if (isset($clientLastname)) {
                        echo "value='$clientLastname'";
                    } elseif (isset($accountInfo['clientLastname'])) {
                        echo "value='$accountInfo[clientLastname]'";
                    }
                    ?> required><br>
                    <label for="clientEmail">Email address</label><br>
                    <input type="email" name="clientEmail" id="clientEmail" <?php
                    if (isset($clientEmail)) {
                        echo "value='$clientEmail'";
                    } elseif (isset($accountInfo['clientEmail'])) {
                        echo "value='$accountInfo[clientEmail]'";
                    }
                    ?> required><br>
                    <input type="submit" name="submit" value="Update Account">
                    <!-- Add the action key - value pair -->
                    <input type="hidden" name="action" value="updateAccount">
                    <input type="hidden" name="clientId" value="<?php
                    if (isset($accountInfo['clientId'])) {
                        echo $accountInfo['clientId'];
                    } elseif (isset($clientId)) {
                        echo $clientId;
                    }
                    ?>">
                </form>
                <br>
                <h3>Password Change</h3>
                <?php
                if (isset($passwordUpdateMessage)) {
                    echo $passwordUpdateMessage;
                }
                ?>
                <form class="updateAccount" action="/acme/accounts/index.php" method="post">
                    <label for="clientPassword">Password</label><br>
                    <p class="footnote">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
                    <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    <input type="submit" name="submit" value="Update Password">
                    <!-- Add the action key - value pair -->
                    <input type="hidden" name="action" value="updatePassword">
                    <input type="hidden" name="clientId" value="<?php
                    if (isset($accountInfo['clientId'])) {
                        echo $accountInfo['clientId'];
                    } elseif (isset($clientId)) {
                        echo $clientId;
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

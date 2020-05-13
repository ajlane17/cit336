<div id="sitebrand">
    <a href="/acme/index.php?action=home"><img src="/acme/images/site/logo.gif" title="Site Logo" alt="ACME Logo"></a>
</div>

<div id="toplinks">
    <?php
    if (isset($_SESSION['loggedin'])) {
        echo "<span><a href='/acme/accounts/' title='Account Management'>Welcome " . $_SESSION['clientData']['clientFirstname']. "</a></span>";
        echo '<a href="/acme/accounts/index.php?action=Logout" title="Click to logout"><img src="/acme/images/site/account.gif" alt="My Account Icon"><span>Log Out</span></a>';
    } else {
        echo "<span><a href='/acme/' title='Home'>Welcome</span>";
        echo '<a href="/acme/accounts/index.php?action=login" title="Click to register or login"><img src="/acme/images/site/account.gif" alt="My Account Icon"><span>My Account</span></a>';
    }
    ?>

</div>

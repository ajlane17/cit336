<?php
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Image Management | ACME, Inc.</title>
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
                <h1>Image Management</h1>
                <p>Please select an option below.</p>

                <h2>Add New Product Image</h2>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form action="/acme/uploads/" method="post" enctype="multipart/form-data">
                    <label for="invId">Product</label><br>
                    <?php echo $prodSelect; ?><br><br>
                    <label>Upload Image:</label><br>
                    <input type="file" name="file1"><br>
                    <input type="submit" class="regbtn" value="Upload">
                    <input type="hidden" name="action" value="upload">
                </form>
                
                <hr>
                
                <h2>Existing Images</h2>
                <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
                <?php
                if (isset($imageDisplay)) {
                    echo $imageDisplay;
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
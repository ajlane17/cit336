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
        <h1>Welcome to ACME!</h1>
        <section id="feature">
          <img src="/acme/images/site/rocketfeature.jpg" alt="Acme rocket">
          <ul>
            <li><h2>Acme Rocket</h2></li>
            <li>Quick lighting fuse</li>
            <li>NHTSA approved seat belts</li>
            <li>Mobile launch stand included</li>
            <li><a href="/acme/cart/"><img id="actionbtn" alt="Add to cart button" src="/acme/images/site/iwantit.gif"></a></li>
          </ul>

        </section>
        <div id="valueadded">
          <section class="recipes">
          <h3>Featured Recipes</h3>
          <table>
            <tbody>
              <tr>
                <td><img src="/acme/images/recipes/bbqsand.jpg" alt="Picture of roadrunner bbq sandwich"></td>
                <td><img src="/acme/images/recipes/potpie.jpg" alt="Picture of roadrunner pot pie"></td>
              </tr>
              <tr>
                <td><a href="#">Pulled Roadrunner BBQ</a></td>
                <td><a href="#">Roadrunner Pot Pie</a></td>
              </tr>
              <tr>
                <td><img src="/acme/images/recipes/soup.jpg" alt="Picture of roadrunner soup"></td>
                <td><img src="/acme/images/recipes/taco.jpg" alt="Picture of roadrunner tacos"></td>
              </tr>
              <tr>
                <td><a href="#">Roadrunner Soup</a></td>
                <td><a href="#">Roadrunner Tacos</a></td>
              </tr>
            </tbody>
          </table>
          </section>

          <section class="reviews">
            <h3>ACME Rocket Reviews</h3>
            <ul>
              <li>"I don't know how I ever caught roadrunners before this." (4/5)</li>
              <li>"That thing was fast!" (4/5)</li>
              <li>"Talk about fast delivery." (5/5)</li>
              <li>"I didn't even have to pull the meat apart." (4.5/5)</li>
              <li>"I'm on my thirtieth one. I love these things!" (5/5)</li>
            </ul>
          </section>
        </div>
      </main>
      <footer id="page-footer">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        <br>
        Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
      </footer>
    </div>
  </body>

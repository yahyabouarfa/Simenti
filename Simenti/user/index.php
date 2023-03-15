<?php
session_start();
?>

 <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Simenti</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  </head>
  <body>
 

    <section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="men.php">Men</a></li>
                <li><a href="women.php">Women</a></li>
                <?php 
                  if (isset($_SESSION["id"])){ ?>
                <li><a href="../connexion/logout.php">Log Out</a></li>
                <?php }else{ ?>
                <li><a href="../connexion/login.php">Log In</a></li>
                <?php } ?>
                <li><a href="card.php"><i class="fa-solid fa-bag-shopping"></i></a></li>

            </ul>
        </div>
        </section>
        
    <section id="hero">
        <h2>Feel unstoppable </h2>
        <h1>With our products</h1>
        <p>Live how you feel</p>
    </section>
<section  id="banners" class=sp1>
    <div id="women" class="banner-box">
        <a href="women.php">Women</a>
    </div>
    <div id="men" class="banner-box">
        <a href="men.php" >Men</a>
    </div>
    </section>
    <?php include "../include/footer.php"; ?>

</body>
  </html>
<?php
session_start();
?>

 <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Terms and Conditions</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  </head>
  <style>
    .pli {
            font-size: 18px;
            color: white;
        }
        #terms{
            text-align:left;
            margin: 0 200px;
        }
  </style>
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
    <section id="terms">
  <h1>Terms and Conditions</h1>
  <p class="pli">Welcome to SIMENTI, an ecommerce store that sells perfumes. By using this website, you agree to the following terms and conditions. Please read them carefully before using the site.</p>
  <ul>
    <li class="pli"><strong style="color:gold">Product Descriptions and Availability</strong><br>
      We strive to provide accurate and up-to-date information about our products, including their descriptions, prices, and availability. However, we cannot guarantee that all information is completely accurate or up-to-date at all times. In the event that a product is not available after you have placed an order, we will notify you as soon as possible and offer you a refund or alternative product if available.</li>
    <li class="pli"><strong style="color:gold">Ordering and Payment</strong><br>
      To place an order, you must be over the age of 18 and have a valid payment method. By placing an order, you are making an offer to purchase the products listed in your order. We reserve the right to refuse or cancel any order for any reason. Payment must be made at the time of purchase, and all prices listed on our website are in US dollars.</li>
    <li class="pli"><strong style="color:gold" >Shipping and Delivery</strong><br>
      We offer shipping to most countries worldwide. Shipping times may vary depending on your location and the shipping method selected at checkout. We are not responsible for any customs or import duties that may be charged on international orders. Please see our Shipping page for more information.</li>
    <li class="pli"><strong style="color:gold">Returns and Refunds</strong><br>
      If you are not satisfied with your purchase, you may return it for a refund or exchange with;in 30 days of the date of purchase. The product must be unused and in its original packaging. Please see our Returns page for more information.</li>
    <li class="pli"><strong style="color:gold">Privacy Policy</strong><br>
      We value your privacy and will not share your personal information with any third parties. Please see our Privacy Policy page for more information.</li>
  </ul>
</section>

    <?php include "../include/footer.php"; ?>
</body>
  </html>
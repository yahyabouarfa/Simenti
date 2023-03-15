<?php
session_start();
?>

 <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  </head>
  <body>
<style>
    #about{
    height: 70vh;
    width: 100%;
    background-size: cover;
    padding: 0 80px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    text-align: right;
}
#u {
  text-align: center;
  font-size: 25px;
  color: white;
  margin: 40px 0;
}
</style>
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
        <section id="about">
        <h1>About Us</h1>
        <p id="u">At SIMENTI, we are passionate about providing our customers with the finest selection of perfumes for both men and women. Our goal is to help you find your signature scent, the one that makes you feel confident and unique. We believe that a fragrance is an extension of your personality, and that is why we have carefully curated a diverse range of perfumes to cater to everyone's tastes.

Our online store offers a seamless shopping experience, from browsing our extensive collection to placing your order. We understand that receiving your order promptly is essential, and that is why we offer shipping to your address. Moreover, we want our customers to be fully satisfied with their purchase, and that is why we have implemented a payment system where you only pay after you have received your order.

We pride ourselves on offering exceptional customer service, and our knowledgeable team is always ready to assist you with any questions or concerns you may have. Whether you are looking for a specific fragrance or need recommendations, we are here to help you.

Thank you for choosing SIMENTI, and we look forward to providing you with an unforgettable fragrance experience.</p>
</section>
        <?php include "../include/footer.php"; ?>

</body>
  </html>
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
  <style>
        .h {
            color: gold;
            font-size: 24px;
        }
        .pli {
            font-size: 18px;
            color: white;
        }
        #ol{
            text-align:left;
            margin: 0 200px;
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
        <h2 style="text-align:center;">Privacy Polity</h2>
        <section id="ol">
        <h2 class="h">Information We Collect</h2>
<p class="pli">We collect various types of information when you visit and use our website, including:</p>
<ul>
    <li class="pli">Your name, email address, and shipping address when you place an order.</li>
    <li class="pli">Your IP address, browser type, and device information when you visit our website.</li>
    <li class="pli">Your email address when you sign up for our newsletter.</li>
</ul>
<h2 class="h">How We Use Your Information</h2>
<p class="pli">We use the information we collect to:</p>
<ul>
    <li class="pli">Fulfill and ship your orders.</li>
    <li class="pli">Improve our website and personalize your experience.</li>
    <li class="pli">Send you marketing communications if you have opted in to receive them.</li>
</ul>
<h2 class="h">Sharing Your Information</h2>
<p class="pli">We do not sell, trade, or rent your personal information to third parties. We may share your information with:</p>
<ul>
    <li class="pli">Third-party service providers who help us operate our website or fulfill your orders.</li>
    <li class="pli">Law enforcement or other government officials in response to a subpoena or other legal request.</li>
</ul>
<h2 class="h">Security</h2>
<p class="pli">We take reasonable precautions to protect your personal information from unauthorized access, use, or disclosure. However, no data transmission over the internet or electronic storage system can be guaranteed to be 100% secure. If you have any concerns about the security of your information, please contact us.</p>
<h2 class="h">Changes to This Privacy Policy</h2>
<p class="pli">We reserve the right to update or change this Privacy Policy at any time. Any changes will be effective immediately upon posting on our website.</p>
<h2 class="h">Contact Us</h2>
<p class="pli">If you have any questions or concerns about our Privacy Policy, please contact us at privacy@simenti.com.</p>
</section>
        <?php include "../include/footer.php"; ?>
</body>
  </html>
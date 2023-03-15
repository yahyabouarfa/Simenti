<?php
    require("../config/commandes.php");
    $perfums = display();
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
    #menhero{
    background-image: url("../img/pexels-pixabay-22.jpg");
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
  </style>
<section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a  href="index.php">Home</a></li>
                <li><a class="active"href="men.php">Men</a></li>
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
    <section id="menhero">
        <h2>Add Some Spice</h2>
        <h1>To Your Style</h1>
        <p>Discover the best perfume for you</p>
    </section>
    <section id="product1" class="sp1">
    <?php foreach($perfums as $perfum):
    if ($perfum->Type == 'men'): ?>
        <a href="Sproduct.php?id=<?= $perfum->id ?>" class="pro-container">
            <div class="prod">
                <?php 
                    $imgData = base64_encode($perfum->img);
                    echo '<img src="data:image/jpeg;base64,'.$imgData.'" alt="">';
                ?>
                <div class="des">
                    <span id="marque"><?= $perfum->marque ?></span>
                    <h4 id="name"><?= $perfum->name ?></h4>
                    <h4 id="price"><?= $perfum->price ?>$</h4>
                </div>
            </div>
        </a>
    <?php endif; ?>
<?php endforeach; ?>
</section>
<?php include "../include/footer.php"; ?>
</body>
  </html>

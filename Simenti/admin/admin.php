<?php 
session_start();
if (intval($_SESSION['id']) !== 1) {
    header("location: ../connexion/login.php");
}

     require("../config/commandes.php");
     $perfums=display(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Products</title>
</head>
<body>
<section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a class="active" href="admin.php">Products</a></li>
                <li><a href="add.php">Add</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="../user/index.php">Log Out</a></li>

            </ul>
        </div>
        </section>
<section id="product1" class="sp1">
    <?php foreach($perfums as $perfum): ?>
        <a href="Aproduct.php?id=<?= $perfum->id ?>" class="pro-container">

            <div class="pro-container">
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
            </div>
    </a>
        <?php endforeach; ?>
        
    </section>
        
</body>
</html>
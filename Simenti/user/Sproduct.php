<?php
require("../config/commandes.php");
$id = $_GET['id'];
$product = displayone($id);
session_start();
?>
<?php
 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title><?php echo $product->name ?></title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  </head>
  <style>
      *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
        body {
  font-family: Arial, sans-serif;
  background-color: black;
  color: #333;
}

h1 {
  font-size: 2em;
  font-weight: bold;
  margin-bottom: 1em;
}
h2 {
  font-size: 1.5em;
  font-weight: bold;
  margin-bottom: 0.5em;
}

p {
  font-size: 1em;
  line-height: 1.5em;
  margin-bottom: 1em;
}

.logo {
    text-align: center;

  font-size: 2em;
  font-weight: bold;
  color: gold;
  text-transform: uppercase;
}

.product-co {
  display: flex;
  justify-content: space-between;
  margin-top: 2em;
}

.product-image {
  width: 40%;
  padding-left: 150px;
}

.product-image img {
  width: 100%;
  height: auto;
}

.product-info {
  width: 55%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.product-name {
  font-size: 2em;
  font-weight: bold;
  margin-bottom: 0.5em;
}

.product-brand {
  font-size: 1.5em;
  font-weight: bold;
  margin-bottom: 0.5em;
  color: #999;
}

.product-description {
  font-size: 20px;
  line-height: 1.5em;
  margin-bottom: 1em;
}

.product-price {

  font-size: 2em;
  font-weight: bold;
  margin-bottom: 1em;
}

.add-to-cart {
  background-color: gold;
  color: black;
  border: none;
  padding: 0.5em 1em;
  font-size: 1em;
  font-weight: bold;
  text-transform: uppercase;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.add-to-cart:hover {
  background-color: dark gold;
}
.product-type{
  color: gold;
}
</style>
  <body>
  <section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a  href="index.php">Home</a></li>
                <?php if($product->Type=="men"){?>
                <li><a class="active"href="men.php">Men</a></li>
                <li><a href="women.php">Women</a></li>
                <?php }else {?>
                  <li><a href="men.php">Men</a></li>
                <li><a class="active"href="women.php">Women</a></li>
                <?php }?>
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
    
      <form method="GET" class="product-co" action="addtocart.php">
        <div class="product-image">
          <?php 
            $imgData = base64_encode($product->img);
            echo '<img src="data:image/jpeg;base64,'.$imgData.'" alt="">';
          ?>
        </div>
        <div class="product-info">
          <div>
            <h1 class="product-name"><?php echo $product->name ?></h1>
            <h2 class="product-brand"><?php echo $product->marque ?></h2>
            <p class="product-description"><?php echo $product->description ?></p>
          </div>
          <h2 class="product-type"><?php echo $product->Type ?></h2>
          <div>
            <p class="product-price"><?php echo $product->price ?>$</p>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="1"  min="1" max="99"required >
            <br><br><br>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button class="add-to-cart">Add to cart</button>
            
          </div>
        </div>
                </form>
     
    <section id="banners" class=sp1>
      <div id="women" class="banner-box">
        <a href="women.php">Women</a>
      </div>
      <div id="men" class="banner-box">
        <a href="men.php">Men</a>
      </div>
    </section>
    <?php include "../include/footer.php"; ?>

</body>
  </html>
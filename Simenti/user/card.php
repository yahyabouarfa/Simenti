<?php
session_start(); // Start the session to store the user ID

require_once("../config/connexion.php");
require_once("../config/commandes.php");
$perfums=display();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
  header("Location: ../connexion/login.php");
  exit();
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

// Handle update quantity or remove item actions
if (isset($_POST['action'])) {
  switch ($_POST['action']) {;
    case 'remove_item':
      $cart_item_id = $_POST['cart_item_id'];
      $stmt = $access->prepare("DELETE FROM cartitems WHERE id = :id");
      $stmt->bindParam(':id', $cart_item_id);
      $stmt->execute();
      break;
  }
}

// Get the cart items for the user
$stmt = $access->prepare("SELECT cartitems.id, perfums.img,perfums.name, perfums.price, cartitems.quantity,perfums.Type FROM cartitems INNER JOIN perfums ON cartitems.perfumid = perfums.id WHERE cartitems.userid = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate the total price of the cart
$total_price = 0;
foreach ($cart_items as $cart_item) {
  $stmt = $access->prepare("SELECT price FROM perfums WHERE id = :perfum_id");
  $stmt->bindParam(':perfum_id', $cart_item['perfumid']);
  $stmt->execute();
  $price = $stmt->fetchColumn();
  $total_price += $price * $cart_item['quantity'];
}

?>
<style>
table {
  border-collapse: collapse;
  margin: 40px auto;
  background-color: black;
  
}

td {
  padding: 10px;
  text-align: left;
  color: white;

}

th {
    padding: 20px;
   text-align: left;
  background-color: black;
  color: gold;
}

td img {
  max-height: 100px;
}

input[type="submit"] {
  display: block;
  margin: 20px auto;
  background-color: gold;
  color: black;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #ffd700;
}
form input[type="number"] {
  margin-bottom: 15px;
  width: 20%;
  border-radius: 5px;
  border: none;
  background-color: #111;
  color: white;
  text-align: center;
}
 button[type="submit"] {
  padding: 10px 20px;
  background-color: gold;
  color: black;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
button[type="submit"]:hover{
  color: white;
}
.button-container {
  display: flex;
  justify-content: center;
}
</style>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>  
<section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a  href="index.php">Home</a></li>
                <li><a href="men.php">Men</a></li>
                <li><a href="women.php">Women</a></li>
                <?php if (isset($_SESSION["id"])){ ?>
                <li><a href="../connexion/logout.php">Log Out</a></li>
                <?php }else{ ?>
                <li><a href="../connexion/login.php">Log In</a></li>
                <?php } ?>
                <li><a class="active"href="card.php"><i class="fa-solid fa-bag-shopping"></i></a></li> 
            </ul>
        </div>
</section>
<h2 style="text-align:center;">Your Cart</h2>
<?php if (empty($cart_items)) {?>
    <p style="text-align:center;">Your cart is empty !!</p>
    <?php }else{?>

<!-- Display the cart items in a table -->
<table>
  <thead>
    <tr>
    <th>Picture</th>
      <th>Name</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total Price</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php  $total_price=0; ?>
    <?php foreach ($cart_items as $cart_item): ?>
      <tr>
      <td><img src="data:image/jpeg;base64,<?php echo base64_encode($cart_item['img']); ?>" /></td>
        <td><?php echo $cart_item['name']; ?></td>
        <td><?php echo $cart_item['price']; ?>$</td>
        <td><?php echo $cart_item['quantity']; ?></td>
        <td><?php echo $cart_item['price'] * $cart_item['quantity'] ?>$
        </td>
        <td>
          <form action="card.php" method="post">
          <input type="hidden" name="cart_item_id" value="<?php echo $cart_item['id']; ?>">
            <input type="hidden" name="action" value="remove_item">
            <button type="submit">Remove</button>
          </form>
        </td>
      </tr>
      <?php  $total_price+=$cart_item['price'] * $cart_item['quantity']; ?>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3">Total Price:</td><td></td>
      <td><?php echo $total_price; ?>$</td>
    </tr>
  </tfoot>
</table>
<!-- Display a button to submit the order -->
<form action="checkout.php" method="post">
<div class="button-container">
<input type="hidden" name="total" value="<?php echo $total_price; ?>">
  <button id="val" type="submit" >Checkout</button>
</div>
</form>
<form action="checkout.php" method="post">

<?php }?>

<?php include "../include/footer.php"; ?>
</body>
  </html>
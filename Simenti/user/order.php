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
$userid = $_SESSION['id'];
$date=$_POST['date'];
$payment=$_POST['payment'];

// Get the cart items for the user
$stmt = $access->prepare("SELECT orders.id, perfums.img, perfums.name, perfums.price, orders.quantity FROM orders INNER JOIN perfums ON orders.perfumid = perfums.id WHERE orders.userid = ? AND orders.date = ? AND orders.payment = ?");
$stmt->execute([$userid, $date, $payment]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate the total price of the cart
$total_price = 0;
foreach ($orders as $order) {
  $stmt = $access->prepare("SELECT price FROM perfums WHERE id = :perfum_id");
  $stmt->bindParam(':perfum_id', $order['perfumid']);
  $stmt->execute();
  $price = $stmt->fetchColumn();
  $total_price += $price * $order['quantity'];
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
    <title>Order</title>
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
<h2 style="text-align:center;">Your Order</h2>
<!-- Display the cart items in a table -->
<table>
  <thead>
    <tr>
      <th>Picture</th>
      <th>Name</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total Price</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($orders as $order): ?>
      <tr>
        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($order['img']); ?>" /></td>
        <td><?php echo $order['name']; ?></td>
        <td><?php echo $order['price']; ?>$</td>
        <td><?php echo $order['quantity']; ?></td>
        <td><?php echo $order['price'] * $order['quantity'] ?>$</td>
      </tr>
      <?php $total_price += $order['price'] * $order['quantity']; ?>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4">Total Price:</td>
      <td><?php echo $total_price; ?>$</td>
      <td></td>
    </tr>
  </tfoot>
</table>

<!-- Display a button to submit the order -->
<form action="checkout.php" method="post">
<div class="button-container">
<input type="hidden" name="total" value="<?php echo $total_price; ?>">
</div>
</form>
<form action="checkout.php" method="post">
<?php include "../include/footer.php"; ?>
</body>
  </html>
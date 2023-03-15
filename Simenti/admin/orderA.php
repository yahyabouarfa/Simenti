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
$userid = $_POST['userid'];
$date=$_POST['date'];
$payment=$_POST['payment'];

// Get the cart items for the user
$stmt = $access->prepare("SELECT  perfums.img, perfums.name, perfums.price, orders.quantity , users.name as username ,users.adress,users.mail,users.phone FROM perfums INNER JOIN orders ON orders.perfumid = perfums.id INNER JOIN users ON users.id=orders.userid WHERE orders.userid = ? AND orders.date = ? AND orders.payment = ?");
$stmt->execute([$userid, $date, $payment]);
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
    <title>Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>  
  <section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a  href="admin.php">Products</a></li>
                <li><a href="add.php">Add</a></li>
                <li><a class="active"href="orders.php">Orders</a></li>
                <li><a href="../user/index.php">Log Out</a></li>

            </ul>
        </div>
        </section>
<h2 style="text-align:center;">Order Details</h2>
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
    <?php foreach ($cart_items as $cart_item): ?>
      <tr>
        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($cart_item['img']); ?>" /></td>
        <td><?php echo $cart_item['name']; ?></td>
        <td><?php echo $cart_item['price']; ?>$</td>
        <td><?php echo $cart_item['quantity']; ?></td>
        <td><?php echo $cart_item['price'] * $cart_item['quantity'] ?>$</td>
      </tr>
      <?php $total_price += $cart_item['price'] * $cart_item['quantity']; ?>
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
<table>
  <tr>
    <th>Client</th>
    <td><?php echo $cart_items[0]['username']; ?></td>
  </tr>
  <tr>
    <th>Address</th>
    <td><?php echo $cart_items[0]['adress']; ?></td>
  </tr>
  <tr>
    <th>Email</th>
    <td><?php echo $cart_items[0]['mail']; ?></td>
  </tr>
  <tr>
    <th>Phone</th>
    <td><?php echo $cart_items[0]['phone']; ?></td>
  </tr>
  <tr>
    <th>Payment Status</th>
    <td><?php echo $payment; ?></td>
  </tr>
</table>
</body>
  </html>
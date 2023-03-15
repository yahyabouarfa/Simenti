<?php 
session_start();
$user_id = $_SESSION['id'];

require_once("../config/connexion.php");

try {
  $stmt = $access->prepare("SELECT orders.id, orders.payment, orders.date, perfums.price, orders.quantity FROM orders INNER JOIN perfums ON orders.perfumid = perfums.id WHERE orders.userid = ?");
  $stmt->execute([$user_id]);
  $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error retrieving orders: " . $e->getMessage();
}

// Group the orders by payment status and date
$grouped_orders = array_reduce($orders, function($result, $order) {
  $payment_status = $order['payment'];
  $date = date('Y-m-d', strtotime($order['date']));
  $result[$payment_status][$date]['total'] += $order['price'] * $order['quantity'];
  $result[$payment_status][$date]['orders'][] = $order;
  return $result;
}, []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width= , initial-scale=1.0">
  <title>Orders</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<style>
  table {
    border-collapse: collapse;
    margin: 40px auto;
    background-color: black;
  }
  td {
    padding: 5px; /* Change this value as desired */
    text-align: left;
    color: white;
    border: 1px solid white;
  }

  th {
    padding: 10px; /* Change this value as desired */
    text-align: left;
    background-color: black;
    color: gold;
    border: 1px solid white;
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
    border-radius: 4px;
    cursor: pointer;
  }

  button[type="submit"]:hover {
    background-color: #ffd700;
    color: white;
  }

</style>
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
<section id="orders">
  <h2 style="text-align: center;">My Orders</h2> 
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Payment Status</th>
        <th>Total</th>
        <th></th>
      </tr>
    </thead> 
    <tbody>
      <?php foreach ($grouped_orders as $payment_status => $dates): ?>
        <?php foreach ($dates as $date => $data): ?>
          <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $payment_status ?></td>
            <td>$<?php echo $data['total'] ?></td>
            <td>
              <form action="order.php" method="POST">
                <input type="hidden" name="date" value="<?php echo $date ?>">
                <input type="hidden" name="payment" value="<?php echo $payment_status ?>">
                <button type="submit">View Order</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      <?php endforeach ?>
    </tbody>
  </table>
</section>
<?php include "../include/footer.php"; ?>
</body>
</html>

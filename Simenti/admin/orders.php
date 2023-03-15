<?php  
session_start();
if (intval($_SESSION['id']) !== 1) {
    header("location: ../connexion/login.php");
}
    
require_once("../config/connexion.php");
    
try {
    $stmt = $access->prepare("SELECT orders.id, orders.payment, orders.date, perfums.price, orders.quantity, users.id as userid, users.name as username
                              FROM orders 
                              INNER JOIN perfums ON orders.perfumid = perfums.id 
                              INNER JOIN users ON orders.userid = users.id");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error retrieving orders: " . $e->getMessage();
}

// Group the orders by payment status, date, and user ID
$grouped_orders = array_reduce($orders, function($result, $order) {
    $payment_status = $order['payment'];
    $date = date('Y-m-d', strtotime($order['date']));
    $userid = $order['userid'];
    $result[$payment_status][$date][$userid]['total'] += $order['price'] * $order['quantity'];
    $result[$payment_status][$date][$userid]['orders'][] = $order;
    return $result;
}, []);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $orderid = $_POST['orderid'];

  try {
    $stmt = $access->prepare("DELETE FROM orders WHERE id = :orderid");
    $stmt->bindParam(':orderid', $orderid);
    $stmt->execute();
    header("location: orders.php");
    exit();
  } catch (PDOException $e) {
    echo "Error deleting order: " . $e->getMessage();
  }
}

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
                <li><a  href="admin.php">Products</a></li>
                <li><a href="add.php">Add</a></li>
                <li><a class="active"href="orders.php">Orders</a></li>
                <li><a href="../user/index.php">Log Out</a></li>

            </ul>
        </div>
        </section>
    <h2 style="text-align: center;">Orders</h2>
    <table>
  <thead>
    <tr>
      <th>Username</th>
      <th>Date</th>
      <th>Payment Status</th>
      <th>Total</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($grouped_orders as $payment_status => $dates): ?>
      <?php foreach ($dates as $date => $users): ?>
        <?php foreach ($users as $userid => $data): ?>
          <tr>
            <td><?php echo $data['orders'][0]['username'] ?></td>
            <td><?php echo $date ?></td>
            <td><?php echo $payment_status ?></td>
            <td>$<?php echo $data['total'] ?></td>
            <td>
              <form action="orderA.php" method="POST">
              <input type="hidden" name="userid" value="<?php echo $userid ?>">
              <input type="hidden" name="payment" value="<?php echo $payment_status ?>">
              <input type="hidden" name="date" value="<?php echo $date ?>">
              <button type="submit">View Order</button>
            </form>
            </td>
            <td> <!-- New column for delete button -->
            <form  method="POST">
              <input type="hidden" name="orderid" value="<?php echo $data['orders'][0]['id'] ?>">
              <button type="submit">Delete Order</button>
            </form>
          </td>
          </tr>
        <?php endforeach ?>
      <?php endforeach ?>
    <?php endforeach ?>
  </tbody>
</table>

</body>
</html>



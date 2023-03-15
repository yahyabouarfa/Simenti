<?php
session_start(); // Start the session to store the user ID

// Connect to the database using PDO
$host = "localhost"; // Your host name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "simenti"; // Your database name

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../connexion/login.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

// Get the product ID from the URL
$product_id = $_GET['id'];
// Get the product quantity from the URL
$product_quantity = $_GET['quantity'];

// Check if the product ID is valid
$product_query = $pdo->prepare("SELECT * FROM perfums WHERE id = :id");
$product_query->bindParam(':id', $product_id);
$product_query->execute();
if ($product_query->rowCount() == 0) {
  echo "Invalid product ID.";
  exit();
}

// If the user already has a cart, check if the product is in the cart
$cart_item_query = $pdo->prepare("SELECT * FROM cartitems WHERE userid = :user_id AND perfumid = :product_id");
$cart_item_query->bindParam(':user_id', $user_id);
$cart_item_query->bindParam(':product_id', $product_id);
$cart_item_query->execute();

if ($cart_item_query->rowCount() == 0) {
  // If the product is not in the cart, add it
  $cart_item_query = $pdo->prepare("INSERT INTO cartitems (userid, perfumid, quantity) VALUES (:user_id, :product_id, :quantity)");
  $cart_item_query->bindParam(':user_id', $user_id);
  $cart_item_query->bindParam(':product_id', $product_id);
  $cart_item_query->bindParam(':quantity', $product_quantity);
  $cart_item_query->execute();
} else {
  // If the product is already in the cart, update its quantity
  $cart_item = $cart_item_query->fetch();
  $cart_item_id = $cart_item['id'];
  $quantity = $cart_item['quantity'] + $product_quantity;
  $cart_item_query = $pdo->prepare("UPDATE cartitems SET quantity = :quantity WHERE id = :cart_item_id");
  $cart_item_query->bindParam(':quantity', $quantity);
  $cart_item_query->bindParam(':cart_item_id', $cart_item_id);
  $cart_item_query->execute();
}

// Redirect to the cart page
header("Location: card.php");
exit();
?>

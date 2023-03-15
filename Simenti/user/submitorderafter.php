<?php 
session_start();
$user_id = $_SESSION['id'];

require_once("../config/connexion.php");
try {
    
    // Move all items from the cart to the order
   $stmt = $access->prepare("INSERT INTO orders (userid, perfumid, quantity, payment) SELECT userid, perfumid, quantity, 'unpaid' FROM cartitems WHERE userid = ?");
   $stmt->execute([$user_id]);

    // Delete all items from the cart for the current user
    $stmt = $access->prepare("DELETE FROM cartitems WHERE userid = ?");
    $stmt->execute([$user_id]);

    // Commit the transaction
    $access->commit();

    echo "Order placed successfully!";
} catch (PDOException $e) {
    // Something went wrong, roll back the transaction and show an error message
    echo "Error placing order: " . $e->getMessage();
}
header("Location: myorders.php");
?>
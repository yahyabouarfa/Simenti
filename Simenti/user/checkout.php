<?php
    require("../config/connexion.php");
    session_start();
    $total=$_POST['total'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="https://www.paypal.com/sdk/js?client-id=AVnJKxDEL-GW5LPV-x8bt8cgnEjxmhry-nERxC8SFbr-1Z2yZNDwDnSCA0ehHawH9ZI5QbOpQFiRHtJ5"></script>
  </head>
<body>
<style>
  body {
  background-color: black;
  color: white;
  font-size: 18px;
  text-align: center;
}

.logo {
  color: gold;
}

form {
  margin: 50px auto;
  max-width: 500px;
}

form label {
  display: block;
  text-align: left;
  color: gold;
  margin-bottom: 10px;
}

p  {
  padding: 10px;
  margin-bottom: 15px;
  width: 100%;
  border-radius: 5px;
  border: none;
  background-color: #111;
  color: white;
}

form input[type="submit"] {
  padding: 10px 20px;
  background-color: gold;
  color: black;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

#error-msg {
  color: red;
}

#create-account {
  padding: 10px 20px;
  background-color: gold;
  color: black;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

#create-account:hover {
  color: white;
}
form input[type="submit"]:hover{
  color: white;
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
 <h2>Checkout</h2>
<form action="#" method="post">
<label for="fullname">Full Name</label>
<p id="fullname" class="input-field"><?php echo $_SESSION['name'] ?></p>

<label for="email">Email</label>
<p id="email" class="input-field"><?php echo $_SESSION['mail'] ?></p>

<label for="phone">Phone</label>
<p id="phone" class="input-field"><?php echo $_SESSION['phone'] ?></p>

<label for="address">Address</label>
<p id="address" class="input-field"><?php echo $_SESSION['adress'] ?></p>

<label for="price">Total :<?php echo $total ?>$</label>

    </form>
    <form action="submitorderafter.php" method="post">
<div class="button-container">
  <button id="val" type="submit" >Pay After Delivery</button>
</div>
</form>

    <div id="paypal-button-container"></div>

<script>
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '<?php echo $total ?>'
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            // Insert your code to handle a successful transaction here
            alert('Transaction completed by ' + details.payer.name.given_name + '!');
            window.location.href = 'submitorderbefore.php'; 
        });
    }
}).render('#paypal-button-container');
</script>
<?php include "../include/footer.php"; ?>   
</body>
</html>
   
   

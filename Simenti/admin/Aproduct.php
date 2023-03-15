<?php 
session_start();
if (intval($_SESSION['id']) !== 1) {
    header("location: ../connexion/login.php");
}

require("../config/commandes.php");

// Retrieve the 'id' from the query parameters
$id = $_GET['id'];

// Fetch the selected product from the database
$product = displayone($id);

// Check if the "delete" button was clicked
if (isset($_POST['delete'])) {
     // Connect to the database
     $conn = new mysqli('localhost', 'root', '', 'simenti');
  
     // Check connection
     if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
     }
   
     // Prepare SQL statement to delete the selected perfume
     $stmt = $conn->prepare("DELETE FROM perfums WHERE id=?");
   
     // Bind the parameter values to the statement
     $stmt->bind_param("i", $id);
   
     // Execute the statement
     $result = $stmt->execute();
   
     // Close the statement and database connection
     $stmt->close();
     $conn->close();
     header("Location: admin.php");
}
?>
<!-- Display the product information -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title><?php echo $product->name ?></title>
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
    <style>
         body {
  font-family: Arial, sans-serif;
  background-color: black;
  color: #333;
}

h1 {
  font-size: 30px;
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

.Edit , .Delete {
  text-decoration: none;
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

.Edit:hover , .Delete:hover {
  background-color: dark gold;
}
    </style>
   <header>
</header>
<main>
  <div class="product-co">
    <div class="product-image">
    <?php 
            $imgData = base64_encode($product->img);
            echo '<img src="data:image/jpeg;base64,'.$imgData.'" alt="">';
    ?>
    </div>
    <div class="product-info">
      <div>
        <h2 class="product-name"><?php echo $product->name ?></h2>
        <h3 class="product-brand"><?php echo $product->marque ?></h3>
        <p class="product-description"><?php echo $product->description ?></p>
      </div>
      <div>
        <p class="product-price"><?php echo $product->price ?>$</p>
        <form method="post" action="">
          <input type="hidden" name="id" value="<?php echo $id ?>">
          <button type="submit" name="delete" class="Delete">Delete</button>
          <a href="edit.php?id=<?php echo $id ?>" class="Edit">Edit</a>
        </form>
      </div>
    </div>
  </div>
</main>
  </body>
</html> 
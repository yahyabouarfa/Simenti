<?php 
session_start();
if (intval($_SESSION['id']) !== 1) {
    header("location: ../connexion/login.php");
}

require_once('../config/commandes.php');
// Retrieve the 'id' from the query parameters
$id = $_GET['id'];

// Fetch the selected perfume from the database
$perfume = displayone($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Edit <?php echo $perfume->name ?></title>
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
    h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        h2{
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;  
        }
        form {
            margin: 0 auto;
            max-width: 600px;
        }
        label {
            display: block;
            margin-bottom: 10px;
			color: gold;
        }
        input[type="text"],
        input[type="file"],input[type="number"],select,
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #222;
            color: white;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #f9a602;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #fbd65d;
        }
         .submit {
        background-color: gold;
        color: black;
        border: none;
        padding: 0.5em 1em;
        font-size: 1em;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
    }
.product-image {
  width: 25%;
}
.product-image img {
  width: 100%;
  height: auto;
}
#name{
    color: white;
}
</style>
<h2>Edit Perfume</h2>
<section class="prodd">
<!-- Display the perfume information -->
<form method="POST" enctype="multipart/form-data">
<label for="img">Image:</label>
<input type="file" name="img" id="img" accept="image/png, image/jpeg" onchange="document.getElementById('img-preview').src = window.URL.createObjectURL(this.files[0])" required>

    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $perfume->name ?>"required >

    <label for="marque">Brand:</label>
    <input type="text" name="marque" id="marque" value="<?php echo $perfume->marque ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" ><?php echo $perfume->description ?></textarea required>

    <label for="price">Price:</label>
    <input type="number" name="price" id="price" value="<?php echo $perfume->price ?>"required >

    <label for="Type">Type:</label>
    <select id="Type" name="Type" required>
            <option value="men">Men</option>
            <option value="women">Women</option>
        </select><br><br>
        <?php
// Check if the "save" button was clicked
if (isset($_POST['save'])) {
    // Retrieve the form data
    $name = $_POST['name'];
    $marque = $_POST['marque'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $Type = $_POST['Type'];
    $img = file_get_contents($_FILES['img']['tmp_name']);

    $sql = "UPDATE perfums SET name=?, marque=?, description=?, price=?, Type=?, img=? WHERE id=?";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "simenti";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("ssssssi", $name, $marque, $description, $price, $Type, $img, $id);

    // Execute the query
    $result = $stmt->execute();

    // Check if the query was successful
    if ($result) {
        // Display a success message
        echo '<p>Perfume updated successfully!</p>';

        // Redirect to the perfume display page
        header("Location: Aproduct.php?id=$id");
        exit();
    } else {
        // Display an error message
        echo '<p>Error updating perfume. Please try again.</p>';
    }

}
?>

<button type="submit" name="save" class="submit">Save Changes</button>
</section>
</form>
</body>
</html>

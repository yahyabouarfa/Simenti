<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Upload Perfume</title>
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
        
    </style>
</head>
<body>
 <section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a  href="admin.php">Products</a></li>
                <li><a class="active"href="add.php">Add</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="../user/index.php">Log Out</a></li>

            </ul>
        </div>
        </section>
<h2>Upload Perfume</h2>
    <form method="post" enctype="multipart/form-data">
		 <label for="img">Image:</label>
        <input type="file" id="img" name="img" accept="image/*" required><br><br>
       
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="marque">Brand:</label>
        <input type="text" id="marque" name="marque" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <label for="Type">Type:</label>
        <select id="Type" name="Type" required>
            <option value="men">Men</option>
            <option value="women">Women</option>
        </select><br><br>

        <?php 
session_start();
if (intval($_SESSION['id']) !== 1) {
    header("location: ../connexion/login.php");
}

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $host = 'localhost';
            $db = 'simenti';
            $user = 'root';
            $password = '';

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Error connecting to database: ' . $e->getMessage();
                exit();
            }

            $name = $_POST['name'];
            $marque = $_POST['marque'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $Type = $_POST['Type'];
            $img = file_get_contents($_FILES['img']['tmp_name']);

            $stmt = $pdo->prepare("INSERT INTO perfums (img,name, marque, description, price, Type) VALUES (:img, :name, :marque, :description, :price, :Type)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':marque', $marque);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':Type', $Type);
            $stmt->bindParam(':img', $img, PDO::PARAM_LOB);
            $stmt->execute();
            echo '<p style= text-align: center;>Perfume uploaded successfully!</p>';
            header("Location: admin.php");
        }
    ?>
        <input type="Submit" value="Upload">
    </form>

</body>
</html>

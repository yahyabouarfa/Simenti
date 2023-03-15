<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <title>Sign Up</title>
<style>
  *{
  margin: 0;
  padding: 0;
 box-sizing: border-box;
 font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
body {
  background-color: black;
  color: white;
  font-size: 18px;
  text-align:center;
}
#logo{
    color: gold;
}
form {
  margin: 50px auto;
  max-width: 500px;
}

label {
  display: block;
  text-align: left;
  color: gold;
  margin-bottom: 10px;
}
input[type="text"],
input[type="email"],
input[type="password"],
form textarea {
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
form input[type="submit"]:hover{
  color: white;
}
</style>
</head>
<body>
<section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a  href="../user/index.php">Home</a></li>
                <li><a href="../user/men.php">Men</a></li>
                <li><a href="../user/women.php">Women</a></li>
                <li><a class="active" href="login.php">Login</a></li>
                <li><a href="../user/card.php"><i class="fa-solid fa-bag-shopping"></i></a></li>

            </ul>
        </div>
    </section>
    <h2>Sign Up</h2>
    <br><br>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <label>Phone Number:</label><br>
        <input type="text" name="phone" required><br>
        <label>Address:</label><br>
        <input type="text" name="adress" required><br>
        <input type="submit" name="submit" value="Sign Up">
    <?php
    // Check if the form was submitted
    if (isset($_POST['submit'])) {
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "simenti";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the user's entered information
        $name = $_POST['username'];
        $mail = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $adress = $_POST['adress'];

        $sql = "SELECT * FROM users WHERE mail=? OR phone=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $mail, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<p style= color:red;>Email or phone number already exists!</p>";
        } 
        else {
        $sql = "INSERT INTO users (name, password_hash, mail, phone, adress) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $password,$mail,  $phone, $adress);

        // Execute the SQL statement
        if ($stmt->execute() === TRUE) {
            echo "<p>Account created successfully!</p>";
            header("Location: login.php");
        } else {
            echo "<p>Error creating account: " . $conn->error . "</p>";
        }

        // Close the database connection
        $conn->close();
         }
        }
    ?>
    </form>
    <?php include "../include/footer.php"; ?>
</body>
</html>

<?php
session_start();
require_once("../config/connexion.php");

if (!isset($_SESSION["id"])){
    header("Location: login.php");
} else {
    $error='';
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = validate($_POST['password']);
        $email = validate($_POST['email']); // Fix: Change the variable name from $mail to $email
        $query="SELECT * FROM users where mail=:mail ";
        $stmt = $access->prepare($query);
        $stmt->execute(['mail' => $email]);

        if($stmt->rowCount() === 1){
            $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
            if($row[0]['mail'] === $email && password_verify($password, $row[0]['password_hash'])){
                $name = validate($_POST['fullname']);
                $phone = validate($_POST['phone']);
                $address = validate($_POST['address']); // Fix: Change the variable name from $adress to $address
                $stmt = $access->prepare("UPDATE users SET name=?,phone=?,mail=?, adress=? WHERE id=?");
                $stmt->execute([$name, $phone, $email, $address, $_SESSION['id']]);
                // update the session variables
                $_SESSION['name'] = $name;
                $_SESSION['phone'] = $phone;
                $_SESSION['mail'] = $email;
                $_SESSION['adress'] = $address; // Fix: Change the session variable name from 'adress' to 'address'
                $message = "Your information has been updated successfully.";
                header("location: ../user/index.php");
            } else {
                $error = "Incorrect password. Please try again.";
                header("location: ../account.php?error=" . urlencode($error)); // Fix: Pass error message as a URL parameter
            }
        }
    }
}
?>


 <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Simenti</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

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

form input[type="email"],
form input[type="text"],
form input[type="tel"] ,
form input[type="password"]  {
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
#error-msg {
  color: red;
}
</style>
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
        <h2>Account</h2>
    <form action="account.php" method="POST">
      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" value="<?php echo $_SESSION['name'] ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo $_SESSION['mail'] ?>"required>

      <label for="phone">Phone</label>
      <input type="tel" id="phone" name="phone" value="<?php echo $_SESSION['phone'] ?>"required>

      <label for="address">Address</label>
      <input type="text"id="address" name="address" value="<?php echo $_SESSION['adress'] ?>"required></input>
     
      <label>Password:</label>
     <input type="password" name="password"  required>
     <p id="error-msg"><?php echo $error ?></p>
      <input type="submit" value="Submit">
    </form>
        <?php include "../include/footer.php"; ?>

</body>
  </html>
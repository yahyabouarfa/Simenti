<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
  </head>
<body>

<section id="header">
        <h1 class="logo">SIMENTI</h1>
        <div>
            <ul id="navbar">
                <li><a  href="../user/index.php">Home</a></li>
                <li><a href="../user/men.php">Men</a></li>
                <li><a href="../user/women.php">Women</a></li>
                <li><a class="active"href="login.php">Log In</a></li>
                <li><a href="../user/card.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
            </ul>
        </div>
    </section>
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
form input[type="password"] {
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
</style>
<h2>Log In</h2>
<!-- INCLUDING NECESSARY FILES  -->
<?php 
  session_start();
  include '../config/connexion.php';
	?>
	  <title>LOGIN</title>
<!-- CHECK IF ALREADY LOGGED IN -->

<?php 
  if(isset($_SESSION['id'])){
    header('location: logout.php');
 }
?>

<!-- LOGIN LOGIC -->
<?php 
  $error='';
if(isset($_POST['submit'])){
  if(isset($_POST['email']) && isset($_POST['password'])){
    function validate($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  }

  $email = validate($_POST['email']);
  $password = validate($_POST['password']);

  $query="SELECT * FROM users where mail=:email limit 1";
  
  $stmt = $access->prepare($query);

  $stmt->execute(['email' => $email]);
  if($stmt->rowCount() === 1){

    $row=$stmt->fetchALL(PDO::FETCH_ASSOC);
    if($row[0]['mail'] === $email && password_verify($password, $row[0]['password_hash'])){
      if($row[0]['id']==1){
        $_SESSION['id']=$row[0]['id'];
        header("Location: ../admin/admin.php");
      }
      else{ 
      $_SESSION['id']=$row[0]['id'];
      $_SESSION['name']=$row[0]['name'];
      $_SESSION['phone']=$row[0]['phone'];
      $_SESSION['adress']=$row[0]['adress'];
      $_SESSION['mail']=$row[0]['mail'];
      header("Location: ../user/index.php");
    }
     
    }
    else{
      $error = "Email or password incorrect!!";
    }
  }
  else{
     $error = "Email or password incorrect!!";
  }
}
?>
<form  method="POST" action="">
  <label>Email:</label><br>
  <input type="email" name="email" required><br>
  <label>Password:</label><br>
  <input type="password" name="password"  required><br>
   <p id="error-msg"><?php echo $error ?></p>
<input type="submit" name="submit" value="Login">
</form>
<input type="button" id="create-account" value="Create account" onclick="window.location.href='createuser.php'" />
<?php include "../include/footer.php"; ?>   
</body>
</html>
   
   

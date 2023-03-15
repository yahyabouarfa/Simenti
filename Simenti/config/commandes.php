<?php
function display(){
    if(require("connexion.php")){
        $req=$access->prepare("SELECT * FROM perfums ORDER BY id DESC ");
        $req->execute();
        $data=$req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();   
    }
}
function displayone($id){
    if(require("connexion.php")){
        $req=$access->prepare("SELECT * FROM perfums WHERE id=$id ");
        $req->execute();
        $data=$req->fetch(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();   
    }
}
function update_perfum($id, $img, $name, $marque, $description, $price) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "simenti";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Prepare the SQL query with placeholders for bind parameters
    $sql = "UPDATE perfums SET name=$name, marque=$name, description=$description, price=$price WHERE id=$id";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters to the placeholders
    mysqli_stmt_bind_param($stmt, "bssssi", $name, $marque, $description, $price, $id);
    
    // Execute the query
    $result = mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    return $result;
}


?>

 <?php
 try {
    $access=new pdo("mysql:host=localhost;dbname=simenti;charset=utf8","root","");

    $access->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
     } catch (Exception $th) {
    $th->getMessage();
    }


 ?>
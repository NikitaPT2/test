<?php

require("config.php");
session_start();
if(isset($_SESSION['admin_name'])){

if(isset($_POST['add'])){

   $Nosaukums_kategorija = mysqli_real_escape_string($conn, $_POST['Nosaukums_kategorija']);

   $select = " SELECT * FROM kategorija WHERE Nosaukums_kategorija = '$Nosaukums_kategorija' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'Tāda kategotija jau ir';

   }else{
        mysqli_query($conn,"insert into `kategorija` (Nosaukums_kategorija) 
        values ('$Nosaukums_kategorija')");
    header('location:category.php');
      
   }
};


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoriju administrēšana</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="statistics.php">Statistika/Profils</a>
            <a href="all_products.php">Preces</a>
            <a href="all_masters.php" >Pārdevēji</a>
            <a href="category.php"  class="active">Kategorijas / Reģistrācija</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <div class="form-container">
        <form action="" method="post">
            <h3>Reģistrācija</h3>
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
            ?>
            <input type="text" name="Nosaukums_kategorija" required placeholder="Kategorija">
            <input type="submit" name="add" value="Reģistrēt" class="form-btn">
            <input type="button" onclick="history.back();" value="Atpakaļ" class="form-btn ">
        </form>


    <footer>
        Kiriyena © 2023 Small start = Big deal</br>
        Designed by Kiriyena
    </footer>
<?php
   }
?>
</body>
</html>
<?php

require("config.php");
session_start();
$Administrators_ID = $_GET['Administrators_ID'];
$E_pasts = $_GET['E_pasts'];
$T_numurs = $_GET['T_numurs'];
if(isset($_SESSION['admin_name'])){

    if(isset($_POST['update'])){
    
        $new_E_pasts = mysqli_real_escape_string($conn, $_POST['E_pasts']);
        $new_T_numurs = mysqli_real_escape_string($conn, $_POST['T_numurs']);
    
        // Проверяем, есть ли уже другой пользователь с таким же email
        $check_query = "SELECT * FROM administrators WHERE E_pasts = '".$new_E_pasts."' AND Administrators_ID != '".$Administrators_ID."'";
        $check_result = mysqli_query($conn, $check_query);
        if(mysqli_num_rows($check_result) > 0){
            // Если есть, выводим сообщение об ошибке
            $error[] = 'Пользователь с таким email уже существует';
        } else {
            // Иначе, обновляем запись в базе данных
            mysqli_query($conn, "UPDATE `administrators` SET `E_pasts`='".$new_E_pasts."', `T_numurs`='".$new_T_numurs."' WHERE `Administrators_ID`='".$Administrators_ID."'");
            header("location: statistics.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilu administrēšana</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="statistics.php" class="active">Statistika/Profils</a>
            <a href="all_products.php">Preces</a>
            <a href="all_masters.php" >Pārdevēji</a>
            <a href="category.php" >Kategorijas</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <div class="form-container">
        <form action="" method="post">
            <h3>Rediģēt</h3>
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
            ?>
            <input type="E_pasts" name="E_pasts" required  value="<?php echo $E_pasts ?>">
            <input type="tel" name="T_numurs" required value="<?php echo ($T_numurs && $T_numurs[0] === '+') ? $T_numurs : '+371'; ?>">
            <input type="submit" name="update" value="Reģistrēt" class="form-btn">
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
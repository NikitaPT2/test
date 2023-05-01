<?php

require("../admin/config.php");
session_start();
$Pardevejs_ID = $_GET['Pardevejs_ID'];
$E_pasts_pardevejs = $_GET['E_pasts_pardevejs'];
$T_numurs_pardevejs = $_GET['T_numurs_pardevejs'];
if (isset($_SESSION['user_name'])) {

    if (isset($_POST['update'])) {

        $new_E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
        $new_T_numurs_pardevejs = mysqli_real_escape_string($conn, $_POST['T_numurs_pardevejs']);

        // Проверяем, есть ли уже другой пользователь с таким же email
        $check_query = "SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '" . $new_E_pasts_pardevejs . "' AND Pardevejs_ID != '" . $Pardevejs_ID . "'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            // Если есть, выводим сообщение об ошибке
            $error[] = 'Пользователь с таким email уже существует';
        } else {
            // Иначе, обновляем запись в базе данных
            mysqli_query($conn, "UPDATE `pardevejs` SET `E_pasts_pardevejs`='" . $new_E_pasts_pardevejs . "', `T_numurs_pardevejs`='" . $new_T_numurs_pardevejs . "' WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'");
            header("location:about_me.php");
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
        <link rel="stylesheet" href="css/cssForMaster.css">
        <link rel="stylesheet" href="../assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="about_me.php" class="active">Statistika/Profils</a>
                <a href="my_products.php">Preces </a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">
            <form action="" method="post">
                <h3>Rediģēt</h3>
                <?php
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                    ;
                }
                ;
                ?>
                <input type="East_ps" name="E_pasts_pardevejs" required value="<?php echo $E_pasts_pardevejs ?>">
                <input type="tel" name="T_numurs_pardevejs" required
                    value="<?php echo ($T_numurs_pardevejs && $T_numurs_pardevejs[0] === '+') ? $T_numurs_pardevejs : '+371'; ?>">

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
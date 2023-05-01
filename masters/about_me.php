<?php
require("../admin/config.php");
session_start();
if (isset($_SESSION['user_name'])) {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Statistika un profilu administrēšana</title>
        <link rel="stylesheet" href="css/cssForMaster.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="about_me.php" class="active">Statistika/Profils</a>
                <a href="my_products.php">Preces</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <section id="description">
            <h1>Profils
            </h1>
            <div class="box-container">
                <?php
                $lietotajsSQL = "SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '" . $_SESSION['user_name'] . "'";
                $atlasa_lietotajs = mysqli_query($conn, $lietotajsSQL) or die("Nekorekts vaicājums");

                if (mysqli_num_rows($atlasa_lietotajs) > 0) {
                    while ($row = mysqli_fetch_assoc($atlasa_lietotajs)) {
                        $T_numurs_pardevejs = $row['T_numurs_pardevejs']; // сохраняем значение T_numurs в отдельной переменной
                        $Pardevejs_ID = $row['Pardevejs_ID']; // сохраняем значение Administrators_ID в отдельной переменной
                        echo "
                            <div class='box'>
                            <img src='{$row['Attela_URL']}'>
                            <h3>{$row['Brenda_nosaukums']}</h3>
                            <p><b>Vārds: </b>{$row['Vards_pardevejs']}</p>
                            <p><b>Uzvārds: </b>{$row['Uzvards_pardevejs']}</p>
                            <p><b>E-pasts: </b>{$row['E_pasts_pardevejs']}</p>
                            <p><b>Telefona numurs: </b>{$row['T_numurs_pardevejs']}</p>
                            <p><b>Loma: </b>{$row['Loma']}</p>
                            <p><b>Apraksts: </b>{$row['Apraksts']}</p>   
                            <a class='btn2' title='Rediģēt' href='edit_my_prof.php?Pardevejs_ID={$Pardevejs_ID}&E_pasts_pardevejs={$_SESSION['user_name']}&T_numurs_pardevejs={$T_numurs_pardevejs}'><i class='far fa-edit' aria-hidden='true'></i></a>
                            </div>
                            
                        ";
                    }
                } else {
                    echo "Tabula nav datu ko attēlot";
                    header("location:../admin/confirmation.php");
                }
                ?>
            </div>
        </section>

        <?php
        $sql = "SELECT COUNT(prece.prece_ID) AS total,
        pardevejs.Pardevejs_ID, pardevejs.E_pasts_pardevejs
        FROM prece
        JOIN pardevejs
        ON Pardevejs_ID = prece.ID_Pardevejs
        WHERE pardevejs.E_pasts_pardevejs = '" . $_SESSION['user_name'] . "'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        ?>

        <?php
        $sql2 = "SELECT * FROM administrators";
        $result = mysqli_query($conn, $sql2);
        $data2 = mysqli_fetch_assoc($result);
        $phone_number = $data2['E_pasts'];
        ?>

        <section id="statistics">
            <div class="icons-container">
                <div class="icons">
                    <h1> Statistika</h1>
                    <i class="fa-solid fa-people-group" style="font-size:31px"></i>
                    <h3>
                        <?php echo $data['total'] ?>
                    </h3>
                    <p style="font-size:18px">Preces</p>
                </div>

                <div class="icons">
                    <h1> Administrātors</h1>
                    <i class="fa-solid fa-id-card-clip"></i></i>
                    <h3>
                        <?php echo $data2['E_pasts'] ?>
                    </h3>
                    <p style="font-size:18px">E-pasts</p>
                    <a class='btn2' href="https://mail.google.com/mail/?view=cm&to=<?php echo $data2['E_pasts']; ?>">Atvērt e-pastu</a>
                    
                </div>
            </div>


        </section>

        <footer>
            Kiriyena © 2023 Small start = Big deal</br>
            Designed by Kiriyena
        </footer>
        <?php
}
?>
</body>

</html>
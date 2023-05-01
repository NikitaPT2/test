<?php
    require("config.php");
    session_start();
    if(isset($_SESSION['admin_name'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pārdevēja administrācija</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="statistics.php">Statistika/Profils</a>
            <a href="all_products.php">Preces</a>
            <a href="all_masters.php"  class="active">Pārdevēji / Apraksts</a>
            <a href="category.php">Kategorijas</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <section id="description">
        <h1>Detalizēts pārdevēja apraksts
        </h1>
        <div class="box-container">
            <div class='box'>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    require("config.php"); 
                    $Pardevejs_ID = $_POST['Apskatīt'];
                    $pardevejsSQL = "SELECT * FROM pardevejs
                    WHERE Pardevejs_ID = $Pardevejs_ID"; 
                    $atlasa = mysqli_query($conn, $pardevejsSQL) or die ("Nekorekts vaicājums");

                    $sql ="SELECT pardevejs.Pardevejs_ID, COUNT(prece.Prece_ID) as skaits
                    FROM pardevejs
                    LEFT JOIN prece ON pardevejs.Pardevejs_ID = prece.ID_Pardevejs
                    WHERE Pardevejs_ID = $Pardevejs_ID";

                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_assoc($result);
                        while($row = mysqli_fetch_assoc($atlasa)){
                                echo "       
                                    <img src='{$row['Attela_URL']}'>   
                                    <h3>{$row['Brenda_nosaukums']}</h3>                 
                                    <p><b>Vārds: </b>{$row['Vards_pardevejs']}</p>
                                    <p><b>Uzvārds: </b>{$row['Uzvards_pardevejs']}</p>
                                    <p><b>E-pasts: </b>{$row['E_pasts_pardevejs']}</p>
                                    <p><b>Telefona numurs: </b>{$row['T_numurs_pardevejs']}</p>
                                    <p><b>Preču skaits: </b>{$data['skaits']}</p>
                                    <p><b>Loma: </b>{$row['Loma']}</p>
                                    <p><b>Apraksts: </b>{$row['Apraksts']}</p>
                                    <p><b>Izveidošanas datums: </b>{$row['Izveidosanas_datums']}</p>
                                ";
                            }
                        }else{
                            echo "Tabula nav datu ko attēlot";
                        }                         
                ?>
                <input type="button" onclick="history.back();" value="Atpakaļ" class="btn ">
            </div>                           
        </div>
    </section>

    <?php 
      
    ?>

    <footer>
        Kiriyena © 2023 Small start = Big deal</br>
        Designed by Kiriyena
    </footer>
<?php
   }
?>
</body>
</html>
<?php
    require("../admin/config.php");
    session_start();
    if(isset($_SESSION['user_name'])){
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preču administrācija</title>
    <link rel="stylesheet" href="css/cssForMaster.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="about_me.php" >Statistika/Profils</a>
            <a href="my_product_details.php" class="active">Preces</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <section id="description">
        <h1>Detalizēts preču apraksts</h1>
        <div class="box-container">
            <div class='box'>
                <?php 
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        require("../admin/config.php"); 
                        $prece_ID = $_POST['Apskatīt'];
                        $par_preceSQL = "SELECT prece.prece_ID, prece.Nosaukums_prece, prece.Cena, prece.Statuss, prece.Apraksts_prece, prece.Attela_prece, prece.Ipatnibas_prece, 
                        kategorija.Nosaukums_kategorija, 
                        k_apakssadala.Nosaukums_sadala,
                        pardevejs.Brenda_nosaukums
                        FROM prece
                        JOIN kategorija
                        ON Kategorija_ID = prece.ID_Kategorija
                        LEFT JOIN k_apakssadala
                        ON Kapakssadala_ID = prece.IDKapakssadala
                        LEFT JOIN pardevejs
                        ON Pardevejs_ID = prece.ID_Pardevejs
                        WHERE prece_ID=$prece_ID && pardevejs.E_pasts_pardevejs = '".$_SESSION['user_name']."'"; 
                        $atlasa_apraksts = mysqli_query($conn, $par_preceSQL) or die ("Nekorekts vaicājums");
                        while($row = mysqli_fetch_assoc($atlasa_apraksts)){
                            $Nosaukums_prece = $row['Nosaukums_prece']; 
                            $Cena = $row['Cena']; 
                            $Statuss = $row['Statuss']; 
                            $Apraksts_prece = $row['Apraksts_prece']; 
                            $Ipatnibas_prece = $row['Ipatnibas_prece']; 
                            $Nosaukums_kategorija = $row['Nosaukums_kategorija']; 
                            $Nosaukums_sadala = $row['Nosaukums_sadala']; 
    
                            echo "
                                        <img src='{$row['Attela_prece']}'>
                                        <h3>{$row['Nosaukums_prece']}</h3>
                                        <p><b>Cena: </b>{$row['Cena']}€</p>
                                        <p><b>Statuss: </b>{$row['Statuss']}</p>
                                        <p><b>Apraksts: </b>{$row['Apraksts_prece']}</p>
                                        <p><b>Īpatnības: </b>{$row['Ipatnibas_prece']}</p>
                                        <p><b>Kategorija: </b>{$row['Nosaukums_kategorija']}</p>
                                        <p><b>Kategoriju apakšsadaļa: </b>{$row['Nosaukums_sadala']}</p>
                                        <a class='btn' title='Atpaķaļ' href='my_products.php'><i class='fa-solid fa-angles-left' aria-hidden='true'></i></a>
                                        <a class='btn' title='Rediģēt' href='edit_my_prod.php?prece_ID={$prece_ID}&Nosaukums_prece={$Nosaukums_prece}&Cena={$Cena}
                                        &Statuss={$Statuss}&Cena={$Cena}&Apraksts_prece={$Apraksts_prece}&Ipatnibas_prece={$Ipatnibas_prece}
                                        &Nosaukums_kategorija={$row['Nosaukums_kategorija']}&Nosaukums_sadala={$row['Nosaukums_sadala']}
                                        '><i class='far fa-edit' aria-hidden='true'></i></a>            
                                ";  
                                
                        }
                    }else{
                        echo "Tabula nav datu ko attēlot";
                    }
                ?> 
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
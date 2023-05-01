<?php
    require("config.php"); // Ievietoju failu ar konfigurācijas informāciju, kas palīdz savienoties ar datu bāzi
    session_start();  // Sākam PHP sesiju, lai atzīmētu lietotāju, kas ir pieteicies
    // Ja administrātora vārds ir definēts sesijā, lietotājs ir autorizējies
    if(isset($_SESSION['admin_name'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Iestatām metadatus, lai pārlūkprogrammas varētu pareizi interpretēt lapu -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Iestatām lapas virsrakstu -->
    <title>Statistika un profilu administrēšana</title>
    <!-- Pievienojam CSS failu, lai stilizētu lapu -->
    <link rel="stylesheet" href="css/css.css">
    <!-- Pievienojam Font Awesome bibliotēkas ikonas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Iestatām lapas faviconu -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <!-- Attēlojam lapas nosaukumu / LOGO -->
        <a class="logo">Administrēšanas panelis</a>
        <!-- Attēlojam navigācijas joslu ar saitēm uz citām lapām -->
        <nav class="navbar">
            <a href="#" class="active">Statistika/Profils</a>
            <a href="all_products.php">Preces</a>
            <a href="all_masters.php" >Pārdevēji</a>
            <a href="category.php">Kategorijas</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <section id="description">
        <h1>Profils
        </h1>
        <div class="box-container">
            <?php
                $adminSQL = "SELECT * FROM administrators WHERE E_pasts = '".$_SESSION['admin_name']."'";   //Šajā rindiņā tiek izveidots SQL vaicājums, lai atgūtu datus par administratoru, kurš ir pieslēdzies ar savu e-pastu.
                $output = mysqli_query($conn, $adminSQL)  or die ("Nekorekts vaicājums");                   /*Šajā rindiņā tiek izpildīts SQL vaicājums, un atgrieztie dati tiek saglabāti mainīgajā $output. Ja vaicājums nav veiksmīgs, 
                                                                                                            tiek izvadīts kļūdas paziņojums un izpildīšana tiek pārtraukta. */
                                            
                if(mysqli_num_rows($output) >0){                                                            /*Šajā rindiņā tiek pārbaudīts, vai vaicājums atgriež kādus datus. 
                                                                                                            Ja tā ir, tad tiek sākta while cikla izpilde, lai izvadītu katru atgriezto rindu.*/
                    while($row = mysqli_fetch_assoc($output)){                                              /*Šī ir while cikla izpilde, lai izvadītu katru atgriezto rindu. 
                                                                                                            Katrā iterācijā tiks saglabāti datus, kas atgriezti katrā rindā, un tiks izvadīta informācija par administratoru.*/
                        $t_numurs = $row['T_numurs'];                                                       //Šeit no datubāzes iegūstam administratora telefona numuru, lai to izmantotu turpmāk.
                        $Administrators_ID = $row['Administrators_ID'];                                     //Šeit no datubāzes iegūstam administratora ID, lai to izmantotu turpmāk.
                        /*Šeit tiek izvadīts HTML kods uz ekrāna, izmantojot echo funkciju. Iekšā ir daudz iekavu, lai varētu veidot tekstu, kurā iekļaut mainīgos, 
                        piemēram, $row['Vards'], kas tiek aizstāts ar faktisku administratora vārdu no datubāzes.*/
                        /*class='btn2.. - Šajā rindiņā tiek izveidots saiti uz "edit_profile.php" lapu, kas ļauj administrātoram rediģēt savu profilu. 
                        Saitē tiek padoti trīs parametri: Administrators_ID, E_pasts un T_numurs. */
                        echo "                                                                               
                            <div class='box'>
                            <img src='{$row['Attela_admin']}'>
                            <p><b>Vārds: </b>{$row['Vards']}</p>
                            <p><b>Uzvārds: </b>{$row['Uzvards']}</p>
                            <p><b>E-pasts: </b>{$row['E_pasts']}</p>
                            <p><b>Telefona numurs: </b>{$t_numurs}</p>
                            <p><b>Loma: </b>{$row['Loma']}</p>
                            <a class='btn2' title='Rediģēt' href='edit_profile.php?Administrators_ID={$Administrators_ID}&
                            E_pasts={$_SESSION['admin_name']}&T_numurs={$t_numurs}'><i class='far fa-edit' aria-hidden='true'></i></a>  
                            </div>
                                          
                        ";
                    }
                }else{                                                                                        //Ja vaicājums neiegūst nevienu rindu, tiks izvadīts kļūdas paziņojums, un lapas pāradresācija tiks veikta uz apstiprinājuma lapu.
                    echo "Tabula nav datu ko attēlot";
                    header("location: confirmation.php");
                }
            ?>  
                 
        </div>
    </section>

    <?php
    //Pirmajā vaicājumā tiek izvēlēti visi ieraksti no "prece" tabulas, un ar COUNT funkciju tiek saskaitīts to skaits. Rezultāts tiek saglabāts mainīgajā $data ar nosaukumu "total1".
        $sql ="SELECT COUNT(Prece_ID ) AS total1 from prece";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <?php 
    //Otrajā vaicājumā tiek izvēlēti visi ieraksti no "pardevejs" tabulas, un ar COUNT funkciju tiek saskaitīts to skaits. Rezultāts tiek saglabāts mainīgajā $data2 ar nosaukumu "total2".
        $sql2 ="SELECT COUNT(Pardevejs_ID) AS total2 from pardevejs ";
        $result2 = mysqli_query($conn, $sql2);
        $data2 = mysqli_fetch_assoc($result2);
    ?>
    <?php 
    //Trešajā vaicājumā tiek izvēlēti visi ieraksti no "kategorija" tabulas, un ar COUNT funkciju tiek saskaitīts to skaits. Rezultāts tiek saglabāts mainīgajā $data3 ar nosaukumu "total3".
        $sql3 ="SELECT COUNT(Kategorija_ID) AS total3 from kategorija ";
        $result3 = mysqli_query($conn, $sql3);
        $data3 = mysqli_fetch_assoc($result3);
    ?>
    <?php 
    //Ceturtajā vaicājumā tiek izvēlēti visi ieraksti no "k_apakssadala" tabulas, un ar COUNT funkciju tiek saskaitīts to skaits. Rezultāts tiek saglabāts mainīgajā $data4 ar nosaukumu "total4".
        $sql4 ="SELECT COUNT(Kapakssadala_ID) AS total4 from k_apakssadala ";
        $result4 = mysqli_query($conn, $sql4);
        $data4 = mysqli_fetch_assoc($result4);
    ?>

    <section id="statistics"> 
        <!--Šajā kodā tiek izveidotas SQL vaicājumi, lai iegūtu kopējo skaitu ierakstiem katrā tabulā + Font Awesome ikonas. Tad šī informācija tiek attēlota uz ekrāna, izmantojot HTML un PHP.Tas ir nepieciešams, lai parādītu statistiku -->
        <h1> Statistika</h1>
        <div class="icons-container">
            <div class="icons">
                <i class="fa-solid fa-people-group" style="font-size:31px"></i>
                <h3><?php echo $data2['total2']?></h3>
                <p style="font-size:18px">Pārdevēji</p>
            </div>
            <div class="icons">
                <i class="fa-solid fa-gifts" style="font-size:31px"></i>
                <h3><?php echo $data['total1']?></h3>
                <p style="font-size:18px">Preces</p>
            </div>
            <div class="icons">
                <i class="fa-solid fa-list-ul"  style="font-size:31px"></i>
                <h3><?php echo $data3['total3']?></h3>
                <p style="font-size:18px">Kategorijas</p>
            </div>
            <div class="icons">
                <i class="fa-solid fa-list-ul"  style="font-size:31px"></i>
                <h3><?php echo $data4['total4']?></h3>
                <p style="font-size:18px">Kategoriju apakšsadaļas</p>
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
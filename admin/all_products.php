<?php
require("config.php");
session_start();
if (isset($_SESSION['admin_name'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preču administrācija</title>
        <link rel="stylesheet" href="css/css.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>

        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="statistics.php">Statistika/Profils</a>
                <a href="#" class="active">Preces</a>
                <a href="all_masters.php">Pārdevēji</a>
                <a href="category.php">Kategorijas</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <section id="forInfo">
            <div class="row">
                <div class="info">
                    <div class="head-info head-color">Preču administrēšana: <br>
                    </div>
                    <table>
                        <tr>
                            <th>Nosaukums</th>
                            <th>Cena</th>
                            <th>Pārdevējs</th>
                            <th><a class='btn2' href="add_prod.php">Pievienot jaunu prece</a></th>
                            <th></th>
                        </tr>

                        <?php
                        require("config.php");
                        $preceSQL = "SELECT prece.prece_ID, prece.Nosaukums_prece, prece.Cena, 
                            pardevejs.Brenda_nosaukums
                            FROM prece
                            JOIN pardevejs
                            ON Pardevejs_ID = prece.ID_Pardevejs;";
                        $atlasa_prece = mysqli_query($conn, $preceSQL) or die("Nekorekts vaicājums");
                        if (mysqli_num_rows($atlasa_prece) > 0) {
                            while ($row = mysqli_fetch_assoc($atlasa_prece)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row['Nosaukums_prece']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['Cena']; ?>€
                                    </td>
                                    <td>
                                        <?php echo $row['Brenda_nosaukums']; ?>
                                    </td>
                                    <td>
                                        <a class='btn2' href="delete_prod.php?prece_ID=<?php echo $row['prece_ID']; ?>"><i
                                                class="fa fa-trash" aria-hidden="true" title="Dzēst"></i></a>
                                        <form action='about_prod.php' method='post'>
                                            <button type='submit' class='btn2' name='Apskatīt' value=<?php echo $row['prece_ID']; ?>
                                                title="Detalizēts preču apraksts">
                                                <a><i class="far fa-clipboard" aria-hidden="true"></i></a>
                                            </button>
                                        </form>
                                    </td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
                        }
                        ?>


                    </table>
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
<?php
require("../admin/config.php"); // Подключение файла с настройками подключения к базе данных
session_start(); // Начало новой сессии
$email = $_SESSION['user_name'];
$query = "SELECT Pardevejs_ID FROM pardevejs WHERE E_pasts_pardevejs = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$Pardevejs_ID = $user['Pardevejs_ID'];

if (isset($_SESSION['user_name'])) { // Проверка, авторизован ли пользователь в системе
    if (isset($_POST['add'])) { // Проверка, была ли нажата кнопка "Добавить"
        // Получение данных о новом товаре из формы
        $Nosaukums_prece = mysqli_real_escape_string($conn, $_POST['Nosaukums_prece']);
        $Cena = mysqli_real_escape_string($conn, $_POST['Cena']);
        $Apraksts_prece = mysqli_real_escape_string($conn, $_POST['Apraksts_prece']);
        $Attela_prece = mysqli_real_escape_string($conn, $_POST['Attela_prece']);
        $Ipatnibas_prece = mysqli_real_escape_string($conn, $_POST['Ipatnibas_prece']);
        $Kategorija_ID = mysqli_real_escape_string($conn, $_POST['Kategorija_ID']);
        $Kapakssadala_ID = mysqli_real_escape_string($conn, $_POST['Kapakssadala_ID']);

        // Вставка данных о новом товаре в базу данных
        mysqli_query($conn, "INSERT INTO `prece`(`Nosaukums_prece`, `Cena`, `Apraksts_prece`, `Attela_prece`, `Ipatnibas_prece`, `ID_Pardevejs`, `IDKapakssadala`, `ID_Kategorija`) 
          VALUES ('$Nosaukums_prece','$Cena','$Apraksts_prece','$Attela_prece','$Ipatnibas_prece','$Pardevejs_ID','$Kapakssadala_ID','$Kategorija_ID')");
        header('location:notification/add_confirm.php'); // Перенаправление на страницу со списком всех товаров     
    } else {
        // Получение данных из базы данных для формирования списков значений в форме добавления товара
        $kategorija = mysqli_query($conn, 'SELECT * FROM kategorija');
        $k_apakssadala = mysqli_query($conn, 'SELECT * FROM k_apakssadala');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preču administrēšana</title>
        <link rel="stylesheet" href="css/cssForMaster.css">
        <link rel="stylesheet" href="../assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="about_me.php" >Statistika/Profils</a>
                <a href="my_products.php" class="active" >Preces / Reģistrācija </a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">
            <form action="" method="post">
                <h3>Reģistrācija</h3>
                <input type="text" name="Nosaukums_prece" required placeholder="Nosaukums">
                <!--Это текстовое поле требует от пользователя ввести название товара и является обязательным для заполнения.  "placeholder" указывает, что ожидается ввод названия товара.-->
                <input type="text" name="Cena" required
                    placeholder="Cena"><!--Это текстовое поле требует от пользователя ввести цену товара и является обязательным для заполнения.  "placeholder" указывает, что ожидается ввод названия товара.-->
                <textarea name="Apraksts_prece" placeholder="Apraksts" style="height:200px;"></textarea>
                <!--Эта строка создает текстовое поле для ввода описания продукта. Высота 200 пикселей-->
                <input type="text" name="Attela_prece" placeholder="Attēls URL">
                <!--Это текстовое поле требует от пользователя ввести ссылку на фотографию на товара.  "placeholder" указывает, что ожидается ввод названия товара.-->
                <textarea name="Ipatnibas_prece" required placeholder="Īpatnības" style="height: 200px;"></textarea>
                <!--Эта строка создает текстовое поле для ввода ос продукта. Высота 200 пикселей-->
                <select name="Kategorija_ID" id="Kategorija_ID" required="true">
                    <option value="" disabled selected hidden>Kategorija</option>
                    <!--первая опция в списке, которая скрыта (атрибут hidden) и используется в качестве placeholder, чтобы пользователь понимал, что должен выбрать. -->
                    <?php
                    $sql = "SELECT Kategorija_ID, Nosaukums_kategorija FROM kategorija";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) { // проверю, что полученный результат запроса содержит как минимум одну строку
                        while ($row = mysqli_fetch_assoc($result)) { //использую цикл while для получения каждой строки из результата запроса и вывожу ее в виде опции в выпадающем списке
                            ?>
                            <option value="<?= $row['Kategorija_ID'] ?>">
                                <!-- значение, которое будет отправлено в базу данных после выбора опции. --><?= $row['Nosaukums_kategorija'] ?>
                            </option> <!--  текст, который будет отображаться на странице для данной опции.-->
                            <?php
                        }
                    }
                    ?>
                </select>
                <select name="Kapakssadala_ID" required="true">
                    <option value="" disabled selected hidden>Apakškategorija</option>
                    <?php
                    if (mysqli_num_rows($k_apakssadala) > 0) {
                        while ($row = mysqli_fetch_assoc($k_apakssadala)) {
                            ?>
                            <option value="<?= $row['Kapakssadala_ID'] ?>"><?= $row['Nosaukums_sadala'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>


                <input type="submit" name="add" value="Reģistrēt" class="form-btn">
                <input type="button" onclick="history.back();" value="Manas preces" class="form-btn ">
            </form>

            <!-- закрывающий тег для раздела страницы, который содержит информацию об авторских правах и дизайне веб-сайта. -->
            <footer>
                Kiriyena © 2023 Small start = Big deal</br>
                Designed by Kiriyena
            </footer>
            <?php
}
?>
</body>

</html>
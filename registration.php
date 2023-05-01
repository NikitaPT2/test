<?php
require("admin/config.php"); // Подключение файла с настройками подключения к базе данных
session_start(); // Начало новой сессии
if (isset($_POST['add'])) { // Проверка, была ли нажата кнопка "Добавить"
    // Получение данных о новом товаре из формы
    $Vards_pardevejs = mysqli_real_escape_string($conn, $_POST['Vards_pardevejs']);
    $Uzvards_pardevejs = mysqli_real_escape_string($conn, $_POST['Uzvards_pardevejs']);
    $E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
    $T_numurs_pardevejs = mysqli_real_escape_string($conn, $_POST['T_numurs_pardevejs']);
    $Apraksts = mysqli_real_escape_string($conn, $_POST['Apraksts']);
    $Brenda_nosaukums = mysqli_real_escape_string($conn, $_POST['Brenda_nosaukums']);
    $Attela_URL = mysqli_real_escape_string($conn, $_POST['Attela_URL']);
    $Parole_pardevejs = md5($_POST['Parole_pardevejs']);

    $select = " SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '$E_pasts_pardevejs' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = 'Tāds E-pasts jau ir';
    } else {

        // Вставка данных о новом товаре в базу данных
        mysqli_query($conn, "INSERT INTO `pardevejs`(`Vards_pardevejs`, `Uzvards_pardevejs`, `E_pasts_pardevejs`, `T_numurs_pardevejs`, `Apraksts`, `Brenda_nosaukums`, `Attela_URL`, `Parole_pardevejs`) 
                VALUES ('$Vards_pardevejs','$Uzvards_pardevejs','$E_pasts_pardevejs','$T_numurs_pardevejs','$Apraksts','$Brenda_nosaukums','$Attela_URL','$Parole_pardevejs')");
        header('location:admin/welcome.php'); // Перенаправление на страницу со списком всех товаров     
    }
}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Мета данные  -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pārdevēja pieteikšanās forma</title><!--заголовок страницы -->
    <!--подключение таблицы стилей для страницы административной панели -->
    <!--подключение иконки для вкладки браузера -->
    <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="admin/css/css.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <!-- (header) веб-страницы административной панели -->
    <header>
        <a class="logo">Pārdevēja reģistrācijas forma</a><!--логотип административной панели (Название) -->
        <button class="menu-toggle" aria-label="Toggle navigation menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="navbar"><!-- навигационное меню: 
                                    ссылка на страницу статистики и профиля, 
                                    ссылка на страницу всех товаров,
                                    ссылка на страницу всех продавцов ,
                                    ссылка на страницу категорий товаров -->
            <a href="index.html">Sākumlapa</a>
            <a href="shop.html">Preces</a>
            <a href="masters.html">Pārdevēji</a>
            <a href="login_master.php"></i>Pieslēgties</a>
            <a href="login_admin.php"><i
                    class="fa-solid fa-user-lock"></i></a><!--ссылка на страницу выхода из административной панели с иконкой.  "Актирная"-->
        </nav>
    </header>

    <div class="form-container">
        <form action="" method="post">
            <h3>Reģistrācija</h3>
            <?php
            // Проверка наличия ошибок и вывод их на страницу
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
                ;
            }
            ;
            ?>
            <input type="text" name="Vards_pardevejs" required placeholder="Vārds">
            <!--Это текстовое поле требует от пользователя ввести название товара и является обязательным для заполнения.  "placeholder" указывает, что ожидается ввод названия товара.-->
            <input type="text" name="Uzvards_pardevejs" required
                placeholder="Uzvārds"><!--Это текстовое поле требует от пользователя ввести цену товара и является обязательным для заполнения.  "placeholder" указывает, что ожидается ввод названия товара.-->
            <input name="E_pasts_pardevejs" required
                placeholder="E-pasts"><!--Эта строка создает текстовое поле для ввода описания продукта. Высота 200 пикселей-->
            <input type="text" name="T_numurs_pardevejs" placeholder="Telefona numurs (Nav obligāts)">
            <!--Это текстовое поле требует от пользователя ввести ссылку на фотографию на товара.  "placeholder" указывает, что ожидается ввод названия товара.-->
            <textarea name="Apraksts" placeholder="Apraksts (Nav obligāts)" style="height: 200px;"></textarea>
            <!--Эта строка создает текстовое поле для ввода ос продукта. Высота 200 пикселей-->
            <input type="text" name="Brenda_nosaukums" required placeholder="Brenda nosaukums">
            <input type="text" name="Attela_URL" placeholder="Attēls URL (Nav obligāts)">
            <input type="text" name="Parole_pardevejs" required placeholder="Parole">
            <input type="submit" name="add" value="Reģistrēt" class="form-btn">
            <a class='btn' title='Sākumlapa' href='index.html'><i class="fa-solid fa-backward"></i> Sākumlapa</a>
            <p>Esi jau reģistrējies? <a href="login_master.php">Ienākt</a></p>

        </form>

        <!-- закрывающий тег для раздела страницы, который содержит информацию об авторских правах и дизайне веб-сайта. -->
        <footer>
            Kiriyena © 2023 Small start = Big deal</br>
            Designed by Kiriyena
        </footer>
        <script>
            const menuToggle = document.querySelector('.menu-toggle');
            const navbar = document.querySelector('.navbar');

            menuToggle.addEventListener('click', () => {
                navbar.classList.toggle('show');
            });</script>

</body>

</html>
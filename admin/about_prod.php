<?php
    require("config.php"); // подключение файла конфигурации базы данных и других настроек
    session_start(); //начало сессии пользователя
    if(isset($_SESSION['admin_name'])){  // Проверка, авторизован ли пользователь в системе
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Мета данные  -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preču administrācija</title> <!--заголовок страницы -->
    <!--подключение таблицы стилей для страницы административной панели -->
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!--подключение иконки для вкладки браузера -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>
</head>
<body>
    <!-- (header) веб-страницы административной панели -->
    <header>
        <a class="logo">Administrēšanas panelis</a><!--логотип административной панели (Название) -->
        <nav class="navbar"> <!-- навигационное меню: 
                                    ссылка на страницу статистики и профиля, 
                                    ссылка на страницу всех товаров "Актирная",
                                    ссылка на страницу всех продавцов ,
                                    ссылка на страницу категорий товаров -->
            <a href="statistics.php">Statistika/Profils</a> 
            <a href="all_products.php" class="active">Preces / Apraksts</a> 
            <a href="all_masters.php" >Pārdevēji</a> 
            <a href="category.php">Kategorijas</a> 
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a> <!--ссылка на страницу выхода из административной панели с иконкой  -->
        </nav>
    </header>

<section id="description">
    <h1>Detalizēts preču apraksts</h1> <!-- Заголовок раздела с детальным описанием товара -->
    <div class="box-container">
        <div class='box'>
            <?php 
                if($_SERVER['REQUEST_METHOD'] == 'POST'){ // Если метод запроса POST, то выполнить следующий блок кода
                    require("config.php"); // Подключение файла с параметрами подключения к базе данных
                    $prece_ID = $_POST['Apskatīt']; // Получение значения ID товара из формы, отправленной методом POST
                     // SQL запрос для получения данных о товаре с заданным ID
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
                    WHERE prece_ID=$prece_ID"; 
                    $atlasa_apraksts = mysqli_query($conn, $par_preceSQL) or die ("Nekorekts vaicājums");  // Выполнение SQL запроса и сохранение результатов в переменную $atlasa_apraksts
                     while($row = mysqli_fetch_assoc($atlasa_apraksts)){ // Итерация по результатам запроса с помощью функции mysqli_fetch_assoc
                        // Полный вывод информации о товаре
                        echo " 
                            <img src='{$row['Attela_prece']}'>
                            <h3>{$row['Nosaukums_prece']}</h3>
                            <p><b>Cena: </b>{$row['Cena']}€</p>
                            <p><b>Statuss: </b>{$row['Statuss']}</p>
                            <p><b>Pārdevējs: </b>{$row['Brenda_nosaukums']}</p>
                            <p><b>Apraksts: </b>{$row['Apraksts_prece']}</p>
                            <p><b>Īpatnības: </b>{$row['Ipatnibas_prece']}</p>
                            <p><b>Kategorija: </b>{$row['Nosaukums_kategorija']}</p>
                            <p><b>Kategoriju apakšsadaļa: </b>{$row['Nosaukums_sadala']}</p>
                            ";  
					}
                }else{
                    echo "Tabula nav datu ko attēlot"; // Если данных нет, то выводится сообщение "Tabula nav datu ko attēlot" 
                }
            ?>  
            <input type="button" onclick="history.back();" value="Atpakaļ" class="btn "> <!--Кнопка, которая перенаправляет пользователя на предыдущую страницу в истории браузера при нажатии -->
        </div>
                                    
    </div>
</section>

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
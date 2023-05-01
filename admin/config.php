<?php
// Параметры для подключения к базе данных
$server_vards = "localhost:3306"; // хост базы данных.
$lietotajvards = "root"; // имя пользователя базы данных.
$parole = ""; // пароль для доступа к базе данных.
$db_vards = "kiriyena_db"; // имя базы данных. 

$conn = mysqli_connect($server_vards,$lietotajvards, $parole, $db_vards); // функция для создания соединения с базой данных с помощью параметров, заданных в переменных.


?>
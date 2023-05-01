 <!-- Подключение стилей для формы подтверждения удаления -->
 <head>
    <link rel="stylesheet" type="text/css" href="../assets/css/confirm.css">
</head>
<?php
	include('config.php');  // Подключение к базе данных
	$id=$_GET['Kapakssadala_ID']; // Получение ID удаляемой записи из URL-адреса
	
	if(isset($_POST['confirm'])){ // Если кнопка "Jā" была нажата
	    mysqli_query($conn,"DELETE FROM `k_apakssadala` WHERE `Kapakssadala_ID`='$id'"); // Удаление записи из базы данных
	    // echo "<script>alert('Ieraksts veiksmīgi izdzēsts!')</script>";  Вывод сообщения об успешном удалении записи
	    echo "<meta http-equiv='refresh' content='0; url=category.php'>"; // Перенаправление на страницу всех категорий
	}
?>

<form method="post">
	<p>Vai tiešām vēlaties dzēst ierakstu?</p>  <!-- Вопрос о подтверждении удаления записи -->
	<button type="submit" name="confirm">Jā</button>  <!-- Кнопка подтверждения удаления записи -->
	<a href="category.php">Nē</a> <!-- Ссылка на отмену удаления записи -->
</form>
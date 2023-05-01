<!-- Ievietoju saiti uz lapas stilu -->

<head>
	<link rel="stylesheet" type="text/css" href="../assets/css/confirm.css">
</head>

<form method="post">
	<p><b>Paldies, ka pievienojies mums!</b></br> Lūdzu, vēlreiz piesakieties savā kontā, lai sāktu jaunu sesiju.</p>
	<?php
	header("Refresh: 3; URL=../login_master.php");
	?>
</form>
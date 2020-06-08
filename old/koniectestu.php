<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
// strona przygotowania i startowania sesji testowej dla podanego katalogu
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Aldur's Memory Helper</title>
</head>

<body>
	
<?php
/*
	echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';

echo '_SESSION = ';
	var_dump($_SESSION); // NEW STATE //[test]
echo '</br>_POST = ';
	var_dump($_POST); // NEW STATE //[test]
echo '<br>';
*/

///  KONIEC SESJI PYTAŃ - EWENTUALNE MIEJSCE DO WYŚWIETLENIA PODSUMOWANIA I ZAPISANIA WYNIKÓW (w przyszłości)

echo "<H1>GRATULACJE!<br>Sesja testowa zakończona.</H1>";

// Nawigacja do uruchomienia testu lub powrotu do wyboru sesji
		echo '<form action="wyborsesji.php" method="post">';
		echo '<br /> <button type="submit" name="submit1" class="submit">Przejdź do wyboru testów</button>';
		echo '</form>';
	
?>

</body>
</html>

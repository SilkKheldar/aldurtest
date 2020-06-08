<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
// strona obsługi pytania po odpowiedzi prawidłowej
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

echo '_SESSION = ';
	var_dump($_SESSION); // NEW STATE //[test]
echo '</br>_POST = ';
	var_dump($_POST); // NEW STATE //[test]

	$TablicaZrobione = $_SESSION['TablicaZrobione'];
	$IleZostalo = $_SESSION['IleZostalo'];
/*
/// obsługa poprzedniej odpowiedzi
	$OstatniePytanie = $_SESSION['OstatniePytanie'];

//	$WynikPytania = $_SESSION['WynikPytania'];
	$WynikPytania = 0;
	if( $WynikPytania == 1 )
	{
		$TablicaZrobione[ $OstatniePytanie ] = 1;
		$IleZostalo--;
		$_SESSION['IleZostalo'] = $IleZostalo; 
		$_SESSION['TablicaZrobione'] = $TablicaZrobione;
	}
	
///  Sprawdzenie czy test nie zakończony... 
	if( !$IleZostalo > 0 )
	{
		header('Location: koniectestu.php');
		exit();
	}
/// ...i jeśli nie to wybór następnego pytania

*/
	$TablicaPliki = $_SESSION['TablicaPliki'];
	$KatalogPlikow = $_SESSION['KatalogPlikow'];
	$IlePytan = $_SESSION['IlePytan'];
	$nr = 0; //potrzebne żeby określić typ zmiennej $nr
	$nr = rand( 0, $IlePytan-1 );

	while( $TablicaZrobione[ $nr ] != 0 )   //sprawdzam czy pytanie nr jeszcze nie rozwiązane, jeśli tak to idę do następnego
	{
echo "sprawdzam czy zadać pytanie nr ".$nr."<br>";  ///[test]
		if( $nr == $IlePytan)
			$nr = 0;
		else
			$nr++;
	}	
	$_SESSION['OstatniePytanie'] = $nr;
	
///  WYŚWIETLENIE PYTANIA i oczekiwanie na wybór akcji przez użytkownikaEWENTUALNE

echo "<p>Pytanie nr ".$nr."</p>";
echo "<p><img src='".$KatalogPlikow."/".$TablicaPliki[$nr]."' width='100%'></p>";      //Wersja robocza do testów
//echo "<img class=\"obrazek\" src=\"".$KatalogPlikow."/".$TablicaPliki[ $nr ]."\" />";  //wersja docelowa z CSS

// Nawigacja do uruchomienia testu lub powrotu do wyboru sesji
		echo '<form action="test1.php" method="post">';
		echo '<br /> <button type="submit" name="submit1" value="tak" class="submit">WIEM :)</button>';
		echo ' <button type="submit" name="submit2" value="nie" class="submit">Nie wiem :(</button>';
// jeśli nie znajdę sposobu na przekazywanie różnych wartości do tej samej strony w zależności od TAK / NIE to można odesłać do innej strony wyglądającej tak samo, ale z różnym kodem dla dobrej i złej odpowiedzi z wykokrzytaniem "formaction"
		echo ' <button type="submit" formaction="test2.php">Nie wiem :(</button>';
		echo '</form>';
	
?>

</body>
</html>

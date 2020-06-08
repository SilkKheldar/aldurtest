<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
// strona obsługi pytania
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
echo '_SESSION = ';
	var_dump($_SESSION); // NEW STATE //[test]
echo '</br>_POST = ';
	var_dump($_POST); // NEW STATE //[test]
echo '<br>';
*/
	/// obsługa poprzedniej odpowiedzi
	$OstatniePytanie = $_SESSION['OstatniePytanie'];
	$WynikPytania = $_POST['WynikPytania'];
	$TablicaZrobione = $_SESSION['TablicaZrobione'];
	$IleZostalo = $_SESSION['IleZostalo'];
	if( $WynikPytania == "1" )
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

	$TablicaPliki = $_SESSION['TablicaPliki'];
	$KatalogPlikow = $_SESSION['KatalogPlikow'];
	$IlePytan = $_SESSION['IlePytan'];
	$nr = 0; //potrzebne żeby określić typ zmiennej $nr
	$nr = rand( 0, $IlePytan-1 );
	if(($nr == $OstatniePytanie) & ($IleZostalo != 1))  //nie chcemy żeby powtarzało się poprzednie pytanie (może jako opcja?)
		if( $nr==$IlePytan-1)
			$nr=0;
		else
			$nr++; 

/*
echo '_SESSION = ';
	var_dump($_SESSION); // NEW STATE //[test]
echo '<br>';
*/

	while( $TablicaZrobione[ $nr ] != 0 )   //sprawdzam czy pytanie nr jeszcze nie rozwiązane, jeśli tak to idę do następnego
	{
//echo "sprawdzam czy zadać pytanie nr ".$nr."<br>";  ///[test]
		if( $nr >= $IlePytan-1)
			$nr = 0;
		else
			$nr++;
	}	
    $_SESSION['OstatniePytanie'] = $nr;
	
///  WYŚWIETLENIE PYTANIA i oczekiwanie na wybór akcji przez użytkownikaEWENTUALNE

echo "<p>Trwa test. Indeks pytania: ".$nr.". Pozostało ".$IleZostalo." / ".$IlePytan."</p>";
echo "<p><img src='".$KatalogPlikow."/".$TablicaPliki[$nr]."' width='100%'></p>";      //Wersja robocza do testów
//echo "<img class=\"obrazek\" src=\"".$KatalogPlikow."/".$TablicaPliki[ $nr ]."\" />";  //wersja docelowa z CSS

// Nawigacja do uruchomienia testu lub powrotu do wyboru sesji
		echo '<form action="test.php" method="post">';
		echo '<br /> <button type="submit" name="WynikPytania" value="1" class="submit">WIEM :)</button>';
		echo ' <button type="submit" name="WynikPytania" value="0" class="submit">Nie wiem :(</button>';
		echo ' &nbsp; &nbsp; <button type="submit" name="przerwij" value="1" formaction="wyborsesji.php" class="submitOut">Przerwij!</button>';
		echo '</form>';
	
?>

</body>
</html>

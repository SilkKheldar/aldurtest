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

	echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';

///  PRZYGOTOWANIE SESJI DLA PODANEGO KATALOGU

	$dir = $_POST['dir'];          // katalog bazowy dla katalogów z testami
	$katalog = $_POST['katalog'];  // nazwa podkatalogu wybranego do testu
	$coreDir = $dir.$katalog;
	echo "<h1>Wybrany katalog do testu: $katalog</h1>";
	echo "<h2>Lista grafik (pytań):</h2>";
	
   
//// zdecydować czy przekazywać tablice POSTem czy wykorzystać SQL (i tak jest juz aktywny do logowania) - przeciw wykorzystaniu bazy przemawia to że chcę, żeby mogło być wiele ssesji jednocześnie, a poza tym po zakończeniu testu informacje o nim nie są już potrzebne - póki to się nie zmieni to chyba nie ma sensu pakować się w bazę danych ???
    $TablicaZrobione;
	$TablicaPliki;
//	array_splice($TablicaPliki,0);  // czy to potrzebne skoro pracuję na zmiennej sesyjnej a nie global ???
    $IlePytan = 0;
    
	if ($handle = opendir($coreDir))  //??? a może lepiej zastosować @opendir(...
    {
        while ($file = readdir($handle)) {  
//			echo "$file<br>";   //[test]
/* !!! kuleje rozpoznawanie katalogów w następnej linii (chcę docelowo zrobić funkcję, która pozwoli w przypadku napotkania podkatalogów na ich pomijanie lub rekurencyjne dodawanie do tablicy obrazków w nich zawartych (jak na razie to ani is_file() ani is_dir() nie działa zadowalająco i wywala warning przy sprawdzaniu [extension])*/
			if ( ( $file != '.' ) && ( $file != '..' ) )  
			{
				$nazwaPliku = pathinfo($file);
				$ext = strtolower($nazwaPliku['extension']);  //wywala warning gdy trafi na podkatalog !!! < jak to poprawić ???
//				echo ">> rozszerzenie to .$ext<br>";        //[test]
				if ($ext=="jpg" || $ext=="png" || $ext=="jpeg" || $ext=="gif")  // wybiramy tylko grafiki
				{
//					echo "dodam obrazek $file<br>";                        //[test]
					++$IlePytan;
					$TablicaPliki[ ] = $file ;
					$TablicaZrobione[ ] = 0 ;
				}
			}
		}
		closedir ( $handle );
	}

// Tabela obrazków wygląda na utworzoną OK, tylko jeszcze pozostaje przekazać ją dalej do sesji testowej...
	$_SESSION['TablicaPliki'] = $TablicaPliki;
	$_SESSION['TablicaZrobione'] = $TablicaZrobione;
	$_SESSION['KatalogPlikow'] = $coreDir;
	$_SESSION['IlePytan'] = $IlePytan;
	$_SESSION['IleZostalo'] = $IlePytan;
	$_POST['WynikPytania'] = 0;        // potrzebne ustalenie na pierwsze wywołanie strony testu
	$_SESSION['OstatniePytanie'] = 1;  // nieistotna wartość, ale potrzebne(?) ustalenie
//	var_dump($_SESSION); // NEW STATE //[test]
	
	
///////////////////////////////////////////////////////////////////////// -- wybór z istniejących katalogów - END
	
// wyświetlenie ikonek obrazków do testu (ilość i pogląd miniaturek)
//	echo 'wczytałem '.$IlePytan.' obrazków do testu<br>';  //[test]
	for($i=0;$i<$IlePytan;$i++)
		echo $TablicaPliki[$i].'<br>';

	
// Nawigacja do uruchomienia testu lub powrotu do wyboru sesji
		echo '<form action="test.php" method="post">';
		echo '<input type="hidden" name="katalog" value="'.$katalog.'">';
		echo '<input type="hidden" name="WynikPytania" value="0">';
		//echo '<br /> <input type="submit" value="Uruchom test" />';
		echo '<br /> <button type="submit" name="submit1" class="submit">Uruchom test</button>';
		echo '</form>';
	
?>

</body>
</html>
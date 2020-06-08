<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
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

	if 	($_SESSION['admin']=='T')
	{
		//opcje tworzenia nowych sesji
		echo "<h1> tu będą opcje tworzenia i zarządzania sesjami (tylko dla administratorów)</h1>";
		
		echo "<h2> wariant A: nowa sesja z katalogu na serwerze</h2>";
		echo "<h2> wariant B: nowa sesja z katalogów i plików z dysku lokalnego</h2>";
		echo "<h2> wariant C: zarządzanie istniejącymi sesjami pytań ( modyfikacje / usuwanie )</h2>";
		echo "<h2> wariant D: definiowanie nowej sesji z sesji już istniejących</h2>";
		echo "<br/>";
		echo "<h2> wariant E: sesja \"na żywo\" z katalogu na dysku lokalnym</h2>";
	}
	
	// lista sesji do wyboru
	//
	
	echo "<h1> tu będzie możliwość wyboru sesji do wykonania </h1>";

///////////////////////////////////////////////////////////// -- wybór z istniejących katalogów - BEGIN
	echo "<h2> wariant A: wybór katalogu z istniejących na serwerze</h2>";
	echo "<p> naciśnij nazwę katalogu z obrazkami by uruchomić dla niego test:</p>";
    $TablicaGalerii;
//	array_splice($TablicaGalerii,0);
    $IleWTablicyGalerii = 0;
    
	$dir = "./dane/";  // katalog główny na podkatalogi z poszczególnymi testami (zdjęciami)
	if ($handle = opendir($dir))
    {
        while (false !== ($file = readdir($handle))) {  
			if ( ( $file != '.' ) && ( $file != '..' ) && (is_dir( $dir.'/'.$file )) )
			{
				$files[ ] = $file;
			}
		}
		closedir ( $handle );
	}
 
	if ( !empty ( $files ) )   // jeśli są jakieś podkatalogi
	{
		sort ( $files );
        
		echo '<form action="generujsesje.php" method="post">';
		echo '<input type="hidden" name="dir" value="'.$dir.'">';
		
		for($i = 0, $c = count($files); $i < $c; $i++) 
		{
			// okrasić to potem odpowiednimi tagami dla CSS
			// ewentualnie rozbudować też tak żeby liczyło fotki i pokazywało opis zrobiony dla danego katalogu
				//echo "do wyboru katalog o nazwie: ".$files[$i]."<br>";
			echo '<input type="radio" name="katalog" value="'.$files[$i].'"><label for="'.$files[$i].'">'.$files[$i].'</label><br />';
		}
		//echo '<br /> <input type="submit" value="Uruchom test" />';
		echo '<br /> <button type="submit" name="submit1" class="submit">Uruchom test</button>';
		echo '</form>';
	}
	else
	{
		echo "<h2>Niestety nie ma żadnych podkatalogów (z obrazkami) do przeprowadzenia testów.</h2>";
	}
/////////////////////////////////////////////////////// -- wybór z istniejących katalogów - END
	
// może kiedyś do dorobienia opcja wyboru z bazy testów...
//	echo "<h2> wariant B: wybór zdefiniowanej sesji z bazy</h2>";
	
?>

</body>
</html>
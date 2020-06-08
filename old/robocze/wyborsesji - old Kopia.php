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

///////////////////////////////////////////////////////////////////////// -- wybór z istniejących katalogów - BEGIN
	echo "<h2> wariant A: wybór katalogu z istniejących na serwerze</h2>";
	echo "<p> lista istniejących katalogów:</p>";
    $TablicaGalerii;
//	array_splice($TablicaGalerii,0);
    $IleWTablicyGalerii = 0;
	$nameLength = 0;
    if ($handle = opendir('./dane/'))
    {
        echo "zawartość katalogu /dane/:<br>";               //[test]
        while (false !== ($file = readdir($handle))) {  // robiąc to w ten sposób nie da się posortować nazw !!!
            echo "$file<br>";                        //[test]
            $nazwaPliku = pathinfo($file);
			
			if ( is_dir($file) )
			{
				if ($file!="." && $file!="..")
				{
					echo "do wyboru katalog o nazwie: $file<br>";
				}	
			}	
			else
			{
				$ext = strtolower($nazwaPliku['extension']);
				echo ">> rozszerzenie to .$ext<br>";        //[test]
				if ($ext=="jpg" || $ext=="png" || $ext=="jpeg" || $ext=="gif")
//			if ( strtolower(substr($file,$nameLength-4,4))=='.jpg' ) // jakby miały być też inne fotki to trzeba zabezpieczyć się na "." i ".."
				{
					echo "$file<br>";                        //[test]
					++$IleWTablicyGalerii;
					$TablicaGalerii[ ] = $file ;                        // tabela(1w): pełna nazwa pliku
//                $TablicaGaleriiPliki[ substr( $file, 0, 6 ) ] = $file ;             // tabela(2w): kod > pełna nazwa pliku
				}
			}
		} // while	
        closedir($handle);
        $IleWTablicyGalerii--;  // korekta warto¶ci wynikaj±ca z "while"
    }
	
///////////////////////////////////////////////////////////////////////// -- wybór z istniejących katalogów - END
	
	echo "<h2> wariant B: wybór zdefiniowanej sesji z bazy</h2>";
	
?>

</body>
</html>
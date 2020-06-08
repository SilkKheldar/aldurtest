<?
// funkcje dla budowania tabeli sesji
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$const_KatalogDanychNaSerwerze = "./dane/" ;    // katalog danych (plików) względem katalogu głównego aplikacji

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Cel: funkcja dodająca do (globalnej) tabeli bieżącej sesji pytań wszystkie pliki graficzne (spełniające podane 
//      kryteria), które znajdują się w katalogu (na serwerze) przekazanym jako parametr.
//      W przypadku wykrycia podkatalogu jest uruchamiana dla niego (rekurencyjnie) ta sama funkcja tak by po
//      zakończeniu wywołania dla katalogu nadrzędnego (pierwszego) tabela zawierała odwołania do wszystkich
//      plików graficznych zarówno w katalogu głównym jak i jego podkatalogach.
//      Nie jest istotne uporządkowanie pozycji w tabeli wynikowej. Nie jest również analizowane występowanie 
//      duplikatów plików o tej samej nazwie w podkatalogach.
//      Wywołanie główne powinno mieć postać $_SESSION['IleWTabeliSesji']=dodajGrafikiZKatalogu('xxx');
//      tak żeby finalnie na zmiennej globalnej była informacja o ilości pozycji w tabeli (sesji).
// Opcje: do rozważenia czy przydatne byłoby ograniczenie tylko do bieżącego katalogu lub określonej głębokości
//        wchodzenia w podkatalogi (na razie schodzimy "do dna")
// Autor: Tomasz Krupiński
// Parametry:
//      $path     : ścieżka katalogu począwszy od ścieżki bieżącej dla danych na serwerze
// Wynik: funkcja zwraca liczbę pozycji (grafik) dodanych do $_SESSION['TabelaSesji']  --- chyba, że nic a rozmiar będę sprawdzał funkcją count() ???
//
function dodajGrafikiZKatalogu( $path )
{
    $ileGrafik = 0;
	global $_SESSION['TabelaSesji'];
	global $_SESSION['IleWTabeliSesji'];

    $dir ;	
	
    if ( $_SESSION['Debug'] == 1 ) {echo "<p> wywołanie funkcji dodajGrafikiZKatalogu(".$katalog.")</p>";}

    if ($handle = @opendir($path))
    {
        while (false !== ($file = readdir($handle))) {
            // sprawdzać rodzaj pozycji:
			// gdy katalog >> wywołaj funkcję rekurencyjnie dla podkatalogu | $ileGrafik += <wynik funkcji> 
			// gdy plik graficzny >> dodaj jedną pozycję do TabelaSesji | $ileGrafik += 1
			// w p.p. >> zignoruj pozycję
			if ( strtolower(substr($file,$nameLength-4,4))=='.jpg' ) // jakby miały być też inne fotki to trzeba zabezpieczyć się na "." i ".."
            {
//                echo "$file<br>";                        //[test]
                ++$IleWTablicyGalerii;
                $TablicaGalerii[ ] = $file ;                        // tabela(1w): pełna nazwa pliku
//                $TablicaGaleriiPliki[ substr( $file, 0, 6 ) ] = $file ;             // tabela(2w): kod > pełna nazwa pliku
            }
        }
        closedir($handle);
//        ksort( $TablicaGaleriiPliki );  // sortowanie po kluczu całej tabeli
        sort( $TablicaGalerii );
        $IleWTablicyGalerii--;  // korekta warto¶ci wynikaj±ca z "while"
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////    BUDOWANIE TABLICY GALERII    ///////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
function resetujTabeleSesji( )
{
	global $_SESSION['TabelaSesji'];
	global $_SESSION['IleWTabeliSesji'];

    array_splice($_SESSION['TabelaSesji'],0);
    $_SESSION['IleWTabeliSesji'] = 0;
//echo "<H1>RESECIK TABELI</H1>";  //[test]
}

// jeżeli skasowana pamięć lub pierwszy raz to wczytanie tablicy galerii
//
//echo "<p>IleWTablicyGalerii=\"".$IleWTablicyGalerii."\"</p>";   //[test]
if ( $IleWTablicyGalerii < 1 )
//or ( $TablicaGalerii[ $IleWTablicyGalerii ] == "" )
{
//echo "<H1>BRAK USTAWIONEJ TABELI</H1>";  //[test]
    ////// stworzenie listy pozycji z zawarto¶ci katalogu galerii
    //
    $IleWTablicyGalerii = 0;
    if ($handle = opendir('./foto/'))
    {
//        echo "Rysunki w katalogu Galerii (/foto):<br>";               //[test]
        while (false !== ($file = readdir($handle))) {
            if ( strtolower(substr($file,$nameLength-4,4))=='.jpg' ) // jakby miały być też inne fotki to trzeba zabezpieczyć się na "." i ".."
            {
//                echo "$file<br>";                        //[test]
                ++$IleWTablicyGalerii;
                $TablicaGalerii[ ] = $file ;                        // tabela(1w): pełna nazwa pliku
//                $TablicaGaleriiPliki[ substr( $file, 0, 6 ) ] = $file ;             // tabela(2w): kod > pełna nazwa pliku
            }
        }
        closedir($handle);
//        ksort( $TablicaGaleriiPliki );  // sortowanie po kluczu całej tabeli
        sort( $TablicaGalerii );
        $IleWTablicyGalerii--;  // korekta warto¶ci wynikaj±ca z "while"
    }
}
//echo "<br><h2>WYNIKOWA TABLICA FOTEK:</h2>";                                                   //[test]
//foreach ($TablicaGalerii as $key => $val) { echo "TablicaGalerii[".$key."] = ".$val."<br>";}   //[test]
//echo "Razem liczba fotek w galerii = ".$IleWTablicyGalerii."<br>";                             //[test]

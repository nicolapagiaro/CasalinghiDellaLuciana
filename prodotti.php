<?php
include('constants.php');
include('class.php');

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();

$categorie = array(); //array con le categorie
$categoriaAttiva; // nome della categoria da mostrare

$queryCat = "SELECT id, nome
             FROM CATEGORIE";
$respCat = mysqli_query($db, $queryCat);
while ($row = mysqli_fetch_assoc($respCat)) {
    $categorie[] = Categoria::conIdNome($row['id'], $row['nome']);
}
?>
<html>
    <head>
        <title>Catalogo - Casalinghi Dalla Luciana</title>
        <!-- Icona -->
        <link rel="icon" href="cdl_home.ico"/>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/maincss.css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0"/>
        
        <meta name="description" content="Casalinghi Dalla Luciana">
        <meta name="keywords" content="Casalinghi Dalla Luciana, sito ufficiale, official site, original brand, Luciana, Padova, negozio, giochi, giocattoli, utensili, casa, regali, arcella, negozio storico,
              giochi per bambino, giochi per bambina, giochi per neonati, giochi da tavolo, giochi di società, borse termiche, tortiere, pentole, padelle 
              ceramiche, contenitori, plastica, ferro, terra cotta">
        <meta name="author" content="Nicola Pagiaro">
    </head>
    <body>
        <div class="red white">
            <nav class="red white nav-extended">
                <div class="container nav-wrapper white">
                    <a href="index.php"><img src="cdl_home.ico" class="ico-home circle hide-on-small-only"></a>
                    <a href="index.php" class="brand-logo hide-on-small-only">Casalinghi Dalla Luciana</a>
                    <a href="index.php" class="brand-logo hide-on-med-and-up">Casalinghi</a>
                    <a href="index.php"><img src="cdl_home.ico" class="ico-home circle right hide-on-med-and-up"></a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="#!">Prodotti</a></li>
                        <li><a href="history.html">La nostra storia</a></li>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="#">Prodotti</a></li>
                        <li><a href="history.html">La nostra storia</a></li>
                    </ul>
                </div>
                <div class="container nav-content">
                    <ul class="tabs tabs-transparent">
                        <?php
                        foreach ($categorie as $c) {
                            $class = "";
                            if ($categorie[0]->getId() == $c->getId()) {
                                $class = "active";
                            }
                            echo "<li class='tab'><a class='$class' id='" . $c->getId() . "' href='#sk" . $c->getId() . "'>" . $c->getNome() . "</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="row">
                        <div id="header" class="col l8 m6 s12">
                            <p id="percorsoText" class="hide-on-small-only"><a href="index.php">Home</a> / Prodotti / </p>
                            <p class="title-prodotti no-padd" id="catAttiva" style="margin-top: 3px !important;"></p>
                            <p id="catAttivaDescr" class="grey-text-2"></p>
                        </div>
                        <div id="headerRicerca" class="col l8 m6 s12">
                            <div class="col s10">
                                <p class="title-prodotti no-padd" id="ricercaText" style="margin-top: 3px !important;"></p>
                                <p class="grey-text-2">La ricerca viene effettuata per i nomi delle marche presenti nel negozio</p>
                                <p><a href="#!" id="ricercaClose" style="text-decoration: underline;">Chiudi</a></p>
                            </div>
                        </div>
                        <div class="col l4 m6 s12 left-align">
                            <form id="search_form">
                                <div class="input-field col s9">
                                    <input id="ricerca" name="search" type="text">
                                    <label for="ricerca">Cerca fra le nostre marche</label>
                                </div>
                                <div class="input-field col s3">
                                    <button type="submit" class="btn red darken-4"><i class="material-icons">search</i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Per mostrare il risultato della ricerca -->
                    <div id="ricercaContainer" class="col s12">
                        <div class="col s12">
                            <div id="ricercaContent"></div>
                        </div>
                        <!-- divider -->
                        <div class="col s12">
                            <div class="section left-align">
                                <i>fine della ricerca</i>
                            </div>
                            <div class="divider"></div>
                            <div class="section"></div>
                        </div>
                    </div>
                    <!-- Per mostrare le foto -->
                    <p class="title-prodotti no-padd-top">Una carrellata di immagini</p>
                    <div class="hide-on-small-only" id="imageContent"></div>
                    <div class="hide-on-med-and-up" id="imageContentCell"></div>
                    <div class="col l10 m8 s12">
                        <p class="title-prodotti">Le nostre marche</p>
                        <p>Cerchi pi&ugrave; informazioni sui nostri prodotti? <a href="index.php#mail_">Inviaci una mail</a> o vienici a trovare in negozio.</p>
                    </div>        
                    <div class="col l2 m4 s12 right-align hide-on-small-and-down">
                        <br>
                        <!-- Dropdown Trigger -->
                        <a class='dropdown-button btn btn-flat' href='#!' data-activates='dropdown1'>Ordina per</a>
                        <!-- Dropdown Structure -->
                        <ul id='dropdown1' class='dropdown-content'>
                            <li><a href="#!" onclick="reloadMarche(1)">A - Z</a></li>
                            <li><a href="#!" onclick="reloadMarche(2)">Z - A</a></li>
                        </ul>
                    </div>
                    <div class="col s12 hide-on-med-and-up">
                        <p>Ordina per: <a class="order-scritte" href="#!" onclick="reloadMarche(1)">A - Z</a> · <a class="order-scritte" href="#!" onclick="reloadMarche(2)">Z - A</a></p>
                    </div>

                    <!-- Per mostrare i prodotti -->
                    <div id="content" class="col s12"></div>
                    
                    <!-- Per mostrare i prodotti senza immagine -->
                    <div id="content_noimage" class="col s12"></div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <a class="btn-floating btn-large grey darker-2 buttonScrollTop tooltipped" data-position="left" data-delay="10" data-tooltip="Torna su">
            <i class="material-icons">arrow_upward</i>
        </a>
        <footer class="page-footer grey lighten-3">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5>Casalinghi Dalla Luciana</h5>
                        <p >Da oltre quarant'anni soddisfiamo i desideri dei più grandi e dei più piccini</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5>Altri contatti</h5>
                        <ul>
                            <li><a target="blank" href="https://www.facebook.com/casalinghi.luciana/">Facebook: @casalinghi.luciana</a></li>
                            <li><a target="blank" href="index.php#mail_">Inviaci una mail (casalinghidallaluciana@gmail.com)</a></li>
                        </ul>
                    </div>		
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container grey-text-2">
                    © 2014 Copyright
                </div>
            </div>
        </footer>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/main_script.js"></script>
    </body>
</html>
<?php
// Close the connection
mysqli_close($db);

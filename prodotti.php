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
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0"/>
    </head>
    <body>
        <div class="red white">
            <nav class="red white nav-extended">
                <div class="container nav-wrapper white">
                    <img src="cdl_home.ico" class="ico-home circle hide-on-small-only">
                    <a href="index.php" class="brand-logo hide-on-small-only">Casalinghi Dalla Luciana</a>
                    <a href="index.php" class="brand-logo hide-on-med-and-up">Casalinghi</a>
                    <img src="cdl_home.ico" class="ico-home circle right hide-on-med-and-up">
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="#!" id="textToChange3">Prodotti</a></li>
                        <li><a href="#">La nostra storia</a></li>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="index.php">Home</a></li>
                        <li><a class="red-text"href="#">Prodotti</a></li>
                        <li><a href="#">La nostra storia</a></li>
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
                            <h4 id="catAttiva" style="margin-top: 3px !important;"></h4>
                            <p id="catAttivaDescr" class="grey-text-2"></p>
                        </div>
                        <div id="headerRicerca" class="col l8 m6 s12">
                            <div class="col s10">
                                <h3 id="ricercaText" style="margin-top: 3px !important;"></h3>
                                <p class="grey-text-2">La ricerca viene effettuata per i nomi delle marche presenti nel negozio</p>
                                <p><a href="#!" id="ricercaClose" style="text-decoration: underline;">Chiudi</a></p>
                            </div>
                        </div>
                        <div class="col l4 m6 s12 left-align">
                            <form id="search_form">
                                <div class="input-field col s8">
                                    <input id="ricerca" name="search" type="text">
                                    <label for="ricerca">Cerca fra le nostre marche</label>
                                </div>
                                <div class="input-field col s4">
                                    <button type="submit" class="btn red darken-4">Cerca</button>
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
                    <!-- Per mostrare i prodotti -->
                    <div id="content" class="col s12"></div>
                    <br>
                    <!-- Per mostrare le info sul prodotto -->
                    <div id="infoProdotto" class="col s12">
                        <!-- divider -->
                        <div class="col s12">
                            <div class="section"></div>
                            <div class="divider"></div>
                            <div class="section"></div>
                        </div>
                        <div class="col l8 m8 s11">
                            <p class="title-prodotti no-padd" id='nameProd'></p>
                        </div>
                        <div class="col l4 m4 s1 right-align">
                            <a href='#!' onclick="closeDetails()"><i class="material-icons">close</i></a>
                        </div>
                        <div class="col l6 m6 s12">
                            <p id='descrProd'></p>
                            <p><i class="material-icons">supervisor_account</i> <span id="etaProd"></span></p>
                        </div>
                        <div class="col s12" id="fotoContainer"></div>
                    </div>
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

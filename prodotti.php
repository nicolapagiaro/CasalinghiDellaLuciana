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
        <link rel="icon" href="favicon.ico"/>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/maincss.css"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <div class="red darken-4 navabar">
            <nav class="red darken-4 nav-extended">
                <div class="container nav-wrapper red darken-4">
                    <a href="index.php" class="brand-logo hide-on-small-only">Casalinghi Dalla Luciana</a>
                    <a href="index.php" class="brand-logo center hide-on-med-and-up">Casalinghi</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="#!" id="textToChange3">Prodotti</a></li>
                        <li><a href="#">La nostra storia</a></li>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="index.php">Home</a></li>
                        <li>
                            <a class="red-text"href="#">Prodotti</a>
                            <ul class="back">
                                <?php
                                foreach ($categorie as $c) {
                                    if ($c->getId() == $categoria)
                                        $class = "acive";
                                    else
                                        $class = "";
                                    echo "<li class=\"truncate $class\"><a href=\"prodotti.php?cat=" . $c->getId() . "\">" . $c->getNome() . "</a></li>";
                                }
                                ?>
                            </ul>
                        </li>
                        <li><a href="#">La nostra storia</a></li>
                    </ul>
                </div>
                <div class="container nav-content">
                    <ul class="tabs tabs-transparent">
                        <?php
                        foreach ($categorie as $c) {
                            $class = "";
                            if($categorie[0]->getId() == $c->getId()) {$class = "active";}
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
                        <div id="header" class="col l8 m12 s12 hide-on-small-only">
                            <p id="percorsoText"><a href="index.php">Home</a> / Prodotti / </p>
                            <h3 id="catAttiva" style="margin-top: 3px !important;"></h3>
                            <p id="catAttivaDescr" class="grey-text-2"></p>
                        </div>
                        <div id="headerRicerca" class="col l8 m12 s12">
                            <div class="col s10">
                                <h3 id="ricercaText" style="margin-top: 3px !important;"></h3>
                                <p class="grey-text-2">La ricerca viene effettuata per i nomi delle marche presenti nel negozio</p>
                                <a href="#!" id="ricercaClose"><p>Chiudi</p></a>
                            </div>
                        </div>
                        <div class="col l4 m12 s12 left-align">
                            <form id="search_form">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">search</i>
                                    <input id="ricerca" name="search" type="text">
                                    <label for="ricerca">Cerca fra le nostre marche</label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="ricercaContainer" class="col s12">
                        <div class="col s12">
                            <div id="ricercaContent"></div>
                        </div>
                        <!-- divider -->
                        <div class="col s12">
                            <div class="section"></div>
                            <div class="divider"></div>
                            <div class="section"></div>
                        </div>
                    </div>
                    <div id="content">

                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <a class="btn-floating btn-large grey darker-2 buttonScrollTop tooltipped" data-position="left" data-delay="10" data-tooltip="Torna su">
            <i class="material-icons">arrow_upward</i>
        </a>
        <footer class="page-footer red darken-4">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">Casalinghi Dalla Luciana</h5>
                        <p class="grey-text text-lighten-4">Da oltre quarant'anni soddisfiamo i desideri dei più grandi e dei più piccini</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">Altri contatti</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="#modal1">Inviaci una mail</a></li>
                            <li><a class="grey-text text-lighten-3" target="black" href="https://www.facebook.com/casalinghi.luciana/">Facebook : Casalinghi Dalla Luciana</a></li>
                        </ul>
                    </div>
                    <!-- Modal Structure -->
                    <div id="modal1" class="modal">
                        <div class="modal-content">
                            <h5>Inviaci una mail (casalinghidallaluciana@gmail.com)</h5>
                            <form class="col s12" id="mail_form" method="POST">
                                <div class="row">
                                    <div class="input-field col l6 s12">
                                        <input id="nome" type="text" name="nome">
                                        <label for="nome">Il tuo nome</label>
                                    </div>
                                    <div class="input-field col l6 s12">
                                        <input id="email" type="email" name="email" class="validate">
                                        <label for="email" data-error="Indirizzo mail non valido!">Il tuo indirizzo email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="textarea1" name="text" class="materialize-textarea" maxlength="150" length="150"></textarea>
                                        <label for="textarea1">Testo della mail</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <button type="submit" class="waves-effect btn red darken-4">Invia</button>
                                    </div>
                                    <div class="input-field col s12">
                                        <p id="result_mail"></p>
                                    </div>
                                </div>
                        </div>
                        </form>
                        <div class="modal-footer">
                            <button class="modal-action modal-close waves-effect waves-red btn-flat">Chiudi</button>
                        </div>
                    </div>
                    <!-- /Modal -->		
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
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

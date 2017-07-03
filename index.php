<?php
include('constants.php');
include('class.php');

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$categorie = array();
$query = "SELECT id, nome, immagine FROM CATEGORIE";
$response = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($response)) {
    $categorie[] = Categoria::conIdNomeImmagine($row['id'],$row['nome'],$row['immagine']);
}
?>
<html>
    <head>
        <title>Casalinghi Dalla Luciana</title>
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
    <body link="black" vlink="black" alink="black">
        <div class="navabar-fixed red darken-4">
            <nav class="red darken-4">
                <div class="container nav-wrapper red darken-4">
                    <a href="#!" class="brand-logo hide-on-small-only">Casalinghi Dalla Luciana</a>
                    <a href="#!" class="brand-logo center hide-on-med-and-up">Casalinghi</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li class="active"><a href="#!">Home</a></li>
                        <li><a href="prodotti.php">Prodotti</a></li>
                        <li><a href="info.html">Informazioni</a></li>
                        <li><a href="#">La nostra storia</a></li>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="#!">Home</a></li>
                        <li><a href="prodotti.php">Prodotti</a></li>
                        <li><a href="info.html">Informazioni</a></li>
                        <li><a href="#">La nostra storia</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="parallax-container hide-on-small-only">
            <div class="parallax"><img id="home1" class="responsive-img" src="images/home1.jpg"></div>
        </div>
        <div class="section grey lighten-4">
            <div class="row container">
                <div class="col l12 s12">
                    <h3 class="header center-align">Casalinghi Dalla Luciana</h3>
                </div>
                <div class="col l2 m2">
                    <img id="home1" class="responsive-img hide-on-small-only" src="images/logo.jpg">
                </div>
                <div class="col l10 m10 s12">
                    <p class="grey-text text-darken-3 lighten-3"gksu netbeans>
                        Forte di un’esperienza pluridecennale, Casalinghi dalla Luciana diventa il luogo adatto per trovare tutto ci&ograve; che serve per attrezzare al meglio una cucina efficiente e funzionale, al passo con le esigenze
                        dei moderni cuochi. L’ambiente, a conduzione familiare, &egrave; un luogo accogliente dove ognuno pu&ograve; affidarsi ai nostri premurosi e professionali consigli. Ai futuri sposi, che vogliono predisporre una lista nozze,
                        offriamo un servizio caratterizzato da una particolare attenzione alle esigenze di ogni singola coppia. Viene data completa disponibilità e assistenza nelle loro scelte, anche al di fuori dell’orario di apertura.
                        E’ possibile effettuare lo stoccaggio dei regali e la consegna a domicilio degli stessi. Stessa competenza e professionalità viene messa in gioco nel secondo settore di vendita del negozio: i giochi e giocattoli.
                        Il vasto assortimento di giocattoli renderà felici bambini e bambine di ogni età e anche gli acquirenti pi&ugrave; indecisi troveranno un valido supporto e aiuto per la scelta del regalo pi&ugrave; appropriato.
                    </p>
                    <br>
                </div>
                <div class="col l12 s12">
                    <h3 class="center-align">Scegli fra i nostri prodotti</h3>
                    <?php
                    foreach ($categorie as $c) { 
                        echo "<a href=\"prodotti.php?cat=".$c->getId()."\">
				<div class=\"col l2 m6 s6\">
                                    <img class=\"responsive-img home-img\" id=\"img_giochi\" src=\"images/".$c->getImmagine()."\">
                                    <h6 class=\"center-align\">".$c->getNome()."</h6>
				</div>
                               </a>";
                    }
                    ?>
                    <a href="prodotti.php">
                        <div class="col l2 m6 s6">
                            <img class="home-img responsive-img" src="images/catalogo1.jpg">
                            <h6 class="center-align">Vedi catalogo completo</h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="parallax-container hide-on-small-only">
            <div class="parallax"><img id="home2" class="responsive-img" src="images/home2.jpg"></div>
        </div>
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
                            <li><a class="grey-text text-lighten-3" href="#modal1">Manda una mail</a></li>
                            <li><a class="grey-text text-lighten-3" target="blank" href="https://www.facebook.com/casalinghi.luciana/">Facebook: Casalinghi Dalla Luciana</a></li>
                        </ul>
                    </div>
                    <!-- Modal Structure -->
                    <div id="modal1" class="modal">
                        <div class="modal-content">
                            <h4>Inviaci una mail (casalinghidallaluciana@gmail.com)</h4>
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
?>

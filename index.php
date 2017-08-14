<?php
session_start();
session_unset();

include('constants.php');
include('class.php');

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$categorie = array();
$query = "SELECT id, nome, immagine FROM CATEGORIE";
$response = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($response)) {
    $categorie[] = Categoria::conIdNomeImmagine($row['id'], $row['nome'], $row['immagine']);
}
$news = array();
$query1 = "SELECT id, titolo, descrizione, coloreTesto, immagine"
        . " FROM NEWS "
        . "WHERE dataI < CURRENT_DATE AND dataF > CURRENT_DATE";
$response1 = mysqli_query($db, $query1);
while ($row = mysqli_fetch_assoc($response1)) {
    $news[] = new News($row['id'], $row['titolo'], $row['descrizione'], $row['coloreTesto'],$row['immagine'], null, null);
}
?>
<html>
    <head>
        <title>Casalinghi Dalla Luciana</title>
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
    </head>
    <body>
        <div class="navabar white">
            <nav class="white">
                <div class="container nav-wrapper white">
                    <a href="index.php"><img src="cdl_home.ico" class="ico-home circle hide-on-small-only"></a>
                    <a href="index.php" class="brand-logo hide-on-small-only">Casalinghi Dalla Luciana</a>
                    <a href="index.php" class="brand-logo hide-on-med-and-up">Casalinghi</a>
                    <a href="index.php"><img src="cdl_home.ico" class="ico-home circle right hide-on-med-and-up"></a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li class="active"><a href="#!">Home</a></li>
                        <li><a href="prodotti.php">Prodotti</a></li>
                        <li><a href="#">La nostra storia</a></li>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="#!">Home</a></li>
                        <li><a href="prodotti.php">Prodotti</a></li>
                        <li><a href="#">La nostra storia</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="parallax-container hide-on-med-and-down">
            <div class="parallax"><img id="home1" class="responsive-img" src="images/home1.jpg"></div>
        </div>
        <div class="section">
            <div class="row container">   
                <!-- Paragrafo #0 -->
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">In primo piano</h4>
                    <div class="slider">
                        <ul class="slides">
                            <?php 
                            foreach ($news as $n) {
                                $color = $n->getColoreTesto();
                                echo "<li>
                                    <img  src='images/" . $n->getImmagine() . "'>
                                    <div class='caption right-align'>
                                    <h3 class='$color'>" . $n->getTitolo() . "</h3>
                                    <h5 class='$color'>" . $n->getDescrizione() . "</h5>
                                    </div>
                                    </li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- Paragrafo #1 -->
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">I nostri punti di forza</h4>
                    <!-- storia -->
                    <div class="col l4 m4 s12">
                        <div class="col s12 center-align">
                            <img class="responsive-img circle" width="180px" src="images/placeholder.png">
                        </div> 
                        <div class="col s12 center-align">
                            <h5>Esperienza</h5>
                        </div>       
                        <div class="col s12 left-align">
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque luctus neque risus. 
                                Mauris efficitur ex urna, vel ornare ante suscipit sit amet. 
                                Etiam aliquam justo odio, a mollis ex dapibus non.
                            </p>
                        </div>  
                    </div>
                    <!-- accoglienza -->
                    <div class="col l4 m4 s12">
                        <div class="col s12 center-align">
                            <img class="responsive-img circle" width="180px" src="images/house.jpg">
                        </div> 
                        <div class="col s12 center-align">
                            <h5>Attenzione al cliente</h5>
                        </div>       
                        <div class="col s12 left-align">
                            <p>L’ambiente, a conduzione familiare, &egrave; un luogo accogliente dove ognuno pu&ograve; affidarsi ai nostri premurosi e professionali consigli.</p>
                        </div>  
                    </div>
                    <!-- vasto assortimento -->
                    <div class="col l4 m4 s12">
                        <div class="col s12 center-align">
                            <img class="responsive-img circle" width="180px" src="images/boy&girl.jpg">
                        </div> 
                        <div class="col s12 center-align">
                            <h5>Vasto assortimento</h5>
                        </div>       
                        <div class="col s12 left-align">
                            <p>
                                Il vasto assortimento di giocattoli renderà felici bambini 
                                e bambine di ogni età e anche gli acquirenti pi&ugrave; 
                                indecisi troveranno un valido supporto e 
                                aiuto per la scelta del regalo pi&ugrave; appropriato.
                            </p>
                        </div>  
                    </div>                    
                </div>
                <!-- Paragrafo #2 -->
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">I nostri prodotti</h4>
                    <?php
                    foreach ($categorie as $c) {
                        echo '<a href="prodotti.php"><div class="col l4 m6 s12 catalogo-container">
                                <div class="col s12 center-align">
                                <img class="responsive-img circle" width="180px" src="images/' . $c->getImmagine() . '">
                                </div> 
                                <div class="col s12 center-align">
                                    <p class="flow-text">' . $c->getNome() . '</p>
                                </div> 
                             </div></a>';
                    }
                    ?>                    
                </div>
                <!-- Paragrafo #3 -->
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">Informazioni</h4>
                    <div class="row">
                        <div class="col s12">
                            <p class="title-prodotti no-padd">Dove trovarci</p>
                        </div>
                        <div class="col l8 m7 s12">
                            <a target="blank" href="https://www.google.it/maps/place/Casalinghi+Dalla+Luciana/@45.424989,11.8903645,17z/data=!3m1!4b1!4m5!3m4!1s0x477eda62c976263b:0xb3095876f1e71eb2!8m2!3d45.424989!4d11.8925585">
                                <img class="responsive-img" src="images/mappa3.png">
                            </a>
                        </div>
                        <div class="col l4 m5 s12">
                            <a target="blank" href="https://www.google.it/maps/place/Casalinghi+Dalla+Luciana/@45.424989,11.8903645,17z/data=!3m1!4b1!4m5!3m4!1s0x477eda62c976263b:0xb3095876f1e71eb2!8m2!3d45.424989!4d11.8925585">
                                <p><i class="material-icons">directions</i> via Tiziano Vecellio, 38</p>
                            </a>
                            <p><i class="material-icons">place</i> Padova</p>
                        </div> 
                    </div>
                    <div class="col l12 m12 s12">
                        <p class="title-prodotti no-padd">Orari - 
                            <span class="green-text text-darken-1" id="orarioA">ora aperto</span> 
                            <span class="red-text text-darken-1" id="orarioC">ora chiuso</span>
                        </p>
                        <p id="orarioDiff"></p>
                    </div>
                    <div class="col l8 m12 s12">
                        <div id="divOrari" class="hide-on-med-and-up"></div>
                        <table class="highlight hide-on-small-and-down">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Mattina</th>
                                    <th>Pomeriggio</th>
                                </tr>
                            </thead>
                            <tbody id="tabellaOrari"></tbody>
                        </table>
                    </div>
                </div>
                <!-- Paragrafo #4 -->
                <div id="mail_" class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">Contatti</h4>
                    <div class="row">
                        <div class="col l8 m12 s12">
                            <p class="title-prodotti truncate">Inviaci una mail (casalinghidallaluciana@gmail.com)</p>
                            <form id="mail_form" method="POST">
                                <div class="row">
                                    <div class="input-field col l6 s12">
                                        <input  id="nome" type="text" name="nome">
                                        <label for="nome">Il tuo nome</label>
                                    </div>
                                    <div class="input-field col l6 s12">
                                        <input  id="email" type="email" name="email" class="validate">
                                        <label for="email" data-error="Indirizzo mail non valido!">Il tuo indirizzo email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="textarea1" name="text" class="materialize-textarea" maxlength="250" length="250"></textarea>
                                        <label for="textarea1">Testo della mail</label>
                                    </div>
                                    <div class="input-field col l6 m8 s8">
                                        <p id="result_mail_success" class="green-text text-darken-2" >Mail inviata.</p>
                                        <p id="result_mail_failed" class="red-text text-darken-2">Errore! Mail non inviata.</p>
                                    </div>
                                    <div class="input-field col l6 m4 s4 right-align">
                                        <button type="submit" class="waves-effect btn red darken-4">Invia</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col l4 m12 s12">
                            <p class="title-prodotti">Chiamaci</p>
                            <p><a href="tel:+39049604890"><i class="material-icons">phone</i> 049 604890</a></p>
                            <p class="title-prodotti">Seguici su Facebook</p>
                            <p><a target="blank" href="https://www.facebook.com/casalinghi.luciana/"><span><img style="vertical-align: middle !important;" src="images/facebook_ico.jpg" height="24px"></span>  @casalinghi.luciana</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax-container hide-on-med-and-down">
            <div class="parallax"><img id="home2" class="responsive-img" src="images/home2.jpg"></div>
        </div>
        <footer class="page-footer grey lighten-3">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5>Casalinghi Dalla Luciana</h5>
                        <p>Da oltre quarant'anni soddisfiamo i desideri dei più grandi e dei più piccini</p>
                        <p><a href="#!" id="cp_trigger">Panello di gestione</a></p>
                    </div>	
                    <div class="col l6 s12">
                        <form id="cp_form" action="cp/index.php" method="POST">
                            <div class="input-field col s12">
                                <h5>Login</h5>
                            </div>
                            <div class="input-field col l5 m5 s12">
                                <input name="user" id="user" type="text">
                                <label for="user">Username</label>
                            </div>
                            <div class="input-field col l5 m5 s12">
                                <input name="pssw" id="pssw" type="password">
                                <label for="pssw">Password</label>
                            </div>
                            <div class="input-field col l2 m2 s12 right-align">
                                <button type="submit" class="btn-flat"><i class="material-icons">arrow_forward</i></button>
                            </div>
                        </form>
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
        <script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" charset="UTF-8" src="js/materialize.min.js"></script>
        <script type="text/javascript" charset="UTF-8"v src="js/main_script.js"></script>
    </body>
</html>
<?php
// Close the connection
mysqli_close($db);

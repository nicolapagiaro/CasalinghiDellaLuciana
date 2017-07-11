<?php
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
        <div class="navabar red darken-4">
            <nav class="red darken-4">
                <div class="container nav-wrapper red darken-4">
                    <a href="#!" class="brand-logo hide-on-small-only">Casalinghi Dalla Luciana</a>
                    <a href="#!" class="brand-logo center hide-on-med-and-up">Casalinghi</a>
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
        <div class="parallax-container hide-on-small-only">
            <div class="parallax"><img id="home1" class="responsive-img" src="images/home1.jpg"></div>
        </div>
        <div class="section">
            <div class="row container">                
                <!-- Paragrafo #1 -->
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">I nostri punti di forza</h4>
                    <!-- luogo accogliente -->
                    <div class="col l4 m4 s12">
                        <div class="col s12 center-align">
                            <img class="responsive-img circle" width="180px" src="images/house.jpg">
                        </div> 
                        <div class="col s12 center-align">
                            <h5>Luogo accogliente</h5>
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
                    <!-- lista nozze -->
                    <div class="col l4 m4 s12">
                        <div class="col s12 center-align">
                            <img class="responsive-img circle" width="180px" src="images/wedding.jpg">
                        </div> 
                        <div class="col s12 center-align">
                            <h5>Lista nozze</h5>
                        </div>       
                        <div class="col s12 left-align">
                            <p>Ai futuri sposi, che vogliono predisporre una lista nozze,
                                offriamo un servizio caratterizzato da una particolare attenzione alle esigenze di ogni singola coppia.
                            </p>
                        </div>  
                    </div>
                </div>
                <!-- Paragrafo #2 -->
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">I nostri prodotti</h4>
                    <?php
                    foreach ($categorie as $c) {
                        echo '<div class="col l4 m6 s12">
                                <div class="col s12 center-align">
                                <img class="responsive-img circle" width="180px" src="images/' . $c->getImmagine() . '">
                                </div> 
                                <div class="col s12 center-align">
                                    <p class="flow-text">' . $c->getNome() . '</p>
                                </div> 
                             </div>';
                    }
                    ?>
                    <a href="prodotti.php">
                        <div class="col l4 m6 s12 catalogo-container">
                            <div class="col s12 center-align">
                                <img class="responsive-img circle" width="180px" src="images/catalogo1.jpg">
                            </div> 
                            <div class="col s12 center-align">
                                <p class="flow-text">Vedo il catalogo completo</p>
                            </div>  
                        </div>
                    </a>
                </div>
                <!-- Paragrafo #3 -->
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">Informazioni</h4>
                    <div class="row">
                        <div class="col s12">
                            <p class="title-prodotti no-padd">Dove trovarci</p>
                        </div>
                        <div class="col l8 m6 s12">
                            <a target="blank" href="https://www.google.it/maps/place/Casalinghi+Dalla+Luciana/@45.424989,11.8903645,17z/data=!3m1!4b1!4m5!3m4!1s0x477eda62c976263b:0xb3095876f1e71eb2!8m2!3d45.424989!4d11.8925585">
                                <img class="responsive-img hide-on-small-only" src="images/mappa3.png">
                            </a>
                        </div>
                        <div class="col l4 m6 s12">
                            <a target="blank" href="https://www.google.it/maps/place/Casalinghi+Dalla+Luciana/@45.424989,11.8903645,17z/data=!3m1!4b1!4m5!3m4!1s0x477eda62c976263b:0xb3095876f1e71eb2!8m2!3d45.424989!4d11.8925585">
                                <p><i class="material-icons">directions</i> via Tiziano Vecellio, 38</p>
                            </a>
                            <p><i class="material-icons">place</i> Padova</p>
                        </div>  
                    </div>
                    <p class="title-prodotti no-padd">Orari</p>
                    <div class="col l8 m12 s12">
                        <div id="divOrari" class="hide-on-large-only"></div>
                        <table class="highlight hide-on-med-and-down">
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
                <div class="col l12 s12">
                    <h4 class="left-align red-text text-darken-4">Contattaci</h4>
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
                                        <textarea id="textarea1" name="text" class="materialize-textarea" maxlength="150" length="150"></textarea>
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
                            <p class="title-prodotti">Chiamaci:</p>
                            <p><i class="material-icons">phone</i> 049 604890</p>
                        </div>
                    </div>
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
                            <li><a class="grey-text text-lighten-3" target="blank" href="https://www.facebook.com/casalinghi.luciana/">Facebook: Casalinghi Dalla Luciana</a></li>
                        </ul>
                    </div>	
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

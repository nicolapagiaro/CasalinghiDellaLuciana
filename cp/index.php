<?php
include('../constants.php');
include('../class.php');
session_start();
session_unset();
$db = mysqli_connect(HOST, USER, PASSW, DB) or die("Errore nella connessione");
/**if(!isset($_SESSION['user'])) {
  $u = trim($_POST['user']);
  $p = sha1(trim($_POST['pssw']));
  $loginQuery = "SELECT * FROM ADMIN WHERE username = '$u' AND passw = '$p'";
  $res = mysqli_query($db, $loginQuery);
  if(mysqli_num_rows($res) === 1) { $_SESSION['user'] = $u; }
  else { header('Location: ../index.php'); }
  } */

$categorie = array();

// raccolgo le informazioni su tutte le marche del db
$queryCategorie = "SELECT id, nome FROM CATEGORIE";
$resCategorie = mysqli_query($db, $queryCategorie);
while ($row = mysqli_fetch_assoc($resCategorie)) {
    $categorie[] = Categoria::conIdNome($row['id'], $row['nome']);
}
foreach ($categorie as $c) {
    $marche = array();
    $queryMarche = "SELECT id, nome FROM MARCHE WHERE categoria = " . $c->getId();
    $resMarche = mysqli_query($db, $queryMarche);
    while ($row = mysqli_fetch_assoc($resMarche)) {
        $marche[] = Marca::conIdNome($row['id'], $row['nome']);
    }
    $c->setMarche($marche);
}
$news = array();
$query1 = "SELECT *"
        . " FROM NEWS "
        . "WHERE dataI < CURRENT_DATE AND dataF > CURRENT_DATE";
$response1 = mysqli_query($db, $query1);
while ($row = mysqli_fetch_assoc($response1)) {
    $news[] = new News($row['id'], $row['titolo'], $row['descrizione'], $row['coloreTesto'], $row['immagine'], $row['dataI'], $row['dataF']);
}
?>
<html>
    <head>
        <title>Pannello di gestione</title>
        <!-- Icona -->
        <link rel="icon" href="ico.png"/>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/cp_maincss.css"/>
        <link type="text/css" rel="stylesheet" href="../css/maincss.css"/>
    </head>
    <body>
        <div class="navabar white">
            <nav class="white">
                <div class="container nav-wrapper white">
                    <img src="../cdl_home.ico" class="ico-home circle hide-on-small-only">
                    <a class="brand-logo hide-on-small-only">Pannello di gestione</a>
                    <ul class="right hide-on-med-and-down">
                        <li class="active"><a href="#!">@<?php echo "paola" ?></a></li>
                        <li><a href="../index.php">Torna al sito</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <br>
        <div class="container">
            <!-- NOTIZIE -->
            <div class="col l12">
                <h4>In primo piano</h4>
                <div class="row">
                    <?php
                    $i = 1;
                    foreach ($news as $n) {
                        setlocale(LC_ALL, 'it_IT.UTF-8');
                        echo "<div id='news" . $n->getId() . "'><div class='col l1 center-align'>
                                <p>#" . $i . "</p>
                             </div>
                            <div class='col l1'>
                                <br>
                                <img  src='../images/" . $n->getImmagine() . "' class='responsive-img'>
                            </div>
                            <div class='col l6'>
                                <p><b>" . $n->getTitolo() . "</b></p>
                                <p>" . $n->getDescrizione() . "</p>
                                <p><a class='link' onclick='eliminaNews(" . $n->getId() . ", \"news" . $n->getId() . "\")'  href='#!'>Elimina</a></p>
                            </div>
                            <div class='col l4'>
                                <p>Da : " . strftime ("%d, %B %Y", strtotime($n->getDataI())) . "</p>
                                <p>A : " . strftime ("%d, %B %Y", strtotime($n->getDataF())) . "</p>
                            </div>
                            <div class='divider col l12'></div></div>";
                        $i++;
                    }
                    if(count($news)  === 0) {
                        echo "<div class='col l12'><p>Nessuna news presente</p></div>";
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col l12"><p class="scritte">Aggiungi</p></div>
                    <div class="col l6">
                        <!-- Titolo  news -->
                        <div class="input-field">
                            <input id="titoloN" type="text" maxlength="255" length="255">
                            <label for="titoloN">Titolo</label>
                        </div>
                        <!-- Descrizione news -->
                        <div class="input-field">
                            <textarea id="descrN" type="text" class="materialize-textarea" maxlength="255" length="255"></textarea>
                            <label for="descrN">Descrizione</label>
                        </div>
                        <!-- Colore testo -->
                        <form action="#">
                            <p>Colore del testo</p>
                            <p>
                                <input name="group1" type="radio" id="whiteT" />
                                <label for="whiteT">Bianco</label>
                            </p>
                            <p>
                                <input name="group1" type="radio" id="darkT" />
                                <label for="darkT">Nero</label>
                            </p>
                        </form>
                        <!-- Nome marca -->
                        <div class="input-field">
                            <input type="text" id="dataI" class="datepicker">
                            <label for="dataI">Da:</label>
                        </div>
                        <!-- Descrizione marca -->
                        <div class="input-field">
                            <input type="text" id="dataF" class="datepicker">
                            <label for="dataF">A:</label>
                        </div>
                    </div>
                    <div class="col l6">
                        <!-- Aggiungi immagine -->
                        <p>Inserisci immagine</p>
                        <form name="imgUploadNews" action="#" method="POST">
                            <div class="file-field input-field">
                                <div class="btn red darken-4">
                                    <span>File</span>
                                    <input type="file" id="userImageNews" name="img" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path" type="text">
                                </div>
                            </div>
                        </form>
                        <div class="center">
                            <img src="" alt="Immagine" class="responsive-img">
                        </div>
                    </div>
                    <!-- bottone form -->
                    <div class="col l12 right-align">
                        <br><br>
                        <button type="submit" id="submit_btn3" class="red darken-4 btn" value="salva"><i class="material-icons right">save</i>Salva</button>
                    </div>
                </div>
            </div>
            <!-- PRODOTTI 
            <div class="col l12">
                <h4>Marche</h4>
                <div class="row">
                    <div class="input-field col s6">
                        <select id="marcheSelect">
                            <option value="default">Seleziona una marca...</option>

                            <?php/*
                            foreach ($categorie as $c) {
                                echo "<optgroup label='" . $c->getNome() . "'>";
                                foreach ($c->getMarche() as $m) {
                                    echo "<option value='" . $m->getId() . "'>" . $m->getNome() . "</option>";
                                }
                                echo "</optgroup>";*/
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col l12 divider"></div>
                <div class="row">
                    <div class="col l6">
                        <!-- Nome marca 
                        <div class="input-field">
                            <input id="nomeP" type="text" maxlength="25" length="25">
                            <label for="name">Nome</label>
                        </div>
                        <!-- Descrizione marca 
                        <div class="input-field">
                            <textarea id="descrP" type="text" class="materialize-textarea" maxlength="255" length="255"></textarea>
                            <label for="descrP">Descrizione</label>
                        </div>
                        <!-- eta marca 
                        <div class="input-field">
                            <input id="etaP" type="text" maxlength="30" length="30">
                            <label for="etaP">Eta</label>
                        </div>
                        <p>Aggiungi immagine</p>
                        <form name="imgUpload" action="#" method="POST">
                            <div class="file-field input-field">
                                <div class="btn red darken-4">
                                    <span>File</span>
                                    <input type="file" id="userImage" name="img" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path" type="text">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- sezione immagini 
                    <div class="col l6 center-align">
                        <p class="scritte">Immagine di default</p>
                        <div id="default_img"></div>
                    </div>
                    <div class="col l12">
                        <br>
                        <!-- lista immagini
                        <p class="scritte">Immagini</p>
                        <p class="red-text text-darken-4">Attenzione! Se viene eliminata una foto che &egrave; anche foto di default della marca occorrer&agrave; impostarne un'altra
                            per evitare problemi di visualizzazione.</p>
                        <div id="images_holder"></div>
                    </div>

                    <!-- bottone form
                    <div class="col l12 right-align">
                        <br><br>
                        <button type="submit" id="submit_btn1" class="red darken-4 btn" value="salva"><i class="material-icons right">save</i>Salva</button>
                    </div>
                </div>
            </div>-->
            <!-- CATEGORIE -->
            <div class="col l12">
                <h4>Categorie</h4>
                <div class="row">
                    <div class="input-field col s6">
                        <select id="categorieSelect">
                            <option value="default">Seleziona una categoria...</option>
                            <?php
                            foreach ($categorie as $c) {
                                echo "<option value='" . $c->getId() . "'>" . $c->getNome() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col l12 divider"></div>
                <div class="row">
                    <div class="col l6">
                        <!-- Nome categoria -->
                        <div class="input-field">
                            <input id="nomeC" type="text" maxlength="25" length="25">
                            <label for="nomeC">Nome</label>
                        </div>
                        <!-- Descrizione categoria -->
                        <div class="input-field">
                            <textarea id="descrC" type="text" class="materialize-textarea" maxlength="255" length="255"></textarea>
                            <label for="descrC">Descrizione</label>
                        </div>
                        <!-- eta cat -->
                        <div class="input-field">
                            <input id="etaC" type="text" maxlength="255" length="255">
                            <label for="etaC">Eta</label>
                        </div>
                        <p>Cambia immagine di default</p>
                        <form name="imgUploadCat" action="#" method="POST">
                            <div class="file-field input-field">
                                <div class="btn red darken-4">
                                    <span>File</span>
                                    <input type="file" id="userImageCat" name="img" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path" type="text">
                                </div>
                            </div>
                        </form>
                        <p class="red-text text-darken-4">&Egrave; consigliato un'immagine quadrata per una migliore visualizzazione.</p>
                        <p>Aggiungi immagini</p>
                        <form name="imgUpload" action="#" method="POST">
                            <div class="file-field input-field">
                                <div class="btn red darken-4">
                                    <span>File</span>
                                    <input type="file" id="userImage" name="img" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path" type="text">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- sezione immagini -->
                    <div class="col l6 center-align">
                        <p class="scritte">Immagine</p>
                        <div id="img_cat"></div>
                    </div>
                    
                    <div class="col l12">
                        <br>
                        <!-- lista immagini -->
                        <p class="scritte">Immagini</p>
                        <p class="red-text text-darken-4">Attenzione! Sono consigliate immagini in 16:9</p>
                        <div id="images_holder"></div>
                    </div>

                    <!-- bottone form -->
                    <div class="col l12 right-align">
                        <br><br>
                        <button type="submit" id="submit_btn2" class="red darken-4 btn" value="salva"><i class="material-icons right">save</i>Salva</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
        <script type="text/javascript" src="js/cp_mainscript.js"></script>
    </body>
</html>

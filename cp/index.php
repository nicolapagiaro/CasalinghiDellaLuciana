<?php
  include('../constants.php');
  session_start();
  
  //if(!(isset($_SESSION['admin'])))
  	//header("Location: index.php");
  	//connection to the database
  $db = mysqli_connect(HOST, USER, PASSW, DB);
  
  // Check connection
  if(!$db)
  	die("Errore nella connessione");
  	
  $categorie = array();
  $queryCat = "SELECT id, descrizione
				FROM CATEGORIE";
  $resCat = mysqli_query($db, $queryCat);
  $i=0;
  while($row = mysqli_fetch_array($resCat, MYSQLI_NUM)) {
  	$categorie[$i] = $row[0]."|".$row[1];
  	$i++;		
  }
  ?>
<html>
  <head>
    <title>Pannello di controllo</title>
    <!-- Icona -->
    <link rel="icon" href="favicon.ico"/>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/maincss.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <style>
	.imgContainer {
		border: 2px solid red;
		border-radius:10px;
	}
  </style>
  <body>
    <div class="navabar-fixed">
      <nav>
        <div class="nav-wrapper red darken-4">
          <a href="controlPanel.php" class="brand-logo hide-on-small-only">Pannello di controllo</a>
          <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="../index.php">Torna al sito</a></li>
          </ul>
        </div>
      </nav>
    </div>
    <br>
    <div class="container">
      <div class="row">
        <!--categorie-->
        <div class="col l12">
          <h5 class="center-align">Categorie</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="input-field col s6">
                  <select id="categorieSelect">
                    <option value="" disabled selected>Seleziona...</option>
                    <?php
						foreach ($categorie as $c) {
							$s = explode("|", $c);
							echo "<option value=\"$s[0]\">$s[1]</option>";
						}
                    ?>
                  </select>
                  <label>Categoria</label>
                </div>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col l6">
                  <!-- Nome categoria -->
                  <div class="input-field col s12">
                    <input id="nomeC" type="text" maxlength="255" length="255">
                    <label class="active" for="nomeC">Nome</label>
                  </div>
                  <!-- descrizione categoria -->
                  <div class="input-field col s12">
                    <textarea id="descrC" type="text" class="materialize-textarea" maxlength="255" length="255"></textarea>
                    <label class="active" for="descrC">Descrizione</label>
                  </div>
                  <!-- immagine categoria -->
                  <form name="imgCategoriaUpload">
					  <div class="file-field input-field col s12">
						  <div class="btn red darken-2">
							<span>Immagine</span>
							<input id="imageUpoad" name="imageCat" type="file" accept="image/*">
						  </div>
						  <div class="file-path-wrapper">
							<input class="file-path" type="text">
						  </div>
					  </div>
				  </form>
                </div>
                <!-- sezione immagine default -->
                <div class="col l6 center">
					<br>
					<div class="col l8 push-l2 imgContainer">
						<img id="imgC" src="" class="responsive-img materialboxed">
						<p id="imageC" class="center-align"></p>
					</div>
                </div>
                <!-- bottone form -->
                <div class="col l12 right-align">
                  <br><br>
                  <button type="submit" id="salvaCat" class="waves-effect waves-light red darken-2 btn" value="salva"><i class="material-icons right">save</i>Salva</input>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!--prodotti-->
      <div class="col l12" id="sezioneModifiche">
        <h5 class="center-align">Prodotti</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
                <div class="input-field col s6">
                  <select id="prodottiSelect">
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
				</select>
				<label>Prodotti</label>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row">
              <div class="col l6">
                <!-- Nome marca -->
                <div class="input-field col s12">
                  <input id="nomeP" type="text" maxlength="25" length="25">
                  <label class="active" for="name">Nome</label>
                </div>
                <!-- Descrizione marca -->
                <div class="input-field col s12">
                  <textarea id="descrP" type="text" class="materialize-textarea" maxlength="255" length="255"></textarea>
                  <label class="active" for="descrP">Descrizione</label>
                </div>
              </div>
              <!-- sezione immagini -->
              <div class="col l6">
                <!-- lista immagini-->
                <div id="image_holder">
                </div>
                <!-- aggiungi immagini-->
                <div class="col s12 right-align">
                </div>
              </div>
              <!-- bottone form -->
              <div class="col l12 right-align">
                <br><br>
                <button type="submit" class="waves-effect waves-light red darken-2 btn" value="salva"><i class="material-icons right">save</i>Salva</input>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="page-footer red darken-4">
      <div class="container">
        <div class="row">
          <div class="col l6 s12">
            <h5 class="white-text">Casalinghi Dalla Luciana</h5>
            <p class="grey-text text-lighten-4">Da oltre quarant'anni soddisfiamo i desideri dei più grandi e dei più piccini</p>
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
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script type="text/javascript" src="js/controlPanel_script.js"></script>
  </body>
</html>

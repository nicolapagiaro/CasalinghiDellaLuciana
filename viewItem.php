<?php
	include('constants.php');
	
	if(!isset($_GET['prod']))
		$idProdotto = 1; //cambiare
	else	
		$idProdotto = $_GET['prod'];
		
	//connection to the database
	$db = mysqli_connect(HOST, USER, PASSW, DB);
	
	// Check connection
	if(!$db)
		die("Errore nella connessione");
	
	$queryProd = "SELECT M.nome, M.descrizione, M.defaultImg, C.descrizione
				  FROM MARCHE M, CATEGORIE C 
				  WHERE M.id = '$idProdotto' AND M.categoria = C.id";
	$resultProd = mysqli_query($db, $queryProd);
	if($row = mysqli_fetch_array($resultProd, MYSQLI_NUM)) {
		$cat = $row[3];
		$nome = $row[0];
		$descr = $row[1];
		$df_img = $row[2];
	}
	else {
		$nome = "";
		$descr = "";
		$df_img = "";
	}
	
	$queryImg = "SELECT id, immagine
				  FROM FOTO
				  WHERE marca = '$idProdotto'";
	$resultImg = mysqli_query($db, $queryImg);
?>
<html>
<head>
  <title>Bruder - Casalinghi Dalla Luciana</title>
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
  <div class="navabar-fixed">
  <nav>
    <div class="nav-wrapper red darken-4">
    <a href="index.php" class="brand-logo hide-on-small-only">Casalinghi Dalla Luciana</a>
    <a href="index.php" class="brand-logo center hide-on-med-and-up">Casalinghi</a>
    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
    <ul class="right hide-on-med-and-down">
		<li><a href="index.php">Home</a></li>
		<li class="active"><a href="prodotti.php">Prodotti</a></li>
		<li><a href="info.html">Informazioni</a></li>
		<li><a href="#">La nostra storia</a></li>
    </ul>
    <ul class="side-nav" id="mobile-demo">
		<li><a href="index.php">Home</a></li>
        <li class="active"><a href="prodotti.php">Prodotti</a></li>
		<li><a href="info.html">Informazioni</a></li>
		<li><a href="#">La nostra storia</a></li>
      </ul>
    </div>
  </nav>
  </div>
  <br>
  <div class="container">
	  <div class="row">
		  <div class="col l6 m6 s12">
			<p>Home / <a href="prodotti.php">Prodotti</a> / <a href="prodotti.php?s=0"><?php echo $cat?></a> / <b><?php echo $nome?></b></p>
		  </div>
		  <div class="col s6 hide-on-small-only">
			<a class="right-align" href="prodotti.php?s=0"><p>Indietro</p></a>
		  </div>
		  <div class="col l6 m12 s12">
			  <div class="card">
                <div class="card-content">
					<div class="row">
						<div class="col l12 m12 s12">
							<img id="imageBig" class="materialboxed responsive-img" src="images/<?php echo $df_img?>">
						</div>
						<div class="col l12 m12 s12">
							<ul>
								<li class="divider"></li>
							</ul>
						</div>
						<div class="col l12 m12 s12 hide-on-med-and-up">
							<div class="col s6 left-align">
								<button class="btn-flat wawes-effect">Indietro</button>
							</div>
							<div class="col s6 right-align">
								<button class="btn-flat wawes-effect">Avanti</button>
							</div>
						</div>
						<div class="col l12 m12 s12 hide-on-small-only">
							<a onclick="changeImage('img0')">
								<div class="col l3">
									<img id="img0" class="responsive-img selected-image" src="images/<?php echo $df_img?>">
								</div>
						    </a>
						    <?php
								while($row = mysqli_fetch_array($resultImg, MYSQLI_NUM)) {
									echo "<a onclick=\"changeImage('img".$row[0]."')\">
											<div class=\"col l3\">
												<img id=\"img".$row[0]."\"class=\"responsive-img unselected-image\" src=\"images/$row[1]\">
											</div>
										  </a>";
								}
						    ?>
						</div>
					</div>
                </div>
             </div>
		  </div>
		  <div class="col l6 m12 s12">
			  <div class="card">
                <div class="card-content">
					<div class="row">
						<div class="col l12 m12 s12">
							<h5><?php echo $nome?></h5>
						</div>
						<div class="col l12 m12 s12">
							<ul>
								<li class="divider"></li>
							</ul>
						</div>
						<div class="col l12 m12 s12">
							<p><?php echo $descr?></p>
						</div>
					</div>
                </div>
             </div>
		  </div>
		  <div class="col l12 m12 s12">
			  <div class="card">				      
				<div class="card-content">
					<span class="card-title">Marche consigliate</span>        
					<div class="row">
						<div class="col l12 m12 s12">
							<div class="col l3 m12 s12">
								<p>Descrizione del prodotto bla bla bla bla</p>
							</div>
							<div class="col l3 m12 s12">
								<p>Descrizione del prodotto bla bla bla bla</p>
							</div>
						</div>
					</div>
                </div>
             </div>
		  </div>
	  </div>
  </div>
  <br><br>
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
                  <li><a class="grey-text text-lighten-3" href="#modal1">Email: casalinghidallaluciana@gmail.com</a></li>
                  <li><a class="grey-text text-lighten-3" target="black" href="https://www.facebook.com/casalinghi.luciana/">Facebook : Casalinghi Dalla Luciana</a></li>
                </ul>
              </div>
			  <!-- Modal Structure -->
			  <div id="modal1" class="modal">
				  <div class="modal-content">
				  <h4>Inviaci una mail</h4>
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

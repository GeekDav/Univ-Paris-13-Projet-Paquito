<?php 
//si pas connecté
  session_start();
 if (!isset($_SESSION['email']) ||  !isset($_SESSION['admin'])) {
    ?>
    <script type="text/javascript">
      alert("Veuillez dabord vous connecter");
    </script>
    <?php
    header('Location: index.php'); 
 }
?>

<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="row" style="background-color: #5bc0de;">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <a href="index.php"><h1 class="text-primary">Paquito</h1></a>
          </div>
          <div class="col-md-3">
            <div>
              <br>
            </div>
          </div>
          <div class="col-md-5 text-right">
            <div>
              <br>
              <?php echo $_SESSION['email']; ?>
            </div>
          </div>
          <div class="col-md-1">
            <div>
              <br>
            </div>
            <a href="deconnexion.php" class="btn btn-primary">déconnexion</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12"></div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <fieldset class="col-md-12">
              <legend>
                <h1 class="text-center">Projets</h1>
              </legend>
              <a href="creation_script.php">
                <button class="btn btn-primary" type="button" onclick="" id="bt" <?php if($_SESSION['admin'] == 0){echo "disabled";}?> >
                  ajouter un projet
                </button></br></br>
              </a>
              <?php
                include 'fonctions/connexion.php';

                            /******************load first level of configuration file **************************/
                            $Configuration = $dbh->query('SELECT IdConfigurationFile,Name, Version,Homepage,Summary,Description,Copyright,Maintainer 
                                                          FROM configurationfile');
                            while($row=$Configuration->fetch()){
                                ?>
                                <fieldset class="col-md-12">
                                  <legend><?php echo htmlspecialchars($row['Name']);?></legend>
                                  <div class="row">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-primary">Télécharger</button>
                                      <button type="button" class="btn btn-primary" <?php if($_SESSION['admin'] == 0){echo "disabled";}?> >telecharger fichier config</button>
                                      <button type="button" class="btn btn-primary" <?php if($_SESSION['admin'] == 0){echo "disabled";}?> >supprimer le projet</button> 
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">Version : </div>
                                    <div class="col-md-8"><?php echo htmlspecialchars($row['Version']);?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">Homepage : </div>
                                    <div class="col-md-8"><?php echo htmlspecialchars($row['Homepage']);?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">Resumé</div>
                                    <div class="col-md-8"><p><?php echo htmlspecialchars($row['Summary']);?></p></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">Description</div>
                                    <div class="col-md-8"><p><?php echo htmlspecialchars($row['Description']);?></p></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">Maintainer</div>
                                    <div class="col-md-8"><p><?php echo htmlspecialchars($row['Maintainer']);?></p></div>
                                  </div>
                                </fieldset>
                            <?php
                            }
                  $Configuration->closeCursor(); 
              ?>  
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <br>
            <p>@copyright</p>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  

</body></html>
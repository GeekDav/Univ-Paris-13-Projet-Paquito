<?php 
//si déjà pas connecté
  session_start();
 if (isset($_SESSION['email']) &&  isset($_SESSION['admin'])) {
    ?>
    <script type="text/javascript">
      alert("vous étes déjà connecté");
    </script>
    <?php
    header('Location: main_page.php'); 
 }
?>
<!-- CODE HTML -->

<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  </head><body>
    <div class="row" style="background-color: #5bc0de;">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <h1 class="text-primary">Paquito</h1>
          </div>
          <div class="col-md-5 col-md-offset-2">
            <div>
              <br>
            </div>
            <form method="post" role="form" class="form-inline form-search" action="verification_connexion.php">
              <div class="form-group">
                <input class="form-control" name="email" id="email" placeholder="Entrer email" type="email" required>
              </div>
              <div class="form-group">
                <input class="form-control input-medium search-query" name="mdp" id="mdp" placeholder="mot de passe" type="password" required>
              </div>
              <!--<button type="submit" class="btn btn-default" id="connexion">connexion</button> ne marche pas-->
              <input type="submit" name="connexion" value="connexion" class="btn btn-primary">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div id="carousel-example" data-interval="false" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="item active">
                  <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png">
                  <div class="carousel-caption">
                    <h2>Title</h2>
                    <p>Description</p>
                  </div>
                </div>
              </div>
              <a class="left carousel-control" href="#carousel-example" data-slide="prev"><i class="icon-prev  fa fa-angle-left"></i></a>
              <a class="right carousel-control" href="#carousel-example" data-slide="next"><i class="icon-next fa fa-angle-right"></i></a>
            </div>
          </div>
          <div class="col-md-6">
            <div>
              <br>
              <br>
              <br>
              <br>
              <br>
            </div>
            <form  method="post" class="form-horizontal centered col-md-10 col-md-offset-1" role="form" action="verification_inscription.php">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="inputEmail3" class="control-label">Email</label>
                </div>
                <div class="col-sm-8">
                  <input type="email" class="form-control" name="email_i" id="email_i" placeholder="Email" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="inputPassword3" class="control-label">mot de passe</label>
                </div>
                <div class="col-sm-8">
                  <input type="password" class="form-control" name="mdp_i" id="mdp_i" placeholder="mot de passe" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4">
                  <label class="control-label">confirmer mot de passe</label>
                </div>
                <div class="col-sm-8">
                  <input type="password" class="form-control" name="pass_confirm" id="pass_confirm" placeholder="confirmer mot de passe" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-9 col-sm-3">
                  <!--<button type="submit" class="btn btn-default" id="inscription">Inscription</button> Ne marche pas-->
                  <input type="submit" name="inscription" value="inscription" class="btn btn-primary">
                </div>
              </div>
            </form>
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
                <a href="#"><i class="text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  

</body></html>
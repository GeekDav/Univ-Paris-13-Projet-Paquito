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
    <script type="text/javascript" src="js/script.js"></script>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  </head><body>
    <div class="row" style="background-color: #5bc0de;">
      <div class="container">
        <div class="row col-md-10 col-md-offset-1">
          <div class="col-md-4">
            <a href="index.php"><h1 class="text-primary">Paquito</h1></a>
          </div>
          <div class="col-xd-5 col-md-5 text-right">
            <div>
              <br>
              <?php echo $_SESSION['email']; ?>
            </div>
          </div>
          <div class="col-md-3">
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
        <div class="row text-center">
          <h1 class="text-primary">Ajout Projet
            <br>&nbsp;</h1>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <form action="fonctions/process.php " method="post" class="form-horizontal centered col-md-10 col-md-offset-1">
              <!-- recuperation nom projet -->
              <div class="col-md-2 form-group">
                <label for="F[name]" class="control-label">Nom projet :</label>
              </div>
              <div class="col-md-10 form-group">
                <input type="text" name="F[Name]" id="F[Name]" required="" placeholder="ex:paquito" class="form-control">
              </div>
              <div class="col-md-2 form-group">
                <label for="F[Version]" class="control-label">Version :</label>
              </div>
              <div class="col-md-10 form-group">
                <input type="number" name="F[Version]" id="F[Version]" required="" placeholder="ex:2.0" step="0.01" class="form-control">
              </div>
              <div class="col-md-2 form-group">
                <label for="F[Homepage]" class="control-label">Homepage :</label>
              </div>
              <div class="col-md-10 form-group">
                <input type="url" name="F[Homepage]" id="F[Homepage]" required="" placeholder="ex:https://github.com/CosyVerif/paquito" class="form-control">
              </div>
              <div class="col-md-2 form-group">
                <label for="F[Github]" class="control-label">Github :</label>
              </div>
              <div class="col-md-10 form-group">
                <input type="url" name="F[Github]" id="F[Github]"  placeholder="ex:https://github.com/CosyVerif/paquito (pour suivi projet)" class="form-control">
              </div>
              <div class="col-md-2 form-group">
                <label for="F[Summary]" class="control-label">resume :</label>
              </div>
              <div class="col-md-10 form-group">
                <textarea rows="4" cols="50" name="F[Summary]" id="F[Summary]" placeholder="entrez le resume ici" class="form-control"></textarea>
              </div>
              <div class="col-md-2 form-group">
                <label for="F[Description]" class="control-label">Description:</label>
              </div>
              <div class="col-md-10 form-group">
                <textarea class="form-control" rows="6" cols="60" name="F[Description]" id="F[Description]" placeholder="entrez la description ici"></textarea>
              </div>
              <div class="col-md-2 form-group">
                <label for="F[Copyright]" class="control-label">Copyright :</label>
              </div>
              <div class="col-md-10 form-group">
                <input type="text" name="F[Copyright]" id="F[Copyright]" required="" placeholder="ex:copyright" class="form-control">
              </div>
              <!-- Maintener-->
              <div class="col-md-12 form-group">
                <fieldset class="form-group">
                  <legend>Maintainer</legend>
                  <div class="col-md-12">
                    <div class="col-md-2 form-group">
                      <label for="F[Maintainer][name]" class="control-label">Nom maintainer :</label>
                    </div>
                    <div class="col-md-4 form-group">
                      <input class="form-control" type="text" id="F[Maintainer][name]" name="F[Maintainer][name]" required="" placeholder="ex:toto">
                    </div>
                    <div class="col-md-2 form-group">
                      <label class="control-label" for="F[Maintainer][email]">Email maintainer :</label>
                    </div>
                    <div class="col-md-4 form-group">
                      <input class="form-control" type="text" name="F[Maintainer][email]" id="F[Maintainer][email]" required="" placeholder="ex:toto@gmail.com">
                    </div>
                  </div>
                </fieldset>
              </div>
              <!-- recuparation des authors-->
              <div class="col-md-12 form-group">
                <fieldset class="form-group">
                  <legend>Autheurs</legend>
                  <div class="col-md-12">
                    <div class="col-md-2 form-group">
                      <label for="F[Authors][name][]" class="control-label">Nom auteur :</label>
                    </div>
                    <div class="col-md-4 form-group">
                      <input class="form-control" type="text" id="F[Authors][name][0]" name="F[Authors][name][]" required="" placeholder="ex:toto">
                    </div>
                    <div class="col-md-2 form-group">
                      <label class="control-label" for="F[Authors][email][]">Email auteur :</label>
                    </div>
                    <div class="col-md-4 form-group">
                      <input class="form-control" type="text" name="F[Authors][email][]" id="F[Authors][email][0]" required="" placeholder="ex:toto@gmail.com">
                    </div>
                    <div class="col-md-2 form-group">
                      <input type="button" onclick="ajouterAuteur(this)" value="+" id="bt_ajouterAuteur" class="btn btn-primary">
                    </div>
                  </div>
                </fieldset>
              </div>
              <div class="col-md-12 form-group">
                <fieldset class="form-group">
                  <legend>Packages</legend>
                  <!-- ne pas oublier l'insertion du bouton pour ajouter
                  les paquets-->
                  <!-- premier paquet-->
                  <fieldset>
                    <div class="col-md-2">
                      <label for="F[Packages][0][name]" class="control-label">Nom paquet :</label>
                    </div>
                    <div class="col-md-10">
                      <input type="text" name="F[Packages][0][name]" id="F[Packages][0][name]" required="" placeholder="ex:paquito" class="form-control">
                    </div>
                    <div class="col-md-2">
                      <label for="F[Packages][0][Type]" class="control-label">Type paquet :</label>
                    </div>
                    <div class="col-md-10">
                      <select class="form-control" name="F[Packages][0][Type]" id="F[Packages][0][Type]" required="">
                        <option value="binary">binary</option>
                        <option value="source">source</option>
                        <option value="arch_independant">arch_independant</option>
                        <option value="library">library</option>
                      </select>
                    </div>
                    <fieldset class="col-md-12">
                      <legend>Files</legend>
                      <div class="col-md-12">
                        <div class="col-md-2 form-group">
                          <label for="F[Packages][0][Files][Destination][]" class="control-label">Destination :</label>
                        </div>
                        <div class="col-md-10 form-group">
                          <input type="text" name="F[Packages][0][Files][Destination][]" id="F[Packages][0][Files][Destination][]" required="" placeholder="ex:/usr/bin/paquito" class="form-control">
                        </div>
                        <div class="col-md-2 form-group">
                          <label for="F[Packages][0][Files][Source][]" class="control-label">Source :</label>
                        </div>
                        <div class="col-md-10 form-group">
                          <input type="text" name="F[Packages][0][Files][Source][]" id="F[Packages][0][Files][Source][]" required="" placeholder="ex:/src/paquito.sh" class="form-control">
                        </div>
                        <div class="col-md-2 form-group">
                          <label for="F[Packages][0][Files][Permissions][]" class="control-label">Permissions :</label>
                        </div>
                        <div class="col-md-10 form-group">
                          <input type="text" name="F[Packages][0][Files][Permissions][]" id="F[Packages][0][Files][Permissions][]" required="" value="755" class="form-control">
                        </div>
                        <div class="col-md-4 col-md-offset-5">
                          <input type="button" onclick="ajouterFichier(this.parentNode.parentNode,0,'[Files]')" value="ajouter" id="bt_ajouterFichier[0]" class="btn btn-primary">
                        </div>
                      </div>
                    </fieldset>
                    <fieldset class="col-md-12">
                      <legend>Build  
                        <button type="button" class="btn btn-info" onclick="showFieldset(this)">show</button>
                      </legend>
                      <div hidden="hidden">
                        <fieldset class="col-md-12">
                          <legend>Dependances</legend>
                          <div class="col-md-4">
                            <input type="button" onclick="ajouterDependane(this.parentNode,0,'[Build][Dependencies]')" value="ajouter une dependance" id="bt_ajouterDependance[0]" class="btn btn-primary">
                          </div>
                        </fieldset>
                        <fieldset class="col-md-12">
                          <legend>Commandes</legend>
                            <div>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <input type="button" class="btn btn-primary" onclick="ajouterCommande(this.parentNode,0,'[Build][Commands]')" value="ajouter" id="bt_ajouterCommandeTest[0]">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                      </div>
                    </fieldset>
                    <fieldset class="col-md-12">
                      <legend>Runtime
                        <button type="button" class="btn btn-info" onclick="showFieldset(this)">show</button>
                      </legend>
                      <div hidden="hidden">
                        <fieldset class="col-md-12">
                          <legend>Dependances</legend>
                          <div class="col-md-4">
                            <input type="button" onclick="ajouterDependane(this.parentNode,0,'[Runtime][Dependencies]')" value="ajouter une dependance" id="bt_ajouterDependance[0]" class="btn btn-primary">
                          </div>
                        </fieldset>
                      </div>
                    </fieldset>
                    <fieldset class="col-md-12">
                      <legend>Install
                        <button type="button" class="btn btn-info" onclick="showFieldset(this)">show</button>
                      </legend>
                      <div hidden="hidden">
                        <fieldset class="col-md-12">
                          <legend>Pre</legend>
                          <div>
                            <div class="col-md-12">
                              <div class="col-md-4">
                                <input type="button" class="btn btn-primary" onclick="ajouterCommande(this.parentNode,0,'[Install][Pre]')" value="ajouter" id="bt_ajouterCommandePost[0]">
                              </div>
                            </div>
                          </div>
                        </fieldset>
                        <fieldset class="col-md-12">
                          <legend>Post</legend>
                          <div>
                            <div class="col-md-12">
                              <div class="col-md-4">
                                <input type="button" class="btn btn-primary" onclick="ajouterCommande(this.parentNode,0,'[Install][Post]')" value="ajouter" id="bt_ajouterCommandePost[0]">
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                    </fieldset>
                    <fieldset class="col-md-12">
                      <legend>Test
                        <button type="button" class="btn btn-info" onclick="showFieldset(this)">show</button>
                      </legend>
                      <div hidden="hidden">
                        <fieldset class="col-md-12">
                          <legend>Files</legend>
                          <div class="col-md-12">
                            <div class="col-md-4 form-group">
                              <input type="button" onclick="ajouterFichier(this.parentNode.parentNode,0,'[Test][Files]')" value="ajouter" id="bt_ajouterFichier[0]" class="btn btn-primary">
                            </div>
                          </div>
                        </fieldset>
                        <fieldset class="col-md-12">
                          <legend>Dependances</legend>
                          <div class="col-md-4">
                            <input type="button" onclick="ajouterDependane(this.parentNode,0,'[Test][Dependencies]')" value="ajouter une dependance" id="bt_ajouterDependance[0]" class="btn btn-primary">
                          </div>
                        </fieldset>
                        <fieldset class="col-md-12">
                          <legend>Commandes</legend>
                          <div>
                            <div class="col-md-12">
                              <div class="col-md-4">
                                <input type="button" class="btn btn-primary" onclick="ajouterCommande(this.parentNode,0,'[Test][Commands]')" value="ajouter" id="bt_ajouterCommandeTest[0]">
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                    </fieldset>
                  </fieldset>
                </fieldset>
              </div>
              <div class="col-md-5 col-md-offset-1">
                <input class="btn btn-success form-control" type="submit" value="valider">
              </div>
              <div class="col-md-5">
                <a href="main_page.php" class="btn btn-danger form-control">
                  annuler
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <br>
            <p>@copyright</p>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
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
<!-- CODE PHP -->

<?php

  if ((isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['mdp']) && !empty($_POST['mdp']))) {

    try{
          // On se connecte à MySQL
        $bdd = new PDO('mysql:host=localhost;dbname=paquito;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    }
    catch(Exception $e){
         // En cas d'erreur, on affiche un message et on arrête tout
      die('Erreur : '.$e->getMessage());
    }
    // on teste si une entrée de la base contient ce couple email email / mdp
    $email=$_POST['email'];
    $mdp=sha1($_POST['mdp']);
    $reponse = $bdd->query('SELECT COUNT(*) AS nb,admin FROM membre WHERE email="'.$email.'" AND  mdp="'.$mdp.'"' );
    //$rep = $bdd->query('SELECT COUNT(*) AS nbre FROM membre WHERE mdp="'.sha1($_POST['mdp']).'"' );
    $donnees= $reponse->fetch();
    //$don= $rep->fetch();

    // si on obtient une réponse, alors l'utilisateur est un membre
    if ($donnees['nb'] == 1) {
      session_start();
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['admin'] = $donnees['admin'];
      //$_SESSION['email'] = $_POST['email'];

      header('Location: main_page.php');
      exit();
    }
    // si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de mdp
    else{
      //faire la gestion d'erreur
      $erreur = 'Compte non reconnu.';
      echo $erreur;
    }
  }
  else {
    $erreur = 'Au moins un des champs est vide.';
    echo $erreur;
  }

?>

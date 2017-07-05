

<!-- INSCRIPTION -->

<?php

  // on teste l'existence de nos variables. On teste également si elles ne sont pas vides
  if ((isset($_POST['email_i']) && !empty($_POST['email_i'])) 
        && (isset($_POST['mdp_i']) && !empty($_POST['mdp_i'])) && (isset($_POST['pass_confirm']) && !empty($_POST['pass_confirm']))) {
  // on teste les deux mots de passe
    if ($_POST['mdp_i'] != $_POST['pass_confirm']) {
      $erreur = 'Les 2 mots de passe sont différents.';
      echo $erreur;
    }
    else{
        
      try{
          // On se connecte à MySQL
         $bdd = new PDO('mysql:host=localhost;dbname=paquito;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

      }
      catch(Exception $e)
      {
         // En cas d'erreur, on affiche un message et on arrête tout
         die('Erreur : '.$e->getMessage()); 
      }

      $reponse = $bdd->query('SELECT COUNT(*) AS nb FROM membre WHERE email="'.$_POST['email_i'].'"');
      $donnees= $reponse->fetch();

      if($donnees['nb']==0)
      {
        $req = $bdd->prepare('INSERT INTO membre(email, mdp, admin) VALUES(?,?,0)');
        $req->execute(array($_POST['email_i'], sha1($_POST['mdp_i'])));

      session_start();
      $_SESSION['email'] = $_POST['email_i'];
      $_SESSION['admin'] = 0;
      header('Location: main_page.php');
      exit();

      }
      else{
         $erreur = 'Un membre possède déjà ce login.';
         echo $erreur;
         }

    }

  }
  else {
    $erreur = 'Au moins un des champs est vide.';
    echo $erreur;
  }



?>

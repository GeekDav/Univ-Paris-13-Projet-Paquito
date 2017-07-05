<?php
include 'connexion.php';
include 'InsertYAML.php';
include 'exctractYAML.php';

			//teste d'insertion
			$var=Chek_ConfigurationFile('https://github.com/CosyVerif/paquito.git','paquito.yml',$dbh);
			if($var==1)
			{
				echo "fichier inséré";
			}
			else
			{
				echo "erreur";
			}
			
			//teste d'extraction (génération de fichier yaml)
			
           $var=Exctract_ConfigFile("https://github.com/CosyVerif/paquito.git",$dbh);
			if($var==1)
			{
				echo "fichier générer";
			}
			else
			{
				echo "erreur";
			}
 
?>
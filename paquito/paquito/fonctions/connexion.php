<?php
// creation de la connexion
	try
	{
		$dbh = new PDO('mysql:host=localhost;dbname=bd_paquito', 'root', '');
		$dbepitelio= new PDO('mysql:host=localhost;dbname=epitelio_store', 'root', ''); 
    }
catch (Exception $e) {
						die('Il y a une erreur : '.$e->getMessage());
					}

	
?>
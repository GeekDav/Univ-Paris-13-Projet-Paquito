<html>
<head>
	<title></title>
</head>

<body>
		<?php
            include 'connexion.php'; // pour la connexion à la bdd
            include 'InsertYAML.php';
            include 'exctractYAML.php';
        // ne pas oublier de mettre tous les hidden en visible lors de l'envoie du formulaire
        $Form=array();
		if(isset($_POST) && !empty($_POST)){
			$Form=$_POST['F'];
            //var_dump($Form['Packages'][0]['Build']['Commands']);
            //$string= 'nom : '+Form[nom]+' prenom: '+Form[prenom];
            foreach ($Form as $key => $val) {
                if($key == 'Maintainer'){
                    $Form['Maintainer']=$val['name'].'<'.$val['email'].'>';
                }
                if($key == 'Authors'){
                    //var_dump($val);
                    //on cree la variable pour les autheus 
                    $authors=array();
                    for($i=0;$i<count($val['name']);$i++){
                        array_push($authors,$val['name'][$i].'<'.$val['email'][$i].'>');
                    }
                    //unset($Form['Authors']);
                    $Form['Authors']=$authors;
                }
                if ($key == 'Packages') {
                    /* La variable $glob contient un tableau mentionnant les paquets qu'on souhaite créer */
				    $glob = $val;
                    //parcours de tous les paquets
                    foreach($glob as $key => $val){
                        $tmp = $val['name'];
                        //on retire l'ancien contenu
                        unset($Form['Packages'][$key]);
                        //on retire le champ nom
                        unset($val['name']);
                        //on met le bon champ
                        $Form['Packages'][$tmp]=$val;
                    }
                    $glob = $Form['Packages'];
                    //on parcours a nouveau tous les pacquets
                    foreach($glob as $key => $val){
                        $nomPaquet=$key;
                        $contenus = $val;
                        //on parcours les différents champs
                        foreach($contenus as $key => $val){
                            if($key=="Files"){
                                $file=$key;
                                $newStruc=array();
                                for($i=0;$i<count($val['Destination']);$i++){
                                    $newStruc[$val['Destination'][$i]]=array('Source'=>$val['Source'][$i],'Permissions'=>$val['Permissions'][$i]);     
                                }
                                $Form['Packages'][$nomPaquet][$file]=$newStruc;
                                //var_dump($newStruc);
                            }
                            if($key=='Build'){
                                $build=$key;
                                $content=$val;
                                foreach($content as $key => $val){
                                    if($key == "Dependencies"){
                                        $depend=$key;
                                        $cont=$val;
                                        //var_dump($cont);
                                        $struc=array();
                                        foreach($cont as $key => $val){
                                            $nomDep=$val['nom'];
                                            unset($val['nom']);
                                            $struc[$nomDep]=$val;
                                        }
                                        $Form['Packages'][$nomPaquet][$build][$depend]=$struc;
                                        //var_dump($Form['Packages'][$nomPaquet][$build]);
                                    }
                                }
                                //apres avoir changer le build, on le reparcours
                                $content=$Form['Packages'][$nomPaquet][$build];
                                foreach($content as $key => $val){
                                    if($key == "Dependencies"){
                                        $depend=$key;
                                        $cont=$val;
                                        foreach($cont as $key => $val){
                                            if(count($val)==0){ // il y a pas de specification debian , archlinux ...
                                                $Form['Packages'][$nomPaquet][$build][$depend][$key]='*';
                                            }
                                            else{//il y a des spécifications
                                                $nomDep=$key;//nom de la dependance
                                                $con=$val;
                                                foreach($con as $key => $val){
                                                    $nomDistrib=$key;
                                                    if(is_array($val)){//il y a des precisions sur les versions de nomdistrib On change leur forme
                                                        $struc=array();
                                                        for($i=0;$i<count($val['Version']);$i++){
                                                            $Form['Packages'][$nomPaquet][$build][$depend][$nomDep][$nomDistrib][$val['Version'][$i]]=$val['Name'][$i];
                                                        }
                                                        unset($Form['Packages'][$nomPaquet][$build][$depend][$nomDep][$nomDistrib]['Version']);
                                                        unset($Form['Packages'][$nomPaquet][$build][$depend][$nomDep][$nomDistrib]['Name']);
                                                    }
                                                }
                                            }
                                        }
                                        //var_dump('jete un coup ');
                                        //var_dump($Form['Packages'][$nomPaquet][$build][$depend]);
                                    }//fin du traitement des dépendances dde BUILD
                                }
                            }//FIN DE TRAITEMENT DE LA ZONE BUILD
                            if($key=='Runtime'){
                                $runtime=$key;
                                $contenu=$val;
                                foreach($contenu as $key => $val){
                                    if($key == "Dependencies"){
                                        $depend=$key;
                                        $cont=$val;
                                        //var_dump($cont);
                                        $struc=array();
                                        foreach($cont as $key => $val){
                                            $nomDep=$val['nom'];
                                            unset($val['nom']);
                                            $struc[$nomDep]=$val;
                                        }
                                        $Form['Packages'][$nomPaquet][$runtime][$depend]=$struc;
                                        //var_dump($Form['Packages'][$nomPaquet][$runtime]);
                                        //var_dump(' fin du premier');
                                    }
                                }
                                //apres avoir changer le build, on le reparcours
                                $contenu=$Form['Packages'][$nomPaquet][$runtime];
                                foreach($contenu as $key => $val){
                                    if($key == "Dependencies"){
                                        $depend=$key;
                                        $conten=$val;
                                        foreach($conten as $key => $val){
                                            if(count($val)==0){ // il y a pas de specification debian , archlinux ...
                                                $Form['Packages'][$nomPaquet][$runtime][$depend][$key]='*';
                                            }
                                            else{//il y a des spécifications
                                                $nomDep=$key;//nom de la dependance
                                                $con=$val;
                                                foreach($con as $key => $val){
                                                    $nomDistrib=$key;
                                                    if(is_array($val)){//il y a des precisions sur les versions de nomdistrib On change leur forme
                                                        for($i=0;$i<count($val['Version']);$i++){
                                                            $Form['Packages'][$nomPaquet][$runtime][$depend][$nomDep][$nomDistrib][$val['Version'][$i]]=$val['Name'][$i];
                                                        }
                                                        unset($Form['Packages'][$nomPaquet][$runtime][$depend][$nomDep][$nomDistrib]['Version']);
                                                        unset($Form['Packages'][$nomPaquet][$runtime][$depend][$nomDep][$nomDistrib]['Name']);
                                                    }
                                                }
                                            }
                                        }
                                        //var_dump('voila');
                                        //var_dump($Form['Packages'][$nomPaquet][$runtime][$depend]);
                                        //var_dump('fin');
                                    }
                                }
                            }//FIN TRAITEMENT RUNTIME
                            if($key=='Test'){
                                $test=$key;
                                $contenu=$val;
                                foreach($contenu as $key => $val){
                                    if($key=='Files'){
                                        $file=$key;
                                        $newStruc=array();
                                        for($i=0;$i<count($val['Destination']);$i++){
                                            $newStruc[$val['Destination'][$i]]=array('Source'=>$val['Source'][$i],'Permissions'=>$val['Permissions'][$i]);     
                                        }
                                        $Form['Packages'][$nomPaquet][$test][$file]=$newStruc;
                                        //var_dump($newStruc);   
                                    }
                                    if($key == "Dependencies"){
                                        $depend=$key;
                                        $cont=$val;
                                        //var_dump($cont);
                                        $struc=array();
                                        foreach($cont as $key => $val){
                                            $nomDep=$val['nom'];
                                            unset($val['nom']);
                                            $struc[$nomDep]=$val;
                                        }
                                        $Form['Packages'][$nomPaquet][$test][$depend]=$struc;
                                    }
                                }
                                //apres avoir reécrit les dependances, on va plus en profondeur
                                $contenu=$Form['Packages'][$nomPaquet][$test];
                                foreach($contenu as $key => $val){
                                    if($key == "Dependencies"){
                                    $depend=$key;
                                    $conten=$val;
                                    foreach($conten as $key => $val){
                                        if(count($val)==0){ // il y a pas de specification debian , archlinux ...
                                                $Form['Packages'][$nomPaquet][$test][$depend][$key]='*';
                                            }
                                        else{//il y a des spécifications
                                            $nomDep=$key;//nom de la dependance
                                            $con=$val;
                                            foreach($con as $key => $val){
                                                $nomDistrib=$key;
                                                if(is_array($val)){//il y a des precisions sur les versions de nomdistrib On change leur forme
                                                    for($i=0;$i<count($val['Version']);$i++){
                                                        $Form['Packages'][$nomPaquet][$test][$depend][$nomDep][$nomDistrib][$val['Version'][$i]]=$val['Name'][$i];
                                                    }
                                                    unset($Form['Packages'][$nomPaquet][$test][$depend][$nomDep][$nomDistrib]['Version']);
                                                    unset($Form['Packages'][$nomPaquet][$test][$depend][$nomDep][$nomDistrib]['Name']);
                                                }
                                            }
                                        }
                                    }
                                        //var_dump('voila');
                                        //var_dump($Form['Packages'][$nomPaquet][$test][$depend]);
                                        //var_dump('fin');
                                    }
                                    }
                                }
                            }//Fin traitement test
                            
                        }
                        //var_dump($key);
                        //on parcoure les champs du paquet
                    }//fin parcours des paquets
                }
            // c'est ici qu'on va gérer la mise dans la base de donné
            // creation du lien ou le fichier sera crée
            $path= '../projets/'.$Form['Name'].'/'.$Form['Version'].'/';
            $link= $path.'paquito.yml';
            if(!file_exists($path)){
                mkdir($path,0777,true);
            }
            //on rajoute le formulaire dans la base de donnée db_paquito
            //Chek_ConfigurationData($link,$Form,$dbh); 
            //Exctract_ConfigFile($link,$dbh); 
            //on rajoute le suivi du projet
            if(isset($Form['Github'])){
                $Name = $Form['Name'];
                $Git_link = $Form['Github'];
                $requete=$dbepitelio->prepare("INSERT INTO `queue`(`Git_link`, `Name`) VALUES (?,?)");
                $requete->execute(Array($Git_link,$Name));
                // connexion a localhost:8080
            }
            ?>
            <script type="text/javascript">
                alert('projet ajouté');
            </script>
            <?php 
            header('Location: ../main_page.php');
        }
        //echo "je suis bien là";				
		?>
</body>

</html>
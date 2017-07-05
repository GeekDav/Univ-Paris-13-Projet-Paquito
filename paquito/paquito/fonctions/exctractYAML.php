<?php	

Function Exctract_ConfigFile($Link,$dbh)
{	
//extraction d'information à partir de la base de données 
             $idConfig = $dbh->prepare('SELECT IdConfigurationFile FROM repository WHERE Link= :Link');
             $idConfig->bindParam(':Link', $Link, PDO::PARAM_STR, 200);		    
			 $idConfig->execute();	
             $idConfig = $idConfig->fetch(PDO::FETCH_ASSOC);
              $idConfig=$idConfig['IdConfigurationFile'];
			if($idConfig)
			{
				
			/******************load first level of configuration file **************************/
			$Configuration = $dbh->query('SELECT Name, Version,Homepage,Summary,Description,Copyright,Maintainer 
			                       FROM configurationfile WHERE IdConfigurationFile='.$idConfig);
			 
			$Configuration= $Configuration->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_LAST);	
			 
			 
			
			/*********load participated Authors in the configuration file **********************/
			$QAuthors=$dbh->query('SELECT Author_Name from authors, prticipated_autors 
			                                 WHERE authors.IdAuthors=prticipated_autors.IdAuthors
												   AND  prticipated_autors.IdConfigurationFile='.$idConfig);
			if(isset($QAuthors))
			{
			    $i=0; 
				foreach ($QAuthors as $row) 
				{
					$Authors[$i]=$row['Author_Name'];
					$i++;
				}	
			}
			else echo "erreur champs Authors vide !";
			
			
		    
			/**********Load packages field of configuration file ********************************/
			$List_Packages=$dbh->query('SELECT package.IdPackage, Package_Name, Type FROM package, build_package
												WHERE package.IdPackage=build_package.idPackage
		                        			AND  build_package.IdConfigurationFile='.$idConfig);
			if(isset($List_Packages ))
			{
			$List_Packages = $List_Packages->fetchAll(PDO::FETCH_NUM);
			$Packages=array();
			foreach( $List_Packages as $row)
            {
				/***********************load packages Files *******************************************/
				 
				$Packages[$row[1]]['Type']=$row[2];
				$File=Extracte_Files_Field($dbh,'Package',$row[0]);
				 
				if(isset($File))
				{
					 
					$Packages[$row[1]]['Files']=$File;
				                           
				}
				else 
				{
					echo "erreur lors de chargement de fichier de configuration : liste des fichiers est vide";
				}
				
				
				/**********************load Runtime *********************************************************/
				$Dependence_Run=$dbh->query('SELECT dependence.IdDependence, Dependence_Name, debian_Field,Archlinux_Field,Centos_Field from dependence,package_dependence
			                                 WHERE  dependence.IdDependence=package_dependence.IdDependence
											        AND dependence.Dependence_Field="Runtime"
											        AND  package_dependence.IdPackage='.$row[0]);
				$Dependence_Run=$Dependence_Run->fetchAll(PDO::FETCH_NUM);
				$Dependence_Run=Extracte_Dependence_Field($dbh,$Dependence_Run);
				if(isset($Dependence_Run))
				{
				     $Runtime=array('Dependencies'=>$Dependence_Run);	
					 $Packages[$row[1]]['Runtime']=$Runtime;
				}
				
				
				/**********************load Build************************************************************/
				$Build=null;
				
				$Dependence_Build=$dbh->query('SELECT dependence.IdDependence, Dependence_Name, debian_Field,Archlinux_Field,Centos_Field from dependence,package_dependence
			                                 WHERE  dependence.IdDependence=package_dependence.IdDependence
											        AND dependence.Dependence_Field="Build"
											        AND  package_dependence.IdPackage='.$row[0]);
				
				$Dependence_Build=$Dependence_Build->fetchAll(PDO::FETCH_NUM);
				$Dependence_Build=Extracte_Dependence_Field($dbh,$Dependence_Build);
				if(isset($Dependence_Build))
				{
				$Build['Dependencies']= $Dependence_Build;
				}
				$Commands_Build=Extracte_Commands_Field($dbh,'Build',$idConfig);
				if(!empty($Commands_Build))
				{
				$Build['Commands']=$Commands_Build;	
				}
				if(isset($Build))
				{
				   $Packages[$row[1]]['Build']=$Build;	
				}
				 
				
				
				/*********************load Install field**********************************************************/	
				
				$Pre= Extracte_Commands_Field($dbh,'Pre',$idConfig);
			    $Post=Extracte_Commands_Field($dbh,'Post',$idConfig);
				if(!empty($Pre))
				{
					 $Install['Pre']=$Pre;
				}
				if(!empty($Post))
				{
					  $Install['Post']=$Post;
				}
			     
				if(isset($Install))
				{
					$Packages[$row[1]]['Install']=$Install ;
										  
				}
					
				/******************************load Test Field***************************************************/
				$Test_Files=Extracte_Files_Field($dbh,'Test',$row[0]);
				if(isset($Test_Files))
				{
				    $Test['Files']=$Test_Files;	
				}
				$Dependence_Test=$dbh->query('SELECT dependence.IdDependence, Dependence_Name, debian_Field,Archlinux_Field,Centos_Field from dependence,package_dependence
			                                 WHERE  dependence.IdDependence=package_dependence.IdDependence
											        AND dependence.Dependence_Field="Test"
											        AND  package_dependence.IdPackage='.$row[0]);
				$Dependence_Test=$Dependence_Test->fetchAll(PDO::FETCH_NUM);
				$Dependence_Test=Extracte_Dependence_Field($dbh,$Dependence_Test);
				if(isset($Dependence_Test))
				{
					 $Test['Dependencies']=$Dependence_Test;	
				}
				$Test_cmd=Extracte_Commands_Field($dbh,'Test',$idConfig);
				if(!empty($Test_cmd))
				{
					$Test['Commands']=$Test_cmd;
				}

				/***********************************build Test array ************************************/
				 if(isset($Test))
				{
					 
                    $Packages[$row[1]]['Test']=$Test;
				
				} 				 
				
				}
			}else echo "erreur le champs Packages est vide ";
			
			
				
				
				/*****************build the array of configuration file **************************************************/
				if(!isset($Authors))
				{
					echo "erreur lors de chargement de fichier de configuration : list authors vide !";
				}
				else 
                    $Configuration['Authors']=$Authors;
				if(!isset($Packages))
				{
					echo "erreur lors de chargement de fichier de configuration: list de packages vide !";
				}
				else 
			          $Configuration['Packages']=$Packages;				
            
			
			Dump_Configuration_File($Configuration,$Link); 
            return 1;			
			}
            else 
            {
				return 0;
			}				
			
			 
			
}		 
			    
//générer le fichier de configuration 
Function Dump_Configuration_File($data,$Link)
{
	 try {
            $yaml=sfYaml::dump($data,6);
			file_put_contents($Link,utf8_encode(print_r($yaml, true)));
        }
        catch (Exception $e) {
            throw new YamlParserException(
                $e->getMessage(), $e->getCode(), $e);
        }
}

/*************************function which build  Deian field******************/
Function Exctract_Debian_Field($Array)
{
	if(isset($Array))
	{
		$Debian_Array=Array();
		foreach($Array as $cle =>$valeur)
		{
			if (isset($Value))
			{
			$Debian_Array[$key]=$Value;	
				
			}
		}
		if(count($Debian_Array)==0)
		{
			return $Array['Name_All'];
		}
		else 
		{
		return $Debian_Array;
		}
		
	}
	else return null;
	
	
}
Function Exctract_Centos_Field($Array)
{
	if(isset($Array))
	{
			$Centos_Array=array();
			foreach($Array as $cle =>$valeur)
			{
				if (isset($Value))
				{
				$Centos_Array[$key]=$Value;	
					
				}
			}
			if(count($Centos_Array)==0)
			{
				return $Array['Name_All'];
			}
			else 
			{
			return $Centos_Array;
			}	
	}
	else return null ;
	
	
}
/************************************fonction pour construire les dependence ***********************************/
 Function Extracte_Dependence_Field($dbh,$Array)
 {
 
	 
			$Dependence_Array=null;	                     
			if(isset($Array))
			{
				foreach($Array as $Run)
				{
					$Dependence_Array[$Run[1]]=array();
					/*******************************the Debian dependence*****************************************/
					if(isset($Run[2]))
					{
					$Dependence_Debian=$dbh->query('SELECT Name_All, Stable, Testing, Wheezy, Jessie FROM debianfield
                                   					WHERE IdDebian='.$Run[2]);
													
					$Dependence_Debian=$Dependence_Debian->fetch(PDO::FETCH_ASSOC);
					$Dependence_Debian=Exctract_Debian_Field($Dependence_Debian);
					$Dependence_Array[$Run[1]]['Debian']=$Dependence_Debian;
					}
					
					/*******************************the Archlinux dependence*********************************************/
					if(isset($Run[3]))
					{
					$Dependence_Archlinux=$dbh->query('SELECT Name_All FROM archlinuxfield
                                   					WHERE IdArchlinux='.$Run[3]);
					$Dependence_Archlinux=$Dependence_Archlinux->fetch(PDO::FETCH_ASSOC);
					$Dependence_Archlinux=$Dependence_Archlinux['Name_All'];
					$Dependence_Array[$Run[1]]['Archlinux']=$Dependence_Archlinux;
					}
					
					
					/*******************************the Centos Dependence********************************************/
					if(isset($Run[4]))
					{
					$Dependence_Centos=$dbh->query('SELECT Name_All,Six_Six, Seven_Zero FROM centosfield
                                   					WHERE IdCentos='.$Run[4]);
					$Dependence_Centos=$Dependence_Centos->fetch(PDO::FETCH_ASSOC);
					$Dependence_Centos=Exctract_Centos_Field($Dependence_Centos);
					$Dependence_Array[$Run[1]]['CentOs']=$Dependence_Centos;
					}
					
					
					
				}
				
				return $Dependence_Array;
			}				
			else return null;
				
 }
 /*******************************************fonction pour construire commands field***********************/
 Function Extracte_Commands_Field($dbh,$Field,$idConfig)
 {
	
				$Commands=$dbh->prepare('SELECT Command from commands , configurationfile_command 
			                                 WHERE commands.IdCommands=configurationfile_command.IdCommands
			                                       AND commands.Commands_Field= :Field
												   AND  configurationfile_command.IdConfigurationFile= :idConfig');
				$Commands->bindParam(':Field', $Field, PDO::PARAM_STR, 200);		    		    
                $Commands->bindParam(':idConfig', $idConfig, PDO::PARAM_INT, 20);		    		    
			    $Commands->execute();	
				$Commands=$Commands->fetchAll(PDO::FETCH_COLUMN , 0);
				
				if(empty($commands))
				{
					
					return $Commands;
				}
				else return null;
 }
 Function Extracte_Files_Field($dbh,$Field,$idPackage)
 {
	 
	  
	   $Package_Files = $dbh->prepare('SELECT Destination,Source,Permission from files,package_files
			                                 WHERE files.IdFile=package_files.IdFiles
											        AND  File_Field= :Field
												    AND  package_files.IdPackage= :idPackage');
            
             $Package_Files->bindParam(':Field', $Field, PDO::PARAM_STR, 200);		    		    
             $Package_Files->bindParam(':idPackage', $idPackage, PDO::PARAM_INT, 20);		    		    
			 $Package_Files->execute();	
            $Package_Files = $Package_Files->fetchAll(PDO::FETCH_ASSOC);
			 
             // $idConfig=$idConfig['IdConfigurationFile'];
	 
				
				if(isset($Package_Files))
				{
					
					 
					//$Package_Files =$Package_Files->fetchAll(PDO::FETCH_ASSOC);
					 
					$File=null;
					foreach($Package_Files as $line)
					{
						
						$Fil=$line['Destination'];
						unset($line['Destination']);
						$File[$Fil]=$line;
						
					}
					 
          			return 	$File;
				}
				 else return null;
				
				
 }
  
?>

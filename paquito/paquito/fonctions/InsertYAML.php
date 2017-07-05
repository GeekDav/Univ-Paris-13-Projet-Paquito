<?php

include 'yaml/sfYaml.php';


//charger le fichier de configuration déja existe 
Function Load_Configuration_File($Name)
{
          try {
	        
             return sfYaml::load($Name);
			 
            }
        catch (Exception $e) {
            throw new YamlParserException(
                   $e->getMessage(), $e->getCode(), $e);
           }
}
//permet l'insertion dans la base de donnée d'un fichier .yaml 
Function Chek_ConfigurationFile($link,$file,$dbh)
{
	
	$repository= $dbh->prepare('SELECT Link FROM repository WHERE Link=:link');
	$repository->execute(array('link' => $link));
	if($repository->rowCount()==0)
	{
		$data=Load_Configuration_File($file);
		insert_ConfigFile($data,$link,$dbh);
		return 1;
	}
	else 
	{
		return 0;
	}
}
//permet l'insertion d'une structure $data
Function Chek_ConfigurationData($link,$data,$dbh)
{
	
	$repository= $dbh->prepare('SELECT Link FROM repository WHERE Link=:link');
	$repository->execute(array('link' => $link));
	if($repository->rowCount()==0)
	{
		insert_ConfigFile($data,$link,$dbh);
		return 1;
	}
	else 
	{
		return 0;
	}
}


Function insert_ConfigFile($data,$link,$dbh)
{
	$dbh->beginTransaction();
	
	if (isset($data)) 
	{
		if ((!empty($data['Name'])) and (!empty($data['Version']))
			and (!empty($data['Homepage'])) and (!empty($data['Summary']))
			and (!empty($data['Description']))and (!empty($data['Copyright']))and (!empty($data['Maintainer'])))
			 
			 {
				 $FirstLevel=array('Name'=>$data['Name'],
									'Version'=>$data['Version'],
									'Homepage'=>$data['Homepage'],
									'Summary'=>$data['Summary'],
									'Description'=>$data['Description'],
									'Copyright'=>$data['Copyright'],
									'Maintainer'=>$data['Maintainer']
									
								   );
				 
				 $requete1 = $dbh->prepare('INSERT INTO configurationfile ( Name, Version, Homepage, Summary, Description, Copyright, Maintainer) 
										  VALUES (:Name,:Version,:Homepage,:Summary,:Description,:Copyright,:Maintainer)');
				 $requete2 = $dbh->prepare('INSERT INTO repository (Link,IdConfigurationFile)
										  VALUES (?,?)');
				  $requete1->execute($FirstLevel);
				  $idConfig=$dbh->lastInsertId();
				  $requete2->execute(Array($link, $idConfig));
				  
			}
	
 
			if(isset($data['Authors']))
			{    $requete1=$dbh->prepare('INSERT INTO prticipated_autors ( IdAuthors,IdConfigurationFile) 
											  VALUES (?,?)');
				 $requete2= $dbh->prepare('INSERT INTO authors ( Author_Name) 
											  VALUES (?)');
				foreach($data['Authors'] as $row)
				{
					   
					  $requete2->execute(array($row)) ;
					  $requete1->execute(array($dbh->lastInsertId(),$idConfig)) ;
					  
				}
				
			}
 
		if (isset($data['Packages']))
		 {
			 $requete1= $dbh->prepare('INSERT INTO package (Package_Name, Type) 
											  VALUES (?,?)');
			 $requete2= $dbh->prepare('INSERT INTO build_package (IdConfigurationFile, idPackage) 
											  VALUES (?,?)');
			foreach($data['Packages'] as $Name=>$value)
				{
				
					   $requete1->execute(array($Name,$value['Type'])) ;
					   $idPackage=$dbh->lastInsertId();
					   $requete2->execute(array($idConfig,$idPackage)) ;
					   if(isset($data['Packages'][$Name]['Files']))
						{
							
							insert_Files_Field($dbh,$data['Packages'][$Name]['Files'],'Package',$idPackage);
							 
						}
						/****************inserer les depndence******************/
						if(isset($data['Packages'][$Name]['Runtime']))
						{
						   insert_Dependence_Field($dbh,$data['Packages'][$Name],"Runtime",$idPackage);
						   insert_Commands_Field($dbh,$data['Packages'][$Name],"Runtime",$idConfig);					
						}
						if(isset($data['Packages'][$Name]['Build']))
						{
							insert_Dependence_Field($dbh,$data['Packages'][$Name],"Build",$idPackage);
							insert_Commands_Field($dbh,$data['Packages'][$Name],"Build",$idConfig);	
						}					
						
						 
							
						/*****************inserer Test field***************************/
						if(isset($data['Packages'][$Name]['Test']))	
						{
							insert_Dependence_Field($dbh,$data['Packages'][$Name],"Test",$idPackage);
							insert_Commands_Field($dbh,$data['Packages'][$Name],"Test",$idConfig);	
							if(isset($data['Packages'][$Name]['Test']['Files']))
							{
								 $requete=$dbh->prepare('INSERT INTO package_files VALUES(?,?)'); 
								 $IdFile=insert_Files_Field($dbh,$data['Packages'][$Name]['Test']['Files'],'Test',$idPackage);
								 $requete->execute(Array($idPackage,$IdFile));
							}	
							
						}
						/*********inserer Install field**********************/
						if(isset($data['Packages'][$Name]['Install']))	
						{
							insert_Commands_Field($dbh,$data['Packages'][$Name]['Install'],"Pre",$idConfig);
							insert_Commands_Field($dbh,$data['Packages'][$Name]['Install'],"Post",$idConfig);
						}					
				
				}
	}
 }
 $dbh->commit(); 
	
}

Function insert_Centos_Dependence($dbh,$Dependence)
 {
	 $All=null; $Six_Six=null; $Seven_Zero=null;
	 $requete = $dbh->prepare('INSERT INTO centosfield (Name_All,Six_Six,Seven_Zero) 
			                          VALUES (?,?,?)');
		
						if(isset($Dependence['Centos']))
						{
							
							if(isset($Dependence['Centos']['All']))
							{
								$All=$Dependence['Centos']['All'];
							}
							else 
							{
								$All=$Dependence['Centos'];
							}
							if(isset($Dependence['Centos']['6.6']))
							{
								$All=$Dependence['Centos']['6.6'];
							}
							if(isset($Dependence['Centos']['7.0']))
							{
								$All=$Dependence['Centos']['7.0'];
							}
							
							$requete->execute(Array($All,$Six_Six,$Seven_Zero));
							 return $dbh->lastInsertId(); 
						}
					
				
 } 
 Function insert_ArchLinux_Dependence($dbh,$Dependence)
 {
	 $requete = $dbh->prepare('INSERT INTO archlinuxfield (Name_All) 
			                          VALUES (?)');
		 
						if(isset($Dependence['Archlinux']))
						{
							
							if(isset($Dependence['Archlinux']['All']))
							{
								$All=$Dependence['Archlinux']['All'];
							}
							else 
							{
								$All=$Dependence['Archlinux'];
							}
							$requete->execute(Array($All));
							 return $dbh->lastInsertId(); 
						}
					
				
 }
 Function insert_Debian_Dependence($dbh,$Dependence)
 {  
	 
	 $All=null; $Stable=null; $Testing=null; $wheezy=null; $Jessie=null;
	  $requete = $dbh->prepare('INSERT INTO debianfield (Name_All,Stable,Testing,Wheezy,Jessie) 
			                          VALUES (?,?,?,?,?)');
					 
						if(isset($Dependence['Debian']))
						{
							
							if(isset($Dependence['Debian']['All']))
							{
								
								$All=$Dependence['Debian']['All'];
							}
							else 
							{
							$All=$Dependence['Debian'];	
							}
							if(isset($Dependence['Debian']['Stable']))
							{
								$Stable=$Dependence['Debian']['Stable'];
							}
							if(isset($Dependence['Debian']['Testing']))
							{
								$Testing=$Dependence['Debian']['Testing'];
							}
							if(isset($Dependence['Debian']['Wheezy']))
							{
								$Wheezy=$Dependence['Debian']['Wheezy'];
							}
							if(isset($Dependence['Debian']['Jessie']))
							{
								$Jessie=$Dependence['Debian']['Jessie'];
							}
							 
							
							$requete->execute(Array($All,$Stable,$Testing,$wheezy,$Jessie));
							 return $dbh->lastInsertId(); 						
						}
						
					
 }
 Function insert_Files_Field($dbh,$array,$field,$idPackage)
 {
	$requete1 = $dbh->prepare('INSERT INTO files (File_Field, Destination,Source ,Permission) 
			                          VALUES (?,?,?,?)');
	 $requete2=$dbh->prepare('INSERT INTO package_files VALUES(?,?)'); 
							
									 
					foreach($array as $Destination=>$value)
		             {
						 if (is_array($value) and array_key_exists('Source', $value)) 
						 {
							 $requete1->execute(array($field,$Destination,$value['Source'],$value['Permissions'])) ;
                               					 
						 }
						 else
						 {
							$requete1->execute(array($field,$Destination,$value,755)) ;  
							  
						 }
						$requete2->execute(Array($idPackage,$dbh->lastInsertId()));	
						
					 } 
 }
 Function  insert_Commands_Field($dbh,$array,$field,$idConfig)
 {
	if(isset($array[$field]['Commands']))
					{
						$requete1 = $dbh->prepare('INSERT INTO configurationfile_command (IdConfigurationFile,IdCommands) 
			                          VALUES (?,?)');
						$requete2 = $dbh->prepare('INSERT INTO commands (Commands_Field,Command) 
			                          VALUES (?,?)');
						foreach($array[$field]['Commands'] as $value)
						 {
							 
						    $requete2->execute(array($field,$value)) ;  
							$requete1->execute(array($idConfig,$dbh->lastInsertId()));
						 }
				
					}    
 }
 Function  insert_Dependence_Field($dbh,$array,$field,$idPackage)
 {
	 if((isset($array[$field])))
				{
				if(isset($array[$field]['Dependencies']))
					{
						$requete1 = $dbh->prepare('INSERT INTO package_dependence (IdPackage,IdDependence) 
			                          VALUES (?,?)');
						$requete2 = $dbh->prepare('INSERT INTO dependence (Dependence_Name,Dependence_Field,debian_Field,Archlinux_Field,Centos_Field) 
			                          VALUES (?,?,?,?,?)');
						foreach($array[$field]['Dependencies'] as $Name=>$Dependence)
						{
							if(is_array($Dependence))
							{
							  $IdDebian=insert_Debian_Dependence($dbh,$Dependence);
							  $IdArch=insert_ArchLinux_Dependence($dbh,$Dependence);
							  $IdCentos=insert_Centos_Dependence($dbh,$Dependence);
							  $requete2->execute(array($Name,$field,$IdDebian,$IdArch,$IdCentos)) ;  
						      $requete1->execute(array($idPackage,$dbh->lastInsertId()));
								
							}
							else
							{
							  $IdDebian=insert_Debian_Dependence($dbh,array("Debian"=>$Name));
							  $IdArch=insert_ArchLinux_Dependence($dbh,array("Archlinux"=>$Name));
							  $IdCentos=insert_Centos_Dependence($dbh,array("Centos"=>$Name));
							  $requete2->execute(array($Name,$field,$IdDebian,$IdArch,$IdCentos)) ;  
						      $requete1->execute(array($idPackage,$dbh->lastInsertId()));
								
							}
							 
						}	 				
				 
					}
					
				}
 }

?>
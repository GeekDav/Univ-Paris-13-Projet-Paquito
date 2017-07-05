//Declaration des variables globales. On aura principalement des compteurs
var nbp=1; //variable permettant de donner des id unique aux paquets
var nba=1; //variable permettant de donner des id unique aux auteurs
var nb_dependances=[];// tableau du nombre de dependance
nb_dependances.push(1); // le nombre de dependance du premier paquet


function ajouterAuteur(node) {
    var frag = document.createElement('div');
    frag.className="col-md-12";
    frag.innerHTML=''
                +   '<div class="col-md-2 form-group"><label for="F[Authors][name][]" class="control-label">Nom auteur : </label></div>'
                +   '<div class="col-md-4 form-group"><input class="form-control" type="text" name="F[Authors][name][]" id="F[Authors][name]['+nba+']" required placeholder="ex:toto"></div>'
                +   '<div class="col-md-2 form-group"><label for="F[Authors][email][]" class="control-label"> Email auteur : </label></div>'
                +   '<div class="col-md-4 form-group"><input class="form-control" type="text" name="F[Authors][email][]" id="F[Authors][email]['+nba+']" required placeholder="ex:toto@gmail.com"></div>'
                +   '<div class="col-md-2 form-group"><input class="btn btn-danger" type="button" onclick="supprimerAuteur(this)" value=" - " ></div>'
                ;
    nba+=1; //on incremente le nombre d'auteurs
    parentNode =node.parentNode;
    parentNode.parentNode.parentNode.appendChild(frag);
   // node.innerHTML="c'est bizzare";
}

function supprimerAuteur(node) {
    node.parentNode.parentNode.parentNode.removeChild(node.parentNode.parentNode);
}

function ajouterFichier(node,idpaquet,path) {
    var docfrag = document.createElement('div');
    docfrag.className="col-md-12";
    docfrag.innerHTML= ''
                        +    '<div class="col-md-2 form-group"><label class="control-label"  for="F[Packages]['+idpaquet+']'+path+'[Destination][]"> Destination : </label></div>'
                        +    '<div class="col-md-10 form-group"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'[Destination][]" id="F[Packages]['+idpaquet+']'+path+'[Destination][]" required placeholder="ex:/usr/bin/paquito"></div>'
                        +   '<div class="col-md-2 form-group"><label class="control-label"  for="F[Packages]['+idpaquet+']'+path+'[Source][]"> Source : </label></div>'
                        +   '<div class="col-md-10 form-group"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'[Source][]" id="F[Packages]['+idpaquet+']'+path+'[Source][]" required placeholder="ex:/src/paquito.sh"></div>'
                        +   '<div class="col-md-2 form-group"><label class="control-label"  for="F[Packages]['+idpaquet+']'+path+'[Permissions][]"> Permissions : </label></div>'
                        +   '<div class="col-md-10 form-group"><input class="form-control" type="number" name="F[Packages]['+idpaquet+']'+path+'[Permissions][]" id="F[Packages]['+idpaquet+']'+path+'[Permissions][]" required value="755"> </div>'
                        +   '<div class="col-md-4 col-md-offset-5"><input class="btn btn-danger" type="button" onclick="supprimerFichier(this.parentNode)" value="suppr. "></div>'
    ;   
    node.parentNode.appendChild(docfrag);
}
function supprimerFichier(node) {
    node.parentNode.parentNode.removeChild(node.parentNode);
}


//------ajout dependance
function ajouterDependane(node, idpaquet, path){
    var idDependance=nb_dependances[idpaquet];
    var dep=document.createElement('fieldset');
    dep.className="col-md-12";
    dep.innerHTML=''
                +'<div class="col-md-2 form-group"><label class="control-label"  for="F[Packages]['+idpaquet+']'+path+'['+idDependance+'][nom]">nom :</label></div>'                        
                +'<div class="col-md-4 form-group"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'['+idDependance+'][nom]" id="F[Packages]['+idpaquet+']'+path+'['+idDependance+'][nom]" required placeholder="ex:base-devel"></div>'
                +'<div class="col-md-7 btn-group">'
                +'<input class="btn btn-success" type="button" onclick="ajouterDistribDependane(this.parentNode,'+idpaquet+','+idDependance+',\'Debian\',\''+path+'\')" value="Debian" id="bt_ajouterDebian'+path+'Dependane['+idpaquet+']['+idDependance+']">'
                +'<input class="btn btn-success" type="button" onclick="ajouterDistribDependane(this.parentNode,'+idpaquet+','+idDependance+',\'Archlinux\',\''+path+'\')" value="ArchLinux" id="bt_ajouterArchlinux'+path+'Dependane['+idpaquet+']['+idDependance+']"> '
                +'<input class="btn btn-success" type="button" onclick="ajouterDistribDependane(this.parentNode,'+idpaquet+','+idDependance+',\'Centos\',\''+path+'\')" value="Centos" id="bt_ajouterCentos'+path+'Dependane['+idpaquet+']['+idDependance+']"> '
                +'<input class="btn btn-danger" type="button" onclick="supprimerDependane(this.parentNode)" value="supprimer"> '
                +'</div>'
    ;
    
    node.parentNode.appendChild(dep);
 nb_dependances[idpaquet]+=1;   
}

function supprimerDependane(node){
    node.parentNode.parentNode.removeChild(node.parentNode);
}


//--------------méthode ajouts des dépendances spécifiques pour une Distrib
function ajouterDistribDependane(node,idpaquet,idDependance,nomDistrib,path) {
    var input=document.createElement('div');
    input.className="col-md-12";
    input.innerHTML=''
                    +'<div class="col-md-2"><label class="control-label"  for="F[Packages][0]'+path+'['+idpaquet+']['+nomDistrib+']">'+nomDistrib+' : </label></div>'
                    +'<div class="col-md-4"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+']" id="F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+']" required placeholder="ex:build-essential"></div>'
                    +'<div class="col-md-6 btn-group">'
                    +' <input class="btn btn-success" type="button" onclick="ajouterDetailDistribDependane(this,'+idpaquet+','+idDependance+',\''+nomDistrib+'\',\''+path+'\')" value=" ajouter details ">'
                    +'<input class="btn btn-danger" type="button" onclick="supprimerDistribDependane(this.parentNode,'+idpaquet+','+idDependance+',\''+nomDistrib+'\',\''+path+'\')" value="- ">'
                    +'</div>'
    ;
    
    // desactivation du bouton Distrib
    var id='bt_ajouter'+nomDistrib+path+'Dependane'+'['+idpaquet+']'+'['+idDependance+']';
    var distrib=document.getElementById(id);
    distrib.setAttribute('disabled','disabled');
    
    node.parentNode.appendChild(input);
}

function ajouterDetailDistribDependane(node,idpaquet,idDependance,nomDistrib,path) {

    var detail = document.createElement('div');
    detail.className="col-md-12 form-group";
    detail.innerHTML='<div>'
                    +'<div class="col-md-4"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+'][Version][]" required placeholder="Version name"></div>'
                    +'<div class="col-md-4"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+'][Name][]"  required placeholder="name of the dependence"></div>'
                    +'<div class="col-md-2"><input class="btn btn-primary" type="button" onclick="ajouterPlusDetailDependane(this,'+idpaquet+','+idDependance+',\''+nomDistrib+'\',\''+path+'\')" value="+"></div>'
                    +'</div>'
    ;
    //desactivation de la zone de saisi Distrib
    var id='F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+']';   
    var distrib=document.getElementById(id);
    distrib.setAttribute('disabled','disabled');
    
    // transformer le bounton ajouter detail en supprimer detail
    node.setAttribute('value','supp. details');
    var test= 'supprimerTousDetails(this,'+idpaquet+','+idDependance+',\''+nomDistrib+'\',\''+path+'\')';
    //alert(test);
    node.setAttribute('onclick',test);
    
    node.parentNode.parentNode.appendChild(detail);
}
function supprimerTousDetails(node,idpaquet,idDependance,nomDistrib,path){
    // à modifier plus tard, beaucoup trop dangereux
    node.parentNode.parentNode.removeChild(node.parentNode.parentNode.lastChild);
    // reactivation du bouton ajout details
    node.setAttribute('value','ajouter details');
    var test= 'ajouterDetailDistribDependane(this,'+idpaquet+','+idDependance+',\''+nomDistrib+'\',\''+path+'\')';
    node.setAttribute('onclick',test);
    // réactivation  de la zone de saisi Distrib
    var id='F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+']';
    var distrib=document.getElementById(id);
    distrib.removeAttribute('disabled');
}
function ajouterPlusDetailDependane(node,idpaquet,idDependance,nomDistrib,path) {
    var input=document.createElement('div');
    input.innerHTML=''
                    +'<div class="col-md-4"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+'][Version][]" required placeholder="Version name"></div>'
                    +'<div class="col-md-4"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'['+idDependance+']['+nomDistrib+'][Name][]"  required placeholder="name of the dependence"></div>'
                    +'<div class="col-md-2"><input class="btn btn-danger" type="button" onclick="supprimerUnDetailDependane(this.parentNode)" value="- "></div>'
                    +''
    ;
    node.parentNode.parentNode.appendChild(input);
}
function supprimerUnDetailDependane(node) {
    node.parentNode.parentNode.removeChild(node.parentNode);
    
}


function supprimerDistribDependane(node,idpaquet,idDependance,nomDistrib,path) {
    var id= 'bt_ajouter'+nomDistrib+''+path+'Dependane['+idpaquet+']['+idDependance+']';
    var bt_Distrib=document.getElementById(id);
    
    bt_Distrib.removeAttribute('disabled');
    node.parentNode.parentNode.removeChild(node.parentNode);
    
}

function ajouterCommande(node,idpaquet,path){
    var input= document.createElement('div');
    input.innerHTML=''
                    +'<div class="col-md-8"><input class="form-control" type="text" name="F[Packages]['+idpaquet+']'+path+'[]" rows="1" cols="60"  required placeholder="ex:bin/create-phar.sh"></div>'
                    +'<div class="col-md-4"><input class="btn btn-danger" type="button" onclick="supprimerCommande(this.parentNode)" value="supprim"></div>'
    ;
    node.parentNode.parentNode.appendChild(input);
}

function supprimerCommande(node){
    node.parentNode.parentNode.removeChild(node.parentNode);
}
function showFieldset(node){
    //affichage du fieldset
    node.parentNode.parentNode.lastElementChild.removeAttribute('hidden');
    
    //changement du bouton en hide
    node.innerHTML="hidde";
    var func="hideFieldset(this)";
    node.setAttribute('onclick',func);  
}
function hideFieldset(node){
    //on cache le fieldset
    node.parentNode.parentNode.lastElementChild.setAttribute('hidden','hidden');
    
    //changement du bouton en show
    node.innerHTML="show";
    var func="showFieldset(this)";
    node.setAttribute('onclick',func);  
}


/*
// Declaration des variables globales
var nbp=1; //nombre de paquets
var nb_dependances=[];// tableau du nombre de dependance
nb_dependances.push(0); // le nombre de dependance du premier paquet
var nb_fichiers=[];
nb_fichiers.push(0);
function ajouterAuteur(node) {
    //ligne d'un auteur
    var docfrag = document.createElement('div');
    docfrag.innerHTML = '<div><label class="control-label"  for="F[auteur]">nom</label>' 
            + '<input type="text" name="F[auteur][nom][]" placeholder="nom auteur">'
            + '<label class="control-label"  for="F[A_prenom]">prenom</label>'
            + '<input type="text" name="F[auteur][prenom][]" placeholder="prenom auteur">'
            + '<input type="button" onclick="supAuteur(this.parentNode)" value="supprimer"/></div>';
    parentNode =node.parentNode;
    parentNode.parentNode.appendChild(docfrag);
   // node.innerHTML="c'est bizzare";
}
function supAuteur(node) {
    node.parentNode.parentNode.removeChild(node.parentNode);
}

function ajouterPaquet(node) {
    var docfrag = document.createElement('div');
    docfrag.innerHTML = ''
    +      '<fieldset>'
    +            '<input type="button" onclick="supPaquet(this.parentNode)" value="supprimer le paquet"/> <br/>'
    +            '<label class="control-label"  for="F[packages]['+nbp+'][nom]">nom pacquet</label>'
    +            '<input type="text" name="F[packages]['+nbp+'][nom]" placeholder="nom package">'
    +            '<br/>'
    +            '<label class="control-label"  for="F[A_prenom]">blabla</label>'
    +            '<input type="text" name="F[packages]['+nbp+'][autreInfo]" placeholder="autre info">'
    +            '<fieldset>'
    +                '<legend>Files</legend>'
    +                '<input type="button" onclick="ajouterFichier(this.parentNode,'+nbp+')" value="ajouter fichier"/>'
    +                '<br/>'
    +            '</fieldset>'
    +            '<input type="button" onclick="ajouterBuild(this,'+nbp+')" value="ajouter le champ Build"/>'
    +            '<input type="button" onclick="ajouterRuntime(this,'+nbp+')" value="ajouter le champ Runtime"/>'
    +            '<input type="button" onclick="ajouterInstall(this,'+nbp+')" value="ajouter le champ Install"/>'
    +            '<input type="button" onclick="ajouterTest(this,'+nbp+')" value="ajouter le champ Test"/>'
    +        '</fieldset>';
         //parentNode =node.parentNode;
        node.parentNode.appendChild(docfrag);
        nb_dependances.push(0); //nombre de dependance du paquet crée
        nb_fichiers.push(0);
        nbp+=1;
}
function supPaquet(node){
    node.parentNode.parentNode.removeChild(node.parentNode);
}
function ajouterFichier(node,idpaquet) {
    var docfrag = document.createElement('div');
    docfrag.innerHTML= '<div>source :' 
            +'<input type="text" name="F[packages][' + idpaquet + '][files][source][]" placeholder="source">'
            +'destination:<input type="text" name="F[packages]['+ idpaquet +'][files][destination][]" placeholder="destination">'
            +'<input type="button" onclick="supFichier(this.parentNode,'+ idpaquet +')" value="supprimer"/></div>'
    ;   
    nb_fichiers[idpaquet]+=1;
    node.appendChild(docfrag);
    alert(nb_fichiers[idpaquet]);// a supprimer, juste pour verifier comment marche ce truc
}
function supFichier(node,idpaquet) {
    node.parentNode.parentNode.removeChild(node.parentNode);
    nb_fichiers[idpaquet]-=1;
     alert(nb_fichiers[idpaquet]);
}

function ajouterBuild(node,idpaquet){
    var docfrag = document.createElement('fieldset');
    docfrag.innerHTML= '<legend>Build</legend>'
                        +'<input type="button" onclick="supprimerBuild(this)" value="supprimer le champ Build"/>'
                        +'<fieldset>'
                        +    '<legend>Dependances</legend>'
                        +    '<input type="button" onclick="ajouterDependance(this.parentNode,'+idpaquet+')" value="ajouter dependence"/>'
                        +'</fieldset>';
    node.parentNode.appendChild(docfrag);
}
function ajouterDependance(node,idpaquet){
    var docfrag = document.createElement('fieldset');
    docfrag.innerHTML= 'nom :' 
            +'<input type="text" name="F[packages][' + idpaquet + '][build][dependancies]['+nb_dependances[idpaquet]+'][nom]" placeholder="nom dependence">'
    ;   
    nb_dependances[idpaquet]+=1;
    node.appendChild(docfrag); 
}


function supprimerBuild(node) {
    node.parentNode.parentNode.removeChild(node.parentNode);
}
*/

<?php
function EnvoyerEmail($to,$subject,$message){
     $headers = 'From: webmaster@example.com' . "\r\n" .'Reply-To: webmaster@example.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();
     mail($to, $subject, $message, $headers);
}
function deconnexion(){
// Détruit toutes les variables de session
$_SESSION = array();
 
// Si vous voulez détruire complètement la session, effacez également
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,$params["path"], $params["domain"],$params["secure"], $params["httponly"]);
}

//  on détruit la session. et redirection vers la page de connectez_vous
header('Location:Connection.php');
exit();
}

function dateDiff($date1, $date2){

$date1  = strtotime($date1);
$date2 = strtotime($date2);
    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();
 
    $tmp = $diff;
    $retour['second'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = $tmp % 60;
    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = $tmp % 24;
    $tmp = floor( ($tmp - $retour['hour'])  / 24 );
    $retour['day'] = $tmp; 
    return $retour['day'];
}


function connexionBdd(&$bdd){
try
{
// Changer les paramètres de connexion à votre base de données  ( la ligne 45 )
$username="Hind";
$password="123HIND"; 
$bdd = new PDO('mysql:host=localhost:8080;dbname=congedb',$username,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch (Exception $e)
{die('Erreur : ' . $e->getMessage());}
}

function verifySession(){
if(!isset($_SESSION['cin']) or !isset($_SESSION['login']))
{  deconnexion();}}

function demander($cin,$dateRetour,$dateDepart){
$bdd;
connexionBdd($bdd);
$req= $bdd->prepare('SELECT joursrest FROM personnel WHERE cin = :cin');
$req->execute(array(':cin' => $cin));
$result=$req->fetch();
$diffDays=dateDiff($dateRetour,$dateDepart)+1;
if (($diffDays <= $result['joursrest']) && $diffDays !=0)
{ $dateNow=date('Y-m-d');
    $etat=0;
	$req = $bdd->prepare('INSERT INTO demande(CIN,DateDepart,DateRetour,DateDemande,Etat) VALUES(:CIN,:DateDepart,:DateRetour,:DateDemande,:Etat)');
    $req->execute(array(
':CIN' => $cin,
':DateDepart' => $dateDepart,
':DateRetour' => $dateRetour,
':DateDemande' =>$dateNow,
':Etat' => 0));
$result['joursrest']=$result['joursrest']-$diffDays;
$req = $bdd->prepare('UPDATE personnel SET joursrest= :newval WHERE cin = :cin');
$req->execute(array(
':newval' => $result['joursrest'],
':cin' => $cin));
$to="y.abainou@gmail.com";
$subject="Demande de congé " ;
$message="Une nouvelle demande en attente d'aprobation \n Visiter : http://localhost:1234/Myapp/listeDemandes.php ";
$message=nl2br($message);
EnvoyerEmail($to,$subject,$message);
$message='La demande a bien été envoyée ! ';
return $message;
}elseif ($diffDays > $result['joursrest']){
$message='Vous avez dépassé le nombre de jours permis!';
return $message;    }
elseif($diffDays ==0){
$message='Veuillez remplir les deux champs';
return $message;    
}
}



 function MesDemandes($cin){
$bdd;
connexionBdd($bdd);
$req= $bdd->query('SELECT * FROM demande WHERE CIN=\'' . $cin. '\' ORDER BY ID DESC');
//$req= $bdd->prepare('SELECT * FROM demande WHERE CIN = ? ORDER BY ID DESC');
//$reponse=$req->execute(array($cin));
return $req ;
}

 function LesDemandes(){
$bdd;
connexionBdd($bdd);
$req= $bdd->query('SELECT * FROM demande ORDER BY ID DESC');
//$reponse=$req->execute(array(':cin' => $cin));
return $req ;
}

function EtatDemande($id,$val){
$bdd;
connexionBdd($bdd);
$var=InfosDemandes($id);
$req = $bdd->prepare('UPDATE demande SET Etat = :petat WHERE ID = :pid');
$req->execute(array(
':petat' => $val,
':pid' => $id
));
if($val==-1){
    //Incrémenter le nombre des jours restants
$req=$bdd->query('SELECT DateDepart,DateRetour FROM demande where id=\'' . $id. '\'');
$req=$req->fetch();
$diffDays=dateDiff($req['DateRetour'],$req['DateDepart'])+1;
$req= $bdd->prepare('SELECT joursrest FROM personnel WHERE cin = :cin');
$req->execute(array(':cin' => CinFromID($id)
));
$donnees=$req->fetch();
$joursrest=$donnees['joursrest']+$diffDays;
$req = $bdd->prepare('UPDATE personnel SET  joursrest= :pjrs WHERE cin = :pcin');
$req->execute(array(
':pjrs' => $joursrest,
':pcin' => CinFromID($id)
));
}

elseif($val==1)
{
   if($var==-1){
        //Décrémenter le nombre des jours restants
$req=$bdd->query('SELECT DateDepart,DateRetour FROM demande where id=\'' . $id. '\'');
$req=$req->fetch();
$diffDays=dateDiff($req['DateRetour'],$req['DateDepart'])+1;
$req= $bdd->prepare('SELECT joursrest FROM personnel WHERE cin = :cin');
$req->execute(array(':cin' => CinFromID($id)
));
$donnees=$req->fetch();
$joursrest=$donnees['joursrest']-$diffDays;
$req = $bdd->prepare('UPDATE personnel SET  joursrest= :pjrs WHERE cin = :pcin');
$req->execute(array(
':pjrs' => $joursrest,
':pcin' => CinFromID($id)
));
                          }  
}

elseif($val==0)
{
   if($var==-1){
        //Décrémenter le nombre des jours restants
$req=$bdd->query('SELECT DateDepart,DateRetour FROM demande where id=\'' . $id. '\'');
$req=$req->fetch();
$diffDays=dateDiff($req['DateRetour'],$req['DateDepart'])+1;
$req= $bdd->prepare('SELECT joursrest FROM personnel WHERE cin = :cin');
$req->execute(array(':cin' => CinFromID($id)
));
$donnees=$req->fetch();
$joursrest=$donnees['joursrest']-$diffDays;
$req = $bdd->prepare('UPDATE personnel SET  joursrest= :pjrs WHERE cin = :pcin');
$req->execute(array(
':pjrs' => $joursrest,
':pcin' => CinFromID($id)
));
                            }  
}
}

function SupprimerDemande($id){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT DateDepart,DateRetour FROM demande where id=\'' . $id. '\'');
$req=$req->fetch();
$diffDays=dateDiff($req['DateRetour'],$req['DateDepart'])+1;
$req= $bdd->prepare('SELECT joursrest FROM personnel WHERE cin = :cin');
$req->execute(array(':cin' => CinFromID($id)
));
$donnees=$req->fetch();
$joursrest=$donnees['joursrest']+$diffDays;
$req = $bdd->prepare('UPDATE personnel SET  joursrest= :pjrs WHERE cin = :pcin');
$req->execute(array(
':pjrs' => $joursrest,
':pcin' => CinFromID($id)
));
$req = $bdd->prepare('DELETE FROM demande WHERE ID = :pid');
$req->execute(array(':pid' => $id));
}

function verifyAdmin(){
if(isset($_SESSION['admin'])){
	if($_SESSION['admin']==0) 
       { return false;}
   else{return true ;}}
else{ 
return false;}
}

function TousPersonnels(){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT * FROM personnel ORDER BY nom ASC');
return $req; 
}
function InfosPersonnel($id){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT * FROM personnel WHERE cin=\'' . strtoupper(htmlspecialchars(trim($id))). '\'');
$rep=$req->fetch();
return $rep; 
}

function InfosPersonnel2($id){
 $bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT * FROM personnel WHERE cin=\'' .strtoupper(htmlspecialchars(trim($id))). '\'');
return $req;    
}

function InfosPersonnelFromDiv($div){
  $bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT * FROM personnel WHERE division=\'' .$div. '\'');
return $req;   
}

function InfosPersonnelFromGrade($grade){
 $bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT * FROM personnel WHERE grade=\'' .$grade. '\'');
return $req;   
}
function InfosPersonnelFromAdmin($admin){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT * FROM personnel WHERE admin=\'' .htmlspecialchars(trim($admin)). '\'');
return $req;   
}
function SupprimerPersonnel($id){
$bdd;
connexionBdd($bdd);
$req = $bdd->prepare('DELETE FROM personnel WHERE cin = :pcin');
$req->execute(array(':pcin' => $id));
}

function CinFromID($id){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT CIN FROM demande WHERE ID=\'' . $id. '\' ');
$rep=$req->fetch();
return $rep['CIN'];
}

function DemandesEnAttente(){
$bdd;
connexionBdd($bdd);
$req= $bdd->query('SELECT * FROM demande WHERE Etat=0 ORDER BY ID DESC');
return $req ;
}

function DemandesAcceptee()
{
$bdd;
connexionBdd($bdd); 
$req= $bdd->query('SELECT * FROM demande WHERE Etat=1 ORDER BY ID DESC ');
return $req ;
}

function DemandesRefusee()
{
$bdd;
connexionBdd($bdd);
$req= $bdd->query('SELECT * FROM demande WHERE Etat= -1 ORDER BY ID DESC');
return $req ;

}

function notifications(){
$bdd;
connexionBdd($bdd);	
$req= $bdd->query('SELECT count(*) AS NbenAttente FROM demande WHERE Etat= 0 ');
$rep=$req->fetch();
return $rep['NbenAttente'];
}

function InfosDemandes($id){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT Etat FROM demande WHERE ID=\'' . $id. '\'');
$rep=$req->fetch();
return $rep['Etat'];
}
function GetDivision(){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT  distinct division FROM personnel ');
return $req;
}

function GetGrade(){
$bdd;
connexionBdd($bdd);
$req=$bdd->query('SELECT  distinct grade FROM personnel ');
return $req;
}

?>
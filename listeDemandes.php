<?php
session_start();?>
<html>
<head>
	<title>Liste des demandes</title>
<style type="text/css">
.container{
    box-shadow: 1px 1px 30px black;
   	width:85%;
   	background-color: rgb(151,199,222);
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 1%;
    }
button:hover{background-color: rgb(151,199,222);}
footer{text-align: center;margin-top: 3%; }
body{background-color: #EEE;}
.notifdiv{ border:1px  dotted black;text-align: center;margin-left:auto;margin-right:auto;margin-top:1%;background-color:#EEF;width:40%; }  
.notif,span{color:red;}
a{text-decoration: none;}
button{
	background-color: #EEF;
	text-align: right;
	width: 170px;
	height: 6%;
	background-repeat: no-repeat;
	background-position: center left;
}
header{text-align: center;background-color: #EEF;}
  fieldset{background-color:#EEF;margin-top:0px;margin-left: auto;margin-right: auto; width: 90%;}
form{text-align: center;
display: inline-block;
}

   table{width: 100%;height: 30%;}
input[name="pasEncore"]{

width: 20px; height: 20px; /* dim. de la case */
  border: 5px solid red;
  background: white;
  border-radius: 3px; /* angles arrondis */
  box-shadow: inset 0 1px 3px blue ;/* légère ombre interne */}
input[name="refuser"]{

width: 20px; height: 20px; /* dim. de la case */
  border: 5px solid red;
  background: white;
  border-radius: 3px; /* angles arrondis */
  box-shadow: inset 0 1px 3px red;/* légère ombre interne */}
  input[name="accepter"]{

width: 20px; height: 20px; /* dim. de la case */
  border: 5px solid red;
  background: white;
  border-radius: 3px; /* angles arrondis */
  box-shadow: inset 0 3px 3px green;/* légère ombre interne */}
input[value="Confirmer"]{
height: 20px;
margin-left: 8px;

}

table{
  border-color: rgb(151,199,222);
}
.choix{
width: 75%;
margin-left: auto;
margin-right: auto;
text-align: center;
}

input[value="Demandes En attente"]{
height: 50px;
width: 180px;
background-repeat: no-repeat;
background-position: center left;
text-align: right;
background-image: url('att.png');
background-color: #EEF;
}
input[value="Demandes Acceptées"]{
height: 50px;
width: 180px;
background-repeat: no-repeat;
background-position: center left;
text-align: right;
background-image: url('ok.png');
background-color: #EEF;
}
input[value="Demandes Refusées"]{
height: 50px;
width: 180px;
background-repeat: no-repeat;
background-position: center left;
text-align: right;
background-image: url('no.png');
background-color: #EEF;}
input[value="Toutes les demandes"]{
height: 50px;
width: 180px;
background-repeat: no-repeat;
background-position: center left;
text-align: right;
background-image: url('tt.png');
background-color: #EEF;}
</style>

</head>
<body>
<div class="container">

<?php
include_once('config.php');

verifySession(); 
if(verifyAdmin()==false){
header('Location:MesDemandes.php');
}
if(isset($_POST['accepter'])){
EtatDemande($_POST['accepter'],1);
$cin1=CinFromID($_POST['accepter']);
$emailPer=InfosPersonnel($cin1);
$subject="Etat de la demande de congé ";
$message="Votre demande est acceptée \n Consulter : http://localhost:1234/Myapp/MesDemandes.php  ";
EnvoyerEmail($emailPer['email'],$subject,$message);

}
if(isset($_POST['refuser'])){
EtatDemande($_POST['refuser'],-1);
$cin1=CinFromID($_POST['refuser']);
$emailPer=InfosPersonnel($cin1);
$subject="Etat de la demande de congé ";
$message="Votre demande est refusée \n Consulter : http://localhost:1234/Myapp/MesDemandes.php  ";
EnvoyerEmail($emailPer['email'],$subject,$message);
}
if(isset($_POST['pasEncore'])){
EtatDemande($_POST['pasEncore'],0);
$cin1=CinFromID($_POST['pasEncore']);
$emailPer=InfosPersonnel($cin1);
$subject="Etat de la demande de congé ";
$message="Votre demande est en cours de traitement \n Consulter : http://localhost:1234/Myapp/MesDemandes.php  ";
EnvoyerEmail($emailPer['email'],$subject,$message);
}
if(isset($_GET['all'])){
$reponse=LesDemandes();
}

if(isset($_GET['enAttente'])){
$reponse=DemandesEnAttente();
}

elseif(isset($_GET['acceptee'])){
$reponse=DemandesAcceptee();
}

elseif(isset($_GET['refusee'])){
$reponse=DemandesRefusee();
}
else{
$reponse=LesDemandes();
}
include_once('header.php');
?>

<div class="choix">
<form action="listeDemandes.php" method="get">
	<input type="hidden" name="all" value="1"> 
    <input type="submit" value ="Toutes les demandes" > 
</form>
<form action="listeDemandes.php" method="get">
	<input type="hidden" name="enAttente" value="1"> 
    <input type="submit" value ="Demandes En attente" > 
</form>
<form action="listeDemandes.php" method="get">
	<input type="hidden" name="acceptee" value="1"> 
    <input type="submit" value ="Demandes Acceptées" > 
</form>
<form action="listeDemandes.php" method="get">
	<input type="hidden" name="refusee" value="1"> 
    <input type="submit" value ="Demandes Refusées" > 
</form>

</div>
<fieldset><legend><img src="tt2.png"></legend>
<table border="2" style="text-align:center">
<tr><th>Personnel</th><th>ID demande</th><th>Date demande</th><th>Date départ</th><th>Date retour</th><th>Nbr jours </th><th class="etat">Etat</th></tr>

<?php
while($donnees=$reponse->fetch())
{
	$infos=InfosPersonnel($donnees['CIN']);
	$choixE=true;$choixA=true;$choixR=true;
	$Etat=$donnees['Etat'];
switch ($Etat) {
	
		case '-1':
			$Etat='Refusée';$choixR=false;break;
	    case '0':
			$Etat='En cours de traitement';$choixE=false;
			break;		
		case '1':
			$Etat='Acceptée';$choixA=false;
			break;
			default : break;

	}

$days=dateDiff($donnees['DateRetour'],$donnees['DateDepart'])+1;

	echo "<tr><td>".$infos['nom']." ".$infos['prenom']."</td><td>".$donnees['ID']."</td><td>".$donnees['DateDemande']."</td><td>".$donnees['DateDepart']."</td><td>".$donnees['DateRetour']."</td><td>".$days."</td><td>".$Etat."<br>";
    $id=$donnees['ID'];

$path=$_SERVER['REQUEST_URI'];
$query=parse_url($path, PHP_URL_QUERY);
$path="";
switch ($query) {
		case 'enAttente=1':
$path="enAttente=1";
			break;
	    case 'acceptee=1':
$path="acceptee=1";
			break;		
		case 'refusee=1':
$path="refusee=1";
			break;
		case 'all=1':
$path="all=1";
			break;
	
}
$lien="listeDemandes.php?".$path;
    echo "
        
              <form method=\"post\" action=\"$lien\">";
                  if($choixE){echo "<input type=\"checkbox\" name=\"pasEncore\" value=\"$id\" id=\"ch3\"/> <label for=\"ch3\">En cour  de traitement </label>";}

              if($choixA){ echo "<input type=\"checkbox\" name=\"accepter\" value=\"$id\" id=\"ch1\"/> <label for=\"ch1\">Accepter</label> ";}

    if($choixR){echo "<input type=\"checkbox\" name=\"refuser\" value=\"$id\" id=\"ch2\"/> <label for=\"ch2\">Refuser</label>";}
    echo "<input type=\"submit\" value =\"Confirmer\" > 
    </form>       
     ";
}
echo "</td></th></table>";	
?>
</fieldset>
<?php include_once("footer.html");?>

<br>
</div>
</body>
</html>
<?php $reponse->closeCursor();?>


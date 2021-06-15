<?php
session_start();
?>
<html>
<head>
<title> Mes Demandes</title>
<style type="text/css">
.container{
    box-shadow: 1px 1px 30px black;
   	width:85%;
   	background-color: rgb(151,199,222);
    margin-left: auto;
    margin-right: auto;
    }
button:hover{background-color: rgb(151,199,222);}
footer{text-align: center;margin-top: 3%;}
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
  fieldset{background-color:#EEF;margin-top:1%;margin-left: auto;margin-right: auto; width: 60%;}
form{text-align: center;}

   table{width: 100%;height: 30%;}

</style>

</head>
<body>
<div class="container">	
<?php
include_once('header.php');
include_once('config.php');
verifySession(); 
if(isset($_POST['supprimer'])){
SupprimerDemande($_POST['supprimer']);
}
$reponse=MesDemandes($_SESSION['cin']);
?>
<fieldset><legend><img src="demande.png"></legend>
<table border="2" style="text-align:center">
<tr><th>ID demande</th><th>Date demande</th><th>Date départ</th><th>Date retour</th><th>Nbr jours </th><th>Etat</th></tr>
<?php
while($donnees=$reponse->fetch())
{
	$Etat=$donnees['Etat'];
switch ($Etat) {
	
		case '-1':
			$Etat='Refusée';
			break;
	    case '0':
			$Etat='En cours de traitement';
			break;		
		case '1':
			$Etat='Acceptée';
			break;
			default : break;
	}
?>

<?php
$days=dateDiff($donnees['DateRetour'],$donnees['DateDepart'])+1;
	echo "<tr><td>".$donnees['ID']."</td><td>".$donnees['DateDemande']."</td><td>".$donnees['DateDepart']."</td><td>".$donnees['DateRetour']."</td><td>".$days."</td><td>".$Etat;
    $id=$donnees['ID'];
    if($Etat=="En cours de traitement"){
    
    echo "
        
              <form method=\"post\" action=\"MesDemandes.php\">
    <input type=\"checkbox\" name=\"supprimer\" value=\"$id\" id=\"ch4\"/> <label for=\"ch4\">Annuler la demande</label><br>
    <input type=\"submit\" value =\"Confirmer\" > 
    </form>       
        
</td></tr>";

}

echo "<br>";	
}
?>
</table>
<br>
</fieldset>
<?php
$reponse->closeCursor();
?>

<?php include_once("footer.html");?>
<br>
</div>
</boyd>
</html>
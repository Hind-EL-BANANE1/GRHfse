
<header >
<div >
<img src="logo2.png" style="width:10%; box-shadow: 1px 1px 5px black;">
<img src="banner3.bmp" style="width:60%;  box-shadow: 1px 1px 5px black;margin-left:50px;">

<!--<img src="logotar.png"style="width:10%; box-shadow: 1px 1px 5px black;">-->
</div>
<br>
<nav>
	<a href="index.php"><button style="width:85px;background-image: url('dd0.png');">Accueil</button></a>
	<a href="demander.php"><button style="width: 170px; background-image: url('dd.png');"> Demander un congé</button></a>
	<a href="MesDemandes.php"><button style="width: 140px;background-image: url('dd2.png');"> Mes demandes</button></a>

<?php
include_once('config.php');
if (verifyAdmin()==true) {
?>
	<a href="listeDemandes.php"><button style="	background-image: url('dd6.png');"> Liste des demandes </button></a>
	<a href="listePersonnels.php"><button style="	background-image: url('dd4.png');"> Liste des personnels</button></a>
	<a href="Inscription.php"><button style="background-image: url('dd5.png');"> Ajouter un personnel </button></a>

<?php
}
echo "
<a href=\"deconnexion.php\"><button style=\"width:85px;; background-image: url('deconect.png');\">Quitter</button></a>";
?>
</nav>

<?php
if(verifyAdmin()==true){
$val=notifications();
echo " <div class=\"notifdiv\"> <img src=\"notif.png\"/><p>Bonjour <i><b>".$_SESSION['nom']." ".$_SESSION['prenom']."</i></b> , Vous avez <span><b>".$val." </span></b><a class=\"notif\" href=\"listeDemandes.php?enAttente=1\">  Demande(s) en attente</a></p></div>";
}
?>

<hr>
</header>

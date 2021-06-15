<?php
if(isset($_POST['pass']) & isset($_POST['login'])){
$pass_hache=crypt($_POST['pass'],"x5ncisx5");
try{$bdd = new PDO('mysql:host=localhost:8080;dbname=congedb', 'Hind', '');}catch (Exception $e){die('Erreur : ' . $e->getMessage());}
$req = $bdd->prepare('SELECT cin ,nom,prenom,admin FROM personnel WHERE login = :login AND pass = :pass');
$req->execute(array(':login' => $_POST['login'], ':pass'=> $pass_hache));
$resultat=$req->fetch();
if(!$resultat){
?>
<html> 
<head>
	<style type="text/css">
	   body{background-image: url('aaa.jpg');}
	   fieldset{background-color:#EEF;margin-top:10%;margin-left: auto;margin-right: auto; width: 30%; text-align: center;}
       h3{ color: red;}
	</style>
</head>	
<body>
<fieldset><legend><img src="lock.png"></legend>
        <h3>Login ou mot de passe incorrecte  ! </h3>
        <a href="Connection.php">Réessayer ... </a>
</fieldset>
</body>
</html>
<?php
exit();
}
else{
session_start();
$_SESSION['cin']=$resultat['cin'];
$_SESSION['login']=$_POST['login'];
$_SESSION['nom']=$resultat['nom'];
$_SESSION['prenom']=$resultat['prenom'];
$_SESSION['admin']=$resultat['admin'];
header('Location: index.php');
}}
?>
<html>
<head>
	<title> Identifiez-vous</title>
<style type="text/css">
   body{background-color: #EEE;}
   fieldset{background-color:#EEF;margin-top:2%;margin-left: auto;margin-right: auto; width: 50%;}
   form{text-align:center; margin-top: 2em;}
   footer{text-align: center;margin-top: 5%;}
  .container{
  box-shadow: 1px 1px 30px black;
   	width:50%;
   	margin-top: 8%;
   	background-color: rgb(151,199,222);
   margin-left: auto;
   margin-right: auto;
   }
.header{
text-align: center;
}
.confirm{
	text-align: center;
	margin-top:0px; ;
margin-bottom: 1em;
color: ;
border:1px solid #a2d246;
width: 70%;
margin-left: auto;
margin-right: auto;
background-color: #ebf8a4;
}
</style>
</head>
<body>
	<div class="container">
<div class="header">
<img src="banner2.bmp" style="width:100%;">
</div><hr>
<fieldset><legend><img src="lock.png"></legend>
<form method="post" action="Connection.php">
	<input type="text" name="login" placeholder="Nom d'utilisateur" required /><br><br>
	<input type="password" name="pass" placeholder="Mot de passe "  required /><br><br>
	<input type="submit" Value="Connexion" />
</form>
    </fieldset>
<?php include_once("footer.html");?>
<br>
 </div>   

</body>
</html>

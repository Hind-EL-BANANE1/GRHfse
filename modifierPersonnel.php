<?php
session_start();
include_once('config.php');
verifySession();
if(verifyAdmin()==false){
header('Location:accueil.php');
}
if(isset($_POST['newValue'])){

try
{
$bdd = new PDO('mysql:host=localhost;dbname=congedb','root','');
}catch (Exception $e)
{die('Erreur : ' . $e->getMessage());}
?>
<?php
if( isset($_POST['cin']) &&  isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['grade']) && isset($_POST['division']) && isset($_POST['login']) && isset($_POST['tel']) && isset($_POST['adresse']) && isset($_POST['email']) && isset($_POST['jtot']) && isset($_POST['jrest']) && isset($_POST['admin']))
{
$req = $bdd->prepare('UPDATE  personnel set cin=:pcin ,nom=:pnom,prenom=:pprenom,grade=:pgrade,division=:pdivision,tel=:ptel,adresse=:padresse,jourstot=:pjourstot,joursrest=:pjoursrest,login=:plogin,admin=:padmin,email=:pemail WHERE cin=\'' . $_POST['modifierPers']. '\'');
$req->execute(array(':pcin' => strtoupper(htmlspecialchars(trim($_POST['cin']))),':pnom' => ucfirst(strtolower(htmlspecialchars(trim($_POST['nom'])))),':pprenom' => ucfirst(strtolower(htmlspecialchars(trim($_POST['prenom'])))),
':pgrade' => ucfirst(strtolower(htmlspecialchars(trim($_POST['grade'])))),
':pdivision' => ucfirst(strtolower(htmlspecialchars(trim($_POST['division'])))),
':ptel' => htmlspecialchars($_POST['tel']),
':padresse' => htmlspecialchars($_POST['adresse']),
':pjourstot' => htmlspecialchars($_POST['jtot']),
':pjoursrest' => htmlspecialchars($_POST['jrest']),
':plogin' => htmlspecialchars($_POST['login']),
':padmin' => $_POST['admin'],
':pemail' => $_POST['email']
));
$message =" Modification terminée !";

}
else {
echo " <script language=\"JavaScript\"> alert(\"Veuillez remplir tous les champs ...\") </script>";
}
}
if(isset($_POST['modifierPers'])){
$reponse=InfosPersonnel($_POST['modifierPers']);


}
?>
<html>
<head><title>Modifier le personnel </title>
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
	     .submit{text-align: center;}
input[Value="Valider les Modifications"]{
height: 50px;
width: 190px;
background-repeat: no-repeat;
background-position: center left;
text-align: right;
background-image: url('ok.png');
background-color: #EEF;
}
  fieldset{background-color:#EEF;margin-top:0px;margin-left: auto;margin-right: auto; width: 40%;}
.confirm{
	text-align: center;
	margin-top:0px; ;
margin-bottom: 1em;
color: ;
border:1px solid #a2d246;
width: 60%;
margin-left: auto;
margin-right: auto;
background-color: #ebf8a4;
}
</style>
</head>
<body>
<div class="container">
<?php include_once('header.php');?>	
	<fieldset><legend><img src="pers.png"></legend>
<form method="post" action="modifierPersonnel.php">
	<?php if(isset($message)){?><p class="confirm"><em> <?php echo $message;}?></em></p>

	    <table border="0" cellspacing="5" >
<tr><td><label>Nom : </label></td><td><input type="text" name="nom" size="30" value ="<?php echo $reponse['nom'];?>"  /></tr></td>
<tr><td>	<label>Prénom :</label></td><td><input type="text" name="prenom" size="30" value ="<?php echo $reponse['prenom'];?>"  /></tr></td>
<tr><td>	<label>CIN :</label></td><td><input type="text" name="cin" size="30" value ="<?php echo $reponse['cin'];?>"/></tr></td>
<tr><td>	<label>Grade :</label></td><td><input type="text" name="grade" size="30" value ="<?php echo $reponse['grade'];?>"/></tr></td>
<tr><td>	<label>Division :</label></td><td><input type="text" name="division" size="30" value ="<?php echo $reponse['division'];?>"/></tr></td>
<tr><td>	<label>Login :</label></td><td><input type="text" name="login" size="30" value ="<?php echo $reponse['login'];?>"/></tr></td>
<tr><td>	<label>Tél :</label></td><td><input type="tel" name="tel" size="30" value ="<?php echo $reponse['tel'];?>" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$"/></tr></td>
<tr><td>	<label>Adresse :</label></td><td><input type="text" name="adresse" size="30" value ="<?php echo $reponse['adresse'];?>"/></tr></td>
<tr><td>	<label>Email</label></td><td><input type="email" name="email" size="30" value ="<?php echo $reponse['email'];?>"/></tr></td>
<tr><td>	<label>Nbr Jours Total</label></td><td><input type="number" name="jtot" size="30" min="0"  value ="<?php echo $reponse['jourstot'];?>"/></tr></td>
<tr><td>	<label>Nbr Jours Restant</label></td><td><input type="number" name="jrest" size="30" min="0"  value ="<?php echo $reponse['joursrest'];?>"/></tr></td>
	<tr><td>Admin ?</td>
    <td><input type="radio" name="admin" value="1" id="ch1" required/> <label for="ch1">Oui</label>
    <input type="radio" name="admin" value="0" id="ch2" required/> <label for="ch2">Non</label></td>
        <input type="hidden"  name="modifierPers"  value="<?php echo $_POST['modifierPers'];?>">
        <input type="hidden"  name="newValue"  value="1">
                        <tr><td></td></tr><tr><td></td></tr>

	 <tr class="submit"><td colspan="2"><input type="submit" Value="Valider les Modifications" /></tr></td>
</table>
</form>
</fieldset>
<?php include_once("footer.html");?><br>
</div>
</body>
</html>



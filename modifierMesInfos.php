<?php session_start();
include_once('config.php');
verifySession();
if(isset($_POST['newValue'])){
try
{
$bdd = new PDO('mysql:host=localhost;dbname=congedb','root','');
}catch (Exception $e)
{die('Erreur : ' . $e->getMessage());}

if(  isset($_POST['pass']) & isset($_POST['pass2']) & isset($_POST['login']) & isset($_POST['tel']) & isset($_POST['adresse']) & isset($_POST['email']) )
{
	if ($_POST['pass']==$_POST['pass2']) {
		$pass_hache=crypt($_POST['pass'],"x5ncisx5");
$req = $bdd->prepare('UPDATE  personnel set tel=:ptel,adresse=:padresse,login=:plogin,pass=:ppass,email=:pemail WHERE cin=\'' . $_SESSION['cin']. '\'');
$req->execute(array(
':ptel' => htmlspecialchars($_POST['tel']),
':padresse' => ucfirst(strtolower(htmlspecialchars(trim($_POST['adresse'])))),
':plogin' => htmlspecialchars(trim($_POST['login'])),
':ppass' => $pass_hache,
':pemail' => htmlspecialchars(trim($_POST['email']))
));
$message="Modification réussie !";
}
else{
	echo " <script language=\"JavaScript\"> alert(\"les Mots de passe ne sont pas identiques ...\") </script>";

} 
}
else {
echo " <script language=\"JavaScript\"> alert(\"Veuillez remplir tous les champs ...\") </script>";
}
}
if(isset($_SESSION['cin'])){
$reponse=InfosPersonnel($_SESSION['cin']);
}


?>
<html>
<html>
<head>
<title> Modifier mes infos </title>
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
<form method="post" action="modifierMesInfos.php">
	<fieldset><legend><img src="pers.png"></legend>
	<?php if(isset($message)){?><p class="confirm"><em> <?php echo $message;}?></em></p>

	    <table border="0" cellspacing="5" >

<tr><td><label>Login :</label></td><td><input type="text" name="login" size="30" required value ="<?php echo $reponse['login'];?>"/></td></tr>
<tr><td>	<label>Mot de passe :</label></td><td><input type="password" name="pass" size="30" required  /></td></tr>
<tr><td>	<label>Confirmer votre Mot de passe :</label></td><td><input type="password" name="pass2" required size="30" /></td></tr>
<tr><td>	<label>Tél :</label></td><td><input type="tel" name="tel" size="30" required value ="<?php echo $reponse['tel'];?>" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$"/></td></tr>
<tr><td>	<label>Adresse :</label></td><td><input type="text" name="adresse" size="30" required value ="<?php echo $reponse['adresse'];?>"/></td></tr>
<tr><td>	<label>Email</label></td><td><input type="email" name="email" size="30" required value ="<?php echo $reponse['email'];?>"/></td></tr>
             <input type="hidden"  name="newValue"  value="1">
                <tr><td></td></tr><tr><td></td></tr>

	 <tr class="submit"><td colspan="2"><input type="submit" Value="Valider les Modifications" /></tr></td>

</table>
</form>
</fieldset>
<?php include_once("footer.html");?>
<br>
</div>
</body>
</html>

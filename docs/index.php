<?php
session_start();
?>
<html>
<head>
	<title> Accueil </title>
<style type="text/css">
   .container{
  box-shadow: 1px 1px 30px black;
   	width:85%;
   	background-color: rgb(151,199,222);
   margin-left: auto;
   margin-right: auto;
   }
   body{background-color: #EEE;}
   .notifdiv{ border:1px  dotted black;text-align: center;margin-left:auto;margin-right:auto;margin-top:1%;background-color:#EEF;width:40%; }  
  fieldset{background-color:#EEF;margin-top:1%;margin-left: auto;margin-right: auto; width: 40%;}
   table{width: 100%;height: 30%;}
form{text-align: center;}
.notif,span{color:red;}

a{
text-decoration: none;	
}
table{
  border-color: rgb(151,199,222);
}
button{
	background-color: #EEF;
	text-align: right;
	width: 170px;
	height: 6%;
	background-repeat: no-repeat;
	background-position: center left;
}
button:hover{
background-color: rgb(151,199,222);
}
header{
	text-align: center;
		background-color: #EEF;

}

footer{text-align: center;margin-top: 1%;}

</style>
</head>
<body>
	<div class="container">
<?php include_once('header.php');?>
<?php
if(isset($_SESSION['cin']) & isset($_SESSION['login']))
{
	$infos=InfosPersonnel($_SESSION['cin']);
echo "
<fieldset><legend><img src=\"dd3.png\"></legend>
<table border=\"5\" cellspacing=\"2\" style=\"text-align:left\" >
<caption> Mes Coordonnées  </caption>
<tr><th>CIN</th><td>".$_SESSION['cin']."</td></tr>
<tr><th>Nom</th><td>".$_SESSION['nom']."</td></tr>
<tr><th>Prénom</th><td>".$infos['prenom']."</td></tr>
<tr><th>Login</th><td>".$infos['login']."</td></tr>
<tr><th>Grade</th><td>".$infos['grade']."</td></tr>
<tr><th>Division</th><td>".$infos['division']."</td></tr>
<tr><th>Tél</th><td>".$infos['tel']."</td></tr>
<tr><th>Adresse</th><td>".$infos['adresse']."</td></tr>
<tr><th>Email</th><td>".$infos['email']."</td></tr>
<tr><th>JrsTotal</th><td>".$infos['jourstot']."</td></tr>
<tr><th>JrsRestants </th><td>".$infos['joursrest']."</td></tr>
</table>
<form action=\"modifierMesInfos.php\" method=\"post\">
<br>
    <input type=\"submit\" value=\"Modifier les infos \" > 
</form>
</fieldset>
</body>
";
}
else {
header('Location: Connection.php');
}
include_once("footer.html");
?><br>
</div>
</body>
</html>

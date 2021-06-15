<?php
session_start();
include_once('config.php');
verifySession(); 
$message=false;
if (isset($_POST['datedepart']) & isset($_POST['dateretour']))
{
$message=demander($_SESSION['cin'],$_POST['dateretour'],$_POST['datedepart']);
}

?>

<html>
<head>
	<title> Demander un congé</title>
	<style type="text/css">
a{
text-decoration: none;	
}
button{
	background-color: #EEF;
	text-align: right;
	width: 170px;
	height: 6%;
	background-repeat: no-repeat;
	background-position: center left;
}
   body{background-color: #EEE;}
   .notifdiv{ border:1px  dotted black;text-align: center;margin-left:auto;margin-right:auto;margin-top:1%;background-color:#EEF;width:40%; }  
.notif,span{color:red;}
  


header{
	text-align: center;
	background-color: #EEF;
}
   .container{
  box-shadow: 1px 1px 30px black;
   	width:85%;
   	background-color: rgb(151,199,222);
   margin-left: auto;
   margin-right: auto;
   }

  fieldset{background-color:#EEF;margin-top:1%;margin-left: auto;margin-right: auto; width: 50%;}
form{text-align: center;}
.confirm{
margin-bottom: 2em;
color: ;
border:1px solid #a2d246;
width: 60%;
margin-left: auto;
margin-right: auto;
background-color: #ebf8a4;
}
button:hover{
background-color: rgb(151,199,222);
}
footer{text-align: center;margin-top: 3%;}

	</style>
</head>	
<body>
	<div class="container">

<?php include_once('header.php');?>

<fieldset><legend><img src="demande.png"></legend>
<form method="post" action="demander.php">
	<p class="confirm"><em> <?php echo $message;?></em></p>
<label>Date Départ: </label> <input type="date" name="datedepart" required>
<label style="margin-left:1em;">Date Retour : </label><input type="date" name="dateretour" required><br><br>
<input type="submit" value="Envoyer la demande" > 
</form>
</fieldset>
<?php include_once("footer.html");?>
<br>
</div>
</body>
</html>

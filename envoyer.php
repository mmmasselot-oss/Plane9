<?php

//les informations de connexion
$servername = "mysql-plane9.alwaysdata.net";
$username = "plane9";  
$password = ""; 
$dbname = "plane9_formulaire";          

// la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// la vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}
//else echo "connexion réussie";

//on vérifie si l'utilisateur a entré quelque chose dans les champs email et commentaires
$email = isset($_POST['email']) ? $_POST['email'] : '';
$commentaires = isset($_POST['commentaires']) ? $_POST['commentaires'] : '';

//la fonction nettoyer du cours
 function nettoyer($x){
  if ($x){
  $x = trim($x);
  $x = stripslashes($x);
  $x = htmlspecialchars($x);
  }
  return $x;
  }
  
//on nettoie email et commentaires
$semail = nettoyer($email);
$scommentaires = nettoyer($commentaires);

//on récupère les autres champs
$date = $_POST['date'];
$Windows = isset($_POST['Windows']) ? 1 : 0;
$Linux = isset($_POST['Linux']) ? 1 : 0;
$MacOS = isset($_POST['MacOS']) ? 1 : 0;
$ChromeOS = isset($_POST['ChromeOS']) ? 1 : 0;
$BSD_UNIX = isset($_POST['BSD_UNIX']) ? 1 : 0;
$installation = isset($_POST['fonctionné']) ? $_POST['fonctionné'] : '';

//la requête sql
$sql = "INSERT INTO formulaire (id,date_du_jour, Windows, Linux, MacOS, ChromeOS, BSD_UNIX, installation, email, commentaires) VALUES (NULL,'$date', $Windows, $Linux, $MacOS, $ChromeOS, $BSD_UNIX, '$installation', '$semail', '$scommentaires')";

//on tente la requête 
if ($conn->query($sql) === TRUE) {
   echo "Merci !";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

//on ferme la connexion
$conn->close();

//on affiche les valeurs entrées:
echo "<p><ul><li> Date : $date";
echo "<p><li>Vous avez comme distribution(s) :";
	$OS = [$Windows, $Linux, $MacOS, $ChromeOS, $BSD_UNIX];
	$nomsOS = ['Windows', 'Linux','MacOS','ChromeOS', 'BSD/Unix'];
	for ($i = 0; $i < 5; $i++) {
			 if ($OS[$i] == 1)
			 echo "<p>$nomsOS[$i]";}
			  echo "<p></li>";
			  if($installation == "oui")
			  {
			  echo "<li>Vous avez réussi l'installation." ;
			  }
			  else if($installation == "non")
			  {
			  echo "<li>Vous n'avez pas réussi l'installation.";
			  }
			  else if($installation == "nonconcerné")
			  {
			  echo "<li>Vous n'êtes pas concerné par l'installation.";
			  }
			  echo "</li>";
echo "<p><li>Votre email : $semail";
echo "<p><li>Vos commentaires : $scommentaires";
echo "</li></ul>";

?>


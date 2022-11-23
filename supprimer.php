<?php

include_once 'ConnexionBdd.php';
include_once 'VerifCo.php';
$bdd=cobdd();
	session_start();

  if (isAdmin($_SESSION['id'])){ //Si on est un admin
    if($_GET['id']>1) {
      $getid=intval($_GET['id']);// On supprime l'id dans l'url
			$requser = $bdd->prepare("DELETE   FROM membres WHERE id = ?");
			$requser->execute(array($getid));
			$reqnote = $bdd->prepare("DELETE FROM avis WHERE id_user = ?");
			$reqnote->execute(array($getid));
			$reqprop = $bdd->prepare("DELETE FROM add_mini_golf WHERE id_user = ?");
			$reqprop->execute(array($getid));
			header('Location: Profil.php?id='.$_SESSION['id']); //on retoure sur le profil de l'admin
  }else {
    header("Location: Connexion.php");//Si non on retourne a la connexion
  }
}else {
  header("Location: Connexion.php"); //Si non on retourne a la connexion
}
     ?>

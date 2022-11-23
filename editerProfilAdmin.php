<?php
include_once 'ConnexionBdd.php';
$bdd=cobdd();
	session_start();
include_once 'VerifCo.php';
  if (isAdmin($_SESSION['id'])){ // verification que la personne connecter soit un admin
	if($_GET['id']>1) { // verifie si l'id existe
    $getid=intval($_GET['id']);
	   $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
	   $requser->execute(array($getid));
	   $user = $requser->fetch();//recupere le tableau qui correspond a la ligne d'user dans la bdd
	   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
	      $newpseudo = htmlspecialchars($_POST['newpseudo']);
				$newpseudo = str_replace("'" , "\'", $newpseudo);
	      $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
	      $insertpseudo->execute(array($newpseudo, $getid));
	      header('Location: Profil.php?id='.$_SESSION['id']);
	   }
     if(isset($_POST['newbio']) AND !empty($_POST['newbio']) AND $_POST['newbio'] != $user['bio']) {
	      $newbio = htmlspecialchars($_POST['newbio']);
				$newbio = str_replace("'" , "\'", $newbio);
	      $insertbio = $bdd->prepare("UPDATE membres SET bio = ? WHERE id = ?");
	      $insertbio->execute(array($newbio, $getid));
	      header('Location: Profil.php?id='.$_SESSION['id']);
	   } //les deux if ici servent a modifier les information si elles ont été changées
	?>
	<!DOCTYPE html>
	<html lang="fr" dir="ltr">
		<head>
			<meta charset="utf-8">
			<title>Édition profil administrateur</title>
			<link rel="stylesheet" href="css/acceuil.css">
		</head>
		<body>
			 <?php include_once 'Header.php'; ?>
	      <div class="profil">
	         <h2>Edition de le profil de <?php $user['pseudo'] ?></h2>
	         <div class="champdemodif">
	            <form method="POST" action="#" enctype="multipart/form-data">
	               <label>Pseudo :</label>
	               <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php //on le rempli initalement avec les information deja presente
								 echo $user['pseudo']; ?>" /><br /><br />
                 <label>biographie :</label>
	               <input type="text" name="newbio" placeholder="Biographie" value="<?php echo $user['bio']; ?>" /><br /><br />
	               <input type="submit" value="Mettre à jour le profil" />
	            </form>
	            <?php if(isset($msg)) { echo $msg; } ?>
	         </div>
	      </div>
				<br>
				<br>
				<br>
				<div class="avis">
				<?php
				//on affiche les differentes note de l'utilisateur en proposant de les supprimer si on veut
				include_once 'NoteAux.php';
			afficheAvisDUser($getid, $_SESSION['id']);
				 ?>
			 </div>
	   </body>
	</html>
	<?php
	}
	else {
	   header("Location: Connexion.php");
	}
}else {
  header("Location: Connexion.php");
}
	?>

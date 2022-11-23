<?php
include_once 'ConnexionBdd.php';
$bdd=cobdd();

	session_start();

	if(isset($_GET['id']) AND $_GET['id'] > 0) {
	   $getid = intval($_GET['id']);
	   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
	   $requser->execute(array($getid));
	   $userinfo = $requser->fetch(); //On recupere les information a la ligne de la bdd
	?>
	<!DOCTYPE html>
	<html lang="fr" dir="ltr">
		<head>
			<meta charset="utf-8">
			<title>Profil</title>
			<link rel="stylesheet" href="css/acceuil.css">
		</head>
		<body>
			 <?php include_once 'Header.php';
			 include_once 'VerifCo.php';?>
			 <div class="info">
				 <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
				 <br />
				 Mail : <?php echo $userinfo['mail']; ?>
				 <br />
				 Biographie : <?php echo $userinfo['bio']; ?>
	         <?php
					 if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { // on verifie que la personne qui est sur la page est la personne du profil
						 //On proposee donc de se Deconnecter et ou d'éditer le profil
					 if (isAdmin($getid)) { //Si il est admin
					 	?>
						<div class="option">
							<br>
							<a href="EditionProfil.php">Editer mon profil</a>
							<a href="Deconnexion.php">Se déconnecter</a>
							<br>
						</div>
						<?php
						//On porpose de voir les diffenrente chose en tant qu'admin comme les avis signaler ou la suggestion de mini golf
						$reqrep = $bdd->prepare('SELECT * FROM avis WHERE report = 1');
 					 $reqrep->execute();
 					 $isrepor	= $reqrep->rowCount();
					 if ($isrepor!=0) {
					 	?>
						<br>
						<div class="reportaff">
							<h2>Il y a des avis qui ont été signalés</h2>
							<a href="ListeAvisReported.php">Les avis signalés</a>
							<br>
							<br>
						</div>
						<?php
					 }
					 ?>
					 <br>
					 <?php
					if (golfAAjouter()) {//Verifie qu'il y a des golf proposer
						 ?>
						 <div class="ajoutGolf">
							 <h2><a href="AjouterGolf.php">De nouveaux miniGolfs ont été proposé</a></h2>
						 </div>
						 <br>
					 <div class="listeuser">
						 <h2> Listes des utilisateurs </h2>
						 <?php
						 //On affiche les user pour voir leur profis ou supprimer leur compte
						 $reqliste = $bdd->prepare("SELECT pseudo , id FROM membres WHERE id != 1");
						 $reqliste->execute();
						 $tabuser = $reqliste->fetchAll();
						 foreach ($tabuser as $key => $value) {
							 echo "<br /> \n <a href=\"editerProfilAdmin.php?id=".$value['id']."\">".$value['pseudo']." </a> ";
							 echo "\n <a href=\"supprimer.php?id=".$value['id']."\">Supprimer le compte</a>";
						 }
						 ?>
					 </div>
		          <?php
		        }
					}else { //else du if si est admin
	         ?>
	         <br>
	         <a href="EditionProfil.php">Editer mon profil</a>
	         <a href="Deconnexion.php">Se déconnecter</a>
					 <br>
	         <?php
				 }
	         }
					 ?>
					 <?php
					 include_once 'affichageDesNotes.php';
					 ?>
					 <br>
					 <div class="sesnotes">
					 <?php if (!isAdmin($_SESSION['id'])) {
						 ?>
					 <h3>Liste de ses avis</h3>
					 <?php
					 if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
						 ListeNoteConnected($getid);//Affichge les not si il est connecter et proposer de les supprimer
					 }else {
						 if (isAdmin($_SESSION['id'])) {
							 ListeNoteConnected($getid);//Affichge les not si il est connecter et proposer de les supprimer
						 }else {
							 listeNote($getid);//Affiche les avis de l'utilisateur
						 }
					 }
	         ?>
			<?php } ?>
		</div>
		</div>
	   </body>
	</html>
	<?php
}else{
	header('Location: Acceuil.php');
}
	?>

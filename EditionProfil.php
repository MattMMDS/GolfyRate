<?php
include_once 'ConnexionBdd.php';
$bdd=cobdd();
	session_start();
	//on verifi si l'utilisateur est connecter et suite on fait des verification
	//Si un des champs a été modifier on le change dans la base de donnes si non on ne fait rien
	if(isset($_SESSION['id'])) {
	   $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
	   $requser->execute(array($_SESSION['id']));
	   $user = $requser->fetch();
	   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
	      $newpseudo = htmlspecialchars($_POST['newpseudo']);
				$newpseudo = str_replace("'" , "\'", $newpseudo);
	      $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
	      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
	      header('Location: Profil.php?id='.$_SESSION['id']);
	   }
	   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
	      $newmail = htmlspecialchars($_POST['newmail']);
				$newmail = str_replace("'" , "\'", $newmail);
	      $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
	      $insertmail->execute(array($newmail, $_SESSION['id']));
	      header('Location: Profil.php?id='.$_SESSION['id']);
	   }
     if(isset($_POST['newbio']) AND !empty($_POST['newbio']) AND $_POST['newbio'] != $user['bio']) {
	      $newbio = htmlspecialchars($_POST['newbio']);
				$newbio = str_replace("'" , "\'", $newbio);
	      $insertbio = $bdd->prepare("UPDATE membres SET bio = ? WHERE id = ?");
	      $insertbio->execute(array($newbio, $_SESSION['id']));
	      header('Location: Profil.php?id='.$_SESSION['id']);
	   }
	   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
	      $mdp1 = sha1($_POST['newmdp1']);
	      $mdp2 = sha1($_POST['newmdp2']);
	      if($mdp1 == $mdp2) {
	         $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
	         $insertmdp->execute(array($mdp1, $_SESSION['id']));
	         header('Location: Profil.php?id='.$_SESSION['id']);
	      } else {
	         $msg = "Vos deux mdp ne correspondent pas !";
	      }
	   }
	?>
	<html>
	   <head>
	      <title>Edition profil</title>
	      <meta charset="utf-8">
				<link rel="stylesheet" href="css/acceuil.css">
	   </head>
	   <body>
			 <?php include_once 'Header.php'; ?>
	      <div class="profiledi">
	         <h2>Edition de mon profil</h2>
	         <div class="champdemodif">
	            <form method="POST" action="" enctype="multipart/form-data">
	               <label>Pseudo :</label>
	               <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
	               <label>Mail :</label>
	               <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" /><br /><br />
                 <label>biographie :</label>
	               <input type="text" name="newbio" placeholder="Biographie" value="<?php echo $user['bio']; ?>" /><br /><br />
	               <label>Mot de passe :</label>
	               <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br />
	               <label>Confirmation - mot de passe :</label>
	               <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
	               <input type="submit" value="Mettre à jour mon profil !" />
	            </form>
	            <?php if(isset($msg)) { echo $msg; } ?>
	         </div>
	      </div>
	   </body>
	</html>
	<?php
	}
	else {
	   header("Location: Connexion.php");
	}
	?>

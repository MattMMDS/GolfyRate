<?php
include_once 'ConnexionBdd.php';
$bdd=cobdd();

session_start();

if(isset($_POST['formconnexion'])) { // verifie que le formulaire a été validé
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mailconnect= str_replace("'", "\'" , $mailconnect);
   $mdpconnect = sha1($_POST['mdpconnect']); //protege kes differentes information pourne pas avoir d'injection de code
   if(!empty($mailconnect) AND !empty($mdpconnect)) { // verifie que tout les champs soit completer
      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();//compte le nombre de ligne dans la bdd ou les mdp et le mail corresponde au info rempli
      if($userexist == 1) {//Si il y en a une on mais les information dans le tableau session
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: Profil.php?id=".$_SESSION['id']);//on envoi sur la page de son profil
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <title>Connexion</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/acceuil.css">
   </head>
   <body>
     <?php include_once 'Header.php'; ?>
      <div class="conn">
         <h2>Connexion</h2>
         <br /><br />
         <form method="POST" action="">
            <input type="email" name="mailconnect" placeholder="Mail" />
            <input type="password" name="mdpconnect" placeholder="Mot de passe" />
            <br /><br />
            <input type="submit" name="formconnexion" value="Se connecter" />
         </form>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
       </div>
      <div >
      </div>
   </body>
</html>

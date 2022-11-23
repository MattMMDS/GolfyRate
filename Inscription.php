<?php
include_once('ConnexionBdd.php');
$bdd=cobdd();
//La suite d'inscruction permettent de verifier la conformiter des information remplis
if(isset($_POST['forminscription'])) {
	   $pseudo = htmlspecialchars($_POST['pseudo']);
	   $mail = htmlspecialchars($_POST['mail']);
	   $mail2 = htmlspecialchars($_POST['mail2']);
	   $mdp = sha1($_POST['mdp']);
	   $mdp2 = sha1($_POST['mdp2']);
     //On formate les differentes chaines de caractere pour securiser l'implentation de code et la securité des mot de passes
	   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
	      $pseudolength = strlen($pseudo);
	      if($pseudolength <= 255) { //on verifie que le pseudo ne sois pas trop long
          $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?"); //on prepare une requete pour chercher les pseudo que pourrait etre le meme que celui renseigner
                $reqpseudo->execute(array($pseudo));
                $pseudoexist = $reqpseudo->rowCount();//on l'execute et compte le nombre de ligne du tableau renvoyer
                if ($pseudoexist == 0) {// si le nombre de ligne est egale a 0 le pseudon n'est pas dans la base de donné
                  if($mail == $mail2) { // on verifie que les deux mails soit identiques
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) { // on verifie que me mail soit bien un mail
                      $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");//meme processus que pour les mot de passes
                      $reqmail->execute(array($mail));
                      $mailexist = $reqmail->rowCount();
                      if($mailexist == 0) {
                        if($mdp == $mdp2) {// on verefie que les deux mot de passes soit egaux
                          $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
													$pseudo = str_replace("'" , "\'", $pseudo);
													$mail = str_replace("'" , "\'", $mail);
													$mdp = str_replace("'" , "\'", $mdp);
                          $insertmbr->execute(array($pseudo, $mail, $mdp));//on ajoute a la base de donne et propose d'aller se connecter
                          $erreur = "Votre compte a bien été créé ! <a href=\"Connexion.php\">Me connecter</a>";
                        } else { // Ici on a les else de chaque if avec precise quelle est le probleme
                          $erreur = "Vos mots de passes ne correspondent pas !";
                        }
                      } else {
                        $erreur = "Adresse mail déjà utilisée !";
                      }
                    } else {
                      $erreur = "Votre adresse mail n'est pas valide !";
                    }
                  } else {
                    $erreur = "Vos adresses mail ne correspondent pas !";
                  }
                }else{
                  $erreur = "Pseudo déjà utilisé";
                }
              } else {
                $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
              }
            } else {
              $erreur = "Tous les champs doivent être complétés !";
            }
          }
?>

<html>
   <head>
      <title>Inscription</title>
      <meta charset="utf-8">
			<link rel="stylesheet" href="css/acceuil.css">
   </head>
   <body>
		 <?php include_once 'Header.php'; ?>
      <div class="insc">
         <h2>Inscription</h2>
         <br /><br />
         <form method="POST" action="#">
            <table>
               <tr>
                  <td align="right">
                     <label for="pseudo">Pseudo :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mail">Mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mail2">Confirmation du mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp">Mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp2">Confirmation du mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="forminscription" value="Je m'inscris" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($erreur)) {
            echo '<br> <font color="red">'.$erreur."</font>";// on affiche tout ce qu'ils y aurait dans erreur
         }
         ?>
      </div>
   </body>
</html>

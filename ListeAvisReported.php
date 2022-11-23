<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Avis signalé</title>
    <link rel="stylesheet" href="css/acceuil.css">
  </head>
  <body>
    <?php
    session_start();
     include_once 'Header.php';
     ?>
     <div class="avis">
    <h1>Listes des avis signalés</h1>
    <?php
    include_once 'VerifCo.php';
    session_start();
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    if (isAdmin($_SESSION['id'])) { // Seule les administrateur on accées a cette pasge donc si il ne l'est pas in renvoi a l'acceuil
      $reqrep = $bdd->prepare('SELECT * FROM avis WHERE report = 1');
      $reqrep->execute();
      $isrepor	= $reqrep->rowCount(); //On verfifie qu'il y est des avis qui on été signalé
      if ($isrepor!=0) {
        $report	= $reqrep->fetchALL();//Si oui on les affiche et on proposer de les Supprimer un a un ou d'ignorer et suprimer le signalement
        foreach ($report as $key => $value) {
          $requser = $bdd ->prepare('SELECT pseudo FROM membres WHERE id= ?');
          $requser->execute(array($value['id_user']));
          $user = $requser->fetch();
          $reqgolf = $bdd ->prepare('SELECT nom FROM mini_golf WHERE id= ?');
          $reqgolf->execute(array($value['id_golf']));
          $golf = $reqgolf->fetch();
          ?><div class="report">
          <?php
          echo "L'utilisateur ".$user['pseudo']." a commenté : ".$value['com'].". Sur la page du minigolf : ".$golf['nom'];
          echo "
          <form action=\"#\" method=\"post\">
            <input type=\"submit\" name=\"".$user['pseudo'].$value['id_golf']. "\" value=\"Supprimer\" />
            <input type=\"submit\" name=\"unreport".$user['pseudo'].$value['id_golf']. "\" value=\"Ignorer\" />
          </form> ";
          ?>
        </div>
        <br>
          <?php
          $b=$user['pseudo'].$value['id_golf'];
          $a="unreport".$user['pseudo'].$value['id_golf'];
            if (isset($_POST[$b])) {//Si le bouton de suppresont est clique son supprime alors l'avis
            $reqsuppr = $bdd->prepare("DELETE FROM avis WHERE id_user = ? AND id_golf= ?");
            $reqsuppr->execute(array($value['id_user'] , $value['id_golf']));
            header("Refresh:1");
          }elseif (isset($_POST[$a])) { // Si c'est l'autre alors on change la valeur dans la base de donné
            $requpdate = $bdd->prepare("UPDATE avis SET report=0 WHERE id_user = ? AND id_golf= ?");
            $requpdate->execute(array($value['id_user'] , $value['id_golf']));
            header("Refresh:1");
          }
        }

      }else {
        ?>
        <h3>Il n'y a pas d'avis report</h3>
        <?php
      }
    }else {
      header('Location: Acceuil.php');
    }
  ?>
</div>
  </body>
</html>

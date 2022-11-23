<?php
function listeNote($idUser=0)
{
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqnote = $bdd->prepare("SELECT * FROM avis WHERE id_user = ?");
  $reqnote->execute(array($idUser));
  $tabnote = $reqnote->fetchAll();
  //méthode qui permet de recupere et afficher chaque commentaire d'un utilisateur
  foreach ($tabnote as $key => $value) {
    afficheNote($value['id_user'] , $value['id_golf'] , $value['note'] , $value['com']);
  }
}

function afficheNote($idUser , $idGolf , $note , $com)
{
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqgolf = $bdd->prepare("SELECT nom , id FROM mini_golf WHERE id = ?");
  $reqgolf->execute(array($idGolf));
  $golf = $reqgolf->fetchALL();
  // affiche toute les note d'un golf donner sauf celle de la personne connecter qui regarde la page
  echo "\nA noter ".round($note, 2)."/5 le minigolf \n";
  echo "<a href=\"PageMiniGolf.php?id=".$idGolf."\">".$golf[0]['nom']."</a>";
  echo " et a commenté \"".$com."\"";
}

function ListeNoteConnected($idUser=0)
{
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqnote = $bdd->prepare("SELECT * FROM avis WHERE id_user = ?");
  $reqnote->execute(array($idUser));
  $tabnote = $reqnote->fetchAll();
  // méthode qui affiche les note d'un utilisateur et permet de les supprimer si il est connecter ou admin
  foreach ($tabnote as $key => $value) {
    afficheNote($value['id_user'] , $value['id_golf'] , $value['note'] , $value['com']);
    ?><form action="" method="post">
      <input type="submit" name="<?php echo $value['id_user'].$value['id_golf']; ?>" value="Le modifier/Supprimer" />
    </form>
    <?php
    $b=$value['id_user'].$value['id_golf'];
    if (isset($_POST[$b])) {
      $reqsuppr = $bdd->prepare("DELETE FROM avis WHERE id_user = ? AND id_golf= ?");
      $reqsuppr->execute(array($idUser , $value['id_golf']));
      header("Refresh:1");
    }
  }
}
 ?>

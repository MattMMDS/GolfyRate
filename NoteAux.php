<?php function isNoted($iduser , $idgolf)
{
  include_once 'ConnexionBdd.php';
  //méthode qui verifie que l'user est noté ou non le golf
  //renvoit true si il a noté et false si non
  $bdd=cobdd();
  $requser = $bdd->prepare("SELECT * FROM avis WHERE id_user = ? AND id_golf=?");
  $requser->execute(array($iduser, $idgolf));
  $userexist = $requser->rowCount();
  if($userexist == 1) {
    return true;
  }else {
    return false;
  }
}

function quelleNote($iduser , $idgolf)
{
  //méthode qui revoie la note de l'utilisateur
  if(isNoted($iduser , $idgolf)) {
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $requser = $bdd->prepare("SELECT note FROM avis WHERE id_user = ? AND id_golf=?");
  $requser->execute(array($iduser, $idgolf));
  $userexist = $requser->fetch();
  return $userexist['note'];
  }
}
function getCom($iduser , $idgolf)
{
  //méthode qui revoit le commentaire de l'utilisateur
  if(isNoted($iduser , $idgolf)) {
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $requser = $bdd->prepare("SELECT com FROM avis WHERE id_user = ? AND id_golf=?");
  $requser->execute(array($iduser, $idgolf));
  $userexist = $requser->fetch();
  return $userexist['com'];
  }
}

function toNote($iduser , $idgolf , $note , $com)
{
  if(!isNoted($iduser , $idgolf)) {
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    //méthode qui integre l'avis et les information a entrer dans la bdd
    $requser = $bdd->prepare("INSERT INTO avis (id_user , note , id_golf , com) VALUES ( ? , ? , ? , ?)");
    $requser->execute(array($iduser, $note, $idgolf , $com));
  }
}

function getMoyenne($idGolf)
{
  //méthode qui renvoit la moyenne d'un golf ou affiche qu'il n'est pas noté et rnvoi -1 si non
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqnotedugolf = $bdd->prepare("SELECT * FROM avis WHERE id_golf = ?");
  $reqnotedugolf->execute(array($idGolf));
  $dejanote = $reqnotedugolf->rowCount();
  if ($dejanote != 0) {
    $reqmoyenne = $bdd->prepare("SELECT avg(note) FROM avis WHERE id_golf = ?");
    $reqmoyenne->execute(array($idGolf));
    $moyenne = $reqmoyenne->fetch();
    $moyenne=intval($moyenne['avg(note)']);
    return $moyenne."/5";
  }else {
    return -1;
  }
}

function afficherAvis($idGolf , $idUser)
{
  //Affiche les avis d'un golf en evitant celui de l'user et propose de report si on est connecter et que l'avis n'est pas reporter
  if ($idUser == "0") {
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    $reqavis = $bdd->prepare("SELECT note , com , id_user FROM avis WHERE id_golf=?");
    $reqavis->execute(array($idGolf));
    $avis = $reqavis->fetchAll();
    foreach ($avis as $key => $value) {
      $requsername = $bdd->prepare("SELECT pseudo FROM membres WHERE id=?");
      $requsername->execute(array($value['id_user']));
      $user = $requsername->fetch();
      $userName=$user['pseudo'];
      echo "\n";
      ?><div class="note">
        <a href="<?php echo "Profil.php?id=".$value['id_user']; ?>"><?php echo $userName; ?></a>
      <?php
      echo " à noté ".$value['note']." et a commenté \"".$value['com']."\"";
      echo "</div> \n";
    }
  }else {
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    $reqavis = $bdd->prepare("SELECT note , com , id_user , report FROM avis WHERE id_golf=? AND id_user!=?");
    $reqavis->execute(array($idGolf , $idUser));
    $avis = $reqavis->fetchAll();
    foreach ($avis as $key => $value) {
        $requsername = $bdd->prepare("SELECT pseudo FROM membres WHERE id=?");
        $requsername->execute(array($value['id_user']));
        $user = $requsername->fetch();
        $userName=$user['pseudo'];
        echo "\n";
        ?><div class="note">
          <a href="<?php echo "Profil.php?id=".$value['id_user']; ?>"><?php echo $userName; ?></a>
        <?php
        echo " à noté ".$value['note']." et a commenté \"".$value['com']."\"";
        if ($value['report']==0) {
          echo "<form action=\"\" method=\"POST\"> \n<input type=\"submit\" name=\"reported\" value=\"Report\">\n
          <input type=\"hidden\" name=\"id_user\" value=\"".$value['id_user']."\">
          </form> \n";
        }
        echo "</div> \n";
      }
      }
    }

  function afficheAvisDUser($id=0 , $idsession=0)
  {
    //affichetout les avis d'un utilisateur
    include_once 'ConnexionBdd.php';
    include_once 'VerifCo.php';
    $bdd=cobdd();
    if (isAdmin($idsession)) {
      echo "<h2> Avis posté :</h2>";
      $reqavis = $bdd->prepare("SELECT note , com , id_golf FROM avis WHERE id_user=?");
      $reqavis->execute(array($id));
      $avis = $reqavis->fetchAll();
      foreach ($avis as $key => $value) {
        $reqg = $bdd->prepare("SELECT * FROM mini_golf WHERE id = ?");
        $reqg->execute(array($value['id_golf']));
        $golf = $reqg->fetch();
        echo "<h4> Sur le golf : <a href=\"PageMiniGolf.php?id=".$value['id_golf']."\"> ".$golf['nom']."  </a> </h4> \n";
        echo "<div class=\"note\"> \n";
        echo "à noté ".$value['note']." et a commenté \"".$value['com']."\"";
        echo "<form action=\"\" method=\"post\">
          <input type=\"submit\" name=\"".$value['id_golf']."\" value=\"Supprimer\" />
        </form>";
        if (isset($_POST[$value['id_golf']])) {
          deleteAvis($id , $value['id_golf']);
        }
        echo "</div>";
      }
    }
  }

  function deleteAvis($idUser=0 ,$idGolf=0)
  {
    //Supprime l'avis d'un utilisateur pour par exemple le reecrire
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    $reqsuppr = $bdd->prepare("DELETE FROM avis WHERE id_user = ? AND id_golf= ?");
    $reqsuppr->execute(array($idUser , $idGolf));
    header("Refresh:1");
  }
 ?>

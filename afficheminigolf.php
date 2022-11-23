<?php
include_once 'ConnexionBdd.php';
function getGolf($id)
{
  if ($id>0) {
    $bdd=cobdd();
    $reqg = $bdd->prepare("SELECT * FROM mini_golf WHERE id = '$id'");
    $reqg->execute();
    $golf = $reqg->fetch();
    if ($golf==0) {
      //On verifie que l'idé est bien un id dans la base de donnée
      echo "l'id n'est pas valable";
    }else {
      //Si oui on affiche le golf affiche($golf);
      affiche($golf);
    }
  }else {
    echo "l'id n'est pas valable";
  }
}

function affiche($array)
{
  include_once 'NoteAux.php';
  //on affiche les differentes valeurs dans le tableau donnée en argument
  $nom=str_replace("\'" , "'" ,$array['nom']);
  ?>
  <div class="Golf">
  <?php
  echo "<h4> <a href=\"PageMiniGolf.php?id=".$array['id']."\"> ".$nom."  </a> </h4> \n <br>";
    echo "<a href=\"PageMiniGolf.php?id=".$array['id']."\"> <img src=\"";
    echo $array['image_path']."/".$array['nom_image'];
    echo "\" alt=\"Photo de ".$array['nom']."\" loading=\"lazy\" height=\"500\" length=\"500\">";
    echo "  </a>\n";
    if (getMoyenne($array['id'])!=-1) {
      echo "<br><div class=\"moy\">".getMoyenne($array['id'])."</div>";
    }
    ?>
    </div>
    <br>
    <?php
}
 ?>

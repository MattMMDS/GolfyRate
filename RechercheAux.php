<?php
  function returnTabidGolf($tabGet)
  {
    //Fonction qui reverra un tableau de golf qui
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    //On fait une suite de verification selon quelle critere son rempli
    if ($tabGet['reg']!="") {
      //Ici on a la region qui est rempli
      $region = str_replace("'", "\'", $tabGet['reg'] );
      if ($tabGet['filtrenote']!="") {
        $note = str_replace("'", "\'", $tabGet['filtrenote'] );
        if ($tabGet['filtrenom']!="") {
          $name="%".$tabGet['filtrenom']."%";
          // Recherche par nom region et note
          $reqgof = $bdd->prepare("SELECT id FROM mini_golf WHERE region = ? AND nom LIKE ?");
          $reqgof->execute(array($region , $name));
          $golf = $reqgof->fetchAll();
          $tab = array();
          include_once 'NoteAux.php';
          foreach ($golf as $key => $value) {
            if (getMoyenne($value['id']) >= $note) {
              $addtotab=array('id' => $value['id']);
              array_push($tab , $addtotab );
            }//On ajout a un tableau les id de golf qui correspondent
          }
          return $tab;
        }else {
          //recherche par note et region
          $reqgof = $bdd->prepare("SELECT id FROM mini_golf WHERE region = ?");
          $reqgof->execute(array($region));
          $golf = $reqgof->fetchAll();
          $tab = array();
          include_once 'NoteAux.php';
          foreach ($golf as $key => $value) {
            if (getMoyenne($value['id']) >= $note) {
              $addtotab=array('id' => $value['id']);
              array_push($tab , $addtotab );
            }//On ajout a un tableau les id de golf qui correspondent
          }
          return $tab;
        }
      }else {
        //recherhce par region
        $reqgof = $bdd->prepare("SELECT id FROM mini_golf WHERE region = ?");
        $reqgof->execute(array($region));
        $golf = $reqgof->fetchAll();
        return $golf;
      }
    }else {
      if ($tabGet['filtrenote']!="") {
        $note = str_replace("'", "\'", $tabGet['filtrenote'] );
        if ($tabGet['filtrenom']!="") {
          $name="%".$tabGet['filtrenom']."%";
          // Recherche ppar nom et note
          $reqgof = $bdd->prepare("SELECT id FROM mini_golf WHERE nom LIKE ?");
          $reqgof->execute(array($name));
          $golf = $reqgof->fetchAll();
          $tab = array();
          include_once 'NoteAux.php';
          foreach ($golf as $key => $value) {
            if (getMoyenne($value['id']) >= $note) {
              $addtotab=array('id' => $value['id']);
              array_push($tab , $addtotab );
            }//On ajout a un tableau les id de golf qui correspondent
          }
          return $tab;
        }else {
          //recherche par note et region
          $reqgof = $bdd->prepare("SELECT id FROM mini_golf ");
          $reqgof->execute();
          $golf = $reqgof->fetchAll();
          $tab = array();
          include_once 'NoteAux.php';
          foreach ($golf as $key => $value) {
            if (getMoyenne($value['id']) >= $note) {
              $addtotab=array('id' => $value['id']);
              array_push($tab , $addtotab );
            }//On ajout a un tableau les id de golf qui correspondent
          }
          return $tab;
        }
    }else {
      // recherer par nom
      $name="%".$tabGet['filtrenom']."%";
      $reqgof = $bdd->prepare("SELECT id FROM mini_golf WHERE nom LIKE ?");
      $reqgof->execute(array($name));
      $golf = $reqgof->fetchAll();
      return $golf;
    }
  }
  }
?>

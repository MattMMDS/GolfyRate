<?php
function isDejaPro($idUser)
{
  //methode qui renvoi false si l'id d'user n'a pas proposéde golf true si non
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqdemande = $bdd->prepare("SELECT * FROM add_mini_golf WHERE id_user = ?");
  $reqdemande->execute(array($idUser));
  $dejademande= $reqdemande->rowCount();
  if ($dejademande == 0) {
    return false;
  }else {
    return true;
  }
}

function ajouterATable($nom , $adr , $idUser)
{
  //Ajoute les differentes iformation en protegant les bases de données
  $nom = str_replace("'", "\'", $nom);
  $adr = str_replace("'", "\'", $adr);
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqdemande = $bdd->prepare("INSERT INTO add_mini_golf(nom , adresse , id_user) VALUES ( ?, ? ,?)");
  $reqdemande->execute(array($nom,$adr,$idUser));
}

function golfAAjouter()
{
  //Renvoi true si il y a des golf qui ont été proposé et false si non
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqdemande = $bdd->prepare("SELECT * FROM add_mini_golf");
  $reqdemande->execute();
  $demande= $reqdemande->rowCount();
  if ($demande == 0) {
    return false;
  }else {
    return true;
  }
}

function afficherPropo()
{
  //méthode qui affiche toute les porposition
  //En proposant de la supprimer si elle n'est pas sérieuse et la completer a l'ajouter a la bdd des minigolf
  // quand on clique Un nouveua formulaire se creait et permet de remplir les information qie l'admin aura recolté personnellement
  include_once 'ConnexionBdd.php';
  $bdd=cobdd();
  $reqdemande = $bdd->prepare("SELECT * FROM add_mini_golf");
  $reqdemande->execute();
  $demandes = $reqdemande -> fetchAll();
  // var_dump($demandes);
  foreach ($demandes as $key => $value) {
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($value['id_user']));
    $user = $requser->fetch();
    $userName= $user['pseudo'];
    $nom=str_replace("\'" , "'" ,$value['nom']);
    $adr=str_replace("\'" , "'" ,$value['adresse']);
    ?>
    <div class="proposition">
      <a href="Profil.php?id=<?php echo $user['id']; ?>"><?php echo $userName; ?></a> a proposé d'ajouter le miniGolf <?php echo $nom; ?> à l'adresse <?php echo $adr; ?>
      <form class="" action="AjouterGolf.php" method="post">
        <input type="submit" name="suppr<?php echo $value['id_user']; ?>" value="Supprimer">
        <input type="submit" name="valid<?php echo $value['id_user']; ?>" value="Valider et completer">
      </form>
    </div>
    <br>
    <?php
    if (isset($_POST['suppr'.$value['id_user']])) {
      $suppde = $bdd->prepare("DELETE FROM add_mini_golf WHERE id_user = ?");
      $suppde->execute(array($value['id_user']));
      header("Refresh:1");
    }elseif (isset($_POST['valid'.$value['id_user']])) {
      ?>
      <div class="ajoutGolf">
      <h4>Il faut compléter les champs suivants</h4>
      <p>
      Remplir tous les champs, le nom du golf, séléctionnez la région, l'adresse, l'intégration GoogleMaps, le nom d'une image et sa localisation
      <br>
      Pour l'image il faut la télécharger et la mettre dans un dossier
    </p>
      <form class="" action="addMinigolf.php" method="post">
        <input type="text" name="nom" value="<?php echo $value['nom'] ?>">
        <select class="" name="region">
          <option value=""  selected="selected">Sélection d'une région</option>
          <option value="Auvergne-Rhône-Alpes">Auvergne-Rhône-Alpes</option>
          <option value="Bourgogne-Franche-Comté">Bourgogne-Franche-Comté</option>
          <option value="Bretagne">Bretagne</option>
          <option value="Centre-Val de Loire">Centre-Val de Loire</option>
          <option value="Corse">Corse</option>
          <option value="Grand Est">Grand Est</option>
          <option value="Hauts-de-France">Hauts-de-France</option>
          <option value="Île-de-France">Île-de-France</option>
          <option value="Normandie">Normandie</option>
          <option value="Nouvelle-Aquitaine">Nouvelle-Aquitaine</option>
          <option value="Occitanie">Occitanie</option>
          <option value="Pays de la Loire">Pays de la Loire</option>
          <option value="PACA">Provence-Alpes-Côte d'Azur</option>
        </select>
        <input type="text" name="adresse" value="<?php echo $value['adresse'] ?>">
        <input type="text" name="htmlmaps" value="" placeholder="Il faut entrer la partie entre '''' sur l'integration GoogleMaps" size="40" >
        <input type="text" name="nom_image" value="" placeholder="Nom de l'image">
        <input type="text" name="image_path" value="photo_mini_golf">
        <input type="submit" name="add<?php echo $value['id_user'];?>" value="Validé">
        <input type="hidden" name="id" value="<?php echo $value['id_user']; ?>">
      </form>
    </div>
    <br>
      <?php
    }
  }
}
 ?>

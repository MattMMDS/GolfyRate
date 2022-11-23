<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Recherche</title>
    <link rel="stylesheet" href="css/acceuil.css">
  </head>
  <body>
    <?php
    session_start();
    include_once 'Header.php';
     ?>
    <form class="rech" action="Recherche.php" method="get">
      <br>
      <input type="text" name="filtrenom" value="">
      <select class="" name="filtrenote">
        <option value="" selected>Sélection une note</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <select class="" name="reg">
        <option value=""  selected="selected">Sélection une région</option>
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
      <input type="submit" name="cherche" value="Recherche">
    </form>
    <br>
    <?php
    session_start();
    ?><div class="res">
    <?php
    if (isset($_GET['cherche'])) {
        include_once 'RechercheAux.php';
        include_once 'afficheminigolf.php';
        $arraygolf=returnTabidGolf($_GET);//Recupere le differement minigolf remplissant les criteres de recherre et on affiche
        foreach ($arraygolf as $key => $value) {
          getGolf($value['id']);//On affiche les different golfs qui remplisse les criteres
        }
    }
    ?>
    </div>
    <?php
    ?>
  </body>
</html>

<?php
function report($iduser , $idGolf)
{
  // include("ConnexionBdd.php");
  $bdd=cobdd();
  $reqReport = $bdd->prepare("UPDATE avis SET report = 1 WHERE id_user = ? AND id_golf=?");
  $reqReport->execute(array($iduser , $idGolf));
  $adr="Location: PageMiniGolf.php?id=".$idGolf;
  header($adr);
  //méthode qui chage la donne de la bdd qui permet de savoir qi quelqun a signaler le commentaire
}
 ?>

<?php
function isConnected($id)
{
  //Verifie que l'id de la session existe
  include_once 'ConnexionBdd.php';
  $bdd = cobdd();
  $requs = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
  $requs->execute(array($id));
  $us = $requs->rowCount();
  if ($us != 0){
    return true;
  }
  return false;
}

function isAdmin($id=0)
{//méthode qui compte le nombre de ligne avec l'id e argument si il y en a au moins une on revoit true si non false
  include_once 'ConnexionBdd.php';
  $bdd = cobdd();
  $reqadmin = $bdd->prepare("SELECT * FROM adminliste WHERE id = ?");
  $reqadmin->execute(array($id));
  $admin = $reqadmin->rowCount();
  if ($admin != 0){
    return true;
  }
  return false;
}
 ?>

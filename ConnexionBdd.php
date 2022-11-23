<?php
function cobdd()
{
  //On établit la connexion
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=ProjetIO2', 'marques', 'Ch@rl0tt3');
  return $bdd;
}
?>

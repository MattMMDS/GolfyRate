<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ajouter un Golf</title>
    <link rel="stylesheet" href="css/prop.css">

  </head>
  <body>
    <?php session_start();
    include_once 'Header.php';
     include_once 'VerifCo.php';
      if (isset($_SESSION['id'])) { //verifie que l'utilisateur est connecté
        if (!isAdmin($_SESSION['id'])) {//verifie qu'il ne soit pas un admin
          ?>
        <h1>Poposition d'ajout d'un minigolf</h1>
        <br>
      <?php
      include_once 'AjouterGolfAux.php';
      if (isDejaPro($_SESSION['id'])) {
        //on verifie que l'utilisateur a déjà proposer un mini golf
        ?>
        <div class="dejaprop">
        <h2 class=>Vous avez déjà proposé un minigolf vous devez attendre que l'administrateur vérifie votre demande et l'ajoute</h2>
        <br>
        <a href="Acceuil.php" class="ret">Retour a l'acceuil</a>
      </div>
      <br>
        <?php
      }else {
        //Si il n'a pas proposer
        //on lui propose de remplir les differentes informations nécessaires
        ?>
        <div class="aprop">
        <h3>Vous pouvez proposer d'ajouter un minigolf</h3>
        <h5>Remplissez les champs suivant</h5>
        <p>Attention si vous faites une demande les informations doivent être toutes remplies et correctes</p>
        <p>Vous n'avez le droit de proposer qu'un mini golf à la fois et pourrez en reproposer un nouveau  après vérification des informations par notre équipe d'administration</p>
        <br>
        <form class="" action="AjouterGolf.php" method="post">
          <br>
          <input type="text" name="nom" value="" placeholder="Nom">
          <input type="text" name="adresse" value="" placeholder="Adresse">
          <input type="submit" name="valid" value="Validé">
        </form>
      </div>
        <?php
        if (isset($_POST['valid'])) {
          //Si le formulaire a été validé on verifie que les champs on été rempli
          if (!empty($_POST['nom']) AND !empty($_POST['adresse'])) {
            $nom=htmlspecialchars($_POST['nom']);
            $adr=htmlspecialchars($_POST['adresse']);
          ajouterATable($nom , $adr , $_SESSION['id']);
          header("Refresh:1");
          //Si oui on ajoute a la table et on rafraichit
          }else {
            ?><h4>Vous devez remplir tous les champs</h4>
            <?php
          }
        }
      }
      ?>
      <?php
    }else {
      ?>
      <h1>Liste des propositions</h1>
      <br>
      <?php
      //Si il est admin on affiche les differentes proposition
      afficherPropo();
    }
  }else {
    //Si il n'est pas connecter alors on le dit et on l'affiche
    ?>
    <h2>Il faut être connecté pour pouvoir proposer l'ajout d'un minigolf</h2>
    <a href="Acceuil.php">Retour à l'acceuil</a>
    <?php
  } ?>

  </body>
</html>

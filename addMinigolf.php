<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Proposition Mini Golf</title>
  </head>
  <body>
    <?php
    include_once 'Header.php';
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    if (isset($_POST['add'.$_POST['id']])) { // verifie que le formulaire a été validé
      if (!empty($_POST['region']) AND !empty($_POST['nom']) AND !empty($_POST['adresse']) AND !empty($_POST['htmlmaps']) AND !empty($_POST['nom_image']) AND !empty($_POST['image_path'])) {
        //verifie si tout les champs ont bien été rempli
        $nom = htmlspecialchars($_POST['nom']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $path = htmlspecialchars($_POST['image_path']);
        $nomimg = htmlspecialchars($_POST['nom_image']);
        $htmlmaps = $_POST['htmlmaps'];
        $region = htmlspecialchars($_POST['region']);
        // protege l'integration de code sauf pour la variable htmlmaps ou on droit entré un lien pour l'intégration google maps
        $addTab = $bdd->prepare("INSERT INTO mini_golf (nom , adresse , image_path , nom_image , htmlmaps , region) VALUES (?, ?, ?, ?, ?, ?)");
        //prepare la requete sql
        $addTab->execute(array($nom, $adresse, $path, $nomimg, $htmlmaps, $region));
        //l'execute en prenant le tableau avec toute les variable
        $suppdeadd = $bdd->prepare("DELETE FROM add_mini_golf WHERE id_user = ?");
        $suppdeadd->execute(array($_POST['id']));
        // on prepare et execute la suppression de la ligne du tableau des demande d'ajout pour que l'utilisateur puisse en proposer un
        header("Refresh:1");//on rafraichi pour mettre a jour la page
      }else {
        //affichage d'un message d'erreur si tout les champs ne sont pas rempli
        ?>
        <h2>Il faut remplir tout les champs</h2>
        <?php
      }
    }else {
      //affichage d'un message prevenant qu'il n'y a rien dans la base de données
      ?>
      <h1>Aucun golf n'a été proposé</h1>
      <?php
    }
    ?>
  </body>
</html>

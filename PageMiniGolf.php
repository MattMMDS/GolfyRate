<?php
session_start();

 if (!isset($_GET['id'])) {
  header('Location: Acceuil.php');//On verifie que le tableau get est remplie
}else {
  $id=intval($_GET['id']);
  if ($id<0) { //et que cette id est quelque chose de valable
    header('Location: Acceuil.php');
  }
  ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">

    <?php
    include_once 'ConnexionBdd.php';
    $bdd=cobdd();
    $reqg = $bdd->prepare("SELECT * FROM mini_golf WHERE id = '$id'");
    $reqg->execute();
    $golf = $reqg->fetch(); //on recupere le golf avec l'id correspondant
    ?>
    <title><?php if ($golf!=0) {
      echo $golf['nom'];
    }else {
      echo "Invalid";
    }
    ?></title>
    <link rel="stylesheet" href="css/Minigolf.css">
  </head>
  <body onload="updateslider(document.getElementById('slider'))">
    <?php include_once 'Header.php';
      if ($golf==0) {
        echo "<h2 class=\"error\">L'id n'est pas valable</h2>";//Si l'id n'est pas dans la base de donné on affiche un message d'errerur
      }else {
        $nom=str_replace("\'" , "'" ,$golf['nom']);
        ?>
        <div class="page">
        <h2><?php echo $nom; ?></h2>
        <p>Ce mini golf est un mini golf dans la région
          <a href="Recherche.php?filtrenom=&filtrenote=&reg=<?php echo $golf['region']; ?>&cherche="><?php echo $golf['region']; ?></a>
        </p>
        <img src="<?php echo $golf['image_path']."/".$golf['nom_image']; ?>" alt="">
        <p>Adresse : <?php echo $golf['adresse']; ?></p>
        <iframe src="<?php echo $golf['htmlmaps']; ?>" width="600" height="450" style="border:1" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <h3>Avis</h3>
        <?php
        // On afficher les differentes information de la bdd sur ce golf et on entre dans l'ecpaces commentaire
        include_once 'VerifCo.php';
        include 'NoteAux.php';
        if (isset($_SESSION['id'])) {
        	if(isConnected($_SESSION['id'])){
            //Verfifi que l'utilisateur est connecter et est existant
            $iduser=$_SESSION['id'];
            if (!isNoted($iduser , $golf['id'])) {
              //Si il n'est pas noter on le propose
              ?>
              <div class="notable">
              <form  action="" method="post">
                <script type="text/javascript">
                function updateslider(t){
                  console.log(t.value);
                  document.getElementById("slider_data").innerText = t.value + "/5";
                }
              </script>
              <input type="range" name="value" min="O" max="5" id="slider" onclick="updateslider(this)">
              <p id="slider_data"></p>
                <input type="text" name="com" value="">
                <input type="submit" name="valueValid" value="Noter">
              </form>
            </div>
            <br>
              <?php
              if (isset($_POST['valueValid'])) {
                $note=$_POST['value'];
                $com=htmlspecialchars($_POST['com']);
                $com= str_replace("'", "\'", $com);
                //Verifie que le message n'est pas trop long
                if (strlen($com)>=421) {
                  echo ("<h2 class=\"error\">
                  Attention le commentaire est trop long
                  </h2>");
                }else {
                  toNote($iduser , $golf['id'] , $note , $com);
                  header("Refresh:1");
                }
              }
              afficherAvis($golf['id'] , $_SESSION['id']);
            }else {
              ?><div class="note">
              <?php
              //Si non on propose de supprimer l'avis et ou de le modifier
              $noteuser=quelleNote($iduser , $golf['id']);
              $comuser=getCom($iduser , $golf['id']);
              echo "Tu as deja noté ".$noteuser."/5 Commentaire :".$comuser;
              ?> <form action="" method="post">
                <input type="submit" name="supprNote" value="Le modifier/Supprimer" />
              </form>
            </div>
            <br>
              <?php
              afficherAvis($golf['id'] , $_SESSION['id']);//On affiche tout les avis
              if (isset($_POST['supprNote'])) {
                //Si on cilique sur la suppression de la note et on supprime dans la bdd
                $reqsuppr = $bdd->prepare("DELETE FROM avis WHERE id_user = ? AND id_golf= ?");
                $reqsuppr->execute(array($iduser , $golf['id']));
                header("Refresh:1");
              }
            }
          }
          include_once('Report.php');
          if (isset($_POST['reported'])) {
            report($_POST['id_user'] , $_GET['id']);//Si on clique sur le report on fait l'appel de la method pour mettre a jour la bdd
          }
        }else {
          ?><h3 class="deco">Vous êtes déconnecté il faut vous connecter pour noter ce golf</h3>
        <br>  <?php
          //Si on est pas connecter un petit message d'erreur
        afficherAvis($golf['id'] , "0");
        }
          ?>
          <?php
      } ?>
    </div>
  </body>
</html>

<?php
} ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Acceuil</title>
    <link rel="stylesheet" href="css/acceuil.css">

  </head>
  <body>
    <?php
    session_start();
    include_once 'Header.php'; // affiche un beaudeau present sur toute les pages avec des liens utiles
    include_once 'afficheminigolf.php'; // inclu les differentes méthide php d'ont j'ai besion
    ?>
    <div class="ligne1">
    <div class="Presentation" >
      <h1>Bienvenue sur GolfyRate</h1>
      <div class="entete">
      <p>GolfyRate LE SITE de notations des minigolfs de France</p>
      <p>Sur ce site vous devez vous inscrire ou vous connecter (si vous avez déjà un compte) <br> Plusieurs fonctionnalités vous y sont proposées </p>
    </div>
    <div class="subtext">
        Vous pouvez évaluer vos terrains de mini golf favoris
        <p>Vous pouvez les commenter également</p>
        <p>Si un commentaire vous semble déplacé vous pourrez<br> le signaler et un administrateur s'occupera du message</p>
        <p>Si le coeur vous en dit et que le site ne vous semble pas assez<br> étoffé, vous pouvez proposé l'ajout d'un golf et un administrateur s'occupera de la proposition</p>
        <p>Si les souvenirs que vous avez d'un golf sont flous vous pourrez le chercher<br> et voir si quelqu'un l'a déjà ajouté sur notre site <br> La recherche pourra être effectuée par plusieurs critères: les notes ou encore la région</p>
      </ul>
    </div>
    </div>
  </div>
    <?php
    for ($i=1; $i < 6; $i++) {
      getGolf($i); // Un boucle qui fait appel a une méthode qui affiche un lien vers la page du golf et une photo
    }
    ?>
   </body>
</html>

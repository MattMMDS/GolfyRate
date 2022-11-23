<header id="banniere">
  <div class="sticky">
   <nav>
     <ul>
       <li class="acc">
     <a href="Acceuil.php"><img src="logo.png" width="80"  length="80" class="logo"></a>
   <!-- </li>  -->
     <!-- <li> -->
    <a href="Acceuil.php">Accueil</a>
  </li>
    <li>
    <a class="recherhce" href="Recherche.php">Recherche</a>
  </li>
    <?php if (isset($_SESSION['id'])) {
      include_once 'VerifCo.php';
      include_once 'AjouterGolfAux.php';
      if (isAdmin($_SESSION['id'])) {
        //on fait une seri de teste qui permettent de proposer les bonne choses aux personnes
        //Si il est admin on propose le menu d'administrateur
        ?>
        <li>
        <a href="<?php echo "Profil.php?id=".$_SESSION['id']; ?>">Menu administrateur</a>
      </li>
        <?php
      }else {
        //Si non juste le profil avec ses infomation
        $page = "Profil.php?id=".$_SESSION['id'];
        ?>
        <li>
        <a id="profil" href="<?php echo $page; ?>">Profil</a>
      </li>
        <?php
        //on verifie si il a proposé un golf et en concequences on affiche on non un lien pour en proposer un
        if (!isDejaPro($_SESSION['id'])) {
          ?>
          <li>
          <a href="AjouterGolf.php">Proposer un golf</a>
        </li>
          <?php
        }
      }
      // on propose de se deconnecter si on l'est
      ?>
      <li>
      <a id="deconnexion" href="Deconnexion.php">Se deconnecter</a>
    </li>
      <?php
    }else {
      // On propose de se connecter ou de s'inscrire si on n'est pas encore connecté
      ?>
      <li>
      <a id="connexion" href="Connexion.php">Se connecter</a>
    </li>
      <li>
      <a id="inscription" href="Inscription.php">S'inscrire</a>
    </li>
      <?php
    } ?>
  </ul>
  </nav>
</div>
</header>

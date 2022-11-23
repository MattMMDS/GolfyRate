Guide pour lancer le site et le faire fonctionner

Premièrement il faut lancer mySQL sur votre machine et taper la commande
"  source CreationTable.sql "

Ensuite il faut modifier le fichier ConnexionBdd.php et en particulier la fonction cobdd()
Sur la ligne il faut remplir entre les ''
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=ProjetIO2', '*ici*', '*et la*');

Et vous pouvez aller surfer sur le site GolfyRate

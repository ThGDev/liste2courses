<?php

require_once('./lib/lib.php');

$pattern = "/^[A-Za-z '-]+$/";  //la regex qui va vérifier que ce qui est saisi sont des lettres ou "-"

// fonction de vérif des données saisies (pour éviter l'injection de code malicieux ou autre)
function valid_donnees($donnees){
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}
$nameList = valid_donnees($_POST["nameList"]);  //on passe les données saisies à la moulinette

//on teste également que les données sont bien au format attendu (conforme au pattern)
if(!preg_match($pattern, $nameList)){
    $errorMessage = "Uniquement des lettres ou le caractère \"-\" svp";
    errorManager($errorMessage."<br>Vous allez être redirigé vers l'accueil dans 5 secondes.", "index.php");
    // echo "Uniquement des lettres ou le caractère \"-\" svp";
}else{
    echo $nameList."<br>"; // si tout va bien, on affiche le nom de la liste
    dbConnect($nameList);    // et on se connecte à la BDD
    //header( "refresh:5;url=/list/?id=$id&key=$key" );  // on redirige vers l'URL spécifiée au bout de 5sec
    header( "refresh:5;url=/liste-de-course/list/?id=_____&key=________________________________" );
}

?>
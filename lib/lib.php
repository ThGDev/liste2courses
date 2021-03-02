<?php 

//génération d'une clé basée sur l'heure courante en microseconde -> uniqid
// servira pour éviter qu'une liste soit accessible par n'importe qui
// sera utilisée dans l'URL pour accéder à la liste
// sera stockée dans la BDD
function generateKey(){
    $ukey = md5(uniqid().rand());
    echo $ukey;
}

//--------------------------------------------------------- gestion des erreurs
function errorManager($message, $url = NULL){
    echo $message;  // renvoi le message d'erreur
    
    if($url != NULL){   // si $url est différent de NULL
        header( "refresh:5;url=$url" );  // on redirige vers l'URL spécifiée au bout de 5sec
    }   
}

//--------------------------------------------------------- connexion à la BDD
function dbConnect($nomDeListe){
    $key = md5(uniqid().rand());
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'liste2courses';
   
    //$name = $nomDeListe;

    //On essaie de se connecter
    try{
        // on utilise la librairie PDO pour se connecter et on instancie l'objet $db
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //On définit le mode d'erreur de PDO sur Exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // on éxécute la création d'une nouvelle liste
        dbNewList($dbname, $db, $nomDeListe, $key);
    }
    
    /*On capture les exceptions si une exception est lancée et on affiche
     *les informations relatives à celle-ci*/
    catch(PDOException $e){
        errorManager("Erreur : " . $e->getMessage());
    //   echo "Erreur : " . $e->getMessage();
    }

    //On ferme la connexion
    $db = null;
}

//--------------------------------------------------------- pour enregistrer une nouvelle liste dans la BDD
function dbNewList($dbname, $db, $name, $ukey = NULL){

    $tableList = 'listes_shop';
    $tableArticle = 'articles';
    $tableArticleColumn1 = 'name';
    $tableArticleColumn2 = 'ukey';

    //echo "$dbname, $tableList, $name, $ukey";
    //$sth appartient à la classe PDOStatement
    $sth = $db->prepare("
    INSERT INTO $dbname.$tableList($tableArticleColumn1, $tableArticleColumn2)
    VALUES (:name, :ukey)
    ");
    //La constante de type par défaut est STR
    $sth->bindValue(':name', $name);
    $sth->bindValue(':ukey', $ukey);
    $sth->execute();
    echo "Entrée ajoutée dans la table";
}

//--------------------------------------------------------- Récuperer les listes de course
function getListData($db, $id, $key){
    $query = $db->prepare("
    SELECT name FROM liste2courses.listes_shop
    ");
    $query->bindValue(':id', $id);
    $query->bindValue(':ukey', $key);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>
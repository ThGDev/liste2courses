<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Mes listes de course</title>
</head>
<body>
    <h1 class="text-center">Mes Listes de course</h1>
    <?php 
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'liste2courses';
        $tableList = 'listes_shop';
        $tableArticle = 'articles';
        $tableArticleColumn1 = 'name';
        $tableArticleColumn2 = 'ukey';
        try{
            // on utilise la librairie PDO pour se connecter et on instancie l'objet $db
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            //On définit le mode d'erreur de PDO sur Exception
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // on éxécute la création d'une nouvelle liste
            $query = $db->prepare("
                                SELECT $tableArticleColumn1 FROM $dbname.$tableList
                                ");
            $queryIsOk = $query->execute();
            $listesDesCourses = $query->fetchAll();
        }
        
        /*On capture les exceptions si une exception est lancée et on affiche
         *les informations relatives à celle-ci*/
        catch(PDOException $e){
        //    errorManager("Erreur : " . $e->getMessage());
           echo "Erreur : " . $e->getMessage();
        }
    ?>
    <ul>
        <?php foreach($listesDesCourses as $listeDesCourses): ?>
        <li><?= $listeDesCourses[$tableArticleColumn1] ?></li>
        <?php //<?= est équivalent à <?php echo ?>
        <?php endforeach; ?>
    </ul>
    
</body>
</html>
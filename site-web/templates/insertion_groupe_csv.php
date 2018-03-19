<?php
    require '../../../BD/Interactions/Connexion.php';
    require '../../../BD/Interactions/InteractionsBD.php';
    require '../../../BD/Interactions/ImportCSV.php';
    require '../../../BD/Classe/Jury.php';
    require '../../../BD/Classe/Groupe.php';
    require '../../../BD/Classe/Eleve.php';
    require '../../../BD/Classe/Professeur.php';
    require '../../../BD/Classe/Personne.php';

    try{
        $db = connect_database();
        $path = $_FILES["file"]["tmp_name"];
        echo getCSVforGroupe($db,$path);
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    header('Location:InsererGroupe.php');
?>

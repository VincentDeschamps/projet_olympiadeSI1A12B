<?php
    require '../../../BD/Interactions/Connexion.php';
    require '../../../BD/Interactions/InteractionsBD.php';
    require '../../../BD/Interactions/ImportCSV.php';
    require '../../../BD/Classe/Heure.php';

    try{
        $db = connect_database();
        $path = $_FILES["file"]["tmp_name"];
        getCSVforHeure($db,$path);
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    header('Location:insererHorairesCSV.php');
?>

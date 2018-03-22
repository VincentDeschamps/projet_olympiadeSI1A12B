<?php
    require '../../../BD/Interactions/Connexion.php';
    require '../../../BD/Interactions/InteractionsBD.php';

    try{
        $db = connect_database();

        $ID = getMaxIDHeure($db)+1;
        $HeureDeb = $_POST["HeureDeb"];
        $HeureFin = $_POST["HeureFin"];

        $stmt1 = $db->prepare("insert into HEURE (idHeure,hDeb,hFin)values (?,?,?);");

        $stmt1->bindParam(1,$ID);
        $stmt1->bindParam(2,$HeureDeb);
        $stmt1->bindParam(3,$HeureFin);

        $stmt1->execute();
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    header('Location:InsererHoraires.php');
?>

<?php
require '../../../BD/Interactions/Connexion.php';
$edition = $_POST['edition'];
$date = $_POST['date'];
$sponsors = $_POST['sponsors'];
$illu = $_POST['illustration'];
$upsti = $_POST['upsti'];
$bandeau = $_POST['bandeau'];
$iut = $_POST['iut'];

function insertParam($db, $edition, $date, $sponsors, $illu, $upsti, $bandeau, $iut){
  try{
    $stmt = $db->prepare("UPDATE OLYMPIADES SET NumEdition = ?, LogOlympiades = ?, LogoSponsor = ?, LogoUPSTI = ?, datetimeOlymp = ?, BandeauPartenaires = ?, LogoIUT = ? where NumEdition = ? or NumEdition = ?");
    $stmt->bindValue(1,$edition);
    $stmt->bindParam(2,$illu);
    $stmt->bindParam(3,$sponsors);
    $stmt->bindParam(4,$upsti);
    $stmt->bindParam(5,$date);
    $stmt->bindParam(6,$bandeau);
    $stmt->bindParam(7,$iut);
    $stmt->bindValue(8,$edition-1);
    $stmt->bindValue(9,$edition);

    $stmt->execute();
  }
  catch(Exception $e){
    $e.getMessage();
  }
  header('Location:parametrage.php');
}

insertParam(connect_database(),$edition, $date, $sponsors, $illu, $upsti, $bandeau, $iut);
?>

<?php
  include("PDOConnection.php");
  $data=$_POST['data'];
  $data_decode=json_decode($data,true);
  function insererDonne($data_decode, $cnn){
    $query = "INSERT INTO DONNE (NumJury, NumGroupe, idNote) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE idNote = idNote";
    for($i=0;$i<sizeof($data_decode['Donne']);$i++){
      try{
        $stmt = $cnn->prepare($query);
        $stmt->bindParam(1, $data_decode['Donne'][$i]["NumJury"]);
        $stmt->bindParam(2, $data_decode['Donne'][$i]["NumGroupe"]);
        $stmt->bindParam(3, $data_decode['Donne'][$i]["idNote"]);
        $stmt->execute();
      }
      catch(Exception $e){
        $e->getMessage();
      }
    }
    return 0;
  }
  function insererNote($data_decode, $cnn){
    $query = "REPLACE INTO NOTE (idNote,prototype,originalite,DemarcheScientifique,pluriDisciplinarite,MaitriseScientifique,Communication) VALUES (?,?,?,?,?,?,?)";
    for($i=0;$i<sizeof($data_decode['Note']);$i++){
      try{
        $stmt = $cnn->prepare($query);
        $stmt->bindParam(1, $data_decode['Note'][$i]["idNote"]);
        $stmt->bindParam(2, $data_decode['Note'][$i]["prototype"]);
        $stmt->bindParam(3, $data_decode['Note'][$i]["originalite"]);
        $stmt->bindParam(4, $data_decode['Note'][$i]["demarcheSI"]);
        $stmt->bindParam(5, $data_decode['Note'][$i]["pluriDisciplinarite"]);
        $stmt->bindParam(6, $data_decode['Note'][$i]["maitrise"]);
        $stmt->bindParam(7, $data_decode['Note'][$i]["devDurable"]);
        $stmt->execute();
      }
      catch(Exception $e){
        $e->getMessage();
      }
    }
    return 0;
  }
  $resultat=insererNote($data_decode, $cnn)+insererDonne($data_decode, $cnn);
  echo json_encode(array("resultat"=>$resultat));
  /* Donne INSERT INTO table (a, b, c)
    VALUES (1, 45, 6)
    ON DUPLICATE KEY UPDATE id = id
  */
  /* Note REPLACE INTO my_table (pk_id, col1) VALUES (5, '123');*/
?>

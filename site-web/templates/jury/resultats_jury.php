<html>
<head>
  <link rel="stylesheet" href="../../css/index.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
</head>

<body>
  <?php session_start();
  $_SESSION['connect']=0;
  if(!isset($_SESSION['loginOK2'])){
    header('Location: ../protection/connexion.php');
  }?>

  <?php
    include 'menu_jury.php';
    include '../../../BD/Interactions/InteractionsBD.php';
    include '../../../BD/Interactions/Connexion.php';

    $db = connect_database();
  ?>

    <center><h1>Résultats finaux</h1></center>

    <div>
      <div style="padding-top: 1% ; padding-left: 5% ; padding-right: 5%">
        <table class="table table-striped" style="text-align: center;">
          <thead class="thead-dark">
            <tr>
              <th>Équipe</th>
              <th>Nom Projet</th>
              <th>Lycée</th>
              <th>Originalité</th>
              <th>Prototype</th>
              <th>Démarche SI</th>
              <th>Pluridisciplinarité</th>
              <th>Maîtrise</th>
              <th>Communication</th>
              <th>Moyenne</th>
            </tr>
          </thead>
          <?php
          $all_grp = array();
          $all_recompense = array();
          $all_lycee = array();
          try{
            $stmt = $db->prepare("SELECT NumGroupe,Lycee,NomProjet FROM GROUPE");
            $stmt->execute();
            $stmt2 = $db->prepare("SELECT idGroupe, idRecompense FROM RECOMPENSE");
            $stmt2->execute();
            while($row = $stmt2->fetch()){
              $all_recompense[$row["idRecompense"]] = $row["idGroupe"];
            }
            $rec0 = 0;
            $rec1 = 0;
            $rec2 = 0;
            $rec3 = 0;
            $rec4 = 0;
            $rec5 = 0;
            $rec6 = 0;
            while($row = $stmt->fetch()){
              array_push($all_grp,$row['NumGroupe']);
              $liste = getNote($db,$row['NumGroupe']);
              echo "<tr>";
              echo "<td>".$row['NumGroupe']."</td>";
              echo "<td>".$row['NomProjet']."</td>";
              echo "<td>".$row['Lycee']."</td>";
              //echo $liste['Originalite'];
              if($liste['Originalite']==-1){
                $rec0+=1;
                if ($rec0 != $all_recompense["1"]){
                  echo "<td>". "/" ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>". "/" ."</td>";
                }
              }
              if($liste['Prototype']==-1){
                $rec1+=1;
                if ($rec1 != $all_recompense["2"]){
                  echo "<td>". "/" ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>". "/" ."</td>";
                }
              }
              if($liste['DemarcheSI']==-1){
                $rec2+=1;
                if ($rec2 != $all_recompense["3"]){
                  echo "<td>". "/" ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>". "/" ."</td>";
                }
              }
              if($liste['pluriDisciplinarite']==-1){
                $rec3+=1;
                if ($rec3 != $all_recompense["4"]){
                  echo "<td>". "/" ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>". "/" ."</td>";
                }
              }
              if($liste['Maitrise']==-1){
                $rec4+=1;
                if ($rec4 != $all_recompense["5"]){
                  echo "<td>". "/" ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>". "/" ."</td>";
                }
              }
              if($liste['devDurable']==-1){
                $rec5+=1;
                if ($rec5 != $all_recompense["6"]){
                  echo "<td>". "/" ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>". "/" ."</td>";
                }
              }
              if($liste['Originalite']==-1 OR $liste['Prototype']==-1 OR $liste['DemarcheSI']==-1 OR $liste['pluriDisciplinarite']==-1 OR $liste['Maitrise']==-1 OR $liste['devDurable']==-1){
                $rec6+=1;
                if ($rec6 != $all_recompense["7"]){
                  echo "<td>". "/" ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>". "/" ."</td>";
                }
              }
              else{
                $rec0+=1;
                if ($rec0 != $all_recompense["1"]){
                  echo "<td>".$liste['Originalite']."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>".$liste['Originalite']."</td>";
                }
                $rec1+=1;
                if ($rec1 != $all_recompense["2"]){
                  echo "<td>".$liste['Prototype']."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>".$liste['Prototype']."</td>";
                }
                $rec2+=1;
                if ($rec2 != $all_recompense["3"]){
                  echo "<td>".$liste['DemarcheSI']."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>".$liste['DemarcheSI']."</td>";
                }
                $rec3+=1;
                if ($rec3 != $all_recompense["4"]){
                  echo "<td>".$liste['pluriDisciplinarite']."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>".$liste['pluriDisciplinarite']."</td>";
                }
                $rec4+=1;
                if ($rec4 != $all_recompense["5"]){
                  echo "<td>".$liste['Maitrise']."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>".$liste['Maitrise']."</td>";
                }
                $rec5+=1;
                if ($rec5 != $all_recompense["6"]){
                  echo "<td>".$liste['devDurable']."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>".$liste['devDurable']."</td>";
                }
                $rec6+=1;
                if ($rec6 != $all_recompense["7"]){
                  echo "<td>".round(($liste['Originalite'] + $liste['Prototype'] + $liste['DemarcheSI'] + $liste['pluriDisciplinarite'] + $liste['Maitrise'] + $liste['devDurable'])/6, 2) ."</td>";
                }
                else{
                  echo "<td bgcolor='#FFE469'>".round(($liste['Originalite'] + $liste['Prototype'] + $liste['DemarcheSI'] + $liste['pluriDisciplinarite'] + $liste['Maitrise'] + $liste['devDurable'])/6, 2) ."</td>";
                }
              }
              echo "</tr>";
            }
          }
          catch(Exception $e){
            echo $e.getMessage();
          }
          ?>
        </table>
      </div>

      <div style:"display: flex">
        <div style="background-color: #FFE469 ; height: 25px ; width: 30px ; float: left ; margin-left: 5%"> </div>
        <label style="padding-left: 1%">Attribution actuelle des prix</label>
      </div>

        <!-- <div id="rules" style:"margin:0 auto">
          <article>
                <h3>Règles de notations: </h3>
                <p>Une seule récompense par groupe.</p><br>
                <p>Deux récompenses par Lycée.</p>
          </article>
        </div> -->

      <div style="padding-left: 5% ; padding-right: 5% ; padding-top: 5%">
        <h3>Attribution des prix :</h3>
        <form method="post" action="insert_res.php">
          <table class="table">
            <tr>
              <td>Originalité</td>
              <td>
                <select name="originalite">
                  <option value="none"></option>
                  <?php
                    foreach ($all_grp as $num) {
                      if ($all_recompense["1"]==$num){
                        echo "<option value='".$num."' selected='selected'>Groupe ".$num."</option>";
                      }
                      else{
                        echo "<option value='".$num."'>Groupe ".$num."</option>";
                      }
                    }?>
                </select>
              </td>
              <td>Prototype</td>
              <td>
                <select name="prototype">
                  <option value="none"></option>
                  <?php foreach ($all_grp as $num) {
                    if ($all_recompense["2"]==$num){
                      echo "<option value='".$num."' selected='selected'>Groupe ".$num."</option>";
                    }
                    else{
                      echo "<option value='".$num."'>Groupe ".$num."</option>";
                    }
                  } ?>
                </select>
              </td>
              <td>Démarche SI</td>
              <td>
                <select name="demarche_si">
                  <option value="none"></option>
                  <?php foreach ($all_grp as $num) {
                    if ($all_recompense["3"]==$num){
                      echo "<option value='".$num."' selected='selected'>Groupe ".$num."</option>";
                    }
                    else{
                      echo "<option value='".$num."'>Groupe ".$num."</option>";
                    }
                  } ?>
                </select>
              </td>
            </tr>

            <tr>
              <td>Pluridisciplinarité</td>
              <td>
                <select name="pluridisciplinarite">
                  <option value="none"></option>
                  <?php foreach ($all_grp as $num) {
                    if ($all_recompense["4"]==$num){
                      echo "<option value='".$num."' selected='selected'>Groupe ".$num."</option>";
                    }
                    else{
                      echo "<option value='".$num."'>Groupe ".$num."</option>";
                    }
                  } ?>
                </select>
              </td>
              <td>Maîtrise</td>
              <td>
                <select name="maitrise">
                  <option value="none"></option>
                  <?php foreach ($all_grp as $num) {
                    if ($all_recompense["5"]==$num){
                      echo "<option value='".$num."' selected='selected'>Groupe ".$num."</option>";
                    }
                    else{
                      echo "<option value='".$num."'>Groupe ".$num."</option>";
                    }
                  } ?>
                </select>
              </td>
              <td>Communication</td>
              <td>
                <select name="developpement_durable">
                  <option value="none"></option>
                  <?php foreach ($all_grp as $num) {
                    if ($all_recompense["6"]==$num){
                      echo "<option value='".$num."' selected='selected'>Groupe ".$num."</option>";
                    }
                    else{
                      echo "<option value='".$num."'>Groupe ".$num."</option>";
                    }
                  } ?>
                </select>
              </td>
            </tr>

            <tr>
              <td>Moyenne</td>
              <td>
                <select name="moyenne">
                  <option value="none"></option>
                  <?php foreach ($all_grp as $num) {
                    if ($all_recompense["7"]==$num){
                      echo "<option value='".$num."' selected='selected'>Groupe ".$num."</option>";
                    }
                    else{
                      echo "<option value='".$num."'>Groupe ".$num."</option>";
                    }
                  } ?>
                </select>
              </td>
            </tr>
          </table>
          <center>
            <div>
              <input class="btn btn-dark" type="submit" value="Attribuer"/>
            </div>
          </center>
        </form>
      </div>
    </div>

  </body>
  </html>

<html>
<head>
  <link rel="stylesheet" href="../../css/index.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body>
  <?php session_start();
  $_SESSION['connect']=0;
  if(!isset($_SESSION['loginOK'])){
    header('Location: ../protection/connexion.php');
  }?>

  <?php
    include 'menu_admin.php';
    include '../Interactions/InteractionsBD.php';
    include '../Interactions/Connexion.php';

    $db = connect_database();
    $all_grp = array();
    $all_jury = array();
    $all_hours = array();

    try{
      $stmt = $db->prepare("SELECT NumGroupe FROM GROUPE where NumGroupe != 0");
      $stmt->execute();

      $stmt2 = $db->prepare("SELECT NumJury FROM JURY");
      $stmt2->execute();

      $stmt3 = $db->prepare("SELECT hDeb, hFin FROM HEURE");
      $stmt3->execute();

      while($row = $stmt->fetch()){
        array_push($all_grp,$row['NumGroupe']);
      }

      while($row = $stmt2->fetch()){
        array_push($all_jury,$row['NumJury']);
      }

      while($row = $stmt3->fetch()){
        array_push($all_hours, $row['hDeb']." - ".$row['hFin']);
      }
    }
    catch(Exception $e){}
  ?>
  <center><h1>Planning</h1></center>

  <div style="padding: 5%">
    <form method="post" action="insert_planning.php">
      <table class="table table-sm table-striped">
        <tr style="text-align: center;">
          <thead class="thead thead-dark" style="text-align:center;">
            <th></th>
          <?php
          $nb_jury = sizeof($all_jury)+1;
          $cpt = 0;
          for($i=1;$i<$nb_jury;$i++)
          {
            echo "<th>Jury ".$i."</th>";
          }
          ?>
          </thead>
        </tr>
          <?php
          foreach ($all_hours as $creneau){

            echo "<tr>";
            echo "<td>".explode(":", $creneau)[0].":".explode(":", $creneau)[1]." - ".explode("-", explode(":", $creneau)[2])[1].":".explode(":", $creneau)[3]."</td>";
          ?>
          <?php
          for($i=1;$i<$nb_jury;$i++){
            ?>
            <td>
              <?php
              $cr1 = explode("-", $creneau)[0];
              $cr2 = explode("-", $creneau)[1];

              $h1 = explode(":", $cr1)[0];
              $m1 = explode(":", $cr1)[1];

              $h2 = explode(":", $cr2)[0];
              $m2 = explode(":", $cr2)[1];

              if ($h2 - $h1 == 0){
                $inter = $m2 - $m1;
              }
              else{
                $inter = 60-($m1 - $m2);
              }
              // echo $inter;
              if ($inter != 10){
              ?>
              <center>
                <select onclick="majPlanning(id)" id = <?php echo $cpt; ?> name=<?php echo "select".$cpt; $cpt+=1; ?>  >
                  <option value="none"></option>
                  <?php
                    foreach ($all_grp as $num) {
                      echo "<option value='".$num."'>Groupe ".$num."</option>";
                    }?>
                </select>
              </center>
            <?php }

            else{
              echo "<center>Pause</center>";
            }

            ?>

            </td>
            <?php
          }
          }
          echo "</tr>";
          ?>

      </table>
      <input type="submit" class="btn btn-dark">
    </form>
  </div>
  <div id="commentaires"> </div>


  <script>

    // $("#select0").click(function(){
    //
    //   $.ajax({
    //                  url : 'test.php',
    //                  type : 'POST',
    //                  data : {select: $('#select0').val(),
    //                         grp: $('#allgrp').val()},
    //                  dataType : 'html',
    //                  success : function(code_html, statut){
    //                    for(var i=1; i<$('select').length;++i){
    //                      if(i%($('select').length/($('th').length-1))  == 0){
    //                        $("#select"+i).empty();
    //                        $(code_html).appendTo("#select"+i);
    //                      }
    //                     }
    //
    //                     for(var j=1; j<$('th').length;j++){
    //                       $("#select"+j).empty();
    //                       $(code_html).appendTo("#select"+j);
    //                     }
    //                  },
    //
    //                  error : function(resultat, statut, erreur){
    //                    alert(resultat);
    //                  },
    //
    //
    //                });
    // });

    function majPlanning(id){
      $.ajax({
                       url : 'test.php',
                       type : 'POST',
                       data : {select: $('#'+id).val(),
                              grp: $('#allgrp').val()},
                       dataType : 'html',
                       success : function(code_html, statut){
                         for(var i=1; i<$('select').length;++i){
                           if(i%($('th').length-1)  == id%($('th').length-1)){
                             $("#"+i).empty();
                             $(code_html).appendTo("#"+i);
                           }
                          }

                          for(var j=1; j<$('th').length;j++){
                            $("#"+j).empty();
                            $(code_html).appendTo("#"+j);
                          }
                       },

                       error : function(resultat, statut, erreur){
                         alert(resultat);
                       },


                     });


    }



  </script>


</body>

</html>

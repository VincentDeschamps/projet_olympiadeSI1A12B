<!DOCTYPE html>
<html class="h-100">
<head>
<link rel="stylesheet" href="../../css/index.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
</head>
<body class="h-100">
<?php session_start();
$_SESSION['connect']=0;
if(!isset($_SESSION['loginOK'])){
  header('Location: ../protection/connexion.php');
}?>
<?php include 'menu_admin.php'; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Élèves
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="InsererEleveCSV.php">Import CSV</a>
          <a class="dropdown-item" href="InsererEleve.php">Créer</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Professeurs
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="InsererProfesseurCSV.php">Import CSV</a>
          <a class="dropdown-item" href="InsererProfesseur.php">Créer</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Groupes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="InsererGroupeCSV.php">Import CSV</a>
          <a class="dropdown-item" href="InsererGroupe.php">Créer</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Jurys
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="insererJuryCSV.php">Import CSV</a>
          <a class="dropdown-item" href="insererJury.php">Créer</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Horaires
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="insererHorairesCSV.php">Import CSV</a>
          <a class="dropdown-item" href="InsererHoraires.php">Créer</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<div id="main" class="container-fluid" style="height:50%">
  <div class="row justify-content-between" style="height:150%">
    <div class="col-8">
      <form name="AjoutEleve" method="POST" style="padding-top: 2%" action="insertion_groupe_CSV.php" enctype="multipart/form-data">
        <h4>Formulaire d'ajout d'un groupe (CSV) :</h4>
        <div class="form-group row">
          <label for="filename" class="col-4">Fichier CSV</label>
          <input id="filename" type="file" name="file" required></input>
        </div>
        <div class="text-center">
          <button class="btn btn-dark" type="submit">Ajouter Groupe</button>
        </div>
      </form>
    </div>
    <div class="col-4" style="overflow-y:scroll; height:100%; width: 400px">
      <?php
      require "../../../BD/Interactions/Connexion.php";
      require "../../../BD/Interactions/InteractionsBD.php";
      $db = connect_database();
      try{
        $maxNumGroupe = getMaxIDGROUPE($db);
        $grpancien = 0;
        $stmt2 = $db->prepare("SELECT * FROM ELEVE natural join PERSONNE natural join GROUPE where ID=IDEleve and NumGroupe = ?");
        $stmt = $db->prepare("SELECT * FROM GROUPE where NumGroupe not in(SELECT NumGroupe FROM ELEVE)");
        $stmt->execute();

        for ($i=1; $i<=$maxNumGroupe; $i++){
          $stmt2->bindParam(1, $i);
          $stmt2->execute();
          while($row = $stmt2->fetch())
          {
            if($row["NumGroupe"] != $grpancien){
              if($i != 1){
                echo '</div>';
              }
              echo '
              <div id="grp-'.$row["NumGroupe"].'" class="jumbotron text-white bg-dark" style="padding:1em">
                <h1>Groupe n°'.$row["NumGroupe"].'</h1>
                <h2>Projet : '.$row["NomProjet"].'</h2>
                <div class="jumbotron text-dark bg-light" style="padding:0.5em">
                  <p>Élève n°'.$row["IDEleve"].'</p>
                  <p>Nom : '.$row["Nom"].' '.$row["Prenom"].'</p>
                </div>';
              }
              else{
                echo '
                <div class="jumbotron text-dark bg-light" style="padding:0.5em">
                  <p>Élève n°'.$row["IDEleve"].'</p>
                  <p>Nom : '.$row["Nom"].' '.$row["Prenom"].'</p>
                </div>
                ';
              }
              $grpancien = $row["NumGroupe"];
            }
          }
          echo "</div>";
          while($row2 = $stmt->fetch()){
            if($i != $maxNumGroupe-1){
              echo '
              <div id="grp-'.$row2["NumGroupe"].'" class="jumbotron text-white bg-dark" style="padding:1em">
                <h1>Groupe n°'.$row2["NumGroupe"].'</h1>
                <h2>Projet : '.$row2["NomProjet"].'</h2>
              </div>';
            }
            else{
              echo '
              </div>
              <div id="grp-'.$row2["NumGroupe"].'" class="jumbotron text-white bg-dark" style="padding:1em">
                <h1>Groupe n°'.$row2["NumGroupe"].'</h1>
                <h2>Projet : '.$row2["NomProjet"].'</h2>
              </div>';
            }
        }
      }
      catch(Exception $e)
      {
        echo $e->getMessage();
      }

      ?>

    </div>
  </div>
</body>

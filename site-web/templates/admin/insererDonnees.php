<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../../css/index.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
</head>
<body>
<?php session_start();
$_SESSION['connect']=0;
if(!isset($_SESSION['loginOK'])){
  header('Location: ../protection/connexion.php');
}?>
<div style="display:flex">
  <?php include 'menu_admin.php'; ?>

  <nav class="navbar navbar-expand-lg navbar-light navbar-right" style="margin-left: 11%">

    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Élèves
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
      </ul>
    </div>

  </nav>
</div>

<!DOCTYPE html>
<html class="h-100">
<head>
  <link rel="stylesheet" type="text/css" href="./css/index.css"/>
  <link rel="stylesheet" type="text/css" href=""/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
  <base href="templates/protection/">
</head>
<body class="h-100">
  <?php
    include '../BD/Interactions/Connexion.php';
    $db = connect_database();

    $statement = $db->prepare("SELECT * from OLYMPIADES");
    $statement->execute();

    while($row = $statement->fetch()){
      $numEdition = $row["NumEdition"];
      $LogOlympiades = $row["LogOlympiades"];
      $LogoSponsor = $row["LogoSponsor"];
      $LogoUPSTI = $row["LogoUPSTI"];
      $LogoIUT = $row["LogoIUT"];
      $date = $row["datetimeOlymp"];
    }
  ?>
  <div class="container-fluid h-100" style="padding-bottom: 13%">

    <div class="row justify-content-start">
      <div class="col-2">
        <div id="mySidenav" class="sidenav">
          <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
          <a href="../../index.php">Accueil</a>
          <a href="connexion.php">Connexion</a>
        </div>

        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
      </div>

      <div class="col-8 text-center">
        <h1 class="display-2"><?php echo "Olympiades n°".$numEdition?></h1>
      </div>

      <div class="col-2">
        <div class="media" id="upsti">
          <img src="<?php
            echo '../../images/'.$LogoUPSTI;
          ?>"/>
        </div>
      </div>
    </div>

    <div class="row justify-content-center h-100">
      <div class="col align-self-center">
        <div class="media" id="olymp">
          <img src="<?php
            echo '../../images/'.$LogOlympiades;
          ?>"/>
        </div>
      </div>
    </div>

    <div class="row justify-content-end">
      <div class="col-4">
        <div class="media" id="upsti">
          <img src="<?php
            echo '../../images/'.$LogoSponsor;
          ?>"/>
        </div>
      </div>
      <div class="col-4 text-center align-self-center">
        <h5 id="date"><?php echo $date?></h5>
      </div>
      <div class="col-4">
        <div class="media" id="iut">
          <img src="<?php
            echo '../../images/'.$LogoIUT;
          ?>"/>
        </div>
      </div>
    </div>

  </div>

  <script>
  let elemdate = document.getElementById("date").textContent.split(" ")[0].split("-");
  document.getElementById("date").textContent = elemdate[2]+"-"+elemdate[1]+"-"+elemdate[0];
  function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
  }

  function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
  }
  </script>
</body>
</html>

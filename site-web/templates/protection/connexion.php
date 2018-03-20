<!DOCTYPE html>
<html class="h-100">
<head>
  <link rel="stylesheet" href="../../css/index.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
</head>
<body class="h-100">
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="../../index.php">Accueil</a>
    <a href="connexion.php">Connexion</a>
  </div>

  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>

  <script>
  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  }
  </script>
  <div class="container h-100">
    <div class="row justify-content-center h-100">
      <div class="row align-items-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
          <div class="jumbotron bg-dark">
            <form id="needs-validation" class="" method="POST" action="connect.php" novalidate>
              <h1 class="text-center text-white display-4">Authentification</h1>
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label for="usrname" class="text-white">Nom d'utilisateur</label>
                  <input type="text" class="form-control" id="usrname" placeholder="Nom d'utilisateur" name="username" required>
                  <div class="invalid-feedback">
                    Veuillez renseigner un nom d'utilisateur.
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <label for="passwd" class="text-white">Mot de passe</label>
                  <input type="password" class="form-control" id="passwd" placeholder="Mot de passe" name="mdp" required>
                  <div id="erreurMDP" class="invalid-feedback">
                    Veuillez renseigner un mot de passe.
                  </div>
                </div>
              </div>
              <div id="erreur">
              </div>
              <center><button class="btn btn-light" type="submit">Connexion</button></center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <img id="logo" />
  <script>
  (function() {
    'use strict';

    window.addEventListener('load', function() {
      var form = document.getElementById('needs-validation');
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    }, false);
  })();

  </script>
</body>
</html>

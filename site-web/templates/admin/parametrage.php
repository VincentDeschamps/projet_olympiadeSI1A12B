<html >
<head>
  <link rel="stylesheet" href="../../css/index.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body >
  <?php session_start();
  $_SESSION['connect']=0;
  if(!isset($_SESSION['loginOK'])){
    header('Location: ../protection/connexion.php');
  }?>

  <?php include 'menu_admin.php'; ?>

  <h1 class="h1 text-center">Paramétrage du site</h1>
  <div class="container">
    <div class="jumbotron bg-dark text-white">
      <h4 class="h4">Renseignez les champs à mettre à jour :</h4>

      <form method="POST" action="insertion_param.php">
        <div class="form-group row">
          <label for="edition" class="col-8 col-sm-8 col-md-8 col-lg-8 col-form-label">Édition des Olympiades</label>
          <div class="col-sm-4">
            <input id="edition" type="number" class="form-control" min="1" name="edition" value=
            <?php
            require '../../../BD/Interactions/Connexion.php';
            try{
              $db = connect_database();
              $stmt = $db->query("select NumEdition from OLYMPIADES");
              echo $stmt->fetch()["NumEdition"];
            }
            catch(Exception $e){
              $e->getMessage();
            }
            ?>
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="date" class="col-8 col-sm-8 col-md-8 col-lg-8 col-form-label">Date</label>
          <div class="col-sm-4">
            <input id="date" name="date" type="date"/>
          </div>
        </div>
        <div class="form-group row">
          <label for="sponsors" class="col-8 col-sm-8 col-md-8 col-lg-8 col-form-label">Logo Sponsors</label>
          <div class="col-sm-4">
            <input id="sponsors" name="sponsors" type="file" value="none"/>
          </div>
        </div>
        <div class="form-group row">
          <label for="illustration" class="col-8 col-sm-8 col-md-8 col-lg-8 col-form-label">Logo Olympiades</label>
          <div class="col-sm-4">
            <input id="illu" name="illustration" type="file" value="none"/>
          </div>
        </div>
        <div class="form-group row">
          <label for="upsti" class="col-8 col-sm-8 col-md-8 col-lg-8 col-form-label">Logo UPSTI</label>
          <div class="col-sm-4">
            <input id="upsti" name="upsti" type="file" value="none"/>
          </div>
        </div>
        <div class="form-group row">
          <label for="bandeau" class="col-8 col-sm-8 col-md-8 col-lg-8 col-form-label">Bandeau partenaires</label>
          <div class="col-sm-4">
            <input id="bandeau" name="bandeau" type="file" value="none"/>
          </div>
        </div>
        <div class="form-group row">
          <label for="iut" class="col-8 col-sm-8 col-md-8 col-lg-8 col-form-label">Logo IUT</label>
          <div class="col-sm-4">
            <input id="iut" name="iut" type="file" value="none"/>
          </div>
        </div>

        <div class="text-center">
          <button id="enr" class="btn btn-light">Enregistrer</button>
        </div>
      </form>

      <div id="err"></div>
    </div>
  </div>

<script>
  let btn = document.getElementById("enr");
  btn.onclick = function(e){
    while(document.getElementById("err").firstChild){
      document.getElementById("err").removeChild(document.getElementById("err").firstChild);
    }
    $("#err").append("<ul id='list-err'></ul>");
    if(document.getElementById("edition").value == ""){
      e.preventDefault();
      $('#list-err').append('\
        <li>Veuillez mettre un numéro d\'édition.</li>\
      ');
      $("#err").addClass("jumbotron bg-danger");
    }
    if(document.getElementById("date").valueAsDate == null){
      e.preventDefault();
      $('#list-err').append('\
        <li>Veuillez mettre une date.</li>\
      ');
      $("#err").addClass("jumbotron bg-danger");
    }
    if(document.getElementById("sponsors").value == ""){
      e.preventDefault();
      $('#list-err').append('\
        <li>Veuillez mettre un logo de sponsors.</li>\
      ');
      $("#err").addClass("jumbotron bg-danger");
    }
    if(document.getElementById("illu").value == ""){
      e.preventDefault();
      $('#list-err').append('\
        <li>Veuillez mettre le logo de l\'événement.</li>\
      ');
      $("#err").addClass("jumbotron bg-danger");
    }
  }
</script>
</body>
</html>

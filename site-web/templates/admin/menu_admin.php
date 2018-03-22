
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="accueil_admin.php">Accueil</a>
  <a href="InsererEleve.php">Ajout</a>
  <a href="resultats_admin.php">Résultats</a>
  <a href="parametrage.php">Paramétrage</a>
  <a href="plan.php">Planning</a>
  <a href="../protection/deconnexion.php">Déconnexion</a>
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

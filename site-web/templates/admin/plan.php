<html>
    <head>
        <link rel="stylesheet" href="../../css/index.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    </head>

    <body>
        <?php session_start();
            $_SESSION['connect']=0;
            if(!isset($_SESSION['loginOK'])){
            header('Location: ../protection/connexion.php');
            }
            include 'menu_admin.php';
            include '../../../BD/Interactions/InteractionsBD.php';
            include '../../../BD/Interactions/Connexion.php';
            include '../../../BD/Classe/Jury.php';
            include '../../../BD/Classe/Groupe.php';
            include '../../../BD/Classe/Heure.php';
            $db = connect_database();
        ?>

        <center><h1>Planning</h1></center>

        <div>
            <div style="padding-top: 1% ; padding-left: 5% ; padding-right: 5%">
                <table class="table table-striped" style="text-align: center;">
                    <thead class="thead-dark">
                        <tr>
                        <th>Horaires</th>
                        <?php
                            $ListeJury = getJury($db);
                            foreach($ListeJury as $j)
                            {
                                echo "<th>".$j->getNumJury()."</th>";
                            }
                        ?>
                        </tr>
                    </thead>
                    <?php
                        $ListeHeure = getHeure($db);
                        $ListeGroupe = getGroupe($db);

                        foreach($ListeHeure as $h)
                        {
                            echo "<tr id =".$h->getID().">";
                            echo "<td>".$h->getDeb().":".$h->getFin()."</td>";
                            for ($i = 1; $i <= count($ListeJury);$i++)
                            {
                                echo "<td>";
                                echo "<select name='".$h->getID().$i."' onchange=assign(this.name,this.value)>";
                                $stmt = $db->prepare("select * from JUGE");
                                $stmt->execute();
                                $verif = false;
                                $idSelected = null;
                                while($row = $stmt->fetch())
                                {
                                    if( ($row['NumJury'] == $i) && ($h->getID() == $row['idHeure'] ))
                                    {
                                        $verif = true;
                                        $idSelected = $row['NumGroupe'];
                                    }
                                }
                                if(!$verif)
                                {
                                    echo "<option value=none></option>";
                                    foreach ($ListeGroupe as $g)
                                    {
                                        echo "<option value='".$g->getNumGroupe()."'>".$g->getNomProj()."</option>";
                                    }
                                }
                                else
                                {
                                    foreach ($ListeGroupe as $g)
                                    {
                                        if ($g->getNumGroupe() === $idSelected)
                                        {
                                            echo "<option value='".$g->getNumGroupe()."' selected>".$g->getNomProj()."</option>";
                                        }
                                        else
                                        {
                                            echo "<option value='".$g->getNumGroupe()."'>".$g->getNomProj()."</option>";
                                        }
                                    }
                                    echo "<option value=none></option>";
                                }
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
        <script>
            function assign(name,value)
            {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 0)) {
                        alert(xmlhttp.responseText);
                        location.reload();
                        }
                };

                let n = encodeURIComponent(name);
                let v = encodeURIComponent(value);
                xmlhttp.open("GET","updatePlanning.php?value="+v+"&name="+n,true);
                xmlhttp.send();
            }
        </script>
    </body>
    <?php
        $db = null;
    ?>
</html>

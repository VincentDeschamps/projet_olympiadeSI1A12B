<?php

    /**
     * Cette fonction récupère l'indice maximum 
     * pour la table PERSONNE dans la base de données.
     * 
     * 
     * @author Bouny Quentin
     * 
     * @param PDO $connexion Connexion avec la base de données
     * 
     * @return int Retourne l'ID maximum de la table PERSONNE dans la base de données. 
     */
    function getMaxIDPersonne($connexion)
    {
        /**
         * 
         * @var String $request Requête à envoyer à la base de données.
         * @var PDOStatement $result Résultat de la requête en base de données.
         * @var Integer $max['max(ID)'] Contient l'ID maximum qu'il y a dans la base de données. 
         */
        // Writing the request
        $request = "SELECT max(ID) from PERSONNE";

        // Getting the result after the query
        $result = $connexion->query($request);

        // Fetch the result in var $max
        $max = $result->fetch();

        // Testing the value of $max
        if($max['max(ID)'] > 0){
            return $max['max(ID)'];
        }
        else{
            return 0;
        }
    }
    /**
     * Cette fonction récupère l'indice maximum 
     * pour la table GROUPE dans la base de données.
     * 
     * 
     * @author Bouny Quentin
     * 
     * @param PDO $connexion Connexion avec la base de données
     * 
     * @return int Retourne l'ID maximum de la table GROUPE dans la base de données. 
     */
    function getMaxIDGROUPE($connexion)
    {
        /**
         * 
         * @var String $request Requête à envoyer à la base de données.
         * @var PDOStatement $result Résultat de la requête en base de données.
         * @var Integer $max['max(ID)'] Contient l'ID maximum qu'il y a dans la base de données. 
         */
        // Writing the request
        $request = "SELECT max(NumGroupe) from GROUPE";

        // Getting the result after the query
        $result = $connexion->query($request);

        // Fetch the result in var $max
        $max = $result->fetch();

        // Testing the value of $max
        if($max['max(NumGroupe)'] > 0){
            return $max['max(NumGroupe)'];
        }
        else{
            return 0;
        }
    }

    /**
     * Cette fonction récupère l'indice maximum 
     * pour la table JURY dans la base de données.
     * 
     * 
     * @author Bouny Quentin
     * 
     * @param PDO $connexion Connexion avec la base de données
     * 
     * @return int Retourne l'ID maximum de la table JURY dans la base de données. 
     */
    function getMaxIDJURY($connexion)
    {
        /**
         * 
         * @var String $request Requête à envoyer à la base de données.
         * @var PDOStatement $result Résultat de la requête en base de données.
         * @var Integer $max['max(ID)'] Contient l'ID maximum qu'il y a dans la base de données. 
         */
        // Writing the request
        $request = "SELECT max(NumJury) from JURY";

        // Getting the result after the query
        $result = $connexion->query($request);

        // Fetch the result in var $max
        $max = $result->fetch();

        // Testing the value of $max
        if($max['max(NumJury)'] > 0){
            return $max['max(NumJury)'];
        }
        else{
            return 0;
        }
    }

    /**
     * Cette fonction récupère l'indice maximum 
     * pour la table HEURE dans la base de données.
     * 
     * 
     * @author Bouny Quentin
     * 
     * @param PDO $connexion Connexion avec la base de données
     * 
     * @return int Retourne l'ID maximum de la table HEURE dans la base de données. 
     */
    function getMaxIDHeure($connexion)
    {
        /**
         * 
         * @var String $request Requête à envoyer à la base de données.
         * @var PDOStatement $result Résultat de la requête en base de données.
         * @var Integer $max['max(ID)'] Contient l'ID maximum qu'il y a dans la base de données. 
         */
        // Writing the request
        $request = "SELECT max(IDHeure) as max from HEURE";

        // Getting the result after the query
        $result = $connexion->query($request);

        // Fetch the result in var $max
        $max = $result->fetch();

        // Testing the value of $max
        if($max['max'] > 0){
            return $max['max'];
        }
        else{
            return 0;
        }
    }

    /**
     * Cette fonction récupère l'indice maximum 
     * pour la table NOTE dans la base de données.
     * 
     * 
     * @author Bouny Quentin
     * 
     * @param PDO $connexion Connexion avec la base de données
     * 
     * @return int Retourne l'ID maximum de la table NOTE dans la base de données. 
     */
    function getMaxIDNote($connexion)
    {
        /**
         * 
         * @var String $request Requête à envoyer à la base de données.
         * @var PDOStatement $result Résultat de la requête en base de données.
         * @var Integer $max['max(ID)'] Contient l'ID maximum qu'il y a dans la base de données. 
         */

        // Writing the request
        $request = "SELECT max(idNote) as max from NOTE";

        // Getting the result after the query
        $result = $connexion->query($request);

        // Fetch the result in var $max
        $max = $result->fetch();

        // Testing the value of $max
        if($max['max'] > 0){
            return $max['max'];
        }
        else{
            return 0;
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste de personnes passée en paramètre
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListePersonne Liste des personnes à insérer dans la base de données.
     * données.
     *
     */
    function insertPersonne($connexion,$ListePersonne)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{
            // Creation of the statement
            $statement = $connexion->prepare("INSERT INTO PERSONNE (ID,Nom,Prenom) VALUES (:id,:Nom, :Prenom)");


            // Binding
            $statement->bindParam(':id',$id);
            $statement->bindParam(':Nom',$Nom);
            $statement->bindParam(':Prenom',$Prenom);


            for($i = 0;$i < count($ListePersonne);$i++)
            {
                // Passing the value to the parameter
                $p = $ListePersonne[$i];
                $id = $p->getiD();
                $Nom = $p->getNom();
                $Prenom = $p->getPrenom();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste d'élèves passée en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListeEleve Liste des élèves à insérer dans la base de données.
     * données.
     *
     */
    function insertEleve($connexion,$ListeEleve)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO ELEVE (IDEleve,Filiere,NumGroupe) VALUES (:id,:filiere, :Num)");

            $statement->bindParam(':id',$id);
            $statement->bindParam(':filiere',$Filiere);
            $statement->bindParam(':Num',$Num);

            for($i = 0;$i < count($ListeEleve);$i++)
            {
                // Passing the value to the parameter
                $id = $ListeEleve[$i]->getID();
                $Filiere = $ListeEleve[$i]->getFiliere();
                $Num = $ListeEleve[$i]->getNumGroupe();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste de professeurs passée en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListeProf Liste des professeurs à insérer dans la base de données.
     * données.
     *
     */
    function insertProf($connexion,$ListeProf)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO PROFESSEUR (IDProf,NumJury) VALUES (:id,:Num)");

            $statement->bindParam(':id',$id);
            $statement->bindParam(':Num',$Num);

            for($i = 0;$i < count($ListeProf);$i++)
            {
                // Passing the value to the parameter
                $id = $ListeProf[$i]->getID();
                $Num = $ListeProf[$i]->getNumJury();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste de groupes passée en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListeGroupe Liste des groupes à insérer dans la base de données.
     * données.
     *
     */
    function insertGroupe($connexion,$ListeGroupe)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO GROUPE (NumGroupe,NomProjet,Lycee,numSalle,image_Projet) VALUES (:Num,:Nom,:Lycee,:salle,:img)");

            $statement->bindParam(':Num',$Num);
            $statement->bindParam(':Nom',$Nom);
            $statement->bindParam(':Lycee',$Lycee);
            $statement->bindParam(':img',$img);
            $statement->bindParam(':salle',$salle);

            for($i = 0;$i < count($ListeGroupe);$i++)
            {
                // Passing the value to the parameter
                $Num = $ListeGroupe[$i]->getNumGroupe();
                $Nom = $ListeGroupe[$i]->getNomProj();
                $Lycee = $ListeGroupe[$i]->getLycee();
                $salle = $ListeGroupe[$i]->getSalle();
                $img = $ListeGroupe[$i]->getImageProjet();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste de jury passée en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListeJury Liste des jury à insérer dans la base de données.
     * données.
     *
     */
    function insertJury($connexion,$ListeJury)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO JURY (NumJury,login_,password_) VALUES (:Num,:log,:passwd)");

            $statement->bindParam(':Num',$Num);
            $statement->bindParam(':log',$log);
            $statement->bindParam(':passwd',$pass);

            for($i = 0;$i < count($ListeJury);$i++)
            {
                // Passing the value to the parameter
                $Num = $ListeJury[$i]->getNumJury();
                $log = $ListeJury[$i]->getLogin();
                $pass = $ListeJury[$i]->getPassword();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste des créneaux horaires passée en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListeHeure Liste des créneaux horaires à insérer dans la base de données.
     * données.
     *
     */
    function insertHeure($connexion,$ListeHeure)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO HEURE (idHeure,hDeb,hFin) VALUES (:id,:hDeb,:hFin)");

            $statement->bindParam(':id',$id);
            $statement->bindParam(':hDeb',$hdeb);
            $statement->bindParam(':hFin',$hfin);

            for($i = 0;$i < count($ListeHeure);$i++)
            {
                // Passing the value to the parameter
                $id = $ListeHeure[$i]->getID();
                $hdeb = $ListeHeure[$i]->getDeb();
                $hfin = $ListeHeure[$i]->getFin();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste des juges passée en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListeJuge Liste des juges à insérer dans la base de données.
     * données.
     *
     */
    function insertJuge($connexion,$ListeJuge)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO JUGE (NumJury,NumGroupe,idHeure,numSalle) VALUES (:NumJury,:NumGroupe,:id,:NumSalle)");

            $statement->bindParam(':NumJury',$NumJury);
            $statement->bindParam(':NumGroupe',$NumGroupe);
            $statement->bindParam(':id',$id);
            $statement->bindParam(':NumSalle',$Salle);

            for($i = 0;$i < count($ListeJuge);$i++)
            {
                // Passing the value to the parameter
                $NumJury = $ListeJuge[$i]->get_NumJury();
                $NumGroupe = $ListeJuge[$i]->get_NumGroupe();
                $id = $ListeJuge[$i]->get_idHeure();
                $Salle = $ListeJuge[$i]->getSalle();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une
     * liste de notes passée en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListeNote Liste des notes à insérer dans la base de données.
     * données.
     *
     */
    function insertNote($connexion,$ListeNote)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO NOTE (idNote,prototype,originalite,demarcheSI,pluriDisciplinarite,maitrise,devDurable) VALUES (:id,:proto,:ori,:demarche,:pluri,:maitrise,:DD)");

            $statement->bindParam(':id',$id);
            $statement->bindParam(':proto',$proto);
            $statement->bindParam(':ori',$ori);
            $statement->bindParam(':demarche',$demarche);
            $statement->bindParam(':pluri',$pluri);
            $statement->bindParam(':maitrise',$maitrise);
            $statement->bindParam(':DD',$DD);

            for($i = 0;$i < count($ListeJuge);$i++)
            {
                // Passing the value to the parameter
                $id = $ListeNote[$i]->getID();
                $proto = $ListeNote[$i]->getProto();
                $ori = $ListeNote[$i]->getOrigin();
                $pluri = $ListeNote[$i]->getPluriDiscipline();
                $maitrise = $ListeNote[$i]->getMaitrise();
                $DD = $ListeNote[$i]->getDurable();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction insère, dans la base de données, une 
     * liste de relations entre la table JURY, GROUPE et NOTE
     * passée en paramètres.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param Array $ListePersonne Liste des personnes à insérer dans la base de données.
     * données.
     *
     */
    function insertDonne($connexion,$ListeDonne)
    {
        /**
         * 
         * @var PDOStatement $statement Variable dans laquelle est stockée les résulats de la requête dans la base de données.
         */
        try{

            $statement = $connexion->prepare("INSERT INTO DONNE (NumJury,NumGroupe,idNote) VALUES (:NumJury,:NumGroupe,:id)");

            $statement->bindParam(':NumJury',$NumJury);
            $statement->bindParam(':NumGroupe',$NumGroupe);
            $statement->bindParam(':id',$id);

            for($i = 0;$i < count($ListeJuge);$i++)
            {
                // Passing the value to the parameter
                $NumJury = $ListeJuge[$i]->get_NumJury();
                $NumGroupe = $ListeJuge[$i]->get_NumGroupe();
                $id = $ListeJuge[$i]->get_IdNote();

                // Execute the insertion
                $statement->execute();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction permet de récupèrer la liste
     * des personnes appartenant à un groupe donné.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données.
     * @param Integer $idGroupe ID du groupe dont on veut récupérer la liste de personnes appartenant à ce groupe.
     * 
     * @return Array Liste des personnes appartenant au groupe dont l'ID est passé en paramètre.
     */
    function getPersonneFromGroupe($connexion,$idGroupe)
    {
        /**
         * @var String $prep Requête à envoyer à la base de données.
         * @var PDOStatement $reponse Résultat de la requête en base de données.
         */
        try{
            $prep = "SELECT ID, Nom, Prenom from PERSONNE NATURAL JOIN ELEVE where IDEleve = ID and NumGroupe=$idGroupe;";

            $reponse = $connexion->query($prep);
            $ListePersonne = array();

            while ($donnees = $reponse->fetch())
            {
                $id = $donnees[0];
                $Nom = $donnees[1];
                $Prenom = $donnees[2];

                $p = new Personne($id,$Nom,$Prenom);
                echo $p;
                array_push($ListePersonne,$p);
            }

            return $ListePersonne;
        }
        catch(Exception $e)
        {
            echo e.getMessage();
        }
    }

    /**
     * Cette fonction permet de récupèrer la liste
     * des élèves dans la base de données.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données.
     * 
     * @return Array Liste des eleves dans la base de données.
     */
    function getEleve($connexion)
    {
        /**
         * @var String $prep Requête à envoyer à la base de données.
         * @var PDOStatement $reponse Résultat de la requête en base de données.
         */
        try{
            $prep = "SELECT * from PERSONNE where ID=(SELECT IDEleve from ELEVE where IDEleve=ID);";

            $reponse = $connexion->query($prep);
            $ListePersonne = array();

            while ($donnees = $reponse->fetch())
            {
                $id = $donnees[0];
                $Nom = $donnees[1];
                $Prenom = $donnees[2];

                $p = new Personne($id,$Nom,$Prenom);
                array_push($ListePersonne,$p);
            }
            return $ListePersonne;
        }
        catch(PDOException $e)
        {
            echo $e.getMessage();
        }
    }

    /**
     * Cette fonction permet de récupèrer la liste
     * des notes appartenant au groupe dont l'ID 
     * est passé en paramètre.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données.
     * @param Integer $numGroupe Numéro du groupe dont on veut récupérer les notes.
     * 
     * @return Array Liste de la moyenne des notes du groupe pour chaque catégorie ou liste avec chaque critère
     * équivalent à -1 si aucune note dans la base de données pour ce groupe.
     */
    function getNote($connexion,$numGroupe)
    {
        /**
         * 
         * @var String $prep Requête à envoyer en base de données.
         * @var PDOStatement $reponse Réponse de la base de données à la requête qui lui est envoyée.
         */
        try
        {
            $Liste = array("Prototype"=>0,"Originalite"=> 0,"DemarcheSI"=>0,"pluriDisciplinarite"=>0,"Maitrise"=>0,"devDurable"=>0);

            $prep = "select idNote from DONNE where NumGroupe = $numGroupe";
            $reponse = $connexion->query($prep);

            $NB = $reponse->rowCount();

            if ($NB == 0)
            {
                return array("Prototype"=>-1,"Originalite"=>-1,"DemarcheSI"=>-1,"pluriDisciplinarite"=>-1,"Maitrise"=>-1,"devDurable"=>-1);
            }

            while ($donnees = $reponse->fetch())
            {
                $id = $donnees['idNote'];
                $req = "select * from NOTE where idNote = $id";

                $data = $connexion->query($req);
                $rep = $data->fetch();

                $Liste["Prototype"] += $rep['prototype'];
                $Liste["Originalite"] += $rep['originalite'];
                $Liste["DemarcheSI"] += $rep['DemarcheScientifique'];
                $Liste["pluriDisciplinarite"] += $rep['pluriDisciplinarite'];
                $Liste["Maitrise"] += $rep['MaitriseScientifique'];
                $Liste["devDurable"] += $rep['Communication'];
            }

            $Liste["Prototype"] = $Liste["Prototype"] / $NB;
            $Liste["Originalite"] = $Liste["Originalite"]/$NB;
            $Liste["DemarcheSI"] = $Liste["DemarcheSI"]/$NB;
            $Liste["pluriDisciplinarite"] = $Liste["pluriDisciplinarite"]/$NB;
            $Liste["Maitrise"] = $Liste["Maitrise"]/$NB;
            $Liste["devDurable"] = $Liste["devDurable"]/$NB;


            return $Liste;
        }
        catch(PDOException $e)
        {
        echo $e.getMessage();
        }
    }

    /**
     * Cette fonction vérifie si le login et le mot de passe passé en paramètre
     * sont dans la base de données et donc valides.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données
     * @param String $Login Login a tester
     * @param String $password Mot de passe a tester
     * 
     */
    function checkLogin($connexion,$Login,$password)
    {
        /**
         * 
         * @var String $prep Requête à envoyer en base de données
         * @var String $prep1 Requête à envoyer en base de données
         * @var PDOStatement $rep Réponse de la base de données.
         */
        try
        {
            $prep = "SELECT login_, password_ FROM JURY";
            $prep1 = "SELECT login, MotDePasse FROM ADMINISTRATEUR";

            $rep = $connexion->query($prep1);

            $test = $rep->fetch();
            if ( ($test['login'] == $Login) && ($test['MotDePasse'] == $password) )
            {
                return 'Admin';
            }

            $rep = $connexion->query($prep);

            while ($test = $rep->fetch())
            {
                if ( ($test['login_'] == $Login) && ($test['password_'] == $password) )
                {
                    return 'Jury';
                }
            }

            return 'None';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Cette fonction permet de récupèrer la liste
     * des professeurs dans la base de données.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données.
     * 
     * @return Array Liste des professeurs dans la base de données.
     */
    function getProf($connexion)
    {
        /**
         * 
         * @var String $prep Requête à envoyer en base de données.
         * @var PDOStatement $reponse Réponse de la base de données à la requête qui lui est envoyée.
         */
        try{
            $prep = "SELECT * from PERSONNE where ID=(SELECT IDProf from PROFESSEUR where IDProf=ID);";

            $reponse = $connexion->query($prep);
            $ListePersonne = array();

            while ($donnees = $reponse->fetch())
            {
                $id = $donnees[0];
                $Nom = $donnees[1];
                $Prenom = $donnees[2];

                $p = new Personne($id,$Nom,$Prenom);
                array_push($ListePersonne,$p);
            }
            return $ListePersonne;
        }
        catch(PDOException $e)
        {
            echo $e.getMessage();
        }
    }

    /**
     * Cette fonction permet de récupèrer la liste
     * des créneaux horaires dans la base de données.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données.
     * 
     * @return Array Liste des créneaux horaires dans la base de données.
     */
    function getHeure($connexion)
    {
        /**
         * 
         * @var String $prep Requête à envoyer en base de données.
         * @var PDOStatement $reponse Réponse de la base de données à la requête qui lui est envoyée.
         */
        try{
            $prep = "SELECT * from HEURE;";

            $reponse = $connexion->query($prep);
            $ListeHeure = array();

            while ($donnees = $reponse->fetch())
            {
                $id = $donnees[0];
                $HDeb = $donnees[1];
                $HFin = $donnees[2];

                $p = new Heure($id,$HDeb,$HFin);
                array_push($ListeHeure,$p);
            }
            return $ListeHeure;
        }
        catch(PDOException $e)
        {
            echo $e.getMessage();
        }
    }

    /**
     * Cette fonction permet de récupèrer la liste
     * des groupes dans la base de données.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données.
     * 
     * @return Array Liste des groupes dans la base de données.
     */
    function getGroupe($connexion)
    {
        /**
         * 
         * @var String $prep Requête à envoyer en base de données.
         * @var PDOStatement $reponse Réponse de la base de données à la requête qui lui est envoyée.
         */
        try{
            $prep = "SELECT * from GROUPE where NumGroupe > 0;";

            $reponse = $connexion->query($prep);
            $ListeGroupe = array();

            while ($donnees = $reponse->fetch())
            {
                $id = $donnees[0];
                $Nom = $donnees[1];
                $Lycee = $donnees[2];
                $img = $donnees[3];

                $p = new Groupe($id,$Nom,$Lycee,$img);
                array_push($ListeGroupe,$p);
            }
            return $ListeGroupe;
        }
        catch(PDOException $e)
        {
            echo $e.getMessage();
        }
    }

    /**
     * Cette fonction permet de récupèrer la liste
     * des jurys dans la base de données.
     * 
     * @author Quentin Bouny
     * 
     * @param PDO $connexion Connexion avec la base de données.
     * 
     * @return Array Liste des jurys dans la base de données.
     */
    function getJury($connexion)
    {
        /**
         * 
         * @var String $prep Requête à envoyer en base de données.
         * @var PDOStatement $reponse Réponse de la base de données à la requête qui lui est envoyée.
         */
        try{
            $prep = "SELECT * from JURY;";

            $reponse = $connexion->query($prep);
            $ListeJury = array();

            while ($donnees = $reponse->fetch())
            {
                $id = $donnees[0];
                $Log = $donnees[1];
                $Pass = $donnees[2];

                $p = new Jury($id,$Log,$Pass);
                array_push($ListeJury,$p);
            }
            return $ListeJury;
        }
        catch(PDOException $e)
        {
            echo $e.getMessage();
        }
    }

?>

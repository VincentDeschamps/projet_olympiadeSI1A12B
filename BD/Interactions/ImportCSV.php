<?php
// require '../Classe/Jury.php';
// require '../Classe/Groupe.php';
// require '../Classe/Eleve.php';
// require '../Classe/Professeur.php';
// require '../Classe/Personne.php';


/**
 * Cette fonction traite le fichier en format CSV
 * passé en paramètres pour ensuite insérer les 
 * données qu'il contient dans la base de données,
 * dans le cas présent des élèves.
 * 
 * @author Quentin Bouny
 * 
 * @param PDO $connexion Connexion avec la base de données.
 * @param String $filename Chemin pour accèder au fichier CSV
 */
function getCSVforEleve($connexion,$filename)
{
    /**
     * 
     * @var Pointeur $handle Pointeur vers le fichier à traiter.
     * @var Array $tabE Liste des élèves à insérer dans la base de données.
     * @var Array $tabP Liste des Personnes à insérer dans la base de données.
     * @var Integer $id ID maximum d'une personne dans la base de données
     */
    $handle = fopen($filename,"r");
    $tabE = array();
    $tabP = array();
    $id = getMaxIDPersonne($connexion)+1;
    if($handle)
    {
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            $Nom = $data[0];
            $Prenom = $data[1];
            $Filiere = $data[2];
            $NumGroupe = $data[3];
    
            $p = new Personne($id,$Nom,$Prenom);
            $e = new Eleve($id,$Filiere,$NumGroupe);
    
            if (!testPInListe($tabP,$p->getiD())) {
                array_push($tabP,$p);
                array_push($tabE,$e);
                $id++;
            }
        }
    
        insertPersonne($connexion,$tabP);
        insertEleve($connexion,$tabE);
        fclose($handle);
    }
}

/**
 * Cette fonction si l'ID passé en paramètre est présent
 * dans la liste passée, elle aussi, en paramètre.
 * 
 * @author Quentin Bouny
 * 
 * @param Array $Liste Liste contenant des personnes
 * @param Integer $id ID dont il faut vérifier la présence dans la liste ou non
 * 
 * @return Boolean Renvoie si oui ou non l'ID est présent dans la liste de personnes.
 * 
 */
function testPInListe($Liste,$id)
{
  foreach ($Liste as $p)
  {
    if ($p->getiD() === $id)
    {
      return true;
    }
  }
  return false;
}

/**
 * Cette fonction traite le fichier en format CSV
 * passé en paramètre pour ensuite insérer les 
 * données qu'il contient dans la base de données,
 * dans le cas présent des professeurs.
 * 
 * @author Quentin Bouny
 * 
 * @param PDO $connexion Connexion avec la base de données.
 * @param String $filename Chemin pour accèder au fichier CSV
 */
function getCSVforProf($connexion,$filename)
{
    /**
     * 
     * @var Pointeur $handle Pointeur vers le fichier à traiter.
     * @var Array $tabProf Liste des profeseurs à insérer dans la base de données.
     * @var Array $tabPers Liste des Personnes à insérer dans la base de données.
     * @var Integer $id ID maximum d'une personne dans la base de données
     */

    $handle = fopen($filename,"r");
    $tabPers = array();
    $tabProf = array();
    $id = getMaxIDPersonne($connexion)+1;
    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
        $Nom = $data[0];
        $Prenom = $data[1];
        $NumJury = $data[2];

        $p = new Personne($id,$Nom,$Prenom);
        $e = new Professeur($id,$NumJury);

        if (!testPInListe($tabPers,$p->getiD())) {
            array_push($tabPers,$p);
            array_push($tabProf,$e);
            $id++;
        }
    }

    insertPersonne($connexion,$tabPers);
    insertProf($connexion,$tabProf);
    fclose($handle);
}

/**
 * Cette fonction traite le fichier en format CSV
 * passé en paramètre pour ensuite insérer les 
 * données qu'il contient dans la base de données,
 * dans le cas présent des groupes.
 * 
 * @author Quentin Bouny
 * 
 * @param PDO $connexion Connexion avec la base de données.
 * @param String $filename Chemin pour accèder au fichier CSV
 */
function getCSVforGroupe($connexion,$filename)
{
    /**
     * 
     * @var Pointeur $handle Pointeur vers le fichier à traiter.
     * @var Array $tabGroupe Liste des groupes à insérer dans la base de données.
     * @var Integer $id ID maximum d'un groupe dans la base de données
     */

    $handle = fopen($filename,"r");
    $tabGroupe = array();
    $id = getMaxIDGROUPE($connexion)+1;
    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
        $Nom = $data[0];
        $Lycee = $data[1];
        $salle = $data[2];
        $chemin = $data[3];

        $g = new Groupe($id,$Nom,$Lycee,$salle,$chemin);

        if (!testPInListeG($tabGroupe,$g->getNumGroupe())) {
            array_push($tabGroupe,$g);
            $id++;
        }
    }

    insertGroupe($connexion,$tabGroupe);
    fclose($handle);
}

/**
 * Cette fonction si l'ID passé en paramètre est présent
 * dans la liste passée, elle aussi, en paramètre.
 * 
 * @author Quentin Bouny
 * 
 * @param Array $Liste Liste contenant des personnes
 * @param Integer $id ID dont il faut vérifier la présence dans la liste ou non
 * 
 * @return Boolean Renvoie si oui ou non l'ID est présent dans la liste de personnes.
 * 
 */
function testPInListeG($Liste,$id)
{
  foreach ($Liste as $g)
  {
    if ($g->getNumGroupe() === $id)
    {
      return true;
    }
  }
  return false;
}

/**
 * Cette fonction traite le fichier en format CSV
 * passé en paramètre pour ensuite insérer les 
 * données qu'il contient dans la base de données,
 * dans le cas présent des jurys.
 * 
 * @author Quentin Bouny
 * 
 * @param PDO $connexion Connexion avec la base de données.
 * @param String $filename Chemin pour accèder au fichier CSV
 */
function getCSVforJury($connexion,$filename)
{
    /**
     * 
     * @var Pointeur $handle Pointeur vers le fichier à traiter.
     * @var Array $tabJury Liste des jurys à insérer dans la base de données.
     * @var Integer $id ID maximum d'un groupe dans la base de données
     */
    try{
        $handle = fopen($filename,"r");
        $tabJury = array();
        $id = getMaxIDJURY($connexion)+1;
        if($handle)
        {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                $Login = $data[0];
                $Mdp = $data[1];
        
                $g = new Jury($id,$Login,$Mdp);
        
                if (!testPInListeJ($tabJury,$g->getNumJury())) {
                    array_push($tabJury,$g);
                    $id++;
                }
            }
        
            insertJury($connexion,$tabJury);
            fclose($handle);
        }
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}

/**
 * Cette fonction si l'ID passé en paramètre est présent
 * dans la liste passée, elle aussi, en paramètre.
 * 
 * @author Quentin Bouny
 * 
 * @param Array $Liste Liste contenant des jurys
 * @param Integer $id ID dont il faut vérifier la présence dans la liste ou non
 * 
 * @return Boolean Renvoie si oui ou non l'ID est présent dans la liste de jurys.
 * 
 */
function testPInListeJ($Liste,$id)
{
  foreach ($Liste as $g)
  {
    if ($g->getNumJury() === $id)
    {
      return true;
    }
  }
  return false;
}

/**
 * Cette fonction traite le fichier en format CSV
 * passé en paramètre pour ensuite insérer les 
 * données qu'il contient dans la base de données,
 * dans le cas présent des créneaux horaires et des
 * instances de la table DONNE.
 * 
 * @author Quentin Bouny
 * 
 * @param PDO $connexion Connexion avec la base de données.
 * @param String $filename Chemin pour accèder au fichier CSV
 */
function getCSVforHeure($connexion,$filename)
{
    /**
     * 
     * @var Pointeur $handle Pointeur vers le fichier à traiter.
     * @var Array $tabHeure Liste des créneaux horaires à insérer dans la base de données.
     * @var Array $tabJuge Liste des instances de la table juge à insérer dans la base de données.
     * @var Integer $id ID maximum d'un groupe dans la base de données
     */
    $handle = fopen($filename,"r");
    $tabHeure = array();
    $tabJuge = array();
    $id = getMaxIDHeure($connexion)+1;
    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
        $Hdeb = $data[0];
        $Hfin = $data[1];
        $NumGroupe = $data[2];
        $NumJury = $data[3];
        $Salle = $data[4];
        
        $Heure = new Heure($id,$Hdeb,$Hfin);
        $Juge = new Juge($NumJury,$NumGroupe,$id,$Salle);

        $resTest = testPInListeH($tabHeure,$Heure);
        if(!$resTest)
        {
            array_push($tabHeure,$Heure);
            array_push($tabJuge,$Juge);
            $id++;
        }
        else
        {
            $Juge->setIdHeure($resTest);
            array_push($tabJuge,$Juge);
        }
    }

    insertHeure($connexion,$tabHeure);
    insertJuge($connexion,$tabJuge);
    fclose($handle);
}

/**
 * Cette fonction si l'heure passée en paramètre est présent
 * dans la liste passée, elle aussi, en paramètre.
 * 
 * @author Quentin Bouny
 * 
 * @param Array $Liste Liste contenant des créneaux horaires
 * @param Heure $heure Heure dont il faut vérifier la présence dans la liste ou non
 * 
 * @return Boolean Renvoie si oui ou non l'heure est présent dans la liste de créneaux horaires.
 * 
 */
function testPInListeH($Liste,$heure)
{
  foreach ($Liste as $h)
  {
    if ( ($h->getID() === $heure->getID()) || ($h->getDeb() === $heure->getDeb()) || ($h->getFin() === $heure->getFin()) )
    {
      return $h->getID();
    }
  }
  return false;
}
?>

<?php

/**
 * Cette fonction permet de se connecter à la base de données.
 * 
 * @author Quentin Bouny
 * 
 * @return PDO  Retourne la connexion avec la base de données.
 */
function connect_database()
{
  /**
   * 
   * @var PDO $file_db Connexion avec la base de données.
   */
  try
  {
<<<<<<< HEAD
    $file_db = new PDO("mysql:dbname=dbbouny;host=servinfo-db", "bouny", "bouny");
    // $file_db = new PDO("mysql:dbname=dbbouny;host=localhost", "bouny", "bouny");
=======
    // $file_db = new PDO("mysql:dbname=dbbouny;host=servinfo-db", "bouny", "bouny");
    $file_db = new PDO("mysql:dbname=dbbouny;host=localhost", "bouny", "bouny");
>>>>>>> ludoliv/master
    // $file_db = new PDO("mysql:dbname=dbbouny;host=localhost", "root", "");
    $file_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    return $file_db;
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
}

?>

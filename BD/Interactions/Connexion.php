<?php
function connect_database()
{
  try
  {
    $file_db = new PDO("mysql:dbname=dbbouny;host=servinfo-db", "bouny", "bouny");
    // $file_db = new PDO("mysql:dbname=dbbouny;host=localhost", "bouny", "bouny");
    $file_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    return $file_db;
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
}

?>

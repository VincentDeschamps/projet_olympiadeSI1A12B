<?php
include("PDOConnection.php");

//Define some value
define("ACTION_LOGIN", "login");
define("RESULT_SUCCESS", 0);
define("RESULT_ERROR", 1);
define("RESULT_USER_EXISTS", 2);


//$action = $_POST["action"];
$action="login";
$result = RESULT_ERROR;
$jury=array();

if(isset($action))
{
	$username = $_POST["username"];
	$pwd = $_POST["password"];
	// $username='Login';
	// $pwd='MDP';

	if($action==ACTION_LOGIN) //Action login
	{
		if(login($cnn, $username, $pwd))
		{
			try{
				$result = RESULT_SUCCESS;
				$listeGrp=array();
				$listeHeure=array();
				$relation=array();
				//Login success + envoi bd
				$sql =  'SELECT DISTINCT * FROM GROUPE NATURAL JOIN JUGE NATURAL JOIN JURY NATURAL JOIN HEURE where login_="'.$username.'" and password_="'.$pwd.'";';
				$res = $cnn->query($sql);

				while  ($row = $res->fetch()) {

					array_push($listeGrp, array('NumGroupe'=>$row[2],"NomProj"=>$row[4],"Lycee"=>$row[5],"image_Projet"=>$row[6], "numSalle"=>$row[3]));

					array_push($relation, array('NumJury'=>$row[1],'NumGroupe'=>$row[2],'idHeure'=>$row[0]));

					array_push($listeHeure, array('idHeure'=>$row[0],'hDeb'=>$row[9],'hFin'=>$row[10]));
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}

		}
		else
		{
			//login fail
			$result = RESULT_ERROR;
		}
	}
}
//Print result as json
echo json_encode(array('result' => $result,"Jury"=>$jury,"Groupe"=>$listeGrp,"Heures"=>$listeHeure,"relation"=>$relation));

function insertUser($cnn, $username, $pwd)
{
	$query = "INSERT INTO JURY(login_, password_) VALUES(?, ?)";
	$stmt = $cnn->prepare($query);
	$stmt->bindParam(1, $username);
	$stmt->bindParam(2, $pwd);
	$stmt->execute();
}
function isExistUser($cnn, $username)
{
	$query = "SELECT * FROM JURY WHERE login_ = ?";
	$stmt = $cnn->prepare($query);
	$stmt->bindParam(1, $username);
	$stmt->execute();
	$rowcount = $stmt->rowCount();
	//for debug
	//var_dump($rowcount);
	return $rowcount;
}

function login($cnn, $username, $pwd)
{
	global $jury;
	$query = "SELECT * FROM JURY WHERE login_ = ? AND password_ = ?";
	$stmt = $cnn->prepare($query);
	$stmt->bindParam(1, $username);
	$stmt->bindParam(2, $pwd);
	$stmt->execute();
	while($row=$stmt->fetch()){
		$jury=array("id"=>$row[0],"Login"=>$row[1],"pwd"=>$row[2]);
	}
	$rowcount = $stmt->rowCount();
	//for debug
	//var_dump($rowcount);
	return $rowcount;
}

<?php
    error_log("FORGET ME");
	error_log("Ids :: ".$_POST["ids"][0]);
	
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$ids = "";
	foreach($_POST["ids"] as $id)
	{
		$ids = $ids.$id.",";
	}
	$ids = substr($ids,0,-1);
	
	$queryString = "DELETE FROM s_files WHERE id IN (".$ids.")";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
?>
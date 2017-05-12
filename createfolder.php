
<?php

	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
	    //print("Échec de la connexion");
	    exit();
	}
	
	$foldersQuery = "SELECT * FROM s_folders WHERE name = \"".$_POST["name"]."\"" ;
	print("REQUETE 1 :: ".$foldersQuery) ;
	$result = mysqli_query($link, $foldersQuery);
	$row = mysqli_fetch_row($result) ;
	
	if ($row) {
		print("DOSSIER EXISTANT");
		mysqli_free_result($result);
	}
	else {
		mysqli_free_result($result);
		
		$foldersQuery = "INSERT INTO s_folders (name, owner, rights, parent) VALUES (\"".$_POST["name"]."\", ".$_POST["owner"].",".$_POST["rights"].",".$_POST["parent"].")" ;
		print("REQUEST :: ".$foldersQuery) ;
		$result = mysqli_query($link, $foldersQuery);
		mysqli_free_result($result);
	}
	
	$foldersQuery = "SELECT * FROM s_folders WHERE 1" ;
	$result = mysqli_query($link, $foldersQuery);
	
	while ($row = mysqli_fetch_row($result))
	{
		echo "<p>".$row[4]."</p>";
	}
	mysqli_free_result($result);
	
echo '<p><form enctype="multipart/form-data" action="./createfolder.php" method="post">
  <select name="owner">
    <option selected value="1">Nicolas</option>
    <option value="2">Anne-Juliet</option>
    <option value="0">All users</option>
  </select>
  <select name="rights">
    <option selected value="3">Public</option>
    <option value="2">Private</option>
  </select>
  <select name="parent">
    <option value="0">No parent</option>
    <option value="1">2014</option>
    <option value="2">Famille</option>
  </select>
  Nom du dossier : <input type="text" name="name" />
  <input type="submit" value="Créer" />
</form></p>';

?>



<?php
// Dans les versions de PHP antiéreures à 4.1.0, la variable $HTTP_POST_FILES
// doit être utilisée à la place de la variable $_FILES.

$uploaddir = '/var/www/ressources/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

$link = mysqli_connect("localhost", "root", "sunny", "sunny");
/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    print("Échec de la connexion");
    exit();
}
 
$fileExist = false ;
$existingFileId ;
$newFileId ;

$queryString = "SELECT * FROM s_files WHERE filename = \"".$_FILES['userfile']['name']."\"";
$result = mysqli_query($link, $queryString);

$row = mysqli_fetch_row($result);
//print_r($row);
if ($row)
{
		print("IMAGE DEJA EXISTANTE");
		$fileExist = true ;
		$existingFileId = $row[0] ;
		mysqli_free_result($result);
		$date = date_create();
		$newName = substr(basename($_FILES['userfile']['name']),0,-4)."(".date_timestamp_get($date).")".substr(basename($_FILES['userfile']['name']),-4);
		print("NEW NAME : ".$newName) ;
		$uploadfile = $uploaddir.$newName;
	}

//echo '<html><body><p>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    	print("Upload OK");
    //echo '<a href="./index.php">Voir mes photos</a>' ;
} else {
    	print("Upload NOT OK");
    //echo '<a href="./upload.html">Reessayer</a>';
}



//echo 'Voici quelques informations de débogage :';
//print_r($_FILES);


if (substr($uploadfile, -3) == "gif" || substr($uploadfile, -3) == "jpg" || substr($uploadfile, -4) == "jpeg" || substr($uploadfile, -3) == "GIF"
|| substr($uploadfile, -3) == "JPG" || substr($uploadfile, -3) == "PNG" || substr($uploadfile, -3) == "png")
{
	if(!$fileExist)
	{
		$imageInfo["file"] = $_FILES['userfile']['name'];
	}
	else {
		$imageInfo["file"] = $newName ;
	}

	$exif = read_exif_data ($uploadfile, O, true);

	$imageInfo["make"] = $exif["IFD0"]["Make"];
	$imageInfo["date"] = $exif["EXIF"]["DateTimeOriginal"]; 
	$imageInfo["gps"] = $exif["GPS"];
	$imageInfo["type"] = exif_imagetype($uploadfile);
	
	//print_r($exif["GPS"]);

	if(!$imageInfo["date"])
	{
		if($exif["FILE"]["FileDateTime"])
		{
			$date = date("Y-m-d H:i:s", $exif["FILE"]["FileDateTime"]);
			$imageInfo["date"] = $date;
		}
	}
}

//print_r($tab_image);
 
//on ferme le répertoire
closedir($pointeur);

//on trie le tableau par ordre alphabétique
//array_sort($tab_image, "date", SORT_DESC);
//array_multisort($tab_image["date"], SORT_ASC, SORT_STRING);
 
$queryString = "INSERT INTO s_files (filename, type, url, date, gps) VALUES (\"".$imageInfo['file']."\",\"".$imageInfo['type']."\", \"".$uploadfile."\", \"".$imageInfo['date']."\", \"".$imageInfo['gps']."\")";
$result = mysqli_query($link, $queryString);
mysqli_free_result($result);

if($fileExist)
{
	print("FILE EXISTS !!");
	$queryString = "SELECT * FROM s_files WHERE filename = \"".$newName."\"";
	print("QUERY A : ".$queryString);
	$result = mysqli_query($link, $queryString);

	$row = mysqli_fetch_row($result);
	
	$newFileId = $row[0];
	print("NEW FILE ID : ".$newFileId);
	mysqli_free_result($result);
	
	$queryString = "INSERT INTO s_files_conflicts (added_file, older_file, insert_date) VALUES (\"".$newFileId."\",\"".$existingFileId."\", \"".date_timestamp_get($date)."\")";
	print("QUERY B : ".$queryString);
	$result = mysqli_query($link, $queryString);
	
	mysqli_free_result($result);
}


?>


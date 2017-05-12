<?
 
 $publicDirectory = "/ressources/" ;
 
 //Enregistrement en BDD
$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    //print("Échec de la connexion");
    exit();
}

$owner = ($_POST["user"] == 0) ? "a1.rights = 2" : "a1.owner = ".$_POST["user"] ;


//GET LOCATIONS
$selectedZoom = ($_POST['userRange']) ? $_POST['userRange'] : 0 ;
$queryString = "SELECT * FROM s_locations WHERE type = ".$selectedZoom;
$result = mysqli_query($link, $queryString);

$locations = [] ;

while ($row = mysqli_fetch_row($result)) {
		array_push($locations, $row) ;
}
mysqli_free_result($result);

//GET AGREGAT SCALE
$queryString = "SELECT * FROM d_location_scale WHERE type = ".$locations[0][1];
$result = mysqli_query($link, $queryString);

$locationScale = mysqli_fetch_row($result)[2] ;
mysqli_free_result($result);



$ii = 0 ;
while ($locations[$ii]) {
	
	
	$images[$ii]['locationName'] = $locations[$ii][2] ;
		
	$latRangeMin = $locations[$ii][3] - ($locationScale / 111) ;
	$latRangeMax = $locations[$ii][3] + ($locationScale / 111) ;
	$longRangeMin = $locations[$ii][4] - ($locationScale / 111*cos($locations[$ii][3])) ;
	$longRangeMax = $locations[$ii][4] + ($locationScale / 111*cos($locations[$ii][3])) ;
	
	//print("/////// ".$locationScale) ;
	//print("/////// ".$locations[$ii][3]) ;
	//print("/////// ".cos($locations[$ii][3])) ;
	//print("//////".($locationScale / 111*cos($locations[$ii][3]))) ;
	//print("//////") ;
	
	$queryString = "SELECT a2.name AS Owner, a1.filename AS Name, a1.date AS Date FROM s_files a1 RIGHT JOIN s_users a2 ON a2.id = a1.owner WHERE ".$owner;
	
	if ($selectedZoom != 0) {
		
		if($latRangeMin < $latRangeMax)
		{
			$queryString = $queryString." AND a1.latitude BETWEEN \"".$latRangeMin."\" AND \"".$latRangeMax."\"" ;
		
		}
		else {
			$queryString = $queryString." AND a1.latitude BETWEEN \"".$latRangeMax."\" AND \"".$latRangeMin."\"" ;
		
		}
		
		if($longRangeMin < $longRangeMax)
		{
			$queryString = $queryString." AND a1.longitude BETWEEN \"".$longRangeMin."\" AND \"".$longRangeMax."\"" ;
		
		}
		else {
			$queryString = $queryString." AND a1.longitude BETWEEN \"".$longRangeMax."\" AND \"".$longRangeMin."\"" ;
		
		}
	}
	
	//print("QUERY :: ".$queryString) ;
	$result = mysqli_query($link, $queryString);
	////print($queryString);
	////print_r($result);
	 
	//affichage des images (en 120 * 120 ici)
	
	$images[$ii]['images'] = [] ;
	$images[$ii]['owner'] = [] ;
	$images[$ii]['date'] = [] ;
	
	
	while ($row = mysqli_fetch_row($result)) {
	        ////print_r($row);   
			
	
	//$image = '<img src="'.$row[2].'" width="120" height="120">'; 
	////print_r($exif);
	
	array_push($images[$ii]['images'], $publicDirectory."thumbs/".$row[1]) ;
	array_push($images[$ii]['owner'], $row[0]) ;
	array_push($images[$ii]['date'], $row[2]) ;

}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	

$ii++;
}

echo'<table border="1" align="center">
<tr>
<td>Image</td>
<td>Nom de l\'image</td>
</tr>
';

for ($j=0; $j < count($images) ; $j++) { 
	
echo '<td>'.$images[$j]["locationName"].'</td>' ;

//print("IMAGES :: ".$images[$j]['images']) ;

for ($jj=0; $jj < count($images[$j]['images']); $jj++) { 
	
	/*
	$imagetoload = ".".$images[$j]['images'][$jj] ;
	$img = imagecreatefromjpeg($imagetoload);
	$nimg = imagecreatetruecolor(200,200);
	imagecopyresampled($nimg,$img,0,0,0,0,200,200,800,800);
	imagejpeg($nimg, "./ressources/temp.jpg", 50) ;
*/
echo
	'
	<tr>
	<td align="center"><img src="'.$images[$j]['images'][$jj].'" width="120" height="120"></td>
	
	<td align="center">';
	
	echo 'Owner : '.$images[$j]['owner'][$jj].'<br/>Date : '.$images[$j]['date'][$jj];
	
	//foreach ($exif as $key => $section) {
	//    foreach ($section as $name => $val) {
	//        echo "$key.$name: $val<br />\n";
	
	//    }
	//}
	echo '</td>
	</tr>
	';
}
}

echo '</table>

<p>This is the default wQue souhaitez-vous faire</p>
<form enctype="multipart/form-data" action="./index.php" method="post">
  <select name="user">
    <option selected="selected" value="1">Nicolas</option>
    <option value="2">Anne-Juliet</option>
    <option value="0">All users</option>
  </select>
  <select name="userRange">
    <option selected="selected" value="3">Maison</option>
    <option value="2">Ville</option>
    <option value="1">Pays</option>
    <option value="0">Toutes</option>
  </select>
  <input type="submit" value="Voir mes photos" />
</form>
<a href="./upload.html">Ajouter une photo</a>';
 ?>

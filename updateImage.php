<?php
include("tools.php");
foreach ($_POST as $key => $value) {
	error_log($key." :: ".$value);
}
updateImageInfo($_POST['image'], $_POST['gps']);

function updateImageInfo($jsonImage, $jsonGps)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	error_log("jsonImage :: ".$jsonImage);
	$params = json_decode($jsonImage, true);
	error_log("Params :: ".$params);
	foreach ($params as $key => $value) {
	error_log($key." :: ".$value);
}

	$queryString = "UPDATE s_files SET ";
	if($params['Name'] != "")
	{
		$queryString = $queryString . " filename = \"".$params['Name']."\",";
	}
	if($params['CameraMake'] != "")
	{
		$queryString = $queryString . " cameraMake = \"".$params['CameraMake']."\",";
	}
	if($params['CameraModel'] != "")
	{
		$queryString = $queryString . " cameraModel = \"".$params['CameraModel']."\",";
	}
	if($params['GpsLatitude'] != "")
	{
		$queryString = $queryString . " latitude = \"".$params['GpsLatitude']."\",";
	}
	if($params['GpsLongitude'] != "")
	{
		$queryString = $queryString . " longitude = \"".$params['GpsLongitude']."\",";
	}
	if($params['DateTaken'] != "")
	{
		$queryString = $queryString . " dateTaken = '".$params['DateTaken']."',";
	}
	if($params['Latitude'] != "")
	{
		$queryString = $queryString . " latitude = ".$params['Latitude'].",";
	}
	if($params['Longitude'] != "")
	{
		$queryString = $queryString . " longitude = ".$params['Longitude'].",";
	}
	if($params['url'] != "")
	{
		$queryString = $queryString . " url = ".$params['url'].",";
	}
	
	$queryString = substr($queryString,0,-1) . " WHERE id=".getFileIdFromPath($params['URL']);
	error_log("UPDATE :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	
	$date = date("Y-m-d H:i:s");
	$queryString = "UPDATE a_date_file SET updateDate = '".$date."' WHERE fileId = ".getFileIdFromPath($params['URL']);
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($params['Tags'] != "")
	{
		$tagsArr = split(",", $params['Tags']);
		foreach($tagsArr as $tag)
		{
			$queryString = "SELECT * FROM s_tags WHERE name = \"".$tag."\"";
			$result = mysqli_query($link, $queryString);
		
			if($row = mysqli_fetch_row($result))
			{
				$tagId = $row[0] ;
				mysqli_free_result($result);
			}
			else {
				error_log("NOUVEAU TAG :: ".$tag) ;
				mysqli_free_result($result);
			
				$queryString = "INSERT INTO s_tags (name) VALUES (\"".$tag."\")";
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				$tagId = mysqli_insert_id($link) ;
			}
			
			$queryString = "INSERT INTO a_tag_file (fileid, tagid) VALUES (".getFileIdFromPath($params['URL']).", ".$tagId.")";
			error_log($queryString);
			$result = mysqli_query($link, $queryString);
		}
	}
	
	if($params['Rights'] != "")
	{
		$queryString = "UPDATE a_owner_right_file SET rightId = ".$params['Rights']." WHERE fileId=".getFileIdFromPath($params['URL']);
		error_log("UPDATE :: ".$queryString);
		$result = mysqli_query($link, $queryString);
	}
	
	$zip = null;
	$city = null;
	$country = null;
	$cityLat = null;
	$cityLong = null;
	//GET Address from GPS
	if(($params['Latitude'] != "0" && $params['Latitude'] != "null" && $params['Latitude'] != "") || ($params['Longitude'] != "" && $params['Longitude'] != "0" && $params['Longitude'] != "null"))
	{
		$address = getAddressFromCoordinate(floatval($params['Latitude']), floatval($params['Longitude']));
		$zip = $address[0];
		$city = $address[1];
		$country = $address[2];
		$cityLat = $address[3];
		$cityLong = $address[4];
		//error_log("FULL ADDRESS :: ".$addressFull['results'][0]['formatted_address']);
	}
	
	error_log("ZIP :: ".$zip." :: CITY :: ".$city." :: COUNTRY ::".$country." :: ".$cityLat.":".$cityLong);
	
	if($country != null)
	{
		$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;
	
		//$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", )";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		
		if($row = mysqli_fetch_row($result))
		{
			$locationId = $row[0];
		}
		else {

			$queryString = "INSERT INTO s_locations (city, country, zipCode, latitude, longitude) 
							VALUES (\"".$city."\", \"".$country."\", \"".$zip."\", ".$cityLat.", ".$cityLong.")";

			error_log($queryString);
			$result = mysqli_query($link, $queryString);
			$locationId = mysqli_insert_id($link) ;
		}
	}
	else if(($city != null && $country != null)) 
	{
		$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;
	
		//$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", )";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		
		if($row = mysqli_fetch_row($result))
		{
			$locationId = $row[0];
		}
		else {

			$queryString = "INSERT INTO s_locations (city, country, zipCode, latitude, longitude) 
							VALUES (\"".$city."\", \"".$country."\", \"".$zip."\", ".$cityLat.", ".$cityLong.")";

			error_log($queryString);
			$result = mysqli_query($link, $queryString);
			$locationId = mysqli_insert_id($link) ;
		}
	}
	
	$queryString = "SELECT * FROM a_file_location WHERE fileId = ".getFileIdFromPath($params['URL']);
	error_log($queryString);
		$result = mysqli_query($link, $queryString);
		
		if($row = mysqli_fetch_row($result))
		{
			$queryString = " UPDATE a_file_location SET locationId=".$locationId." WHERE fileId=".getFileIdFromPath($params['URL']);
		}
		else {
			$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".getFileIdFromPath($params['URL']).", ".$locationId.")";
		}
	
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}
?>
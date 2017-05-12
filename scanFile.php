<?php

//CALLED FROM PC AND PHONE TO SCAN FILES
include_once("tools.php");
include_once("scan.php");

foreach ($_POST as $key => $value) {
	error_log($key." :: ".$value);
}/*
foreach ($_FILES['imageThumbs'] as $key => $value) {
	error_log($key." :: ".$value);
}
*/
if($_POST['deviceId'] != "" && $_POST['deviceId'] != null)
{
	scanPOST();
}

if (isset($_GET["action"]))
{
	 switch ($_GET["action"])
	 {
	 	 case("scanFilesFromUsb") :
	 	 	scanFilesFromUsb($_GET["folderPath"], $_GET["deviceId"], $_GET["isRecursive"], $_GET["makeThumb"]);
	 		 	break;
	 }
}

function scanPOST()
{
	error_log("NEW SCAN");
	$userId = $_POST['userId'];
	$deviceId = $_POST['deviceId'];
	$scannedFiles = $_POST['scannedFiles'];
	
	scanParams($userId, $deviceId, $scannedFiles);
}

function scanFilesFromUsb($folderPath, $deviceId, $isRecursive, $thumbNeeded)
{
	$files = [];
	$isRecursive = ($isRecursive == "true") ? true : false;
	$thumbNeeded = ($thumbNeeded == "true") ? true : false;
	$allFiles = getFilesFromPath($folderPath, $files, $isRecursive);

	$scannedFiles = [];
	$userId = 11;
	$userRights = 2;
	
	foreach ($allFiles as $key => $value)
	{
		$scannedFolder = $key;
		if(is_array($value) && count($value) > 0)
		{
			foreach ($value as $key2 => $value2)
			{
				$fileType = strtolower(substr($value2, strrpos($value2, "."), strlen($value2)));
	
				if ($fileType == ".gif" || $fileType == ".jpg" || $fileType == ".jpeg" || $fileType == ".png")
				{
					$exif = read_exif_data ($key.$value2,1,true);
					
					$ImgBounds = getimagesize($key.$value2);
					
					$orientation = $exif["IFD0"]['Orientation'];
					$width = $ImgBounds[0];
					$height = $ImgBounds[1] ;
	
					$deg = intval($exif['GPS']['GPSLatitude'][0]) ;
					$min = floatval($exif['GPS']['GPSLatitude'][1]) ;
					////////////////////
					/////FLOATVAL NE FONCTIONNE PAS POUR /1000
					////////////////////
					$sec = $exif['GPS']['GPSLatitude'][2] ;
					$min = $min/60 ;
					$sec = $sec/3600000 ;
					$lat = $deg+($min+$sec) ;
					////error_log("LAT :: ".doubleval($lat));
					
					$deg = intval($exif['GPS']['GPSLongitude'][0]) ;
					$min = floatval($exif['GPS']['GPSLongitude'][1]) ;
					////////////////////
					/////FLOATVAL NE FONCTIONNE PAS POUR /1000
					////////////////////
					$sec = $exif['GPS']['GPSLongitude'][2] ;
					$min = $min/60 ;
					$sec = $sec/3600000 ;
					$long = $deg+($min+$sec) ;
				
					array_push($scannedFiles, [
					"filename" => $value2,
					"url" => substr($key.$value2, 9), 
					"fileType" => $fileType, 
					"dateTaken" => $exif["EXIF"]["DateTimeOriginal"], 
					"latitude" =>  $lat, 
					"longitude" => $long,
					"size" => $exif["FILE"]['FileSize'],
					"width" => ($orientation == 6 || $orientation == 8) ? $width : $height,
					"height" => ($orientation == 6 || $orientation == 8) ? $height : $width,
					"cameraManufacturer" => trim($exif["IFD0"]["Make"]),
					"cameraModel" => trim($exif["IFD0"]["Model"]),
					"ownerId" => 11,
					"rightId" => 2,
					"md5" => getMD5($key.$value2)]);
				}
			}
		}	
	}
	$scannedFolder = [];
	$scannedFolder['folderUrl'] = substr($folderPath,9);
	$scannedFolder['folderName'] = split("/", trim($folderPath, "/"))[count(split("/", trim($folderPath, "/")))-1];

	scanParams($deviceId, $userId, $userRights, $scannedFolder, $scannedFiles, $thumbNeeded, substr($folderPath, 0, 9));
	print("OK");
}

function scanFile($filePath, $deviceId, $thumbNeeded)
{
	$thumbNeeded = ($thumbNeeded == "true") ? true : false;
	
	$scannedFiles = [];
	$userId = 11;
	$userRights = 2;
	
	
	$fileType = strtolower(substr($filePath, strrpos($filePath, "."), strlen($filePath)));

	if ($fileType == ".gif" || $fileType == ".jpg" || $fileType == ".jpeg" || $fileType == ".png")
	{
		$exif = read_exif_data ($filePath,1,true);
		
		$ImgBounds = getimagesize($filePath);
		
		$orientation = $exif["IFD0"]['Orientation'];
		$width = $ImgBounds[0];
		$height = $ImgBounds[1] ;

		$deg = intval($exif['GPS']['GPSLatitude'][0]) ;
		$min = floatval($exif['GPS']['GPSLatitude'][1]) ;
		////////////////////
		/////FLOATVAL NE FONCTIONNE PAS POUR /1000
		////////////////////
		$sec = $exif['GPS']['GPSLatitude'][2] ;
		$min = $min/60 ;
		$sec = $sec/3600000 ;
		$lat = $deg+($min+$sec) ;
		////error_log("LAT :: ".doubleval($lat));
		
		$deg = intval($exif['GPS']['GPSLongitude'][0]) ;
		$min = floatval($exif['GPS']['GPSLongitude'][1]) ;
		////////////////////
		/////FLOATVAL NE FONCTIONNE PAS POUR /1000
		////////////////////
		$sec = $exif['GPS']['GPSLongitude'][2] ;
		$min = $min/60 ;
		$sec = $sec/3600000 ;
		$long = $deg+($min+$sec) ;
	
		array_push($scannedFiles, [
		"filename" => array_pop(explode("/", $filePath)),
		"folderUrl" => $filePath,
		"url" => substr($filePath, 9), 
		"fileType" => $fileType, 
		"dateTaken" => $exif["EXIF"]["DateTimeOriginal"],
		"dateCreated" => $exif["EXIF"]["DateTime"],
		"latitude" =>  $lat, 
		"longitude" => $long,
		"size" => $exif["FILE"]['FileSize'],
		"width" => ($orientation == 6 || $orientation == 8) ? $width : $height,
		"height" => ($orientation == 6 || $orientation == 8) ? $height : $width,
		"cameraManufacturer" => trim($exif["IFD0"]["Make"]),
		"cameraModel" => trim($exif["IFD0"]["Model"]),
		"ownerId" => 11,
		"rightId" => 2,
		"md5" => getMD5($filePath)]);
	}

	scanParams($deviceId, $userId, $scannedFiles);
	print("OK");
}
/*
function scanParams($userId, $deviceId, $scannedFiles)
{
    //CONNECT DB
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	if (mysqli_connect_errno()) {
	    ////error_log("Échec de la connexion");
	    exit();
	}
	
	for($i = 0; $i < count($scannedFiles); $i++)
	{
		$fileJson = json_decode($scannedFiles[$i], true);
		
		$folderSlashes = addslashes($fileJson['folderUrl']);
	
		$queryString = "INSERT INTO s_folders (name, ownerId, rightsId, storageType, url, deviceId) 
		VALUES ('".$fileJson['folderName']."',".$userId.",".$fileJson['rightId'].", 1, \"".$folderSlashes."\",".$deviceId.")";
		//error_log("CREATE FOLDER :: ".$queryString);
		$result = mysqli_query($link, $queryString);
		
		if($result)
		{
			$folderId = mysqli_insert_id($link);
			//error_log("FOLDER THUMB MOVED :: ".move_uploaded_file($_FILES['folderThumb']['tmp_name'], $folderThumb));
		}
		else {
			$queryString = "SELECT id FROM s_folders WHERE url=\"".$folderSlashes."\" AND deviceId =".$deviceId;
			//error_log("REQUEST FOLDER :: ".$queryString);
			$result = mysqli_query($link, $queryString);
			$row = mysqli_fetch_row($result);
			$folderId = $row[0] ;
			//error_log("FOLDER ID :: ".$folderId." :: ".$queryString);
			mysqli_free_result($result);
		}
			
		$fileSlashes = addslashes($fileJson["url"]);
	
		$fileDateTaken = (substr($fileJson['dateTaken'], 0, 4) > 1900) ? $fileJson['dateTaken'] : $fileJson['dateCreated'] ;
		
		$queryString = "INSERT INTO s_files (filename, fileType, dateTaken, dateCreated, dateModified, latitude, longitude, size, width, height, cameraMake, cameraModel, deviceId, url, storageType, MD5, duration)	
		VALUES (\"".$fileJson['filename']."\",(SELECT id FROM d_file_types WHERE keywords LIKE '%".strtolower($fileJson['fileType'])."%'),'".$fileDateTaken."','".$fileJson['dateCreated']."','".$fileJson['dateModified']."',".floatval($fileJson['latitude']).",".floatval($fileJson['longitude']).",".$fileJson['size'].",".$fileJson['width'].",".$fileJson['height'].",\"".$fileJson['cameraManufacturer']."\",\"".$fileJson['cameraModel']."\",".$deviceId.",\"".$fileSlashes."\",1,\"".$fileJson['md5']."\",".$fileJson['duration']." )";
		//error_log($queryString);
		$result = mysqli_query($link, $queryString);
		////error_log("RESULT :: ".$result);
		$tempId = mysqli_insert_id($link) ;
		//error_log("RESULT :: ".$tempId);
		
		if(!$result)
		{
			$queryString = "SELECT id FROM s_files WHERE filename = \"".$fileJson['filename']."\" AND dateTaken = '".$fileDateTaken."' AND size = ".$fileJson['size']." AND deviceId = ".$deviceId." AND url = \"".$fileSlashes."\"";
			//error_log($queryString);
			$result = mysqli_query($link, $queryString);
			////error_log("RESULT :: ".$result);
			$tempId = mysqli_fetch_row($result)[0] ;
		}
		
		if($result)
		{
			$date = date("Y-m-d H:i:s");
			$queryString = "INSERT INTO a_date_file (addDate, fileId, updateDate) VALUES ('".$date."', ".$tempId.",'".$date."')";
			//error_log($queryString);
			$result = mysqli_query($link, $queryString);
			
			$queryString = "INSERT INTO a_owner_right_file (ownerId, rightId, fileId) VALUES (".$fileJson['ownerId'].", ".$fileJson['rightId'].",".$tempId.")";
			//error_log($queryString);
			$result = mysqli_query($link, $queryString);
			
			$queryString = "INSERT INTO a_folder_file (folderId, fileId) VALUES (".$folderId.", ".$tempId.")";
			//error_log($queryString);
			$result = mysqli_query($link, $queryString);
			
			$zip = null;
			$city = null;
			$country = null;
			$cityLat = null;
			$cityLong = null;
			//GET Address from GPS
			//error_log("LATITUDE :: ".floatval($fileJson['latitude']));
			//error_log("LATITUDE :: ".floatval($fileJson['longitude']));
			if((floatval($fileJson['latitude']) > 0 || floatval($fileJson['longitude']) > 0))
			{
				$address = getAddressFromCoordinate(floatval($fileJson['latitude']), floatval($fileJson['longitude']));
				$zip = $address[0];
				$city = $address[1];
				$country = $address[2];
				$cityLat = $address[3];
				$cityLong = $address[4];
				//error_log("FULL ADDRESS :: ".$addressFull['results'][0]['formatted_address']);
			}
			
			error_log("ZIP :: ".$zip." :: CITY :: ".$city." :: COUNTRY ::".$country." :: ".$cityLat.":".$cityLong);
			
			if($zip)
			{
				$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;

				//error_log($queryString);
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
				
				$queryString = "SELECT * FROM a_file_location WHERE fileId = ".$tempId;
				//error_log($queryString);
				$result = mysqli_query($link, $queryString);
				if($row = mysqli_fetch_row($result))
				{
					$queryString = " UPDATE a_file_location SET locationId=".$locationId." WHERE fileId=".$tempId;
				}
				else {
					$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", ".$locationId.")";
				}
		
				//error_log($queryString);
				$result = mysqli_query($link, $queryString);
			}
			else if(($city && $country)) 
			{
				$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;

				//error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				if($row = mysqli_fetch_row($result))
				{
					$locationId = $row[0];
				}
				else {
		
					$queryString = "INSERT INTO s_locations (city, country, latitude, longitude) 
									VALUES (\"".$city."\", \"".$country."\", ".$cityLat.", ".$cityLong.")";
		
					//error_log($queryString);
					$result = mysqli_query($link, $queryString);
					$locationId = mysqli_insert_id($link) ;
				}
				
				$queryString = "SELECT * FROM a_file_location WHERE fileId = ".$tempId;
				//error_log($queryString);
				$result = mysqli_query($link, $queryString);
				if($row = mysqli_fetch_row($result))
				{
					$queryString = " UPDATE a_file_location SET locationId=".$locationId." WHERE fileId=".$tempId;
				}
				else {
					$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", ".$locationId.")";
				}
		
				//error_log($queryString);
				$result = mysqli_query($link, $queryString);
			}
	
			$subFolder = floor($tempId / 1000) ;
			$imageThumb = "/var/www/ressources/thumbs/".$subFolder."/". $tempId.".jpg";
			$isImgMoved = move_uploaded_file($_FILES['imageThumbs']['tmp_name'][$i], $imageThumb);
			error_log("THUMB URL :: ".$imageThumb);
			error_log("THUMB MOVED :: ".$isImgMoved);
			//$isImgMoved = true;
			
			if(!$isImgMoved && $thumbNeeded)
			{
				$key = ftok("/var/www/scanDevice.php", "b");
				$sem_identifier = sem_get($key);
				sem_acquire($sem_identifier);
				
				$fileSlashes = $usbMount.$fileSlashes;
				$ImageNews = $fileSlashes;
	 
	 			$exif = read_exif_data ($fileSlashes,1,true);
	 
				$ExtensionPresumee = explode('.', $ImageNews);
				$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
				if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg')
				{
				  	error_log("CREATION DU THUMB :: ".$fileSlashes) ;
				  	$ImageNews = getimagesize($fileSlashes);
				  	
					$ImageChoisie = imagecreatefromjpeg($fileSlashes);
					$TailleImageChoisie = getimagesize($fileSlashes);
					
					$orientation = $exif["IFD0"]['Orientation'];
					
					$hauteur = $TailleImageChoisie[1] ;
					$largeur = $TailleImageChoisie[0];
					
					$NouvelleLargeur = 300; //Largeur choisie à 350 px mais modifiable
		  			$NouvelleHauteur = ( ($hauteur * (($NouvelleLargeur)/$largeur)) );
		  			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
	
					try
			  		{
			  			imagecopyresized($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $largeur,$hauteur);
					}
					catch(exception $e)
					{
						//error_log("ARRET DANS EXCEPTION");
					}
	
					switch($orientation) {
				        case 3:
				            $NouvelleImage = imagerotate($NouvelleImage, 180, 0);
				            break;
				        case 6:
				            $NouvelleImage = imagerotate($NouvelleImage, -90, 0);
				            break;
				        case 8:
				            $NouvelleImage = imagerotate($NouvelleImage, 90, 0);
				            break;
				    }
					
			  		imagedestroy($ImageChoisie);
				                                    
					imagejpeg($NouvelleImage , $imageThumb, 100);
					imagedestroy($NouvelleImage);
				}

				sem_release($sem_identifier);
				//print("OK");
			}
			else {
				//print("OK");
			}
		}
		else {
			//FILE already exists
			
		}	
		
	}
	mysqli_close($link);
	print("OK");
}
 * */
?>
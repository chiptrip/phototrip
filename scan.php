<?php

include_once("tools.php");

function scanParams($userId, $deviceId, $scannedFiles)
{
    //CONNECT DB
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
	    ////error_log("Échec de la connexion");
	    exit();
	}
	
	for($i = 0; $i < count($scannedFiles); $i++)
	{
		$fileJson = json_decode($scannedFiles[$i], true);
		
		////
		//TEMP MODIFICATION TO BE CHECKED !!!!!!!!!!
		////
		//$folderSlashes = addslashes($fileJson['folderUrl']);
		$folderSlashes = getFoldersFromPath(addslashes($fileJson["url"]));
	
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
			error_log("LATITUDE :: ".floatval($fileJson['latitude']));
			error_log("LATITUDE :: ".floatval($fileJson['longitude']));
			if((floatval($fileJson['latitude']) > 0 || floatval($fileJson['longitude']) > 0))
			{
				$address = getAddressFromCoordinate(floatval($fileJson['latitude']), floatval($fileJson['longitude']));
				$zip = $address[0];
				$city = $address[1];
				$country = $address[2];
				$cityLat = $address[3];
				$cityLong = $address[4];
				error_log("FULL ADDRESS :: ".$addressFull['results'][0]['formatted_address']);
			}
			
			error_log("ZIP :: ".$zip." :: CITY :: ".$city." :: COUNTRY ::".$country." :: ".$cityLat.":".$cityLong);
			
			if($zip)
			{
				$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;

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
				
				$queryString = "SELECT * FROM a_file_location WHERE fileId = ".$tempId;
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				if($row = mysqli_fetch_row($result))
				{
					$queryString = " UPDATE a_file_location SET locationId=".$locationId." WHERE fileId=".$tempId;
				}
				else {
					$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", ".$locationId.")";
				}
		
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
			}
			else if(($city && $country)) 
			{
				$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;

				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				if($row = mysqli_fetch_row($result))
				{
					$locationId = $row[0];
				}
				else {
		
					$queryString = "INSERT INTO s_locations (city, country, latitude, longitude) 
									VALUES (\"".$city."\", \"".$country."\", ".$cityLat.", ".$cityLong.")";
		
					error_log($queryString);
					$result = mysqli_query($link, $queryString);
					$locationId = mysqli_insert_id($link) ;
				}
				
				$queryString = "SELECT * FROM a_file_location WHERE fileId = ".$tempId;
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				if($row = mysqli_fetch_row($result))
				{
					$queryString = " UPDATE a_file_location SET locationId=".$locationId." WHERE fileId=".$tempId;
				}
				else {
					$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", ".$locationId.")";
				}
		
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
			}
	
			$subFolder = floor($tempId / 1000) ;
			$imageThumb = "/var/www/html/ressources/thumbs/".$subFolder."/". $tempId.".jpg";
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
					
					$queryString = "INSERT INTO a_file_thumb (fileId, thumb, MD5) VALUES (".$tempId.", 1,\"".$fileJson['md5']."\")";
					
					$result = mysqli_query($link, $queryString);
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

function scanDeviceParams($deviceMac, $userId, $userRights, $scannedFolder, $files, $thumbNeeded, $usbMount)
{
    //CONNECT DB
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
	    ////error_log("Échec de la connexion");
	    exit();
	}
	
	//Check if Device exists
	//$deviceMac = $_POST['deviceId'] ;
	$queryString = "SELECT id FROM s_devices WHERE hardwareId = \"".$deviceMac."\"";
	//error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	if($row)
	{
		$deviceId = $row[0];
		mysqli_free_result($result);
	}
	else {
		mysqli_free_result($result);
		$queryString = "INSERT INTO s_devices (hardwareId) VALUES (\"".$deviceMac."\")";
		//error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$deviceId = mysqli_insert_id($link);
	}
	
	if(!is_array($scannedFolder))
	{
		$folder = json_decode($scannedFolder, true);
	}
	else {
		$folder = $scannedFolder;
	}
	
	$folderSlashes = ($folder['folderUrl'] != "") ? addslashes($folder['folderUrl']) : "";
	
	//$folderThumb = "/var/www/html/ressources/thumbs/" . basename($_FILES['folderThumb']['tmp_name']).".jpg";
	//error_log("FOLDER THUMB NAME :: ".$folderThumb);
	$queryString = "INSERT INTO s_folders (name, ownerId, rightsId, storageType, url, deviceId) 
	VALUES ('".$folder['folderName']."',".$userId.",".$userRights.", 1, \"".$folderSlashes."\",".$deviceId.")";
	//error_log("CREATE FOLDER :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	//$row = mysqli_fetch_row($result);
	
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
	
	
	//$files = json_decode($_POST["scanedFiles"], true);
	for($i = 0; $i < count($files); $i++)
	{
		////error_log("FILES JSON :: ".$files[$i]);
		if(is_array($files[$i]))
		{
			$fileJson = $files[$i];
		}
		else {
			$fileJson = json_decode($files[$i], true);
		}
		
		$fileSlashes = addslashes($fileJson["url"]);
	
		$fileDateTaken = (substr($fileJson['dateTaken'], 0, 4) > 1900) ? $fileJson['dateTaken'] : $fileJson['dateCreated'] ;
		error_log("TEST :: ".(substr($fileJson['dateTaken'], 0, 4) > 1900));
		$queryString = "INSERT INTO s_files (filename, fileType, dateTaken, dateCreated, dateModified, latitude, longitude, size, width, height, cameraMake, cameraModel, deviceId, url, storageType, MD5, duration)	
		VALUES (\"".$fileJson['filename']."\",(SELECT id FROM d_file_types WHERE keywords LIKE '%".strtolower($fileJson['fileType'])."%'),'".$fileDateTaken."','".$fileJson['dateCreated']."','".$fileJson['dateModified']."',".floatval($fileJson['latitude']).",".floatval($fileJson['longitude']).",".$fileJson['size'].",".$fileJson['width'].",".$fileJson['height'].",\"".$fileJson['cameraManufacturer']."\",\"".$fileJson['cameraModel']."\",".$deviceId.",\"".$fileSlashes."\",1,\"".$fileJson['md5']."\",".$fileJson['duration']." )";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		////error_log("RESULT :: ".$result);
		$tempId = mysqli_insert_id($link) ;
		//error_log("RESULT :: ".$tempId);
		
		if($result)
		{
			
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
			/*
			if(($fileJson['Latitude'] != "0" && $fileJson['Latitude'] != "null" && $fileJson['Latitude'] != "") || ($fileJson['Longitude'] != "" && $fileJson['Longitude'] != "0" && $fileJson['Longitude'] != "null"))
	{
				$address = getAddressFromCoordinate(floatval($fileJson['latitude']), floatval($fileJson['longitude']));
				$zip = $address[0];
				$city = $address[1];
				$country = $address[2];
				$cityLat = $address[3];
				$cityLong = $address[4];
				////error_log("FULL ADDRESS :: ".$addressFull['results'][0]['formatted_address']);
			}
			*/
			//error_log("ZIP :: ".$zip." :: CITY :: ".$city." :: COUNTRY ::".$country." :: ".$cityLat.":".$cityLong);
			
			if($zip)
			{
				$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;
			
				//$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", )";
				//error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				if($row = mysqli_fetch_row($result))
				{
					$locationId = $row[0];
				}
				else {
		
					$queryString = "INSERT INTO s_locations (city, country, zipCode, latitude, longitude) 
									VALUES (\"".$city."\", \"".$country."\", \"".$zip."\", ".$cityLat.", ".$cityLong.")";
		
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
			else if(($city && $country)) 
			{
				$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;
			
				//$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", )";
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
	
			//$imageThumb = "/var/www/html/ressources/thumbs/" . $tempId.".jpg";
			//$isImgMoved = move_uploaded_file($_FILES['imageThumbs']['tmp_name'][$i], $imageThumb);
			$isImgMoved = false;
			$subFolder = floor($tempId / 1000) ;
			$imageThumb = "/var/www/html/ressources/thumbs/".$subFolder."/". $tempId.".jpg";  
			error_log("THUMB NEEDED :: ".$thumbNeeded) ;
		  	error_log("USB MOUNT :: ".$usbMount) ;
		  	error_log("PATH :: ".$fileSlashes) ;
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
						//file_put_contents('/var/www/isThumbMeRunning.txt', "");
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
					
					$queryString = "INSERT INTO a_file_thumb (fileId, thumb, MD5) VALUES (".$tempId.", 1,\"".$fileJson['md5']."\")";
					
					$result = mysqli_query($link, $queryString);
				}

				sem_release($sem_identifier);
				//print("OK");
			}
			else {
				//print("OK");
			}
		}
		else {
			//print("KO");
		}	
	}
	mysqli_close($link);
	//print("OK");
}

function scanFileParams($deviceMac, $userId, $userRights, $files, $thumbNeeded, $usbMount)
{
    //CONNECT DB
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
	    ////error_log("Échec de la connexion");
	    exit();
	}
	
	//Check if Device exists
	//$deviceMac = $_POST['deviceId'] ;
	$queryString = "SELECT id FROM s_devices WHERE hardwareId = \"".$deviceMac."\"";
	//error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	if($row)
	{
		$deviceId = $row[0];
		mysqli_free_result($result);
	}
	else {
		mysqli_free_result($result);
		$queryString = "INSERT INTO s_devices (hardwareId) VALUES (\"".$deviceMac."\")";
		//error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$deviceId = mysqli_insert_id($link);
	}
	
	//$files = json_decode($_POST["scanedFiles"], true);
	for($i = 0; $i < count($files); $i++)
	{
		////error_log("FILES JSON :: ".$files[$i]);
		if(is_array($files[$i]))
		{
			$fileJson = $files[$i];
		}
		else {
			$fileJson = json_decode($files[$i], true);
		}
		
		$fileSlashes = addslashes($fileJson["url"]);
	
		$fileDateTaken = (substr($fileJson['dateTaken'], 0, 4) > 1900) ? $fileJson['dateTaken'] : $fileJson['dateCreated'] ;
		//error_log("TEST :: ".(substr($fileJson['dateTaken'], 0, 4) > 1900));
		
		//if(isFileExists($fileJson['filename'], $deviceId, $fileJson['size'], $fileJson['width'], $fileJson['height']))
		//{
			//$queryString = "UPDATE s_files SET url=\"".$fileSlashes."\" WHERE filename=\"".$fileJson['filename']."\" AND size=".$fileJson['size']." AND width=".$fileJson['width']." AND height=".$fileJson['height'];
		
		//}
		//else {
			$queryString = "INSERT INTO s_files (filename, fileType, dateTaken, dateCreated, dateModified, latitude, longitude, size, width, height, cameraMake, cameraModel, deviceId, url, storageType, MD5, duration)	
			VALUES (\"".$fileJson['filename']."\",(SELECT id FROM d_file_types WHERE keywords LIKE '%".strtolower($fileJson['fileType'])."%'),'".$fileDateTaken."','".$fileJson['dateCreated']."','".$fileJson['dateModified']."',".floatval($fileJson['latitude']).",".floatval($fileJson['longitude']).",".$fileJson['size'].",".$fileJson['width'].",".$fileJson['height'].",\"".$fileJson['cameraManufacturer']."\",\"".$fileJson['cameraModel']."\",".$deviceId.",\"".$fileSlashes."\",1,\"".$fileJson['md5']."\",".$fileJson['duration']." )";
		
		//}
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		////error_log("RESULT :: ".$result);
		$tempId = mysqli_insert_id($link) ;
		//error_log("RESULT :: ".$tempId);
		
		if($result)
		{
			
			$queryString = "INSERT INTO a_owner_right_file (ownerId, rightId, fileId) VALUES (".$fileJson['ownerId'].", ".$fileJson['rightId'].",".$tempId.")";
			//error_log($queryString);
			$result = mysqli_query($link, $queryString);
			
			$queryString = "INSERT INTO a_folder_file (folderId, fileId) VALUES (0, ".$tempId.")";
			//error_log($queryString);
			$result = mysqli_query($link, $queryString);
			
			$zip = null;
			$city = null;
			$country = null;
			$cityLat = null;
			$cityLong = null;
			//GET Address from GPS
			
			if(($fileJson['latitude'] != "0" && $fileJson['latitude'] != "null" && $fileJson['latitude'] != "") || ($fileJson['longitude'] != "" && $fileJson['longitude'] != "0" && $fileJson['longitude'] != "null"))
	{
				$address = getAddressFromCoordinate(floatval($fileJson['latitude']), floatval($fileJson['longitude']));
				$zip = $address[0];
				$city = $address[1];
				$country = $address[2];
				$cityLat = $address[3];
				$cityLong = $address[4];
				////error_log("FULL ADDRESS :: ".$addressFull['results'][0]['formatted_address']);
			}
			
			error_log("ZIP :: ".$zip." :: CITY :: ".$city." :: COUNTRY ::".$country." :: ".$cityLat.":".$cityLong);
			
			if($zip)
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
			else if(($city && $country)) 
			{
				$queryString = "SELECT * FROM s_locations WHERE latitude=".$cityLat." AND longitude=".$cityLong;
			
				//$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", )";
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
	
			//$imageThumb = "/var/www/html/ressources/thumbs/" . $tempId.".jpg";
			//$isImgMoved = move_uploaded_file($_FILES['imageThumbs']['tmp_name'][$i], $imageThumb);
			$isImgMoved = false;
			$subFolder = floor($tempId / 1000) ;
			$imageThumb = "/var/www/html/ressources/thumbs/".$subFolder."/". $tempId.".jpg";  
			//error_log("THUMB NEEDED :: ".$thumbNeeded) ;
		  	//error_log("USB MOUNT :: ".$usbMount) ;
		  	//error_log("PATH :: ".$fileSlashes) ;
			if(!$isImgMoved && $thumbNeeded)
			{
				$key = ftok("/var/www/html/scanDevice.php", "b");
				$sem_identifier = sem_get($key);
				sem_acquire($sem_identifier);
				
				$fileSlashes = $usbMount.$fileSlashes;
				$ImageNews = $fileSlashes;
	 
	 			$exif = read_exif_data ($fileSlashes,1,true);
	 
				$ExtensionPresumee = explode('.', $ImageNews);
				$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
				if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg')
				{
				  	
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
						//file_put_contents('/var/www/isThumbMeRunning.txt', "");
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
					
					$queryString = "INSERT INTO a_file_thumb (fileId, thumb, MD5) VALUES (".$tempId.", 1,\"".$fileJson['md5']."\")";
					$result = mysqli_query($link, $queryString);
				}

				sem_release($sem_identifier);
				//print("OK");
			}
			else {
				//print("OK");
			}
		}
		else {
			//print("KO");
		}	
	}
	mysqli_close($link);
	//print("OK");
}

function quickScan($deviceId, $files)
{
	error_log("QUICK SCAN");
	
	
	
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	if (mysqli_connect_errno())
	{
	    exit();
	}
	
	///////////////////////////
	/*
	
	for($i = 0; $i < count($files); $i++)
	{
		$queryStringPart1 = "INSERT INTO s_files (filename, fileType, deviceId, url, storageType, size, dateTaken) VALUES";
		$fileJson = $files[$i];
		$fileSlashes = addslashes($fileJson["url"]);
		$queryStringPart2 = " (\"".$fileJson['filename']."\",(SELECT id FROM d_file_types WHERE keywords LIKE '%".strtolower($fileJson['fileType'])."%'),".$deviceId.",\"".$fileSlashes."\",1, ".$fileJson["size"].", \"".$fileJson['dateTaken']."\")";
		error_log($queryStringPart1.$queryStringPart2);
		//error_log("START");
		$result = mysqli_query($link, $queryStringPart1.$queryStringPart2);
		error_log("result :: ".$result);
	}
	
	error_log("FINI");
	
	*/
	
	$queryStringPart1 = "INSERT INTO s_files (filename, fileType, deviceId, url, storageType, size, dateCreated) VALUES";
	$queryStringPart2 = "";
	$countSend = 0;
	for($i = 0; $i < count($files); $i++)
	{
		if(is_array($files[$i]))
		{
			$fileJson = $files[$i];
		}
		else {
			$fileJson = json_decode($files[$i], true);
		}
		
		$countSend ++;
		//$fileJson = $files[$i];
		$fileSlashes = addslashes($fileJson["url"]);
		$queryStringPart2 = $queryStringPart2 . " (\"".$fileJson['filename']."\",(SELECT id FROM d_file_types WHERE keywords LIKE '%".strtolower($fileJson['fileType'])."%'),".$deviceId.",\"".$fileSlashes."\",1, ".$fileJson["size"].", \"".$fileJson['dateCreated']."\"),";
	
		if($countSend == 1000)
		{
			$queryStringPart2 = substr($queryStringPart2,0,-1);
			//error_log($queryStringPart1.$queryStringPart2);
			error_log("START");
			$result = mysqli_query($link, $queryStringPart1.$queryStringPart2);
			error_log("FINI :: ".$result);
			if($resurlt != 1)
			{
				//error_log($queryStringPart1.$queryStringPart2);
				error_log("ERREUR D'INSERTION");
			}
			$countSend = 0;
			$queryStringPart2 = "";
		}
	}
	if($queryStringPart2 != "")
	{
		$queryStringPart2 = substr($queryStringPart2,0,-1);
		//error_log($queryStringPart1.$queryStringPart2);
		error_log("START");
		$result = mysqli_query($link, $queryStringPart1.$queryStringPart2);
		error_log("FINI :: ".$result);
	}
	else {
		error_log("FINI :: ".$result);
	}
}

function deeperScan($deviceId, $files)
{
	error_log("DEEPER SCAN");
	
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	if (mysqli_connect_errno())
	{
	    exit();
	}
	
	for($i = 0; $i < count($files); $i++)
	{
		if(is_array($files[$i]))
		{
			$fileJson = $files[$i];
		}
		else {
			$fileJson = json_decode($files[$i], true);
		}
		
		$fileSlashes = addslashes($fileJson["url"]);
		
		$queryString = "UPDATE s_files SET ";
		error_log("START");
		$result = mysqli_query($link, $queryStringPart1.$queryStringPart2);
		error_log("FINI :: ".$result);
	}
}
?>

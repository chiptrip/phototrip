
<?php

include("tools.php");
// Dans les versions de PHP antiéreures à 4.1.0, la variable $HTTP_POST_FILES
// doit être utilisée à la place de la variable $_FILES.
error_log("UPLOAD MULTIPLE");
//require_once('./tools.php') ;

error_log("FILES :: ".count($_FILES));
error_log("POST :: ".count($_POST));

foreach ($_REQUEST as $key => $value) {
	error_log("REQUEST :: ".$key." -> ".$value);
}
foreach ($_POST as $key => $value) {
	error_log("POST :: ".$key." -> ".$value);
}
foreach ($_FILES as $key => $value) {
	error_log("FILES :: ".$key." -> ".$value);
}

 if($_FILES['userfiles'] != null)
{
	foreach ($_FILES['userfiles'] as $key => $value) {
	error_log("userfiles :: ".$key." -> ".$value);
		foreach ($_FILES['userfiles'][$key] as $key2 => $value2) {
			error_log("userfiles :: ".$key2." -> ".$value2);
		}
}
	uploadPOST();
}

if (isset($_GET["action"]))
{
	 switch ($_GET["action"])
	 {
	 	 case("uploadFilesFromUsb") :
	 	 	uploadFilesFromUsb();
	 		break;
	 }
}
 
 function uploadPOST()
 {
	 $filesNameArr = [];
	$filesNameArr = $_FILES['userfiles']['name'];
	$filesTempNameArr = [];
	$filesTempNameArr = $_FILES['userfiles']['tmp_name'];
	
	foreach ($filesTempNameArr as $key => $value) {
		error_log("TEMP ARR :: ".$key." -> ".$value);
	}
	
	 $user = $_POST['user'];
	 $rights = $_POST['rights'];
	 $tag = $_POST['tag'];
	 $folder = $_POST["folder"];
	 
	 $deviceId = $_POST["deviceId"];
	 if($deviceId == "" || $deviceId == null)
	 {
	 	$macAdress = getDeviceMacFromIp($_SERVER['REMOTE_ADDR']);
	 	$output = getExistingDevice($macAdress);
		if($output != null)
		{
			$deviceId = $output["deviceId"];
		}
		else {
			$deviceId = addNewDevice($macAdress, "new Device", "16", 0, 0);
		}
	 }
	 
	 $folderPath = $_POST["folderPath"];
	 $filePath = $_POST["filePath"];
	 $mediaType = $_POST['mediaType'];
	 $backupDeviceId = $_POST['backupDeviceId'];
	 $transfertType = $_POST['transfertType'];
	 $storageByType = $_POST['storageByType'];
	 
	 uploadParams($filesNameArr, $filesTempNameArr, $user, $rights, $tag, $folder, $deviceId, $filePath, $mediaType, $backupDeviceId, $transfertType, $storageByType, $folderPath);
 }
 
 function uploadFilesFromUsb()
 {
 	$filesNameArr = [];
	array_push($filesNameArr, $_GET["localPath"]);
	$filesTempNameArr = [];
	array_push($filesTempNameArr, $_GET["localPath"]);
	
	$user = "11";
	 $rights = "2";
	 $tag = "";
	 $folder = "";
	 
	 $deviceId = "0";
	 
	 $filePath = "";
	 $mediaType = "";
	 $backupDeviceId = "";
	 $transfertType = "backup";
	 $storageByType = "";
	 
 	uploadParams($filesNameArr, $filesTempNameArr, $user, $rights, $tag, $folder, $deviceId, $filePath, $mediaType, $backupDeviceId, $transfertType, $storageByType);
 
 }

 function uploadParams($filesNameArr, $filesTempNameArr, $user, $rights, $tag, $folder, $deviceId, $filePath, $mediaType, $backupDeviceId, $transfertType, $storageByType, $folderPath)
 {
 	error_log("FOLDER PATH :: ".$folderPath);
 	if($folderPath != undefined && $folderPath != "")
	{
		$uploaddir = $folderPath;
	}
	else
	{
		$uploaddir = getTransfertPath($transfertType, $backupDeviceId);
	}
	
	error_log("UPLOAD DIR :: ".$uploaddir);
	
	//CONNECT DB
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
		/* Vérification de la connexion */
		if (mysqli_connect_errno()) {
		    //error_log("Échec de la connexion");
		    exit();
		}
	
	$ii = 0 ;
	while ($ii < count($filesNameArr)) {
		error_log("ERROR :: ".$_FILES[0]['name']);
		error_log("ERROR :: ".$_FILES['userfiles']['error'][$ii]);
		error_log("NAME :: ".$_FILES['userfiles']['name'][$ii]);
		error_log("SIZE :: ".$_FILES['userfiles']['size'][$ii]);
		error_log("TYPE :: ".$_FILES['userfiles']['type'][$ii]);
		error_log("TEMP NAME :: ".$_FILES['userfiles']['tmp_name'][$ii]);
		
		//error_log("FILE NAME :: ".$userFiles['tmp_name'][$ii]);
		//$file = $userFiles['tmp_name'][$ii];
		$newName = basename($filesNameArr[$ii]);
		$uploadfile = $uploaddir . basename($filesNameArr[$ii]);
		error_log("BACKUP FILE :: ".$uploadfile);
		$imageType = exif_imagetype($filesTempNameArr[$ii]) ;
		
		$fileExist = false ;
		$existingFileId ;
		$newFileId ;
		
		$nameQuery = "SELECT id, url FROM s_files WHERE deviceId=".getDeviceId($backupDeviceId)." AND filename = \"".$filesNameArr[$ii]."\"" ;
		error_log("IF EXIST QUERY : ".$nameQuery);
		$result = mysqli_query($link, $nameQuery);
		$row = mysqli_fetch_row($result);
		//error_log("GPS QUERY RESULT : ".$row);
		if ($row)
		{
			error_log(" IMAGE deja existante");
			
			
			
			$fileExist = true ;
			$existingFileId = $row[0] ;
			$conflictType = 3 ;
			
			//error_log("MON ET GPS identiques :: Ajout du timestamp") ;
			$date = date_create();
			$newName = substr(basename($filesNameArr[$ii]),0,-4)."_".date_timestamp_get($date).substr(basename($filesNameArr[$ii]),-4);
			$uploadfile = $uploaddir.$newName;
			error_log("UPLOAD FILE :: ".$uploadfile) ;
			$conflictType = 4 ;
			
			
		
			mysqli_free_result($result);
			
		}

		foreach (read_exif_data ($filesTempNameArr[$ii],1,true)['EXIF'] as $key => $value) {
		error_log($key." :: ".$value);
		}
		
		foreach (read_exif_data ($filesTempNameArr[$ii],1,true)['GPS'] as $key => $value) {
		error_log($key." :: ".$value);
		}
		
		
		$newFileGPS = read_exif_data ($filesTempNameArr[$ii],0,true)["GPS"] ;
		
		$deg = intval($newFileGPS['GPSLatitude'][0]) ;
		$min = floatval($newFileGPS['GPSLatitude'][1]) ;
		////////////////////
		/////FLOATVAL NE FONCTIONNE PAS POUR /1000
		////////////////////
		$sec = $newFileGPS['GPSLatitude'][2] ;
		$min = $min/60 ;
		$sec = $sec/3600000 ;
		$lat = $deg+($min+$sec) ;
		error_log("LAT :: ".doubleval($lat));
		
		$deg = intval($newFileGPS['GPSLongitude'][0]) ;
		$min = floatval($newFileGPS['GPSLongitude'][1]) ;
		////////////////////
		/////FLOATVAL NE FONCTIONNE PAS POUR /1000
		////////////////////
		$sec = $newFileGPS['GPSLongitude'][2] ;
		$min = $min/60 ;
		$sec = $sec/3600000 ;
		$long = $deg+($min+$sec) ;
		error_log("LONG :: ".doubleval($long));
		
		$imageInfo["gps"] = ['latitude' => $lat, 'longitude' => $long] ;
		
		/*
		$gpsQuery = "SELECT id, filename FROM s_files WHERE latitude =".doubleval($lat)." AND longitude =".doubleval($long) ;
		//error_log("QUERY GPS : ".$gpsQuery);
		//$newFileDate = read_exif_data ($_FILES['userfile']['tmp_name'], O, true)["EXIF"]["DateTimeOriginal"] ;
		//exit ;
		//$queryString = "SELECT id FROM s_files WHERE filename = \"".$_FILES['userfile']['name']."\" AND gps = \"".$newFileGPS."\" AND dateTaken = \"".$newFileDate."\"";
		////error_log("QUERY : ".$queryString);
		$result = mysqli_query($link, $gpsQuery);
		$row = mysqli_fetch_row($result);
		//error_log_r("GPS QUERY RESULT : ".$row);
		if ($row)
		{
				//error_log(" GPS deja existant");
				$fileExist = true ;
				$existingFileId = $row[0] ;
				$conflictType = 3 ;
				
				if ($row[1] == $_FILES['userfiles']['name'][$ii]) {
					//error_log("MON ET GPS identiques :: Ajout du timestamp") ;
					$date = date_create();
					$newName = substr(basename($_FILES['userfiles']['name'][$ii]),0,-4)."_".date_timestamp_get($date).substr(basename($_FILES['userfiles']['name'][$ii]),-4);
					$uploadfile = $uploaddir.$newName;
					$conflictType = 4 ;
				}
				else { // AJOUTER IF DATE == DATE
					$fileExist = false ;
				}
				
				mysqli_free_result($result);
			}
		*/
		$fileType = strtolower(substr($uploadfile, strrpos($uploadfile, "."), strlen($uploadfile)));
		error_log("FILE TYPE :: ".$fileType);
		if ($fileType == ".gif" || $fileType == ".jpg" || $fileType == ".jpeg" || $fileType == ".png" 
			|| $fileType == ".mov" || $fileType == ".mp4" || $fileType == ".mpeg" || $fileType == ".avi")
		{
			if(!$fileExist)
			{
				$imageInfo["file"] = $filesNameArr[$ii];
			}
			else {
				$imageInfo["file"] = $newName ;
			}
		
			$exif = read_exif_data ($filesTempNameArr[$ii], O, true);
			$file = $filesTempNameArr[$ii];
			error_log("FILE NAME !!!! :: ".$file);
			//error_log("file Size :: ".filesize($_FILES['userfile'][ii][size]));
			error_log("file Size :: ".$_FILES['userfiles']['size'][$ii]);
			$imageInfo["make"] = trim($exif["IFD0"]["Make"]);
			$imageInfo["model"] = trim($exif["IFD0"]["Model"]);
			$imageInfo["date"] = $exif["EXIF"]["DateTimeOriginal"]; 
			$imageInfo["type"] = $fileType ;
			$imageInfo["owner"] = $_POST["user"] ;
			$imageInfo["rights"] = $_POST["rights"] ;
			$imageInfo["width"] = ($exif["IFD0"]['Orientation'] == 6 || $exif["IFD0"]['Orientation'] == 6) ? $exif["EXIF"]['ExifImageWidth'] : $exif["EXIF"]['ExifImageLength'] ;
			$imageInfo["width"] = ($imageInfo["width"] == "") ? 0 : $imageInfo["width"] ;
			$imageInfo["height"] = ($exif["IFD0"]['Orientation'] == 6 || $exif["IFD0"]['Orientation'] == 6) ? $exif["EXIF"]['ExifImageLength'] : $exif["EXIF"]['ExifImageWidth'] ;
			$imageInfo["height"] = ($imageInfo["height"] == "") ? 0 : $imageInfo["height"] ;
			//$imageInfo["size"] = $exif["FILE"]['FileSize'] ;
			$imageInfo["size"] = $_FILES['userfiles']['size'][$ii] ;
			$imageInfo["filePath"] = addslashes($filePath) ;
			$imageInfo["originalDeviceId"] = $deviceId ;
			$imageInfo["md5"] = getMD5($filesTempNameArr[$ii]);
		
		/*
			foreach ($exif as $key => $value) {
				error_log($key." :: ".$value);
			}
		 */
			
			if(!$imageInfo["date"])
			{
				if($exif["FILE"]["FileDateTime"])
				{
					$date = date("Y-m-d H:i:s", $exif["FILE"]["FileDateTime"]);
					$imageInfo["date"] = $date;
				}
				else {
					$date = date("Y-m-d H:i:s");
					$imageInfo["date"] = $date;
				}
			}
		
			//FOLDER
			if($_POST['folder'])
			{
				$folder = json_decode($folder, true);
				$folderSlashes = addslashes($folder['Path']);
				
				//$folderThumb = "/var/www/ressources/thumbs/".$folder['Name'].date_timestamp_get(date_create()).".jpg";
				//error_log("FOLDER THUMB NAME :: ".$folderThumb);
				$queryString = "INSERT INTO s_folders (name, ownerId, rightsId, storageType, url, deviceId) 
				VALUES ('".$folder['Name']."',".$user.",".$rights.", 2, \"".$folderSlashes."\",0)";
				error_log("CREATE FOLDER :: ".$queryString);
				$result = mysqli_query($link, $queryString);
				//$row = mysqli_fetch_row($result);
				if($result)
				{
					$folderId = mysqli_insert_id($link);
				}
				else {
					$queryString = "SELECT id FROM s_folders WHERE url=\"".$folderSlashes."\" AND deviceId=0";
					error_log("REQUEST FOLDER :: ".$queryString);
					$result = mysqli_query($link, $queryString);
					$row = mysqli_fetch_row($result);
					$folderId = $row[0] ;
					error_log("FOLDER ID :: ".$folderId." :: ".$queryString);
					mysqli_free_result($result);
					
					$folderThumb = null;
				}
			}
			
			$folderId = ($folderId == "") ? "-1" : $folderId ;
			
			switch($transfertType)
			{
				case "backup":
					//$deviceId = getBackupDriveId();
					$deviceId = getDeviceId($backupDeviceId);
					$storageType = 3;
					break;
				case "transfert":
					$deviceId = getDeviceId($backupDeviceId);
					$storageType = 2;
					break;
				case "view":
					$deviceId = 0;
					$storageType = 4;
					break;
				default:
					$deviceId = 0;
					$storageType = 3;
					break;
			}
			
			$ms = 0;
			if($mediaType == "video")
			{
				$movieVideoSize = `ffmpeg -i $file 2>&1 | grep Video`;
				error_log("VIDEO SIZE :: ".$movieVideoSize);
				//$movieDuration = trim($movieDuration);
				$movieVideoSize = trim(split(",", trim($movieVideoSize))[2]);
				$movieVideoSize = split(" ",$movieVideoSize)[0];
				$movieWidth = split("x", $movieVideoSize)[0];
				$movieHeight = split("x", $movieVideoSize)[1];
				error_log("MOVIE WIDTH :: ".$movieWidth);
				error_log("MOVIE HEIGHT :: ".$movieHeight);
				$imageInfo["width"] = $movieWidth ;
				$imageInfo["height"] = $movieHeight ;
				
				$movieDuration = `ffmpeg -i $file 2>&1 | grep Duration`;
				//$movieDuration = trim($movieDuration);
				$movieDuration = split(": ", split(",", trim($movieDuration))[0])[1];
				error_log("MOVIE DURATION :: ".$movieDuration);
				sscanf(trim($movieDuration), "%d:%d:%d.%d", $hours, $minutes, $seconds, $milli);
				$ms = $milli * 10 + $seconds * 1000 + $minutes * 60 * 1000 + $hours * 60 * 60 * 1000;
			}
			
			$queryString = "INSERT INTO s_files (filename, fileType, url, size, width, height, dateTaken, latitude, longitude, storageType, deviceId, cameraMake, cameraModel, MD5, duration)
			 VALUES (\"".$imageInfo["file"]."\",(SELECT id FROM d_file_types WHERE keywords LIKE '%".$imageInfo['type']."%'),\"".substr($uploadfile, 9)."\",".$imageInfo["size"].",".$imageInfo["width"].",".$imageInfo["height"].",'".$imageInfo['date']."', ".floatval($imageInfo['gps']['latitude']).", ".floatval($imageInfo['gps']['longitude']).",".$storageType.",".$deviceId.",\"".$imageInfo["make"]."\",\"".$imageInfo["model"]."\",\"".$imageInfo["md5"]."\",".$ms." )";
			error_log("INSERT :: ".$queryString);
			$result = mysqli_query($link, $queryString);
			$tempId = mysqli_insert_id($link) ;
			
			if($tempId == 0)
			{
				return;
			}
			
			$queryString = "INSERT INTO a_owner_right_file (ownerId, rightId, fileId) VALUES (".$imageInfo['owner'].",".$imageInfo['rights'].", ".$tempId.")";
			error_log("INSERT :: ".$queryString);
			$result = mysqli_query($link, $queryString);
			
			$queryString = "INSERT INTO a_folder_file (fileId, folderId) VALUES (".$tempId.",".$folderId.")";
			error_log("INSERT :: ".$queryString);
			$result = mysqli_query($link, $queryString);
			
			
	/*		if($mediaType == "video")
			{	*/
	//			$sed = "sed 's/Duration: \(.*\), start.*/\1/g'";
	//			$sed2 = "sed 's/ //g'";
				//$sed3 = "sed 's/:/ /g'";
	/*			$movieDuration = `ffmpeg -i $file 2>&1 | grep Duration`;
				//$movieDuration = trim($movieDuration);
				$movieDuration = split(": ", split(",", trim($movieDuration))[0])[1];
				error_log("MOVIE DURATION :: ".$movieDuration);
				sscanf(trim($movieDuration), "%d:%d:%d.%d", $hours, $minutes, $seconds, $milli);
				$ms = $milli * 10 + $seconds * 1000 + $minutes * 60 * 1000 + $hours * 60 * 60 * 1000;
				$queryString = "INSERT INTO a_file_extras (fileId, duration) VALUES (".$tempId.",".$ms.")";
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
			}
	*/			
			
			if($imageInfo['group'] != "")
			{
				$queryString = "INSERT INTO a_file_group (fileId, groupId) VALUES (".$tempId.",0)";
				error_log("INSERT :: ".$queryString);
				$result = mysqli_query($link, $queryString);
			}
			
			$zip = null;
			$city = null;
			$country = null;
			
			$lat = floatval($imageInfo['gps']['latitude']);
			$long = floatval($imageInfo['gps']['longitude']);
			
			//GET Address from GPS
			if($lat != "0" || $long != "0")
			{
				$address = getAddressFromCoordinate($lat, $long);
				$zip = $address[0];
				$city = $address[1];
				$country = $address[2];
				$cityLat = $address[3];
				$cityLong = $address[4];
				error_log("FULL ADDRESS :: ".$addressFull['results'][0]['formatted_address']);
			}
			
			error_log("ZIP :: ".$zip." :: CITY :: ".$city." :: COUNTRY ::".$country);
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
		
					error_log($queryString);
					$result = mysqli_query($link, $queryString);
					$locationId = mysqli_insert_id($link) ;
				}
				
				$queryString = "SELECT * FROM a_file_location WHERE fileId = ".$tempId;
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
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
			
				//$queryString = "INSERT INTO a_file_location (fileId, locationId) VALUES (".$tempId.", )";
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
			
			/*
			$queryString = "INSERT INTO a_file_device (fileId, deviceId) VALUES (".$tempId.",0)";
			error_log("INSERT :: ".$queryString);
			$result = mysqli_query($link, $queryString);
			 */
			
			$queryString = "SELECT id FROM s_files WHERE url = \"".$imageInfo["filePath"]."\" AND deviceId = ".$imageInfo["originalDeviceId"];
	//		$queryString = "SELECT id FROM s_files WHERE deviceId = ".$imageInfo["originalDeviceId"];
			error_log("IS ALREADY SCANNED :: ".$queryString);
			$result = mysqli_query($link, $queryString);
			
			if($row = mysqli_fetch_row($result))
			{
				$queryString = "INSERT INTO s_backuped_files (scanId, backupId, fileOriginDeviceId, fileOriginUrl) 
				VALUES (".$row[0].",".$tempId.",".$imageInfo["originalDeviceId"].",\"".$imageInfo['filePath']."\")";
				error_log("INSERT :: ".$queryString);
				$result = mysqli_query($link, $queryString);
			}
			else {
				$queryString = "INSERT INTO s_backuped_files (scanId, backupId, fileOriginDeviceId, fileOriginUrl) 
				VALUES (-1,".$tempId.",".$imageInfo['originalDeviceId'].",\"".$imageInfo['filePath']."\")";
				error_log("INSERT :: ".$queryString);
				$result = mysqli_query($link, $queryString);
			}
			
			if($tag)
			{
				error_log("TAGS :: ".$tag);
				$tags = explode(",", $tag);
				foreach ($tags as $tag)
				{
					error_log("TAG :: ".$tag);
					$queryString = "SELECT * FROM s_tags WHERE name=\"".$tag."\"" ;
					$result = mysqli_query($link, $queryString);
					
					//error_log_r("GPS QUERY RESULT : ".$row);
					if($row = mysqli_fetch_row($result))
					{
						$tagId = $row[0] ;
						mysqli_free_result($result);
					}
					else {
						error_log("NOUVEAU TAG :: ".$tag) ;
						mysqli_free_result($result);
					
						$queryString = "INSERT INTO s_tags (name) VALUES (\"".$tag."\")";
						$result = mysqli_query($link, $queryString);
						
						$tagId = mysqli_insert_id($link) ;
					}
		
					if(!$tagId)
					{
						$queryString = "INSERT INTO s_tags (name) VALUES (\"".$tag."\")";
						$result = mysqli_query($link, $queryString);
						$tagId = mysqli_insert_id($link) ;
					}
					
					$queryString = "INSERT INTO a_tag_file (fileid, tagid) VALUES (".$tempId.", ".$tagId.")";
					error_log("TAG BDD :: ".$queryString);
					$result = mysqli_query($link, $queryString);
				}
			}
			error_log("COPY FILE :: NOW");
			$copyFile = (isset($_GET["action"])) ? backupImage($filesTempNameArr[$ii]) : move_uploaded_file($filesTempNameArr[$ii], $uploadfile) ;
			if ($copyFile) {
			    error_log("UPLOAD OK :: ".$filesTempNameArr[$ii]) ;
				switch ($storageByType) {
					case '1':
						$folderName = split("-", $imageInfo["date"])[0];
						$folderName = split(":", $folderName)[0];
						break;
					case '2':
						
						break;
					case '3':
						
						break;
					case '4':
						
						break;
					case '5':
						
						break;
					case '6':
						
						break;
					case '7':
						
						break;
					case '8':
						
						break;
					case '9':
						$folderName = "";
						break;
					default:
						
						break;
				}
				$uploadFileNew = $uploaddir.$folderName."/".$newName;
				$newFolder = $uploaddir.$folderName."/";
				error_log("MK DIR");
				$command1 = `sudo mkdir $newFolder`;
				error_log("MV FILE");
				$command2 = `sudo mv $uploadfile $uploadFileNew`;
				
				$ImageNews = $uploadfile;
		 
				$ExtensionPresumee = explode('.', $ImageNews);
				$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
				
				/*
				if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg')
				{
				  	error_log("CREATION DU THUMB :: ".$uploadfile) ;
				  	$ImageNews = getimagesize($uploadfile);
				  	
					$ImageChoisie = imagecreatefromjpeg($uploadfile);
					$TailleImageChoisie = getimagesize($uploadfile);
					
					$orientation = $exif["IFD0"]['Orientation'];
					
					$hauteur = $TailleImageChoisie[1] ;
					$largeur = $TailleImageChoisie[0];
					
					$NouvelleLargeur = 200; //Largeur choisie à 350 px mais modifiable
		  			$NouvelleHauteur = ( ($hauteur * (($NouvelleLargeur)/$largeur)) );
		  			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
	
					try
			  		{
			  			imagecopyresized($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $largeur,$hauteur);
					}
					catch(exception $e)
					{
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
				    
					$subFolder = floor($tempId / 1000) ;
					$imageThumb = "/var/www/ressources/thumbs/".$subFolder."/". $tempId.".jpg";                 
					imagejpeg($NouvelleImage , $imageThumb, 100);
					if($folderThumb)
					{
						imagejpeg($NouvelleImage , $folderThumb, 100);
					}
					
				}
				else if($ExtensionPresumee == 'mov' || $ExtensionPresumee == 'mp4' || $ExtensionPresumee == 'avi' || $ExtensionPresumee == 'mpeg')
				{
					$escapedSource = str_replace("(", "\(",$uploadfile);
					$escapedSource = str_replace(")", "\)",$uploadfile);
					$escapedSource = str_replace("_", "\_",$uploadfile);
					$escapedSource = str_replace(" ", "\ ",$uploadfile);
					
					$subFolder = floor($tempId / 1000) ;
					$imageThumb = "/var/www/ressources/thumbs/".$subFolder."/". $tempId.".jpg"; 
					$movieThumb = `ffmpeg -i $escapedSource -vframes 1 $imageThumb`;
				}
					*/		
			} else {
			    	error_log("Upload NOT OK");
			    //echo '<a href="./upload.html">Reessayer</a>';
			}
		}
		
		/*else if ($fileType == ".mov" || $fileType == ".mp4" || $fileType == ".mpeg" || $fileType == ".avi")
		{
			
		}*/
	
		$ii++ ;
	}
	
	mysqli_close($link);
	//`php /var/www/thumbMe.php&`;
	//passthru("php /var/www/thumbMe.php > /var/www/log_file.log 2>&1 &");
	/*
	echo '<form enctype="multipart/form-data" action="./index.php" method="post">
	  <select name="user">
	    <option selected="selected" value="1">Nicolas</option>
	    <option value="2">Anne-Juliet</option>
	    <option value="0">All users</option>
	  </select>
	  <input type="submit" value="Voir mes photos" />';
	
	*/
}
header("Location: upload.html");
?>


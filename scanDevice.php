<?php

//CALLED FROM BOX TO SCAN USB AND REMOTE DEVICES

include_once("scan.php");
include_once("tools.php");
error_log("SCANDEVICE.PHP".count($_GET));
/*
foreach ($_POST as $key => $value) {
	error_log($key." :: ".$value);
}
foreach ($_FILES['imageThumbs'] as $key => $value) {
	error_log($key." :: ".$value);
}
*/
if($_POST['deviceId'] != "" && $_POST['deviceId'] != null)
{
	scanDevicePOST();
}

if (isset($_GET["action"]))
{
	 switch ($_GET["action"])
	 {
	 	 case("scanFolderFromUsb") :
	 	 	scanDeviceFromUsb($_GET["folderPath"],$_GET["folderName"], $_GET["deviceId"], $_GET["isRecursive"], $_GET["makeThumb"]);
	 		 	break;
		case("scanNewFilesFromUsb") :
	 	 	scanNewFilesFromUsb($_GET["deviceId"], $_GET["makeThumb"], $_GET["makeMD5"]);
	 		 	break;
		case("quickScanFromUsb") :
	 	 	quickScanFromUsb($_GET["deviceHwId"]);
	 		 	break;
		case("scanDeeperFromUsb") :
	 	 	scanDeeperFromUsb($_GET["deviceHwId"]);
	 		 	break;
		case("makeThumbsBackground") :
	 	 	makeThumbsBackground($_GET["deviceHwId"]);
	 		 	break;
	 }
}

function scanDevicePOST()
{
	error_log("NEW SCAN POST");
	$deviceMac = $_POST['deviceId'] ;
	$userId = $_POST['userId'];
	$userRights = $_POST['rights'];
	$scannedFolder = $_POST["scanedFolder"];
	$scannedFiles = $_POST["scannedFiles"];
	$files = $_POST['files'];
	$scanType = $_POST['scanType'];
	
	switch ($scanType) {
		case 'quickScan':
			$link = mysqli_connect("localhost", "root", "sunny", "sunny");
			if (mysqli_connect_errno()) {
			    exit();
			}
			
			error_log("STEP 3");
			$queryString = "SELECT id FROM s_devices WHERE hardwareId = \"".getDeviceMacFromIp($_SERVER['REMOTE_ADDR'])."\"";
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
				$queryString = "INSERT INTO s_devices (hardwareId) VALUES (\"".getDeviceMacFromIp($_SERVER['REMOTE_ADDR'])."\")";
				//error_log($queryString);
				$result = mysqli_query($link, $queryString);
				$deviceId = mysqli_insert_id($link);
			}
			
			quickScan($deviceId, $scannedFiles);
			break;
		
		default:
			scanParams($deviceMac, $userId, $userRights, $scannedFolder, $files, false);
			break;
	}
	
}

function scanDeviceFromUsb($folderPath, $folderName, $deviceId, $isRecursive, $thumbNeeded)
{
	error_log("SCAN DEVICE FROM USB :: ".$folderPath." :: ".$folderName." :: ".$deviceId." :: ".$isRecursive." :: ".$thumbNeeded);
	//$isRecursive = ($isRecursive == "true") ? true : false;
	$thumbNeeded = ($thumbNeeded == "true") ? true : false;
	$foldersToScan = [];
	$foldersToScan = getFoldersFromPath($folderPath, $folderName, $foldersToScan, $isRecursive);
	
	$mountPoint = getMountPointFromDeviceId($deviceId);
	
	$foldersLight = [];
	foreach ($foldersToScan as $folder)
	{
		error_log("ITEM :: ".$folder["name"]);
		if($folder["imagesCount"] != 0 || $folder["videosCount"] != 0)
		{
			array_push($foldersLight, $folder);
		}
	}
	
	foreach ($foldersLight as $folderLight)
	{
		error_log("FOLDER TO SCAN :: ".$folderLight['name']." :: ".$folderLight['url']);
		$files = [];
		$allFiles = getFilesFromPath($folderLight['url'], $files, false);
	
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
					//$fileUrl = str_replace(" ", "\ ",$key.$value2);
					$fileUrl = $key.$value2;
		
					if ($fileType == ".gif" || $fileType == ".jpg" || $fileType == ".jpeg" || $fileType == ".png")
					{
						$exif = read_exif_data($fileUrl,1,true);
						$ImgBounds = getimagesize($fileUrl);
						$orientation = $exif["IFD0"]['Orientation'];
						$width = ($ImgBounds[0] != null) ? $ImgBounds[0] : 0 ;
						$height = ($ImgBounds[1] != null) ? $ImgBounds[1] : 0 ;
		
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
						"url" => str_replace($mountPoint, "", $fileUrl), 
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
						"duration" => 0,
						"md5" => getMD5($fileUrl)]);
					}
					else if ($fileType == ".avi" || $fileType == ".mpeg" || $fileType == ".mpg" || $fileType == ".mp4" || $fileType == ".mov")
					{
						$ResolutionArr = split("x", getVideoResolution($mountPoint.$fileUrl));
						
						array_push($scannedFiles, [
						"filename" => $value2,
						"url" => str_replace($mountPoint, "", $fileUrl), 
						"fileType" => "mp4", 
						"dateTaken" => 0, 
						"latitude" =>  0, 
						"longitude" => 0,
						"size" => getFileSize($fileUrl),
						"width" => $ResolutionArr[0],
						"height" => $ResolutionArr[1],
						"cameraManufacturer" => "",
						"cameraModel" => "",
						"ownerId" => 11,
						"rightId" => 2,
						"duration" => getVideoDuration($fileUrl),
						"md5" => 0]);
					}
else {
						$exif = read_exif_data($fileUrl,1,true);
						$ImgBounds = getimagesize($fileUrl);
						$orientation = $exif["IFD0"]['Orientation'];
						$width = ($ImgBounds[0] != null) ? $ImgBounds[0] : 0 ;
						$height = ($ImgBounds[1] != null) ? $ImgBounds[1] : 0 ;
		
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
						"url" => str_replace($mountPoint, "", $fileUrl), 
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
						"duration" => 0,
						"md5" => getMD5($fileUrl)]);
					}
				}
			}	
		}
		$scannedFolder = [];
		$scannedFolder['folderUrl'] = str_replace($mountPoint, "", $folderLight['url']);
		$scannedFolder['folderName'] = $folderLight['name'];//split("/", trim($folderPath, "/"))[count(split("/", trim($folderPath, "/")))-1];
	
		scanDeviceParams($deviceId, $userId, $userRights, $scannedFolder, $scannedFiles, $thumbNeeded, $mountPoint);
	}
	//print("OK");
}

function scanNewFilesFromUSB($deviceId, $thumbNeeded, $md5)
{
	error_log("SCAN DEVICE FROM USB :: ".$deviceId." :: ".$thumbNeeded);
	//$isRecursive = ($isRecursive == "true") ? true : false;
	$thumbNeeded = ($thumbNeeded == "true") ? true : false;
	$md5 = ($md5 == "true") ? true : false;
	
	$mountPoint = getMountPointFromDeviceId($deviceId);
	
	$files = getNewFiles($deviceId);
	
	$scannedFiles = [];
	$userId = 11;
	$userRights = 2;
	
	foreach ($files as $file)
	{
		$fileName = array_pop(explode('/', $file));
		$fileType = array_pop(explode('.', $fileName));
		//$fileUrl = str_replace(" ", "\ ",$file);
		$fileUrl = $file;
		
		if (strtolower($fileType) == "jpg" || strtolower($fileType) == "jpeg")
		{
			$exif = read_exif_data ($mountPoint.$fileUrl,1,true);
			$ImgBounds = getimagesize($mountPoint.$fileUrl);
			$orientation = $exif["IFD0"]['Orientation'];
			$width = ($ImgBounds[0] != null) ? $ImgBounds[0] : 0 ;
			$height = ($ImgBounds[1] != null) ? $ImgBounds[1] : 0 ;

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
			"filename" => $fileName,
			"url" => $fileUrl, 
			"fileType" => $fileType, 
			"dateTaken" => $exif["EXIF"]["DateTimeOriginal"], 
			"dateCreated" => gmdate('Y-m-d H:i:s', filemtime($mountPoint.$fileUrl)),
			"dateModified" => gmdate('Y-m-d H:i:s', filemtime($mountPoint.$fileUrl)), 
			"latitude" =>  $lat, 
			"longitude" => $long,
			"size" => $exif["FILE"]['FileSize'],
			"width" => ($orientation == 6 || $orientation == 8) ? $width : $height,
			"height" => ($orientation == 6 || $orientation == 8) ? $height : $width,
			"cameraManufacturer" => trim($exif["IFD0"]["Make"]),
			"cameraModel" => trim($exif["IFD0"]["Model"]),
			"ownerId" => 11,
			"rightId" => 2,
			"duration" => 0,
			"md5" => ($md5) ? getMD5($mountPoint.$fileUrl) : 0]);
		}
		else if(strtolower($fileType) == "mpg" || strtolower($fileType) == "mpeg" || strtolower($fileType) == "avi" || strtolower($fileType) == "mp4" || strtolower($fileType) == "mov")
		 {
			
			$ResolutionArr = split("x", getVideoResolution($mountPoint.$fileUrl));
			array_push($scannedFiles, [
			"filename" => $fileName,
			"url" => $fileUrl, 
			"fileType" => "mp4", 
			"dateTaken" => 0, 
			"dateCreated" => 0,
			"dateModified" => 0,
			"latitude" =>  0, 
			"longitude" => 0,
			"size" => getFileSize($mountPoint.$fileUrl),
			"width" => $ResolutionArr[0],
			"height" => $ResolutionArr[1],
			"cameraManufacturer" => "",
			"cameraModel" => "",
			"ownerId" => 11,
			"rightId" => 2,
			"duration" => getVideoDuration($mountPoint.$fileUrl),
			"md5" => 0]);
		}
		else {
						$exif = [];
						$ImgBounds = getimagesize($fileUrl);
						$orientation = 0;
						$width = ($ImgBounds[0] != null) ? $ImgBounds[0] : 0 ;
						$height = ($ImgBounds[1] != null) ? $ImgBounds[1] : 0 ;
		
						$deg = 0 ;
						$min = 0 ;
						////////////////////
						/////FLOATVAL NE FONCTIONNE PAS POUR /1000
						////////////////////
						$sec = 0 ;
						$min = $min/60 ;
						$sec = $sec/3600000 ;
						$lat = $deg+($min+$sec) ;
						////error_log("LAT :: ".doubleval($lat));
						
						$deg = 0 ;
						$min = 0 ;
						////////////////////
						/////FLOATVAL NE FONCTIONNE PAS POUR /1000
						////////////////////
						$sec = 0 ;
						$min = $min/60 ;
						$sec = $sec/3600000 ;
						$long = $deg+($min+$sec) ;
					
						array_push($scannedFiles, [
						"filename" => $fileName,
						"url" => str_replace($mountPoint, "", $fileUrl), 
						"fileType" => $fileType, 
						"dateTaken" => 0, 
						"dateCreated" => 0,
						"dateModified" => 0,
						"latitude" =>  $lat, 
						"longitude" => $long,
						"size" => 0,
						"width" => ($orientation == 6 || $orientation == 8) ? $width : $height,
						"height" => ($orientation == 6 || $orientation == 8) ? $height : $width,
						"cameraManufacturer" => "",
						"cameraModel" => "",
						"ownerId" => 11,
						"rightId" => 2,
						"duration" => 0,
						"md5" => getMD5($fileUrl)]);
					}
		
	}
	scanFileParams($deviceId, $userId, $userRights, $scannedFiles, $thumbNeeded, $mountPoint);
	error_log(":: FINISH SCAN NEW FILES ::"." :: ".count($files)." :: ".count($scannedFiles));
	//print("OK");
}

function quickScanFromUsb($deviceHwId)
{
	error_log("QUICK SCAN FROM USB :: ".$deviceHwId);
	
	error_log("STEP 1");
	$mountPoint = getMountPointFromDeviceId($deviceHwId);
	
	error_log("STEP 2");
	$files = getNewFiles($deviceHwId);
	
	error_log("FOLDER TO SCAN :: ".$folderLight['name']." :: ".$folderLight['url']);
	$scannedFiles = [];
	$userId = 11;
	$userRights = 2;
	
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	if (mysqli_connect_errno()) {
	    exit();
	}
	
	error_log("STEP 3");
	$queryString = "SELECT id FROM s_devices WHERE hardwareId = \"".$deviceHwId."\"";
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
		$queryString = "INSERT INTO s_devices (hardwareId) VALUES (\"".$deviceHwId."\")";
		//error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$deviceId = mysqli_insert_id($link);
	}
	
	error_log("STEP 4");
	foreach ($files as $file)
	{
		$fileName = array_pop(explode('/', $file));
		$fileType = array_pop(explode('.', $fileName));
		$fileUrl = $file;
		
		//$exif = read_exif_data ($mountPoint.$fileUrl,1,true);
		
		/*
		error_log("FILE c Time :: ".date('Y-m-d H:i:s',filectime($mountPoint.$fileUrl)));
		error_log("FILE a Time :: ".date('Y-m-d H:i:s',fileatime($mountPoint.$fileUrl)));
		error_log("FILE m Time :: ".date('Y-m-d H:i:s',filemtime($mountPoint.$fileUrl)));*/
		//error_log("FILE m Time :: ".$exif["EXIF"]["DateTimeOriginal"]);
	
		array_push($scannedFiles, [
		"filename" => $fileName,
		"url" => $fileUrl,
		"size" => filesize($mountPoint.$fileUrl),
		//"dateCreated" => $exif["EXIF"]["DateTimeOriginal"], 
		"dateCreated" => gmdate('Y-m-d H:i:s', filemtime($mountPoint.$fileUrl)), 
		"fileType" => $fileType,
		"ownerId" => 11,
		"rightId" => 2,
		]);
	}
	quickScan($deviceId, $scannedFiles);
	//print("OK");
	//makeThumbsBackground($deviceHwId);
}

function makeThumbsBackground($deviceHwId)
{
	error_log("MAKE THUMBS Background :: ".$deviceHwId);
	
	$mountPoint = getMountPointFromDeviceId($deviceHwId);
	$files = getFiles($deviceHwId, true, false, false);
	error_log(" :: ".count($files));
	
	$i = 0;
	while(isDeviceOnline($deviceHwId) && isServerFree() && count($files) > $i)
	{
		$imgUrl = $mountPoint.$files[$i]['url'];
		makeThumbConvert($imgUrl, $files[$i]['id']);
		$i++;
	}
}

function scanDeeperFromUsb($deviceHwId)
{
	error_log("SCAN DEEPER FROM USB :: ".$deviceHwId);
	
	error_log("STEP 1");
	$mountPoint = getMountPointFromDeviceId($deviceHwId);
	$deviceId = getDeviceId($deviceHwId);
	error_log("STEP 2");
	
	//GET SCANNED FILES
	$files = getFiles($deviceHwId, true, false, false);
	error_log(" :: ".count($files));
	
	$scannedFiles = [];
	$userId = 11;
	$userRights = 2;
	
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	if (mysqli_connect_errno()) {
	    exit();
	}
	
	error_log("STEP 3");
	$queryString = "SELECT * FROM s_files WHERE deviceId = \"".$deviceId."\"";
	//error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	if($row)
	{
		$deviceId = $row[0];
		mysqli_free_result($result);
	}

	if($type)
	{
		error_log("STEP 4");
		foreach ($files as $file)
		{
			$fileName = array_pop(explode('/', $file));
			$fileType = array_pop(explode('.', $fileName));
			$fileUrl = $file;
			
			array_push($scannedFiles, [
			"filename" => $fileName,
			"url" => $fileUrl,
			"size" => filesize($mountPoint.$fileUrl),
			"md5" => getMD5($mountPoint.$fileUrl),
			"dateTaken" => gmdate('Y-m-d H:i:s',filectime($mountPoint.$fileUrl)), 
			"fileType" => $fileType,
			"ownerId" => 11,
			"rightId" => 2,
			]);
		}
	}
	else {
		error_log("STEP 4");
		foreach ($files as $file)
		{
			$fileName = array_pop(explode('/', $file));
			$fileType = array_pop(explode('.', $fileName));
			$fileUrl = $file;
			
			array_push($scannedFiles, [
			"filename" => $fileName,
			"url" => $fileUrl,
			"size" => filesize($mountPoint.$fileUrl),
			"md5" => getMD5($mountPoint.$fileUrl),
			"dateTaken" => gmdate('Y-m-d H:i:s',filectime($mountPoint.$fileUrl)), 
			"fileType" => $fileType,
			"ownerId" => 11,
			"rightId" => 2,
			]);
		}
	}
	
	deeperScan($deviceId, $scannedFiles);
	//print("OK");
}
?>
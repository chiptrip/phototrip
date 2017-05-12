<?php
//$_SERVER['SERVER_ADDR'] == sunnyv1.local
header('Access-Control-Allow-Origin: *');

session_start();

include_once("tools.php");

if (isset($_GET["action"]))
{
	 switch ($_GET["action"])
	 {
	 	 case("get") :
	 	 	api_get();
	 		 	break;
		 case("getAllImages") :
	 	 	getAllImages($_GET["offset"], $_GET["count"], $_GET["params"]);
	 		break;
		 case("getNbAllImages") :
	 	 	getNbAllImages($_GET["params"]);
	 		break;
		 case("getImageById") :
	 	 	getImageById();
	 		break;
		 case("getFolders") :
			 api_getFolders($_GET["owner"], $_GET["allPublic"], $_GET["offset"], $_GET["count"]);
			 break;
		 case("getFolderById") :
			 getFolderById();
			 break;
		 case("getUsers") :
			 api_getUsers();
			 break;
		 case("getImagesByFolder"):
		 	api_getImagesByFolder($_GET["folder"], $_GET["owner"], $_GET["allPublic"], $_GET["offset"], $_GET["count"]);
		 	break;
		case("getImagesByCamera"):
		 	api_getImagesByCamera($_GET["camera"], $_GET["owner"], $_GET["allPublic"], $_GET["offset"], $_GET["count"]);
		 	break;
		 case("getImagesByTags"):
		 	getImagesByTags();
		 	break;
		case("getNbImagesByTags"):
		 	getNbImagesByTags();
		 	break;
		 case("getImagesBySpecialDate"):
		 	getImagesBySpecialDate();
		 	break;
		 case("getImagesByYear"):
		 	api_getImagesByYear($_GET["year"], $_GET["owner"], $_GET["allPublic"], $_GET["offset"], $_GET["count"], $_GET["params"]);
		 	break;
		 case("getImagesAndFolders"):
			 api_getImagesAndFolders($_GET["startdate"], $_GET["enddate"], $_GET["owner"], $_GET["allPublic"], $_GET["offset"], $_GET["count"]);
		 	break;
		 case("getDates"):
			 api_getDates($_GET["owner"], $_GET["allPublic"], $_GET["offset"], $_GET["count"]);
		 	break;
		case("getYears"):
			 getYears($_GET["params"]);
		 	break;
		case("getMonths"):
			getMonths($_GET["year"],$_GET["params"]);
			break;
		 case("getTags"):
			 getTags();
		 	break;
		case("getLocations"):
			 getLocations();
		 	break;
		 case("createUser"):
			 api_createUser($_GET["name"], $_GET["password"]);
		 	break;
		 case("checkLoginPassword"):
			 api_checkLoginPassword($_GET["name"], $_GET["password"]);
			break;
		case("getSavedPics"):
		 	getSavedPics($_GET["owner"], $_GET["allPublic"], $_GET["pics"], $_GET["offset"], $_GET["count"]);
			break;
		case("getDuplicates"):
		 	getDuplicates($_GET["imageId"], $_GET["offset"], $_GET["count"]);
			break;
		case("getNbDuplicatesById"):
		 	getNbDuplicatesById($_GET["imageId"]);
			break;
		case("getDuplicatesOverview"):
		 	getDuplicatesOverview($_GET["imageId"]);
			break;
		case("getNoNameDuplicates"):
		 	getNoNameDuplicates($_GET["imageId"], $_GET["offset"], $_GET["count"]);
			break;
		case ("getNbNearDateDuplicates"):
			getNbNearDateDuplicates();
			break;
		case("getNearDateDuplicates")://TO BE TESTED
		 	getNearDateDuplicates($_GET["imageId"], $_GET["offset"], $_GET["count"]);
			break;
		case ("getNbSequences"):
			getNbSequences($_GET["sequenceId"], $_GET["params"]);
			break;
		case("getSequences")://TO BE TESTED
		 	getSequences($_GET["imageId"], $_GET["offset"], $_GET["count"], $_GET["params"]);
			break;
		case("getSequencesFromDate")://TO BE TESTED
		 	getSequencesFromDate($_GET["date"], $_GET["offset"], $_GET["count"]);
			break;
		case("getNearPlaceDuplicates")://TO BE DONE
		 	getNearPlaceDuplicates();
			break;
		case("getMultiSizeDuplicates"):
		 	getMultiSizeDuplicates($_GET["offset"], $_GET["count"], $_GET["allPublic"]);
			break;
		case("add"):
		 	add();
			break;
		case("getStatistics"):
			getStatistics($_GET['type']);
			break;
		case("getDevicesDiagnostics"):
			getDevicesDiagnostics();
			break;
		case("getDeviceDiagnostics"):
			getDeviceDiagnostics($_GET['deviceId']);
			break;
		case("getVideosDuplicatesOverview"):
			getVideosDuplicatesOverview();
			break;
		case("getPhotosDuplicatesOverview"):
			getPhotosDuplicatesOverview();
			break;
		case("getPhotosOverview"):
			getPhotosOverview();
			break;
		case("getVideosOverview"):
			getVideosOverview();
			break;
		case ("getDevices"):
			getDevices();
			break;
		case ("getAllDevices"):
			getAllDevices();
			break;
		case ("getBox"):
			getBox();
			break;
		case ("getDevice"):
			getDevice();
			break;
		case ("getDeviceByHwId"):
			getDeviceByHwId($_GET["deviceHwId"]);
			break;
		case ("addDevice"):
			addDevice();
			break;
		case ("addRemoteDevice"):
			addRemoteDevice();
			break;
		case ("getDeviceTypes"):
			getDeviceTypes();
			break;
		case ("getScannedFiles"):
			getScannedFiles($_GET['deviceId'], $_GET['offset'], $_GET['count']);
			break;
		case ("getNbScannedFiles"):
			getNbScannedFiles($_GET['deviceId']);
			break;
		case ("getNbDuplicates"):
			getNbDuplicates();
			break;
		case ("getNbSequences"):
			getNbSequences();
			break;
		case ("getSequences"):
			getSequences();
			break;
		case ("getNbImagesByDates"):
			getNbImagesByDates($_GET["startDate"], $_GET["endDate"], $_GET["noDuplicates"]);
			break;
		case ("getImagesByDates"):
			getImagesByDates($_GET["startDate"], $_GET["endDate"], $_GET["noDuplicates"], $_GET["offset"], $_GET["count"]);
			break;
		case ("getImagesByMonth"):
			getImagesByMonth($_GET["year"], $_GET["month"], $_GET["noDuplicates"], $_GET["offset"], $_GET["count"]);
			break;
		case ("getNbFolders"):
			getNbFolders();
			break;
		case("getCameras"):
			 api_getCameras($_GET["owner"], $_GET["allPublic"], $_GET["offset"], $_GET["count"]);
		 	break;
		case ("searchPlainText"):
			searchPlainText();
			break;
		case ("getRights"):
			getRights();
			break;
		case ("getOwners"):
			getOwners();
			break;
		case ("getGroups"):
			getGroups();
			break;
		case ("createGroup"):
			createGroup();
			break;
		case ("getBackupedImages"):
			getBackupedImages();
			break;
		case ("getNbImagesByLocations"):
			getNbImagesByLocations();
			break;
		case ("getImagesByLocations"):
			getImagesByLocations();
			break;
		case("getNbFilesByStorage"):
		 	getNbFilesByStorage($_GET["deviceId"], $_GET["noDuplicates"]);
		 	break;
		case("getNbImagesByStorage"):
		 	getNbImagesByStorage($_GET["deviceId"], $_GET["noDuplicates"]);
		 	break;
		 case("getNbVideosByStorage"):
		 	getNbVideosByStorage($_GET["deviceId"], $_GET["noDuplicates"]);
		 	break;
		case("getImagesByStorage"):
		 	getImagesByStorage($_GET["deviceId"], $_GET["noDuplicates"], $_GET["offset"], $_GET["count"]);
		 	break;
		case("updateDevice"):
		 	updateDevice();
		 	break;
		case("getSmartImage"):
		 	getSmartImage();
		 	break;
		case("getSmartUsbImage"):
		 	getSmartUsbImage();
		 	break;
		case("getAvailableUsbDevices"):
		 	getAvailableUsbDevices();
		 	break;
		 case("getAvailableNetworkDevices"):
		 	getAvailableNetworkDevices();
		 	break;
		case("getKnownAvailableNetworkDevices"):
		 	getKnownAvailableNetworkDevices();
		 	break;
		case("getRemoteFoldersToScan"):
		 	getRemoteFoldersToScan();
		 	break;
		case("getRemoteFoldersToBrowse"):
		 	getRemoteFoldersToBrowse();
		 	break;
		case("getUsbFoldersToScan"):
		 	getUsbFoldersToScan();
		 	break;
		case("getUsbFilesToBrowse"):
		 	getUsbFilesToBrowse();
		 	break;
		case("getUsbFoldersToBrowse"):
		 	getUsbFoldersToBrowse();
		 	break;
		case("isUsbFolderSynchro"):
		 	isUsbFolderSynchro($_GET['folderPath'], $_GET['deviceId']);
		 	break;
		 case("getUsbImg"):
		 	getUsbImg();
		 	break;
		case("getDownloadUrl"):
		 	getDownloadUrl($_GET['imgId']);
		 	break;
		case("browseUsbFolder"):
		 	browseUsbFolder();
		 	break;
		case("getBoxBackup"):
		 	getBoxBackup();
		 	break;
		case("getSpecialDays"):
		 	getSpecialDays();
		 	break;
		case("getNbSpecialDays"):
		 	getNbSpecialDays();
		 	break;
		 case("getLastRecords"):
		 	getLastRecords();
		 	break;	
		 case("getTodayImages"):
		 	getTodayImages($_GET["deviceId"]);
		 	break;
		 case("removeFile"):
		 	removeFile($_GET["fileId"]);
		 	break;
		 case("setNetwork"):
			 setNetwork($_GET["mode"]);
			 break;
		case("getStorageByTypes"):
		 	getStorageByTypes();
		 	break;
		case("getBooks"):
			getBooks();
			break;
		case("viewOnTV"):
			viewOnTV();
			break;
		case("getWifiAp"):
			getWifiAp();
			break;
		case("getNewDiapoId"):
			getNewDiapoId($_GET['diapoName']);
			break;
		case("getDiapo"):
			getDiapo($_GET['diapoId']);
			break;
		case("getDiapoName"):
			getDiapoName($_GET['diapoId']);
			break;
		case("getDiapos"):
			getDiapos();
			break;
		case("setDiapo"):
			setDiapo($_GET['diapoId'], $_GET['imgs']);
			break;
		case("setDiapoFromId"):
			setDiapoFromId($_GET['diapoId'], $_GET['imgs']);
			break;
		case("removeFromDiapo"):
			removeFromDiapo($_GET['diapoId'], $_GET['imgs']);
			break;
		case("startDiaporama"):
			startDiaporama($_GET['diapoId']);
			break;
		case("pauseDiaporama"):
			pauseDiaporama($_GET['diapoId']);
			break;
		case("nextItemDiaporama"):
			nextItemDiaporama($_GET['diapoId']);
			break;
		case("previousItemDiaporama"):
			nextItemDiaporama($_GET['diapoId']);
			break;
		case("deleteDiapo"):
			deleteDiapo($_GET['diapoId']);
			break;
		case("updateDiapo"):
			updateDiapo($_GET['diapoId'], $_GET['diapoName']);
			break;
		case("getDiapoDuration"):
			getDiapoDuration($_GET['diapoId']);
			break;
		case("connectDevice"):
			connectDevice($_GET['deviceId']);
			break;
		case("getSelfies"):
			getSelfies($_GET['$noDuplicates'], $_GET['$offset'], $_GET['$count']);
			break;
		case("getNbSelfies"):
			getNbSelfies($_GET['noDuplicates']);
			break;
		case("getOriginalImage"):
			getOriginalImage($_GET['imgId']);
			break;
		case "getNbBackupedImages":
			getNbBackupedImages();
			break;
		case "getBackupedImages":
			getBackupedImages();
			break;
		case "transfertFile":
			transfertFile();
			break;
		case "init":
			init();
			break;
		case "getAvailableDevices":
			getAvailableDevices();
			break;
		case "getThumb":
			getThumb($_GET['imgId']);
			break;
		case "getOfflineDevices":
			getOfflineDevices();
			break;
		case "backupDevice":
			backupDevice($_GET['deviceId'], $_GET['noDuplicates'], $_GET['targetDeviceId'], $_GET['onlyNewFiles']);
			break;
		case "getDistantUrl":
			getDistantUrl();
			break;
		case "getProgress":
			getProgress();
			break;
		case "getBatteryLevel":
				getChipBatteryLevel();
			break;
		case "getBatteryStatus":
				getBatteryStatus();
			break;
		case "getLocalIP":
				getLocalIP();
			break;
		case "getIpOnAP":
				getIpOnAP();
			break;
		case "iddle":
			iddle($_GET['mode']);
			break;
		case "iddle":
			USBStorageStats();
			break;
		case "backupFolder":
			backupFolderAPI($_GET['folderPath'], $_GET['fromDeviceHwId'], $_GET['toDeviceHwId']);
			break;
		case "shutDown":
			shutDown();
			break;
		case "scanUSBDevice":
			scanUSBDevice($_GET['deviceId']);
			break;
		case "backupFile":
			backupFile($_GET['FILEURL'], $_GET['FROMHWID'], $_GET['TOHWID']);
			break;
		case "deleteFile":
			deleteFileAPI($_GET['FILEURL']);
			break;
	}
}

function iddle($mode)
{
	if($mode == "ON")
	{
		error_log("IDDLE ON");
		setIddleMode(true);
	}
	else if($mode == "OFF")
		{
			error_log("IDDLE OFF");
			setIddleMode(false);
		}
}

function shutDown()
{
	shutDownChip();
}

function getChipBatteryLevel()
{
	print(getBatteryLevel());
}

function getBatteryStatus()
{
	print(getBatteryChargingStatus());
}

function USBStorageStats()
{
	print(getUSBDiskUsage()."%");
}

function getLocalIP()
{
	print(getWlan0Ip());
}
function getIpOnAP()
{
	print(getWlan1Ip());
}

function init()
{
	scanNetwork();
	getKnownAvailableNetworkDevices();
	
	/*
	$url = "http://sunnyv1.local/scanDevice.php?action=quickScanFromUsb&deviceHwId=".$macAdress;
		$options=array(
	      CURLOPT_URL            => $url, 
	      CURLOPT_RETURNTRANSFER => true, 
	      CURLOPT_HEADER         => false
		);
		
		$CURL=curl_init();
		curl_setopt_array($CURL,$options);
	    curl_exec($CURL);
		curl_close($CURL);*/
	
	//print("OK");
}

function backupDevice($deviceId, $noDuplicates, $targetDeviceId, $onlyNewFiles)
{
	error_log("BACKUP DEVICE");
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
		
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$targetDeviceId = ($targetDeviceId != "" && $targetDeviceId != null) ? $targetDeviceId : getBackupDriveId();
	
	if($noDuplicates == "true")
	{
		$queryString = "SELECT a.url FROM (
		SELECT * FROM s_files WHERE deviceId =".$deviceId.")a
		INNER JOIN (
		SELECT * FROM s_files WHERE deviceId =".$targetDeviceId.")b
		ON a.size = b.size AND (a.filename = b.filename OR a.dateCreated = b.dateCreated)";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		
		$alreadySaved =[];
		while ($row = mysqli_fetch_row($result))
		{
			array_push($alreadySaved, $row[0]);
		}
	}
	
	$queryString = "SELECT url FROM s_files WHERE deviceId =".$deviceId;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$toBackup =[];
	while ($row = mysqli_fetch_row($result))
	{
		array_push($toBackup, $row[0]);
	}
	
	$diffToBackup = ($noDuplicates != "true") ? $toBackup : array_diff($toBackup, $alreadySaved); //new files
	
	$backupPath = getTransfertPath("backup", getDeviceHwId($targetDeviceId));
	$mountPoint = getMountPointFromDeviceId(getDeviceHwId($deviceId));
	foreach($diffToBackup as $file)
	{
		if($onlyNewFiles == "true")
		{
			backupUniqueFile($mountPoint.$file, getDeviceHwId($deviceId), getDeviceHwId($targetDeviceId));
		}
		else {
			copyFile($mountPoint.$file, $backupPath);
		}
	}
	scanDevice(getBackupDriveHwId());
	//print("OK");
}

function transfertFile()
{
	$file = $_GET['originFilePath'];
	$destinationDeviceId = $_GET['destinationDeviceId'];
	error_log("TRANSFERT :: ".$file." :: ".$destinationDeviceId);
	
	copyFile($file, getTransfertPath("transfert", $destinationDeviceId));
	scanDevice($destinationDeviceId);
}

function scanUSBDevice($deviceHwId)
{
	scanDevice($deviceHwId);
}

function backupFile($originFilePath, $originDeviceHwId, $targetDeviceHwId)
{
	error_log($originFilePath." :: ".$originDeviceHwId." :: ".$targetDeviceHwId);
	backupUniqueFile($originFilePath, $originDeviceHwId, $targetDeviceHwId);
}

function copySingleFile($originFilePath, $originDeviceHwId, $targetDeviceHwId)
{
	copyFile($originFilePath, $targetFolderPath);
}

function deleteFileAPI($fileUrl)
{
	deleteFile($fileUrl);
	print("OK");
}

function backupFolderAPI($originFolderPath, $originDeviceHwId, $targetDeviceHwId)
{
	backupFolder($originFolderPath, $originDeviceHwId, $targetDeviceHwId);
}

function getProgress()
{
	print("COUCOU");
	//print(getProgressCP());
}

function connectDevice($deviceId)
{
	mountRemoteDrive($deviceId);
}

function startDiaporama($diapoId, $autoRotate)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "UPDATE s_diaporamas SET state = \"RUNNING\" WHERE id = ".diapoId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$autoRotate = ($autoRotate == "true") ? true : false;
	$files = getDiapo($diapoId);
	
	$imgToPrepare;
	$imgToDisplay = prepareForTV(null, $files[0], null, true);
	$imgToRemove;
	
	for($i = 1; $i <= count($files); $i++)
	{
		
		$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
		/* Vérification de la connexion */
		if (mysqli_connect_errno()) {
	   		//print("Échec de la connexion");
	    	exit();
		}
		
		$queryString = "SELECT state FROM s_diaporamas WHERE id = ".diapoId;
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		if($row[0] == "PAUSEASKED")
		{
			//code pause
			sleep(10);
		}
		else
		{
			$diplayParams = displayOnTV(null, $imgToDisplay, null, $imgToRemove, true);
			error_log("WAIT FOR :: ".$diplayParams['delai']);
			$imgToRemove = $diplayParams['imgRef'];
			error_log("PREPARE");
			$imgToDisplay = prepareForTV(null, $files[$i], null, true);
			error_log("SLEEP :: ".$diplayParams['delai']);
			sleep($diplayParams['delai']);
			error_log("NEXT");
		}
		
	}
	
	if(count($files) == 1)
	{
		$diplayParams = displayOnTV(null, $files[0], null, null, true);
		sleep($diplayParams['delai']);
	}
	
	endOfDiaporama();
}

function pauseDiaporama($diapoId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "UPDATE s_diaporamas SET state = \"PAUSEASKED\" WHERE id = ".diapoId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	//pauseVideoPlayback();
}

function resumeDiaporama($diapoId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "UPDATE s_diaporamas SET state = \"RESUMEASKED\" WHERE id = ".diapoId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	//pauseVideoPlayback();
}

function nextItemDiaporama($diapoId)
{
	
}

function previousItemDiaporama($diapoId)
{
	
}

function getNewDiapoId($diapoName)
{
	error_log("NICOLAS :: TEST".$diapoName);
	$diapoName = ($diapoName != null && $diapoName != "") ? $diapoName : "" ;
	
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($diapoName != "")
	{
		$queryString = "SELECT id FROM s_diaporamas WHERE name=\"".$diapoName."\"";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		
		if($row = mysqli_fetch_row($result))
		{
			print($row[0]);
		}
		else {
			$queryString = "INSERT INTO s_diaporamas (name) VALUES (\"".$diapoName."\")";
			error_log($queryString);
			$result = mysqli_query($link, $queryString);
		
			print(mysqli_insert_id($link));
		}
		
	}
	
}

function getDiapos()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_diaporamas";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{
					\"Name\":\"".$row[1]."\",\"Value\":\"".$row[0]."\"}," ;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
}

function getDiapoName($diapoId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT name FROM s_diaporamas WHERE id = ".$diapoId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getDiapoDuration($diapoId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT fileLocalPath, fileType FROM a_diaporama_file a1 WHERE diapoId = ".$diapoId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$duration = 0;
	
	while ($row = mysqli_fetch_row($result))
	{
		error_log("TYPE :: ".$row[1]);
		if($row[1] >= 20)
		{
			$duration = $duration + getVideoDuration($row[0]);
		}
	}
	
	print($duration);
}

function getDiapo($diapoId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT fileLocalPath, fileType, deviceId, fileId FROM a_diaporama_file a1 WHERE diapoId = ".$diapoId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$returnArr = [];
	
	$output = "[";
	
	while ($row = mysqli_fetch_row($result))
	{
		error_log("FILE ID :: ".$row[3]);
		if($row[3] != null && $row[3] != "")
		{
			$queryString = "SELECT filename, url, fileType, deviceId FROM s_files a1 WHERE id = ".$row[3];
			error_log($queryString);
			$result2 = mysqli_query($link, $queryString);
			$row2 = mysqli_fetch_row($result2);
			$name = $row2[0] ;
			$type = $row2[2];
			$url = addslashes($row2[1]);
			$deviceId = $row2[3];
			//$deviceType = ;
			
			$output = $output."{
					\"fileId\":".$row[3].",\"Name\":\"".$name."\",\"ThumbUrl\":\"".getMountPointFromDeviceId(getDeviceHwId($deviceId)).$url."\",\"localPath\":\"".$url."\",\"type\":\"".$type."\",\"source\":\"usb\"}," ;
			array_push($returnArr, getMountPointFromDeviceId(getDeviceHwId($row[2])).$row[0]);
		}
		else
		{
			error_log("NAME :: ".$row[0]);
			error_log("TYPE :: ".$row[1]);
			$name = explode("/", $row[0]);
			$name = $name[count($name) - 1];
			$type = ($row[1] >= 20) ? "video" : "image";
			$output = $output."{
						\"Name\":\"".$name."\",\"ThumbUrl\":\"".getMountPointFromDeviceId(getDeviceHwId($row[2])).$row[0]."\",\"localPath\":\"".getMountPointFromDeviceId(getDeviceHwId($row[2])).$row[0]."\",\"type\":\"".$type."\",\"source\":\"usb\"}," ;
			array_push($returnArr, getMountPointFromDeviceId(getDeviceHwId($row[2])).$row[0]);
		}
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	return $returnArr;
}

function setDiapo($diapoId, $imgs, $deviceId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	error_log("IMAGES :: ".$imgs);
	$imgsArr = json_decode($imgs, true);
	
	$deviceId = ($deviceId == null) ? getDeviceIdFromLocalPath($imgsArr[0]) : $deviceId;
	
	$queryString = "INSERT INTO a_diaporama_file (diapoId, fileLocalPath, fileType, deviceId) VALUES";
	//!!!!!!!! check if $imgs.length < 1000
	foreach ($imgsArr as $img) {
		$typeArr = explode(".", $img);
		$typeStr = strtolower($typeArr[count($typeArr)-1]);
		$queryString2 = "SELECT id FROM d_file_types WHERE keywords LIKE '%".$typeStr."%'";
		error_log($queryString);
		$result = mysqli_query($link, $queryString2);
		$row = mysqli_fetch_row($result);
		
		$fileType = $row[0];
		$queryString = $queryString . " (".$diapoId.",\"".substr($img, 9)."\",\"".$fileType."\",\"".$deviceId."\"),";
	}
	 
	$queryString = substr($queryString,0,-1);
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function setDiapoFromId($diapoId, $imgsIds)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	error_log("IMAGES :: ".$imgs);
	$imgsArr = json_decode($imgsIds, true);
	
	$queryString = "INSERT INTO a_diaporama_file (diapoId, fileId) VALUES";
	//!!!!!!!! check if $imgs.length < 1000
	foreach ($imgsArr as $img)
	{
		$queryString = $queryString . " (".$diapoId.",".$img."),";
	}
	 
	$queryString = substr($queryString,0,-1);
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function removeFromDiapo($diapoId, $imgs)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$imgsArr = json_decode($imgs, true);
	
	$queryString = "DELETE FROM a_diaporama_file WHERE diapoId = ".$diapoId." AND fileLocalPath IN (";
	//!!!!!!!! check if $imgs.length < 1000
	foreach ($imgsArr as $img) {
		$queryString = $queryString . "\"".$img."\",";
	}
	 
	$queryString = substr($queryString,0,-1).")";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function deleteDiapo($diapoId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "DELETE FROM s_diaporamas WHERE id = ".$diapoId;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function updateDiapo($diapoId, $diapoName)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "UPDATE s_diaporamas SET name = \"".$diapoName."\" WHERE id = ".$diapoId;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function viewOnTV()
{
	$imgId = $_GET["imgId"];
	$imgPath = $_GET["localPath"];
	$deviceHwId = $_GET["deviceHwId"];
	
	error_log("GET MOUNT POINT");
	//$deviceHwId = getDeviceHwId($deviceId);
	$mountPoint = getMountPointFromDeviceId($deviceHwId);
	$contentAvailable = (getDeviceType($deviceHwId) == "17") ? false : true;
	
	if($imgId != "" && $imgId != null)
	{
		$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
		/* Vérification de la connexion */
		if (mysqli_connect_errno()) {
	   		//print("Échec de la connexion");
	    	exit();
		}
		
		$queryString = "SELECT url, fileType, deviceId FROM s_files WHERE id = ".$imgId;
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		$imgUrl = $mountPoint.$row[0];
		error_log("PATH :: ".$imgUrl);
		//$img = prepareForTV($row[1], $imgUrl, $row[2], true, $contentAvailable);
		//displayOnTV($row[1], $img, $row[2], null, true);
		displayOnTV($row[1], $imgUrl, $row[2], null, true);
	}
	else if($imgPath != "" && $imgPath != null)
	{
		//$img = prepareForTV(null, $imgPath, null, true, $contentAvailable);
		//displayOnTV(null, $img, null, null, true);
		displayOnTV(null, $imgPath, null, null, true);
	}
	
}

function searchPlainText()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$plainText = $_GET['plainText'];
	
	$queryString = "SELECT * FROM s_folders WHERE name LIKE '%".$plainText."%' OR url LIKE '%".$plainText."%'";

	$output = "[";
	$result = mysqli_query($link, $queryString);
	
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Type\":\"folder\",
							\"Title\":\"".$row[2]."\",
							\"FolderId\":\"".$row[0]."\",
							\"DeviceId\":\"".$row[4]."\",
							\"ThumbUrl\":\"http://sunnyv1.local/ressources/thumbs/".floor($row[2] / 1000)."/".$row[2]."\",
							\"DossierSchemaObj\":{\"Id\":\"".$row[0]."\",\"DeviceId\":\"".$row[7]."\",\"Name\":\"".$row[2]."\",\"ThumbUrl\":\"http://sunnyv1.local/ressources/thumbs/".floor($row[2] / 1000)."/".$row[2]."\",\"LocalUrl\":\"".addslashes($row[6])."\"}},";
	}
	
$queryString = "SELECT * FROM s_files WHERE filename LIKE '%".$plainText."%'";

	$result = mysqli_query($link, $queryString);

	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Type\":\"file\",
							\"Title\":\"".$row[1]."\",
							\"FileId\":\"".$row[0]."\",
							\"DeviceId\":\"".$row[3]."\",
							\"LocalUrl\":\"".addslashes($row[11])."\",
							\"ThumbUrl\":\"http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg\",
							\"TouteSchemaObj\":{\"Id\":\"".$row[0]."\",\"DeviceId\":\"".$row[12]."\",\"Name\":\"".$row[1]."\",\"ThumbUrl\":\"http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg\",\"ImageUrl\":\"".addslashes($row[11])."\",\"Latitude\":\"".$row[9]."\",\"Longitude\":\"".$row[10]."\"}},";
	}
	
	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
}

function getNbScannedFiles($deviceId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT(*) FROM s_files WHERE deviceId = ".$deviceId;
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
	mysqli_free_result($result);
	mysqli_close($link);
}

function getScannedFiles($deviceId, $offset, $count)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT url,id FROM s_files WHERE deviceId = ".$deviceId;
	if($offset != "")
	{
		 $queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"url\":\"".addslashes($row[0])."\",\"deviceId\":\"".$deviceId."\",\"id\":\"".$row[1]."\"},";
	}
	
	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getNbDuplicates() //OK
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	
	$queryString = "SELECT COUNT( * )
FROM s_files a1
INNER JOIN (

SELECT id
FROM s_files
GROUP BY size, filename
HAVING COUNT( * ) >1)a2 ON a1.id = a2.id";

/*
$queryString = "SELECT COUNT( * )
FROM s_files a1
INNER JOIN (

SELECT id
FROM s_files
GROUP BY MD5
HAVING COUNT( * ) >1)a2 ON a1.id = a2.id";
*/
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}

function getNbDuplicatesById($imageId) //OK
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	/*if(getFileType($imageId) == "image")
	{
		
		$queryString = "SELECT COUNT(*) FROM s_files a1
		RIGHT JOIN (
		
		SELECT MD5
		FROM s_files
		WHERE id=".$imageId."
		)a2 ON a1.MD5 = a2.MD5 AND a1.MD5 != 0 AND a1.MD5 != \"\"";
	}
	else {
		$queryString = "SELECT COUNT(*) FROM s_files a1
		RIGHT JOIN (
		
		SELECT size
		FROM s_files
		WHERE id=".$imageId."
		)a2 ON a1.size = a2.size AND a1.size != 0 AND a1.size != \"\"";
	}*/
	
	$queryString = "SELECT COUNT(*) FROM s_files a1
		RIGHT JOIN (
		
		SELECT size, filename, dateCreated
		FROM s_files
		WHERE id=".$imageId."
		)a2 ON (a1.size = a2.size AND (a1.filename = a2.filename OR a1.dateCreated = a2.dateCreated))";
		
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}

function getDuplicatesOverview($imageId) // OK
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT(*), a1.filename AS
FILE , a3.name AS Device, a1.deviceId
FROM s_files a1
RIGHT JOIN (

SELECT size, dateCreated
FROM s_files
WHERE id=".$imageId."
)a2 ON a1.size = a2.size
AND a1.dateCreated = a2.dateCreated
INNER JOIN s_devices a3 ON a1.deviceId = a3.id
INNER JOIN a_folder_file a5 ON a1.id = a5.fileId
INNER JOIN s_folders a4 ON a5.folderId = a4.id
GROUP BY a1.deviceId";

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{

	$mediaType = ($row[9] < 20) ? "image" : "video";
	$output = $output."{\"Count\":\"".$row[0]."\",\"ImageName\":\"".$row[1]."\",\"DeviceName\":\"".$row[2]."\",\"DeviceId\":\"".$row[3]."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getFoldersDuplicates($imageId, $offset, $count) // OK
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($imageId == "-1")
	{
		$queryString = "SELECT * FROM (SELECT a.folderId, SUM(b.size) AS somme1 FROM a_folder_file a
RIGHT JOIN (SELECT id, size FROM s_files) b ON a.fileId = b.id
GROUP BY a.folderId) c, (SELECT a.folderId, SUM(b.size) AS somme2 FROM a_folder_file a
RIGHT JOIN (SELECT id, size FROM s_files) b ON a.fileId = b.id
GROUP BY a.folderId) d
WHERE somme1 = somme2
GROUP BY c.folderId
HAVING COUNT(*) > 1
ORDER BY somme1";
//		$queryString = $queryString." GROUP BY size, dateCreated HAVING COUNT( * ) >1 ORDER BY dateCreated DESC";
		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
	}
	else
		{
			$queryString = "SELECT a1.filename AS
FILE , a3.name AS Device, a4.name AS Folder, a4.url AS FolderUrl, a1.deviceId, a1.url, a1.storageType, a1.id, a1.dateCreated, a1.fileType
FROM s_files a1
RIGHT JOIN (

SELECT size, dateCreated
FROM s_files
WHERE id=".$imageId."
)a2 ON a1.size = a2.size
AND a1.dateCreated = a2.dateCreated
INNER JOIN s_devices a3 ON a1.deviceId = a3.id
INNER JOIN a_folder_file a5 ON a1.id = a5.fileId
INNER JOIN s_folders a4 ON a5.folderId = a4.id";
		}

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		if($imageId == "-1")
		{
			$mediaType = ($row[6] < 20) ? "image" : "video";
			$output = $output."{\"DuplicateType\":\"standard\",\"Id\":\"".$row[0]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",\"Count\":\"".$row[2]."\",\"DeviceId\":\"".$row[3]."\",\"ImageUrl\":\"".addslashes($row[4])."\",\"MediaType\":\"".$mediaType."\",\"dateCreated\":\"".$row[5]."\"},";
		}
else {
	$mediaType = ($row[9] < 20) ? "image" : "video";
	$output = $output."{\"DuplicateType\":\"standard\",\"Id\":\"".$row[7]."\",\"Name\":\"".$row[0]."\",\"FolderName\":\"".$row[2]."\",\"FolderUrl\":\"".addslashes($row[3])."\",\"DeviceId\":\"".$row[4]."\",\"DeviceName\":\"".$row[1]."\",\"ImageUrl\":\"".addslashes($row[5])."\",\"StorageType\":\"".$row[6]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[7] / 1000)."/".$row[7].".jpg")."\",\"MediaType\":\"".$mediaType."\",\"dateCreated\":\"".$row[8]."\"}," ;
}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getDuplicates($imageId, $offset, $count) // OK
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($imageId == "-1")
	{
		
		$queryString = "SELECT *
FROM (

SELECT GROUP_CONCAT( id ) AS IDS, filename, COUNT( * ) AS total, deviceId, url, GROUP_CONCAT( dateCreated ) AS DATES, fileType, size
FROM s_files
WHERE fileType <20
GROUP BY size, filename
HAVING COUNT( * ) >1
UNION ALL
SELECT GROUP_CONCAT( id ) AS IDS, GROUP_CONCAT( filename ) AS FILENAMES, COUNT( * ) AS total, deviceId, url, dateCreated, fileType, size
FROM s_files
WHERE fileType <20
GROUP BY size, dateCreated
HAVING COUNT( * ) >1
)a
GROUP BY size, filename
ORDER BY total DESC";
		
		/*$queryString = "SELECT id, filename, COUNT( * ) AS total, deviceId, url, dateCreated, fileType FROM s_files";
		$queryString = $queryString." GROUP BY size, filename HAVING COUNT( * ) >1 ORDER BY total DESC";*/
//		$queryString = $queryString." GROUP BY filename, dateCreated, width, height HAVING COUNT( * ) >1 ORDER BY total DESC";
		//$queryString = $queryString." GROUP BY size, dateCreated HAVING COUNT( * ) >1 ORDER BY total DESC";
		
//		$queryString = $queryString." GROUP BY size, dateCreated HAVING COUNT( * ) >1 ORDER BY dateCreated DESC";
		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
	}
	else
		{
			/*$queryString = "SELECT a1.filename AS
FILE , a3.name AS Device, a4.name AS Folder, a4.url AS FolderUrl, a1.deviceId, a1.url, a1.storageType, a1.id, a1.dateCreated, a1.fileType
FROM s_files a1
RIGHT JOIN (

SELECT size, dateCreated
FROM s_files
WHERE id=".$imageId."
)a2 ON a1.size = a2.size
AND a1.dateCreated = a2.dateCreated
INNER JOIN s_devices a3 ON a1.deviceId = a3.id
INNER JOIN a_folder_file a5 ON a1.id = a5.fileId
INNER JOIN s_folders a4 ON a5.folderId = a4.id";*/

$queryString = "SELECT a1.filename AS FILE , a3.name AS Device,
a1.filename AS FILE , a3.name AS Device,
a1.deviceId, a1.url, a1.storageType, a1.id, a1.dateCreated, a1.fileType
FROM s_files a1
RIGHT JOIN (

SELECT size, filename, dateCreated
FROM s_files
WHERE id=".$imageId."
)a2 ON (a1.size = a2.size
AND (a1.filename = a2.filename
OR a1.dateCreated = a2.dateCreated))
INNER JOIN s_devices a3 ON a1.deviceId = a3.id";
		}

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		if($imageId == "-1")
		{
			//error_log("IDS :: ".$row[0]);
			$ids = explode(",", $row[0]);
			//error_log("IDS arr :: ".count($ids));
			$ids = array_unique($ids, SORT_NUMERIC);
			$mediaType = ($row[6] < 20) ? "image" : "video";
			$output = $output."{\"DuplicateType\":\"standard\",\"Id\":\"".$ids[0]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($ids[0] / 1000)."/".$ids[0].".jpg")."\",\"Count\":\"".count($ids)."\",\"DeviceId\":\"\",\"ImageUrl\":\"".addslashes($row[4])."\",\"MediaType\":\"".$mediaType."\",\"dateCreated\":\"".$row[5]."\"},";
		}
else {
	$mediaType = ($row[9] < 20) ? "image" : "video";
	$output = $output."{\"DuplicateType\":\"standard\",\"Id\":\"".$row[7]."\",\"Name\":\"".$row[0]."\",\"FolderName\":\"".$row[2]."\",\"FolderUrl\":\"".addslashes($row[3])."\",\"DeviceId\":\"".$row[4]."\",\"DeviceName\":\"".$row[1]."\",\"ImageUrl\":\"".addslashes($row[5])."\",\"StorageType\":\"".$row[6]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[7] / 1000)."/".$row[7].".jpg")."\",\"MediaType\":\"".$mediaType."\",\"dateCreated\":\"".$row[8]."\"}," ;
}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getAverageDayCount()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT FLOOR(SUM(c.nb)/COUNT(*)) FROM 
(SELECT MAX(nb) AS maxNb, MIN(nb) AS minNb FROM (SELECT id, fileName, dateCreated, COUNT(*) AS nb
FROM (SELECT * FROM s_files GROUP BY size, filename)x
WHERE YEAR( x.dateCreated ) !=1601
AND YEAR( x.dateCreated ) !=0
GROUP BY YEAR(x.dateCreated), MONTH(x.dateCreated), DAY(x.dateCreated)
ORDER BY nb DESC)a)b, (SELECT id, fileName, dateCreated, COUNT(*) AS nb
FROM (SELECT * FROM s_files GROUP BY size, filename)x
WHERE YEAR( x.dateCreated ) > 1900
GROUP BY YEAR(x.dateCreated), MONTH(x.dateCreated), DAY(x.dateCreated)
ORDER BY nb DESC)c
WHERE c.nb > b.minNb
AND c.nb < b.maxNb";
	
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	//print($row[0]);
	return $row[0];
}

function getNbSequences($imageId, $excludeParams) //BROWSING
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$averageCount = getAverageDayCount();
	$averageCount = floor($averageCount * 0.7);
	
	if($imageId == "-1")
	{
		$queryString ="SELECT date FROM t_sequences ORDER BY date ASC LIMIT 0,1";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		if($row = mysqli_fetch_row($result))
		{
			$lastSequenceDate = date('Y-m-d H:i:s', strtotime($row[0]));
			
			$queryString ="SELECT updateDate FROM a_date_file ORDER BY updateDate DESC LIMIT 0,1";
			error_log($queryString);
			$result = mysqli_query($link, $queryString);
			$row = mysqli_fetch_row($result);
			
			$lastRecordDate = date('Y-m-d H:i:s', strtotime($row[0]));
			error_log("LAST RECORD :: ".$lastRecordDate);
			error_log("LAST SEQUENCE :: ".$lastSequenceDate);
			if($lastRecordDate > $lastSequenceDate)
			{
				$queryString ="DROP TABLE t_sequences";
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				$queryString = "SET @seq = 0;";
				$result = mysqli_query($link, $queryString);
			
				$queryString = "CREATE TABLE t_sequences (INDEX id (ID2)) AS (
				SELECT *, NOW() AS date FROM (
				SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), result2.URL2, result2.DEVICEID2, SUM(dayCount2)/COUNT(*) AS moyenne, SUM(dayCount2) AS nbFiles
				FROM (
				
				SELECT result.ID AS ID1, result.NAME, result.DATE1, result.URL AS URL2, result.DEVICEID AS DEVICEID2, if( result.count =1
				AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount2
				FROM (
				
				SELECT a1.id AS ID, a1.filename AS NAME, a1.dateTaken AS DATE1, a1.url AS URL, a1.deviceId AS DEVICEID, COUNT( * ) AS count, if( (
				DATEDIFF( a2.dateTaken, a1.dateTaken ) !=1 )
				AND a1.id != a2.id, 1, 0
				) AS test, a1.dayCount AS dayCount2
				FROM (
				
				SELECT *, COUNT(*) AS dayCount
				FROM (SELECT * FROM s_files GROUP BY size, filename)x
				WHERE YEAR( x.dateTaken ) !=1601
				AND YEAR( x.dateTaken ) !=0
				GROUP BY YEAR( x.dateTaken ) , MONTH( x.dateTaken ) , DAY( x.dateTaken )
				ORDER BY x.dateTaken ASC
				)a1, (
				
				SELECT *
				FROM (SELECT * FROM s_files GROUP BY size, filename)x
				WHERE YEAR( x.dateTaken ) !=1601
				AND YEAR( x.dateTaken ) !=0
				GROUP BY YEAR( x.dateTaken ) , MONTH( x.dateTaken ) , DAY( x.dateTaken )
				ORDER BY x.dateTaken ASC
				)a2
				WHERE DATEDIFF( a2.dateTaken, a1.dateTaken )
				BETWEEN -1
				AND 1
				AND a1.id != a2.id
				GROUP BY a1.id
				ORDER BY `a1`.`dateTaken` ASC
				)result
				
				)result2
				GROUP BY sequence
				ORDER BY DATE1 DESC)result3
				WHERE moyenne > ".$averageCount.")";
				
				/*$queryString = "CREATE TABLE t_sequences (INDEX id (ID2)) AS (
			SELECT *, NOW() AS date FROM (
				SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), result2.URL2, result2.DEVICEID2, SUM(dayCount2)/COUNT(*) AS moyenne, SUM(dayCount2) AS nbFiles
				FROM (
				
				SELECT result.ID AS ID1, result.NAME, result.DATE1, result.URL AS URL2, result.DEVICEID AS DEVICEID2, if( result.count =1
				AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount2
				FROM (
				
				SELECT a1.id AS ID, a1.filename AS NAME, a1.dateCreated AS DATE1, a1.url AS URL, a1.deviceId AS DEVICEID, COUNT( * ) AS count, if( (
				DATEDIFF( a2.dateCreated, a1.dateCreated ) !=1 )
				AND a1.id != a2.id, 1, 0
				) AS test, a1.dayCount AS dayCount2
				FROM (
				
				SELECT *, COUNT(*) AS dayCount
				FROM s_files
				WHERE YEAR( dateCreated ) !=1601
				AND YEAR( dateCreated ) !=0
				GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
				ORDER BY dateCreated ASC
				)a1, (
				
				SELECT *
				FROM s_files
				WHERE YEAR( dateCreated ) !=1601
				AND YEAR( dateCreated ) !=0
				GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
				ORDER BY dateCreated ASC
				)a2
				WHERE DATEDIFF( a2.dateCreated, a1.dateCreated )
				BETWEEN -1
				AND 1
				AND a1.id != a2.id
				GROUP BY a1.id
				ORDER BY `a1`.`dateCreated` ASC
				)result
				
				)result2
				GROUP BY sequence
				ORDER BY DATE1 DESC)result3
				WHERE moyenne > ".$averageCount.")";*/
				
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				$queryString ="SELECT COUNT(*) FROM t_sequences";
			}
			else {
				$queryString ="SELECT Count(*) FROM t_sequences";
				//TODO filtrer les sequences pour ONLINE
				/*$excludeParamsArr = explode(",", $excludeParams);
		
				foreach ($excludeParamsArr as $key) {
					error_log("PARAM :: ".$key);
					switch($key)
					{
						case "online":
							$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
				RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON DEVICEID2 = a6.id";
							break;
							
					}
				}
				 * */
			}
		}
		else {
						
			$queryString = "SET @seq = 0;";
			$result = mysqli_query($link, $queryString);
		
			$queryString = "CREATE TABLE t_sequences (INDEX id (ID2)) AS (
			SELECT *, NOW() AS date FROM (
			SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), result2.URL2, result2.DEVICEID2, SUM(dayCount2)/COUNT(*) AS moyenne, SUM(dayCount2) AS nbFiles
			FROM (
			
			SELECT result.ID AS ID1, result.NAME, result.DATE1, result.URL AS URL2, result.DEVICEID AS DEVICEID2, if( result.count =1
			AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount2
			FROM (
			
			SELECT a1.id AS ID, a1.filename AS NAME, a1.dateTaken AS DATE1, a1.url AS URL, a1.deviceId AS DEVICEID, COUNT( * ) AS count, if( (
			DATEDIFF( a2.dateTaken, a1.dateTaken ) !=1 )
			AND a1.id != a2.id, 1, 0
			) AS test, a1.dayCount AS dayCount2
			FROM (
			
			SELECT *, COUNT(*) AS dayCount
			FROM (SELECT * FROM s_files GROUP BY size, filename)x
			WHERE YEAR( x.dateTaken ) !=1601
			AND YEAR( x.dateTaken ) !=0
			GROUP BY YEAR( x.dateTaken ) , MONTH( x.dateTaken ) , DAY( x.dateTaken )
			ORDER BY x.dateTaken ASC
			)a1, (
			
			SELECT *
			FROM (SELECT * FROM s_files GROUP BY size, filename)x
			WHERE YEAR( x.dateTaken ) !=1601
			AND YEAR( x.dateTaken ) !=0
			GROUP BY YEAR( x.dateTaken ) , MONTH( x.dateTaken ) , DAY( x.dateTaken )
			ORDER BY x.dateTaken ASC
			)a2
			WHERE DATEDIFF( a2.dateTaken, a1.dateTaken )
			BETWEEN -1
			AND 1
			AND a1.id != a2.id
			GROUP BY a1.id
			ORDER BY `a1`.`dateTaken` ASC
			)result
			
			)result2
			GROUP BY sequence
			ORDER BY DATE1 DESC)result3
			WHERE moyenne > ".$averageCount.")";
			
			error_log($queryString);
			$result = mysqli_query($link, $queryString);
			
			$queryString ="SELECT COUNT(*) FROM t_sequences";
		}
	}
	else
	{
		$queryString ="SELECT nbFiles FROM t_sequences WHERE ID2 = ".$imageId;
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		if($row = mysqli_fetch_row($result))
		{
			print($row[0]);
			return;
		}
		else
		{
			$queryString = "SET @seq = 0;";
			$result = mysqli_query($link, $queryString);
			$queryString = "SELECT COUNT(*) FROM (
			SELECT a6.filename AS FILE , a7.name AS Device, a9.name AS Folder, a6.url AS FolderUrl, a6.deviceId, a6.url, a6.storageType, a6.id
			FROM (
			SELECT *
			FROM s_files a4, (SELECT *
			FROM (
			
			SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), SUM(dayCount)/COUNT(*) AS moyenne
			FROM (
			
			SELECT result.ID AS ID1, result.NAME, result.DATE1, if( result.count =1
			AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount
			FROM (
			
			SELECT a1.id AS ID, a1.filename AS NAME, a1.dateTaken AS DATE1, COUNT( * ) AS count, if( (
			DATEDIFF( a2.dateTaken, a1.dateTaken ) !=1 )
			AND a1.id != a2.id, 1, 0
			) AS test, a1.dayCount
			FROM (
			
			SELECT *, COUNT(*) AS dayCount
			FROM s_files
			WHERE YEAR( dateTaken ) !=1601
			AND YEAR( dateTaken ) !=0
			GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
			ORDER BY dateTaken ASC
			)a1, (
			
			SELECT *
			FROM s_files
			WHERE YEAR( dateTaken ) !=1601
			AND YEAR( dateTaken ) !=0
			GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
			ORDER BY dateTaken ASC
			)a2
			WHERE DATEDIFF( a2.dateTaken, a1.dateTaken )
			BETWEEN -1
			AND 1
			AND a1.id != a2.id
			GROUP BY a1.id
			ORDER BY `a1`.`dateTaken` ASC
			)result
			)result2
			GROUP BY sequence
			)a3
			WHERE a3.ID2 =".$imageId.") a5
			WHERE moyenne > 34
			AND a4.dateTaken BETWEEN a5.debut AND a5.fin
			ORDER BY a4.dateTaken DESC ) a6
			INNER JOIN s_devices a7 ON a6.deviceId = a7.id
			INNER JOIN a_folder_file a8 ON a6.id = a8.fileId
			INNER JOIN s_folders a9 ON a8.folderId = a9.id) count";
		}
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

/*function getSequences($imageId, $offset, $count, $excludeParams) //BROWSING
{
	error_log("!!!!!!!!!!! getSequences !!!!!!!!!!!!! ".$imageId);
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$averageCount = getAverageDayCount();
	$averageCount = floor($averageCount * 0.7);
	
	if($imageId == "-1")
	{
		$queryString ="SELECT date FROM t_sequences ORDER BY date ASC LIMIT 0,1";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		if($row = mysqli_fetch_row($result))
		{
			$lastSequenceDate = date('Y-m-d H:i:s', strtotime($row[0]));
			
			$queryString ="SELECT updateDate FROM a_date_file ORDER BY updateDate DESC LIMIT 0,1";
			error_log($queryString);
			$result = mysqli_query($link, $queryString);
			$row = mysqli_fetch_row($result);
			
			$lastRecordDate = date('Y-m-d H:i:s', strtotime($row[0]));
			error_log("LAST RECORD :: ".$lastRecordDate);
			error_log("LAST SEQUENCE :: ".$lastSequenceDate);
			if($lastRecordDate > $lastSequenceDate)
			{
				$queryString ="DROP TABLE t_sequences";
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				$queryString = "SET @seq = 0;";
				$result = mysqli_query($link, $queryString);
			
				$queryString = "CREATE TABLE t_sequences (INDEX id (ID2)) AS (
				SELECT *, NOW() AS date FROM (
				SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), result2.URL2, result2.DEVICEID2, SUM(dayCount2)/COUNT(*) AS moyenne, SUM(dayCount2) AS nbFiles
				FROM (
				
				SELECT result.ID AS ID1, result.NAME, result.DATE1, result.URL AS URL2, result.DEVICEID AS DEVICEID2, if( result.count =1
				AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount2
				FROM (
				
				SELECT a1.id AS ID, a1.filename AS NAME, a1.dateTaken AS DATE1, a1.url AS URL, a1.deviceId AS DEVICEID, COUNT( * ) AS count, if( (
				DATEDIFF( a2.dateTaken, a1.dateTaken ) !=1 )
				AND a1.id != a2.id, 1, 0
				) AS test, a1.dayCount AS dayCount2
				FROM (
				
				SELECT *, COUNT(*) AS dayCount
				FROM s_files
				WHERE YEAR( dateTaken ) !=1601
				AND YEAR( dateTaken ) !=0
				GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
				ORDER BY dateTaken ASC
				)a1, (
				
				SELECT *
				FROM s_files
				WHERE YEAR( dateTaken ) !=1601
				AND YEAR( dateTaken ) !=0
				GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
				ORDER BY dateTaken ASC
				)a2
				WHERE DATEDIFF( a2.dateTaken, a1.dateTaken )
				BETWEEN -1
				AND 1
				AND a1.id != a2.id
				GROUP BY a1.id
				ORDER BY `a1`.`dateTaken` ASC
				)result
				
				)result2
				GROUP BY sequence
				ORDER BY DATE1 DESC)result3";
			
				error_log("PARAM 1 :: ".$excludeParams);
				$excludeParamsArr = explode(",", $excludeParams);
			
				foreach ($excludeParamsArr as $key) {
					error_log("PARAM :: ".$key);
					switch($key)
					{
						case "online":
							$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
				RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id";
							break;
							
					}
				}
			
				$queryString = $queryString . " WHERE moyenne > ".$averageCount.")";
				
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				$queryString ="SELECT * FROM t_sequences";
		
			}
			else {
				$queryString ="SELECT * FROM t_sequences";
			}
		}
		else {
						
				$queryString = "SET @seq = 0;";
				$result = mysqli_query($link, $queryString);
			
				$queryString = "CREATE TABLE t_sequences (INDEX id (ID2)) AS (
				SELECT *, NOW() AS date FROM (
				SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), result2.URL2, result2.DEVICEID2, SUM(dayCount2)/COUNT(*) AS moyenne, SUM(dayCount2) AS nbFiles
				FROM (
				
				SELECT result.ID AS ID1, result.NAME, result.DATE1, result.URL AS URL2, result.DEVICEID AS DEVICEID2, if( result.count =1
				AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount2
				FROM (
				
				SELECT a1.id AS ID, a1.filename AS NAME, a1.dateTaken AS DATE1, a1.url AS URL, a1.deviceId AS DEVICEID, COUNT( * ) AS count, if( (
				DATEDIFF( a2.dateTaken, a1.dateTaken ) !=1 )
				AND a1.id != a2.id, 1, 0
				) AS test, a1.dayCount AS dayCount2
				FROM (
				
				SELECT *, COUNT(*) AS dayCount
				FROM s_files
				WHERE YEAR( dateTaken ) !=1601
				AND YEAR( dateTaken ) !=0
				GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
				ORDER BY dateTaken ASC
				)a1, (
				
				SELECT *
				FROM s_files
				WHERE YEAR( dateTaken ) !=1601
				AND YEAR( dateTaken ) !=0
				GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
				ORDER BY dateTaken ASC
				)a2
				WHERE DATEDIFF( a2.dateTaken, a1.dateTaken )
				BETWEEN -1
				AND 1
				AND a1.id != a2.id
				GROUP BY a1.id
				ORDER BY `a1`.`dateTaken` ASC
				)result
				
				)result2
				GROUP BY sequence
				ORDER BY DATE1 DESC)result3";
				
				error_log("PARAM 2 :: ".$excludeParams);
				$excludeParamsArr = explode(",", $excludeParams);
				
				foreach ($excludeParamsArr as $key) {
					error_log("PARAM :: ".$key);
					switch($key)
					{
						case "online":
							$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
				RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id";
							break;
							
					}
				}
				
				$queryString = $queryString . " WHERE moyenne > ".$averageCount.")";
				
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
				
				$queryString ="SELECT * FROM t_sequences";
			}		
		}
	else
	{
		$queryString = "SET @seq = 0;";
		$result = mysqli_query($link, $queryString);
		$queryString = "SELECT a6.filename AS FILE , a7.name AS Device, a9.name AS Folder, a6.url AS FolderUrl, a6.deviceId, a6.url, a6.storageType, a6.id, a6.dateTaken
		FROM (
		SELECT *
		FROM s_files a4, (SELECT *
		FROM (
		
		SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), SUM(dayCount)/COUNT(*) AS moyenne
		FROM (
		
		SELECT result.ID AS ID1, result.NAME, result.DATE1, if( result.count =1
		AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount
		FROM (
		
		SELECT a1.id AS ID, a1.filename AS NAME, a1.dateTaken AS DATE1, COUNT( * ) AS count, if( (
		DATEDIFF( a2.dateTaken, a1.dateTaken ) !=1 )
		AND a1.id != a2.id, 1, 0
		) AS test, a1.dayCount
		FROM (
		
		SELECT *, COUNT(*) AS dayCount
		FROM s_files
		WHERE YEAR( dateTaken ) !=1601
		AND YEAR( dateTaken ) !=0
		GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
		ORDER BY dateTaken ASC
		)a1, (
		
		SELECT *
		FROM s_files
		WHERE YEAR( dateTaken ) !=1601
		AND YEAR( dateTaken ) !=0
		GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken )
		ORDER BY dateTaken ASC
		)a2
		WHERE DATEDIFF( a2.dateTaken, a1.dateTaken )
		BETWEEN -1
		AND 1
		AND a1.id != a2.id
		GROUP BY a1.id
		ORDER BY `a1`.`dateTaken` ASC
		)result
		)result2
		GROUP BY sequence
		)a3
		WHERE a3.ID2 =".$imageId.") a5
		WHERE moyenne > ".$averageCount."
		AND a4.dateTaken BETWEEN a5.debut AND a5.fin
		ORDER BY a4.dateTaken DESC ) a6
		INNER JOIN s_devices a7 ON a6.deviceId = a7.id
		INNER JOIN a_folder_file a8 ON a6.id = a8.fileId
		INNER JOIN s_folders a9 ON a8.folderId = a9.id";

		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
	}

	error_log("!!!!!!!!!!! ICI !!!!!!!!!!!!!");
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		if($imageId == "-1")
		{
			$output = $output."{
				\"Id\":\"".$row[0]."\",
				\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",
				\"Count\":\"".$row[4]."\",
				\"StartDate\":\"".$row[2]."\",
				\"EndDate\":\"".$row[3]."\",
				\"DeviceId\":\"".$row[6]."\",
				\"ImageUrl\":\"".addslashes($row[5])."\"},";
		}
		else {
			$output = $output."{
				\"Id\":\"".$row[7]."\",
				\"Date\":\"".$row[8]."\",
				\"Name\":\"".$row[0]."\",
				\"Folder\":\"".$row[2]."\",
				\"FolderUrl\":\"".addslashes($row[3])."\",
				\"DeviceId\":\"".$row[4]."\",
				\"DeviceName\":\"".$row[1]."\",
				\"ImageUrl\":\"".addslashes($row[5])."\",
				\"StorageType\":\"".$row[6]."\",
				\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[7] / 1000)."/".$row[7].".jpg")."\"}," ;
		}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}*/

function getSequences($imageId, $offset, $count, $excludeParams) //BROWSING
{
	error_log("!!!!!!!!!!! getSequences !!!!!!!!!!!!! ".$imageId);
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($imageId == "-1")
	{
		$queryString ="SELECT dateTaken, COUNT(dateTaken) FROM s_files WHERE 1 GROUP BY YEAR( dateTaken ) , MONTH( dateTaken ) , DAY( dateTaken ) ORDER BY dateTaken ASC";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
			
	}
	else
	{
		/*$queryString ="SELECT dateTaken FROM s_files WHERE id=".$imageId;
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		*/
		//$queryString = "SELECT filename, deviceId, dateTaken FROM s_files WHERE YEAR( dateTaken ) = YEAR( ".$row[0]." ) AND MONTH( dateTaken ) = MONTH( ".$row[0]." ) AND DAY( dateTaken ) = DAY( ".$row[0]." )";
		$queryString = "SELECT filename, deviceId, dateTaken, id, url FROM s_files WHERE YEAR( dateTaken ) = YEAR( \"".$imageId."\" ) AND MONTH( dateTaken ) = MONTH( \"".$imageId."\" ) AND DAY( dateTaken ) = DAY( \"".$imageId."\" )";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
	}

	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		if($imageId == "-1")
		{
			$output = $output."{
				\"Id\":\"".$row[0]."\",
				\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",
				\"Count\":\"".$row[4]."\",
				\"StartDate\":\"".$row[2]."\",
				\"EndDate\":\"".$row[3]."\",
				\"DeviceId\":\"".$row[6]."\",
				\"ImageUrl\":\"".addslashes($row[5])."\"},";
		}
		else {
			$output = $output."{
				\"Id\":\"".$row[3]."\",
				\"Date\":\"".$row[2]."\",
				\"Name\":\"".$row[0]."\",
				\"Folder\":\"".$row[2]."\",
				\"FolderUrl\":\"".addslashes($row[3])."\",
				\"DeviceId\":\"".$row[1]."\",
				\"DeviceName\":\"".$row[1]."\",
				\"ImageUrl\":\"".getUSBLocalPath(getDeviceHwId($row[1]), addslashes($row[4]))."\",
				\"StorageType\":\"".$row[6]."\",
				\"remoteURL\" :\"".getUSBRemotePath(getDeviceHwId($row[1]), addslashes($row[4]))."\",
				\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[7] / 1000)."/".$row[7].".jpg")."\"}," ;
		}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}


function getSequencesFromDate($date, $offset, $count)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$date = ($date == "now") ? "NOW()" : "'".$date."'" ;
	
	$averageCount = getAverageDayCount();
	
	$queryString = "SET @seq = 0;";
	$result = mysqli_query($link, $queryString);

	$queryString = "SELECT * FROM (
SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * ), result2.URL2, result2.DEVICEID2, SUM(dayCount2)/COUNT(*) AS moyenne
FROM (

SELECT result.ID AS ID1, result.NAME, result.DATE1, result.URL AS URL2, result.DEVICEID AS DEVICEID2, if( result.count =1
AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence, dayCount2
FROM (

SELECT a1.id AS ID, a1.filename AS NAME, a1.dateCreated AS DATE1, a1.url AS URL, a1.deviceId AS DEVICEID, COUNT( * ) AS count, if( (
DATEDIFF( a2.dateCreated, a1.dateCreated ) !=1 )
AND a1.id != a2.id, 1, 0
) AS test, a1.dayCount AS dayCount2
FROM (

SELECT *, COUNT(*) AS dayCount
FROM s_files
WHERE YEAR( dateCreated ) !=1601
AND YEAR( dateCreated ) !=0
GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
ORDER BY dateCreated ASC
)a1, (

SELECT *
FROM s_files
WHERE YEAR( dateCreated ) !=1601
AND YEAR( dateCreated ) !=0
GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
ORDER BY dateCreated ASC
)a2
WHERE DATEDIFF( a2.dateCreated, a1.dateCreated )
BETWEEN -1
AND 1
AND a1.id != a2.id
GROUP BY a1.id
ORDER BY `a1`.`dateCreated` ASC
)result

)result2
GROUP BY sequence
ORDER BY DATE1 DESC)result3
WHERE moyenne > ".$averageCount."
AND MONTH(".$date.") BETWEEN MONTH(debut) AND MONTH(fin)
AND DAY(".$date.") BETWEEN DAY(debut) AND DAY(fin)";

	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{
			\"Id\":\"".$row[0]."\",
			\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",
			\"Count\":\"".$row[4]."\",
			\"StartDate\":\"".$row[2]."\",
			\"EndDate\":\"".$row[3]."\",
			\"DeviceId\":\"".$row[6]."\",
			\"ImageUrl\":\"".addslashes($row[5])."\"},";
		}
	
	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getLastRecords($count)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_files a RIGHT JOIN a_date_file b ON b.fileId = a.id ORDER BY b.date DESC LIMIT 0,10";
	
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getNbSpecialDays() //BROWSING
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$averageCount = 20 * getAverageDayCount();
	
	$queryString = "SET @seq = 0;";
	$result = mysqli_query($link, $queryString);

	$queryString = "SELECT COUNT(*) FROM (SELECT id, dateCreated, deviceId, url, Count(*) FROM s_files WHERE YEAR( dateCreated ) > 1900 GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated ) HAVING COUNT(*) > ".$averageCount.")a";
	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getSpecialDays($offset, $count, $deviceId) //BROWSING
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$averageCount = 20 * getAverageDayCount();
	
	$queryString = "SET @seq = 0;";
	$result = mysqli_query($link, $queryString);

	$queryString = "SELECT id, dateCreated, deviceId, url, Count(*) FROM s_files WHERE YEAR( dateCreated ) > 1900 GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated ) HAVING COUNT(*) > ".$averageCount;
	
	if($deviceId != "")
	{
		$queryString = "SELECT id, dateCreated, deviceId, url, Count(*) FROM s_files WHERE YEAR( dateCreated ) > 1900 AND deviceId=".$deviceId." GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated ) HAVING COUNT(*) > ".$averageCount;
	}
	
	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		
		$output = $output."{
			\"Id\":\"".$row[0]."\",
			\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",
			\"Count\":\"".$row[4]."\",
			\"StartDate\":\"".$row[1]."\",
			\"DeviceId\":\"".$row[2]."\",
			\"ImageUrl\":\"".addslashes($row[3])."\"},";
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getNbMomentDuplicates($imageId) //TOOLS
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($imageId == "-1")
	{
		$queryString = "SET @seq = 0;";
		$result = mysqli_query($link, $queryString);
		$queryString = "SELECT COUNT(*) FROM (
		SELECT ID, NAME, MIN(DATE1), MAX(DATE1), COUNT( * )
		FROM (
		
		SELECT result.ID, result.NAME, result.DATE1, if( result.count =1
		AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence
		FROM (
		
		SELECT a1.id AS ID, a1.filename AS NAME, a1.dateCreated AS DATE1, a2.dateCreated AS DATE2, DATEDIFF( a2.dateCreated, a1.dateCreated ) AS diff, if( (
		DATEDIFF( a2.dateCreated, a1.dateCreated ) !=1 )
		AND a1.id != a2.id, 1, 0
		) AS test, COUNT( * ) AS count
		FROM ( SELECT *
		FROM ( SELECT *
		FROM s_files
		GROUP BY size )t1
		GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
		ORDER BY dateCreated ASC) a1, (SELECT *
		FROM ( SELECT *
		FROM s_files
		GROUP BY size )t2
		GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
		ORDER BY dateCreated ASC) a2
		WHERE DATEDIFF( a2.dateCreated, a1.dateCreated )
		BETWEEN -1
		AND 1
		AND a1.id != a2.id
		GROUP BY a1.id
		ORDER BY `a1`.`dateCreated` ASC
		)result
		)result2
		GROUP BY sequence) count";
	}
else
{
		$queryString = "SET @seq = 0;";
		$result = mysqli_query($link, $queryString);
		$queryString = "SELECT COUNT(*) FROM (
		SELECT a6.filename AS FILE , a7.name AS Device, a9.name AS Folder, a6.url AS FolderUrl, a6.deviceId, a6.url, a6.storageType, a6.id
		FROM (
		SELECT *
		FROM s_files a4, (SELECT *
		FROM (
		
		SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * )
		FROM (
		
		SELECT result.ID AS ID1, result.NAME, result.DATE1, if( result.count =1
		AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence
		FROM (
		
		SELECT a1.id AS ID, a1.filename AS NAME, a1.dateCreated AS DATE1, COUNT( * ) AS count, if( (
		DATEDIFF( a2.dateCreated, a1.dateCreated ) !=1 )
		AND a1.id != a2.id, 1, 0
		) AS test
		FROM (
		
		SELECT *
		FROM s_files
		GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
		ORDER BY dateCreated ASC
		)a1, (
		
		SELECT *
		FROM s_files
		GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
		ORDER BY dateCreated ASC
		)a2
		WHERE DATEDIFF( a2.dateCreated, a1.dateCreated )
		BETWEEN -1
		AND 1
		AND a1.id != a2.id
		GROUP BY a1.id
		ORDER BY `a1`.`dateCreated` ASC
		)result
		)result2
		GROUP BY sequence
		)a3
		WHERE a3.ID2 =".$imageId.") a5
		WHERE a4.dateCreated BETWEEN a5.debut AND a5.fin
		AND UNIX_TIMESTAMP( a4.dateCreated ) BETWEEN UNIX_TIMESTAMP( b.date )-60 AND UNIX_TIMESTAMP( b.date )+60
		ORDER BY a4.dateCreated ) a6
		INNER JOIN s_devices a7 ON a6.deviceId = a7.id
		INNER JOIN a_folder_file a8 ON a6.id = a8.fileId
		INNER JOIN s_folders a9 ON a8.folderId = a9.id) count";
	}
	
error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getMomentDuplicates($imageId, $offset, $count) //TOOLS
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($imageId == "-1")
	{
		$queryString = "SET @seq = 0;";
		$result = mysqli_query($link, $queryString);
	
		$queryString = "SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * )
FROM (

SELECT result.ID AS ID1, result.NAME, result.DATE1, if( result.count =1
AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence
FROM (

SELECT a1.id AS ID, a1.filename AS NAME, a1.dateCreated AS DATE1, COUNT( * ) AS count, if( (
DATEDIFF( a2.dateCreated, a1.dateCreated ) !=1 )
AND a1.id != a2.id, 1, 0
) AS test
FROM (

SELECT *
FROM s_files
GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
ORDER BY dateCreated ASC
)a1, (

SELECT *
FROM s_files
GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
ORDER BY dateCreated ASC
)a2
WHERE DATEDIFF( a2.dateCreated, a1.dateCreated )
BETWEEN -1
AND 1
AND a1.id != a2.id
GROUP BY a1.id
ORDER BY `a1`.`dateCreated` ASC
)result
)result2
GROUP BY sequence";
		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
	}
	else
		{
			$queryString = "SET @seq = 0;";
			$result = mysqli_query($link, $queryString);
			$queryString = "SELECT a6.filename AS FILE , a7.name AS Device, a9.name AS Folder, a6.url AS FolderUrl, a6.deviceId, a6.url, a6.storageType, a6.id
FROM (
SELECT *
FROM s_files a4, (SELECT *
FROM (

SELECT result2.ID1 AS ID2, NAME, MIN( DATE1 ) AS debut, MAX( DATE1 ) AS fin, COUNT( * )
FROM (

SELECT result.ID AS ID1, result.NAME, result.DATE1, if( result.count =1
AND result.test =0, @seq := @seq +1, @seq := @seq ) , @seq AS sequence
FROM (

SELECT a1.id AS ID, a1.filename AS NAME, a1.dateCreated AS DATE1, COUNT( * ) AS count, if( (
DATEDIFF( a2.dateCreated, a1.dateCreated ) !=1 )
AND a1.id != a2.id, 1, 0
) AS test
FROM (

SELECT *
FROM s_files
GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
ORDER BY dateCreated ASC
)a1, (

SELECT *
FROM s_files
GROUP BY YEAR( dateCreated ) , MONTH( dateCreated ) , DAY( dateCreated )
ORDER BY dateCreated ASC
)a2
WHERE DATEDIFF( a2.dateCreated, a1.dateCreated )
BETWEEN -1
AND 1
AND a1.id != a2.id
GROUP BY a1.id
ORDER BY `a1`.`dateCreated` ASC
)result
)result2
GROUP BY sequence
)a3
WHERE a3.ID2 =".$imageId.") a5
WHERE a4.dateCreated BETWEEN a5.debut AND a5.fin
AND UNIX_TIMESTAMP( a4.dateCreated ) BETWEEN UNIX_TIMESTAMP( b.date )-60 AND UNIX_TIMESTAMP( b.date )+60
ORDER BY a4.dateCreated ) a6
INNER JOIN s_devices a7 ON a6.deviceId = a7.id
INNER JOIN a_folder_file a8 ON a6.id = a8.fileId
INNER JOIN s_folders a9 ON a8.folderId = a9.id";

		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
		
		}

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		if($imageId == "-1")
		{
			$output = $output."{\"Id\":\"".$row[0]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",\"Count\":\"".$row[2]."\"},";
		}
else {
	$output = $output."{\"Id\":\"".$row[7]."\",\"Name\":\"".$row[0]."\",\"Folder\":\"".$row[2]."\",\"FolderUrl\":\"".addslashes($row[3])."\",\"DeviceId\":\"".$row[4]."\",\"DeviceName\":\"".$row[1]."\",\"ImageUrl\":\"".addslashes($row[5])."\",\"StorageType\":\"".$row[6]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[7] / 1000)."/".$row[7].".jpg")."\"}," ;
}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}


function getNbNoNameDuplicates() //DEPRECATED because of MD5
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT( * )
FROM s_files a1
INNER JOIN (

SELECT id
FROM s_files
GROUP BY dateCreated, width, height
HAVING COUNT( * ) >1)a2 ON a1.id = a2.id";

	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}

function getNoNameDuplicates($imageId, $offset, $count, $noDNG) //DEPRECATED because of MD5
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($imageId == "-1")
	{
		$queryString = "SELECT id, filename, COUNT( * ) AS total FROM s_files";

		$queryString = $queryString." GROUP BY dateCreated, width, height HAVING COUNT( * ) >1 ORDER BY total DESC";
		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
	}
	else
		{
			$queryString = "SELECT a1.filename AS
FILE , a3.name AS Device, a4.name AS Folder, a4.url AS FolderUrl, a1.deviceId, a1.url, a1.storageType, a1.id
FROM s_files a1
RIGHT JOIN (

SELECT dateCreated, width, height
FROM s_files
WHERE id=".$imageId."
)a2 ON a1.dateCreated = a2.dateCreated
AND a1.width = a2.width
AND a1.height = a2.height
INNER JOIN s_devices a3 ON a1.deviceId = a3.id
INNER JOIN s_folders a4 ON a1.folderId = a4.id";
		}

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		if($imageId == "-1")
		{
			$output = $output."{\"Id\":\"".$row[0]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",\"Count\":\"".$row[2]."\"},";
		}
else {
	$output = $output."{\"Id\":\"".$row[7]."\",\"Name\":\"".$row[0]."\",\"Folder\":\"".$row[2]."\",\"FolderUrl\":\"".addslashes($row[3])."\",\"DeviceId\":\"".$row[4]."\",\"ImageUrl\":\"".addslashes($row[5])."\",\"StorageType\":\"".$row[6]."\",\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[7] / 1000)."/".$row[7].".jpg")."\"}," ;
}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getNbMultiSizeDuplicates()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT( * ) AS total FROM ( SELECT * FROM s_files
					GROUP BY DAY( dateCreated ) , MONTH( dateCreated ) , YEAR( dateCreated ) , HOUR( dateCreated ) , MINUTE( dateCreated )
					HAVING COUNT( * ) >1
					)a1
					ORDER BY total DESC ";

	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}

function getMultiSizeDuplicates()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT a1.filename AS
	FILE , a3.name AS Device, a1.url AS Url, a1.deviceId, a1.id
	FROM s_files a1
	RIGHT JOIN (
	SELECT *
	FROM s_files
	GROUP BY filename, dateCreated
	HAVING COUNT( * ) >1
	)a2 ON a1.filename = a2.filename
	AND a1.dateCreated = a2.dateCreated
	AND a1.width != 0
	AND a1.height != 0
	RIGHT JOIN s_devices a3 ON a2.deviceId = a3.id";
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Filename\":\"".$row[0]."\",\"Url\":\"".$row[2]."\",\"DeviceName\":\"".$row[1]."\",\"DeviceId\":\"".$row[3]."\",\"ThumbUrl\":\"".$row[4]."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getNbNearDateDuplicates($noDuplicates) //No duplicates a tester
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	/*
	$queryString = "SELECT COUNT( * ) AS total FROM ( SELECT * FROM s_files
					GROUP BY DAY( dateCreated ) , MONTH( dateCreated ) , YEAR( dateCreated ) , HOUR( dateCreated ) , MINUTE( dateCreated )
					HAVING COUNT( * ) >1
					)a1
					ORDER BY total DESC ";
	 * */
				
	$queryString = "SELECT COUNT(*) FROM (SELECT a.id, a.filename AS N, COUNT( * ) AS total, a.dateCreated, a.size as S
	FROM (

	SELECT *
	FROM s_files
	GROUP BY dateCreated
	HAVING COUNT(*) = 1
	)a
	GROUP BY UNIX_TIMESTAMP( a.dateCreated )
	DIV 120
	HAVING COUNT( * ) >1
	ORDER BY a.dateCreated ASC) b";
	
	if($noDuplicates == "true")
	{
		$queryString = $queryString . " GROUP BY S, N";
		//$queryString = $queryString . " GROUP BY MD5";
	}

	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}

function getNearDateDuplicates($imageId, $offset, $count) //OK
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($imageId == "-1")
	{
		/*
		$queryString = "SELECT id, filename, COUNT( * ) AS total, dateCreated FROM s_files
						GROUP BY DAY( dateCreated ) , MONTH( dateCreated ) , YEAR( dateCreated ), HOUR(dateCreated), MINUTE(dateCreated)
						HAVING COUNT( * ) >1 ORDER BY total DESC";
		 * */
					
					
		
		/*
		 * SELECT MAX(a.dateTaken), MIN(a.dateTaken), COUNT(*) FROM (SELECT * FROM `s_files` GROUP BY dateTaken)a GROUP BY (a.dateTaken + 77) DIV 200 HAVING COUNT(*) > 1
		 * */
			
		$queryString = "SELECT a.id, a.filename, COUNT( * ) AS total, a.dateTaken, a.deviceId, a.url
		FROM (

		SELECT *
		FROM s_files
		GROUP BY size
		)a
		RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4 RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a.deviceId = a6.id
		GROUP BY UNIX_TIMESTAMP( a.dateTaken )
		DIV 1200
		HAVING COUNT( * ) >1
		ORDER BY total DESC";
		
				
		//$queryString = $queryString." RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4 RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a.deviceId = a6.id";				
			
		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
	}
	else
	{
		$queryString = "SELECT a.filename AS FILE , b.name AS Device, b.name AS Folder, a.url AS FolderUrl, a.deviceId, a.url, a.storageType, a.id, a.dateTaken, a.dateTaken 
		FROM (SELECT * FROM s_files GROUP BY size) a
		RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4 RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a.deviceId = a6.id
		INNER JOIN s_devices b ON a.deviceId = b.id
		WHERE UNIX_TIMESTAMP( a.dateTaken ) 
		BETWEEN UNIX_TIMESTAMP( (SELECT dateTaken FROM s_files WHERE id=".$imageId.") )-1200 AND UNIX_TIMESTAMP( (SELECT dateTaken FROM s_files WHERE id=".$imageId.") )+1200
		ORDER BY a.filename ASC";
		/*
		$queryString = "SELECT a.filename AS FILE , b.name AS Device, d.name AS Folder, d.url AS FolderUrl, a.deviceId, a.url, a.storageType, a.id, a.dateCreated, a.dateCreated 
		FROM s_files a 
		INNER JOIN s_devices b ON a.deviceId = b.id
		INNER JOIN a_folder_file c ON a.id = c.fileId
		INNER JOIN s_folders d ON c.folderId = d.id
		WHERE UNIX_TIMESTAMP( a.dateCreated ) 
		BETWEEN UNIX_TIMESTAMP( (SELECT dateCreated FROM s_files WHERE id=".$imageId.") )-60 AND UNIX_TIMESTAMP( (SELECT dateCreated FROM s_files WHERE id=".$imageId.") )+60
		ORDER BY a.filename ASC";
		*/
		/*
		$queryString = "SELECT c.filename AS FILE , d.name AS Device, f.name AS Folder, f.url AS FolderUrl, c.deviceId, c.url, c.storageType, c.id
FROM
(SELECT *
FROM (

SELECT *
FROM s_files
GROUP BY size
)a, (

SELECT dateCreated AS date
FROM s_files
WHERE id =".$imageId."
GROUP BY size
)b
WHERE UNIX_TIMESTAMP( a.dateCreated ) BETWEEN UNIX_TIMESTAMP( b.date )-60 AND UNIX_TIMESTAMP( b.date )+60
ORDER BY a.dateCreated ASC) c
INNER JOIN s_devices d ON c.deviceId = d.id
INNER JOIN a_folder_file e ON c.id = e.fileId
INNER JOIN s_folders f ON e.folderId = f.id";
		
		*/
	}
	
	error_log($queryString);
	
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		if($imageId == "-1")
		{
			$output = $output."{\"DuplicateType\":\"nearDate\",
			\"Id\":\"".$row[0]."\",
			\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg")."\",
			\"Count\":\"".$row[2]."\",
			\"dateCreated\":\"".$row[3]."\",
			\"DeviceId\":\"".getDeviceHwId($row[4])."\",
			\"ImageUrl\":\"".getUSBLocalPath(getDeviceHwId($row[4]), addslashes($row[5]))."\"},";
		}
		else {
			$output = $output."{\"DuplicateType\":\"nearDate\",
			\"Id\":\"".$row[7]."\",
			\"Name\":\"".$row[0]."\",
			\"dateCreated\":\"".$row[8]."\",
			\"DateCreated\":\"".$row[9]."\",
			\"FolderName\":\"".$row[2]."\",
			\"FolderUrl\":\"".addslashes($row[3])."\",
			\"DeviceId\":\"".getDeviceHwId($row[4])."\",
			\"DeviceName\":\"".$row[1]."\",
			\"ImageUrl\":\"".getUSBLocalPath(getDeviceHwId($row[4]), addslashes($row[5]))."\",
			\"remoteURL\":\"".getUSBRemotePath(getDeviceHwId($row[4]), addslashes($row[5]))."\",
			\"localPath\":\"".getUSBLocalPath(getDeviceHwId($row[4]), addslashes($row[5]))."\",
			\"StorageType\":\"".$row[6]."\",
			\"ThumbUrl\":\"".addslashes("http://sunnyv1.local/ressources/thumbs/".floor($row[7] / 1000)."/".$row[7].".jpg")."\"}," ;
		}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getNearPlaceDuplicates()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT a1.filename, a1.latitude, a1.longitude
	FROM s_files a1
	RIGHT JOIN (
	SELECT *
	FROM s_files
	GROUP BY latitude, longitude HAVING COUNT(*) > 1
	) a2 ON a1.latitude = a2.latitude
	AND a1.longitude = a2.longitude
	AND a1.latitude !=0
	AND a1.longitude !=0";
	$result = mysqli_query($link, $queryString);

	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Filename\":\"".$row[0]."\",\"latitude\":\"".$row[1]."\",\"logitude\":\"".$row[2]."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getDeviceTypes()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM d_hardware_types WHERE 1";
	$result = mysqli_query($link, $queryString);
	
	$types = Array() ;
	$i = 0 ;
	while ($row = mysqli_fetch_row($result))
	{
		$types[$i]['id'] = $row[0];
		$types[$i]['name'] = $row[1];
		$i++;
	}
	
	outputNameValue($types);
	
}

function getOwners()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_users WHERE 1";
	$result = mysqli_query($link, $queryString);
	
	$users = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$users[$i]['id'] = $row[0];
		$users[$i]['name'] = $row[1];
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	outputNameValue($users);
}

function getGroups()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_groups WHERE 1";
	$result = mysqli_query($link, $queryString);
	
	$users = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$users[$i]['id'] = $row[0];
		$users[$i]['name'] = $row[1];
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	outputNameValue($users);
}

function getRights()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM d_file_rights WHERE 1";
	$result = mysqli_query($link, $queryString);
	
	$users = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$users[$i]['id'] = $row[0];
		$users[$i]['name'] = $row[1];
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	outputNameValue($users);
}

function api_getUsers()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_users WHERE 1";
	$result = mysqli_query($link, $queryString);
	
	$users = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$users[$i]['id'] = $row[0];
		$users[$i]['name'] = $row[1];
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($users) ; $i++)
	{
		$output = $output."{\"Id\":\"".$users[$i]['id']."\",\"Name\":\"".$users[$i]['name']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function api_checkLoginPassword($login, $password)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_users WHERE name=\"".$login."\" AND password=\"".$password."\"";
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	if($row)
	{
		print ($row[0]);
	}
	else {
		print("KO");
	}
	mysqli_free_result($result);
	mysqli_close($link);
}

function api_createUser($name, $password)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "INSERT INTO s_users (name, password) VALUES (\"".$name."\", \"".$password."\")";
	$result = mysqli_query($link, $queryString);
	
	//print ("OK");
	
	mysqli_close($link);
}

function getBooks()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	//TO DO
}

function createGroup()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "INSERT INTO s_groups (name) VALUES (\"".$_GET['groupName']."\")";
	$result = mysqli_query($link, $queryString);
	
	//print ("OK");
	
	mysqli_close($link);
}

function getBackupDrive()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_devices WHERE backup = 1";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	if($row = mysqli_fetch_row($result))
	{
		$deviceId = $row[0];
		$deviceName = $row[1];
		$deviceType = $row[3];
		$deviceScreenWidth = $row[4];
		$deviceScreenHeight = $row[5];
		$user = $row[6];
		$pwd = $row[7];

		$output = "{\"Id\":\"".$deviceId."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$macAdress."\",
				\"User\":\"".$user."\",
				\"Pwd\":\"".$pwd."\",
				\"Type\":\"".$deviceType."\"}";
				
		print($output);
	}
	else {
		print("KO");
	}
}

function getThumb($imgId)
{
	setServerState(1);
	
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT url, deviceId, MD5, size FROM s_files WHERE id = ".$imgId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	$deviceHwId = getDeviceHwId($row[1]);
	
	if(isDeviceOnline($deviceHwId))
	{
		$imgUrl = getMountPointFromDeviceId($deviceHwId).$row[0];
		$MD5 = $row[2];
		$size = $row[3];
		
		$key = ftok("/var/www/sunnyweb.php", "c");
		$sem_identifier = sem_get($key);
		sem_acquire($sem_identifier);
		/*
		$netwokDeviceIp = isNetworkDeviceOnline($deviceHwId);
		if($netwokDeviceIp != null)
		{
			print(str_replace("/mnt/","http://sunnyv1.local/ressources/", $imgUrl));
		}
		else {
			error_log("IMG URL :: ".str_replace("/mnt/","http://sunnyv1.local/ressources/usb", $imgUrl));
			print(str_replace("/mnt/","http://sunnyv1.local/ressources/usb", $imgUrl));
		}
		*/
		print(makeThumbConvert($imgUrl, $imgId));
		
		sem_release($sem_identifier);
		
		
		if(getFileType($imgId) == "image")
		{
			$queryString = "INSERT INTO a_file_thumb (fileId, thumb, MD5) VALUES (".$imgId.",1,\"".$MD5."\")";
		}
		else {
			$queryString = "INSERT INTO a_file_thumb (fileId, thumb, MD5) VALUES (".$imgId.",1,\"".$size."\")";
		}
		
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		mysqli_close($link);
	}
	else
	{
		print("");
	}
	setServerState(0);
}

function getSmartImage()
{
	$deviceId = $_GET['deviceId'];
	$imgUrl = $_GET['url'];
	error_log("GET SMART IMAGE :: ".$imgUrl);
	
	if($_GET['makeThumb'] == "true")
	{
		$newWidth = 300;
	}
	else {
		$newWidth = getDeviceScreenWidth($deviceId);
	}
	
	error_log("WIDTH :: ".$newWidth);
	$newUrl = imgResize($imgUrl, $newWidth);
	error_log("IMAGE READY :: ".$newUrl);
	print($newUrl);
}

function getSmartUsbImage()
{
	$deviceId = $_GET['deviceId'];
	$deviceHwId = $_GET['deviceHwId'];
	$imgUrl = $_GET['url'];
	$localPath = $_GET['localPath'];
	
	if($deviceId == null)
	{
		$deviceId = getDeviceId($deviceHwId);
	}
	if($deviceHwId == null)
	{
		$deviceHwId = getDeviceHwId($deviceId);
	}
	
	$mountPoint = getMountPointFromDeviceId($deviceHwId);
	error_log("MOUNT POINT :: ".$mountPoint);
	$savedUrl = str_replace($mountPoint, "", $localPath);
	$savedUrl = str_replace("/", "%", $savedUrl);
	error_log("SAVED URL :: ".$savedUrl);
	
	
	error_log("DEVICE HWID :: ".$deviceHwId);
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT id FROM s_files WHERE url LIKE '%".$savedUrl."' AND deviceId = ".$deviceId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$row = mysqli_fetch_row($result);
	if($row)
	{
		//$publicDirectory = "http://sunnyv1.local/ressources/" ;
		$publicDirectory = "http://sunnyv1.local/ressources/" ;
 		 
		print($publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg");
	}
	else {
		
	
	
	$imgUrl = ($localPath != "") ? $localPath : str_replace("http://sunnyv1.local/ressources/usb", "/mnt/", $imgUrl);
	
	error_log("GET SMART IMAGE :: ".$imgUrl);
	
	if($_GET['makeThumb'] == "true")
	{
		$newWidth = 300;
	}
	else {
		$newWidth = getDeviceScreenWidth($deviceId);
	}
	
	error_log("WIDTH :: ".$newWidth);
	$newUrl = imgResize($imgUrl, $newWidth);
	error_log("IMAGE READY :: ".$newUrl);
	print($newUrl);
	}
}

function getDistantUrl()
{
	$deviceId = $_GET['deviceId'];
	$imgUrl = $_GET['url'];
	
	if($deviceHwId == null)
	{
		$deviceHwId = getDeviceHwId($deviceId);
	}
	
	$mountPoint = getMountPointFromDeviceId($deviceHwId);
	error_log("MOUNT POINT :: ".$mountPoint);
	
	if(strstr($mountPoint, "sd"))
	{
		$newUrl = str_replace("/mnt/", "http://sunnyv1.local/ressources/usb", $mountPoint).$imgUrl;
	}
	else {
		$newUrl = str_replace("/mnt/", "http://sunnyv1.local/ressources/", $mountPoint).$imgUrl;
	}
	
	
	error_log("GET DISTANT URL :: ".$newUrl);
	
	print($newUrl);
}

function getDownloadUrl($imgId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT a1.filename, a1.url, a2.hardwareId FROM s_files a1 RIGHT JOIN s_devices a2 ON a1.deviceId = a2.id WHERE a1.id =".$imgId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$row = mysqli_fetch_row($result);
	
	transfertImage(getMountPointFromDeviceId($row[2]).$row[1], $row[0]);
	
	print("http://sunnyv1.local/ressources/transfert/".$row[0]);
	
	mysqli_close($link);
}

function getUsbImg()
{
	$key = ftok("/var/www/sunnyweb.php", "a");
	$sem_identifier = sem_get($key);
	sem_acquire($sem_identifier);
	
	$imgUrl = $_GET['usbThumb'];
	$newWidth = 200;
	$newPath = "/var/www/html/ressources/temp/";
	
	$imgPath = imgResize($imgUrl, $newWidth, $newPath);
	print($imgPath);
	
	sem_release($sem_identifier);
}

function getUsbFilesToBrowse()
{
	$folderPath = $_GET['folderPath'];	
	$folders = browseFolder($folderPath, []);
	$deviceHwId = getDeviceHwId(getDeviceIdFromLocalPath($folderPath));
	$output = "[";
	foreach ($folders as $folder)
	{
		error_log("FOLDER DANS SUNNYWEB :: ".$folder['url']);
		if($folder['url'] != "" && $folder['url'] != null 
		&& !( $folder['type'] == "folder" && ($folder['imgNb'] == "0" && $folder['videoNb'] == "0") && $folder['subfolderNb'] == "0"))
		{
			//error_log("FOLDER URL :: ".$folder['url']);
			//error_log("DEVICE ID :: ".$deviceId);
			//$isSynchro = isUsbFolderSynchro($folder['url'], $deviceId);
			//$isSynchro = ($isSynchro == "" || $isSynchro == null) ? false: $isSynchro;
			$localPath = ($folder['type'] == "folder") ? $folder['url']."/" : $folder['url'] ;
			$distantPath = "http://sunnyv1.local/ressources/usb".substr(getMountPointFromDeviceId($deviceHwId), 5).substr($localPath, 9);
			$output = $output."{
				\"localPath\":\"".$localPath."\",
				\"name\":\"".$folder['name']."\",
				\"folderName\":\"".$folder['name']."\",
				\"source\":\"usb\",
				\"deviceHwId\":\"".$deviceHwId."\",
				\"videosCount\":\"".$folder['videoNb']."\",
				\"imagesCount\":\"".$folder['imgNb']."\",
				\"foldersCount\":\"".$folder['subfolderNb']."\",
				\"distantPath\":\"".$distantPath."\",
				\"type\":\"".$folder['type']."\"}," ;
		}
	}
	

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getBoxBackup()
{
	getUsbFoldersToBrowse("/var/www/ressources/boxUserStorage/", "backup", null);	
}

function getUsbFoldersToBrowse($folderPath, $folderName, $deviceHwId)
{
	error_log("GET USB FOLDERS TO BROWSE");
	$folderPath = ($folderPath == null) ? $_GET['folderPath'] : $folderPath ;
	$folderName = ($folderName == null) ? $_GET['folderName'] : $folderName ;
	$deviceHwId = ($deviceHwId == null) ? $_GET['deviceId'] : $deviceHwId ;
	$deviceId = getDeviceId($deviceHwId);
	$baseDistantPath = "http://sunnyv1.local/ressources/usb".substr(getMountPointFromDeviceId($deviceHwId), 5);
	
	$folders = browseFolder($folderPath, [], $_GET['isRecursive'], $_GET['isFileonly']);
	
	$output = "[";
	foreach ($folders as $folder)
	{
		//error_log("FOLDER DANS SUNNYWEB :: ".$folder['url']);
		if($folder['url'] != "" && $folder['url'] != null 
		&& !( $folder['type'] == "folder" && ($folder['imgNb'] == "0" && $folder['videoNb'] == "0") && $folder['subfolderNb'] == "0"))
		{
			//error_log("FOLDER URL :: ".$folder['url']);
			//error_log("DEVICE ID :: ".$deviceId);
			//$isSynchro = isUsbFolderSynchro($folder['url'], $deviceId);
			//$isSynchro = ($isSynchro == "" || $isSynchro == null) ? false: $isSynchro;
			$localPath = ($folder['type'] == "folder") ? $folder['url']."/" : $folder['url'] ;
			$distantPath = (strstr($localPath, "/mnt/") != false) ? $baseDistantPath.substr($localPath, 9) : substr($baseDistantPath,0,20).substr($localPath, 9) ;
			$output = $output."{
				\"localPath\":\"".$localPath."\",
				\"name\":\"".$folder['name']."\",
				\"folderName\":\"".$folder['name']."\",
				\"source\":\"distantUsb\",
				\"deviceHwId\":\"".$deviceHwId."\",
				\"videosCount\":\"".$folder['videoNb']."\",
				\"imagesCount\":\"".$folder['imgNb']."\",
				\"foldersCount\":\"".$folder['subfolderNb']."\",
				\"distantPath\":\"".$distantPath."\",
				\"type\":\"".$folder['type']."\"}," ;
		}
	}
	

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}


function getUsbFoldersToScan()
{
	error_log("GET USB FOLDERS TO SCAN");
	$deviceHwId = $_GET['deviceId'];
	$folderDepth = $_GET['folderDepth'];
	$deviceId = getDeviceId($deviceHwId);
	$folders = [];
	
	error_log("&&&&&&&&&&&&&&&&&&&&&&&& MOUT POINT :: ".getMountPointFromDeviceId($deviceHwId)."/");
	
	$folders = getFoldersFromPath(getMountPointFromDeviceId($deviceHwId)."/", getDeviceName($deviceHwId), $folders, $folderDepth);

	$output = "[";
	foreach ($folders as $folder)
	{
		//error_log("FOLDER DANS SUNNYWEB :: ".$folder['url']);
		if($folder['url'] != "" && $folder['url'] != null /*&& $folder['thumb'] != ""*/)
		{
			//error_log("FOLDER URL :: ".$folder['url']);
			error_log("DEVICE ID :: ".$deviceId);
			//$isSynchro = isUsbFolderSynchro($folder['url'], $deviceId);
			//$isSynchro = ($isSynchro == "" || $isSynchro == null) ? false: $isSynchro;
			$output = $output."{
				\"folderUrl\":\"".$folder['url']."\",
				\"localPath\":\"".$folder['url']."\",
				\"folderName\":\"".$folder['name']."\",
				\"name\":\"".$folder['name']."\",
				\"type\":\"folder\",
				\"folderType\":\"usb\",
				\"source\":\"distantUsb\",
				\"deviceHwId\":\"".$deviceHwId."\",
				\"foldersCount\":\"".$folder['foldersCount']."\",
				\"videosCount\":\"".$folder['videosCount']."\",
				\"imagesCount\":\"".$folder['imagesCount']."\"}," ;	//\"isSynchronized\":".$isSynchro.",
		}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getRemoteFoldersToBrowse($folderPath, $folderName, $deviceHwId)
{
	error_log("GET REMOTE FOLDERS TO BROWSE");
	$folderPath = ($folderPath == null) ? $_GET['folderPath'] : $folderPath ;
	$folderName = ($folderName == null) ? $_GET['folderName'] : $folderName ;
	$deviceHwId = ($deviceHwId == null) ? $_GET['deviceId'] : $deviceHwId ;
	$deviceId = getDeviceId($deviceHwId);
	$baseDistantPath = "http://sunnyv1.local/ressources/".getDeviceIp($deviceHwId);
	$folders = browseFolder($folderPath, [], $_GET['isRecursive'], $_GET['isFileonly']);
	
	$output = "[";
	foreach ($folders as $folder)
	{
		error_log("FOLDER DANS SUNNYWEB :: ".$folder['url']);
		if($folder['url'] != "" && $folder['url'] != null)
		{
			//error_log("FOLDER URL :: ".$folder['url']);
			//error_log("DEVICE ID :: ".$deviceId);
			//$isSynchro = isUsbFolderSynchro($folder['url'], $deviceId);
			//$isSynchro = ($isSynchro == "" || $isSynchro == null) ? false: $isSynchro;
			$localPath = ($folder['type'] == "folder") ? $folder['url']."/" : $folder['url'] ;
			$distantPath = (strstr($localPath, "/mnt/") != false) ? $baseDistantPath.substr($localPath, 9) : substr($baseDistantPath,0,20).substr($localPath, 9) ;
			$output = $output."{
				\"localPath\":\"".$localPath."\",
				\"name\":\"".$folder['name']."\",
				\"folderName\":\"".$folder['name']."\",
				\"source\":\"distantUsb\",
				\"deviceHwId\":\"".$deviceHwId."\",
				\"videosCount\":\"".$folder['videoNb']."\",
				\"imagesCount\":\"".$folder['imgNb']."\",
				\"foldersCount\":\"".$folder['subfolderNb']."\",
				\"distantPath\":\"".$distantPath."\",
				\"type\":\"".$folder['type']."\"}," ;
		}
	}
	

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getRemoteFoldersToScan()
{
	error_log("GET USB FOLDERS TO SCAN");
	$deviceHwId = $_GET['deviceId'];
	$folderDepth = $_GET['folderDepth'];
	$deviceId = getDeviceId($deviceHwId);
	$folders = [];
	
	error_log("&&&&&&&&&&&&&&&&&&&&&&&& MOUT POINT :: ".getMountPointFromDeviceId($deviceHwId)."/");
	
	$folders = getFoldersFromPath(getMountPointFromDeviceId($deviceHwId)."/", getDeviceName($deviceHwId), $folders, $folderDepth);

	$output = "[";
	foreach ($folders as $folder)
	{
		//error_log("FOLDER DANS SUNNYWEB :: ".$folder['url']);
		if($folder['url'] != "" && $folder['url'] != null /*&& $folder['thumb'] != ""*/)
		{
			//error_log("FOLDER URL :: ".$folder['url']);
			error_log("DEVICE ID :: ".$deviceId);
			//$isSynchro = isUsbFolderSynchro($folder['url'], $deviceId);
			//$isSynchro = ($isSynchro == "" || $isSynchro == null) ? false: $isSynchro;
			$output = $output."{
				\"folderUrl\":\"".$folder['url']."\",
				\"localPath\":\"".$folder['url']."\",
				\"folderName\":\"".$folder['name']."\",
				\"name\":\"".$folder['name']."\",
				\"type\":\"folder\",
				\"folderType\":\"usb\",
				\"source\":\"distantUsb\",
				\"deviceHwId\":\"".$deviceHwId."\",
				\"foldersCount\":\"".$folder['foldersCount']."\",
				\"videosCount\":\"".$folder['videosCount']."\",
				\"imagesCount\":\"".$folder['imagesCount']."\"}," ;	//\"isSynchronized\":".$isSynchro.",
		}
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function browseUsbFolder()
{
	error_log("BROWSE USB FOLDER");
	$deviceHwId = $_GET['deviceId'];
	$deviceId = getDeviceId($deviceHwId);
	$folders = [];
	
	$folders = getFoldersFromPath(getMountPointFromDeviceId($deviceHwId)."/", "root", $folders, "true");

	$folderPath = $_GET['folderPath'];
	$files = [];
	$isRecursive = ($isRecursive == "true" || $_GET['isRecursive']) ? true : false;
	$isFlat = ($isFlat == "true" || $_GET['isFlat']) ? true : false;
	$allFiles = getFilesFromPath($folderPath, $files, $isRecursive, $isFlat);

	$output = "[";
	foreach ($allFiles as $key => $value)
	{
		$scannedFolder = str_replace(substr($key, 0, 9), "http://sunnyv1.local/ressources/usb".substr($key, 5, 4), $key);
		if(is_array($value) && count($value) > 0)
		{
			foreach ($value as $key2 => $value2)
			{
				
				error_log("FILE DANS SUNNYWEB :: ".$scannedFolder.$value2);
				$output = $output."{
					\"Name\":\"".$value2."\",\"ThumbUrl\":\"".$scannedFolder.$value2."\"}," ;
			}
		}	
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
}

function getDeviceMac()
{
	$ipAddress=$_SERVER['REMOTE_ADDR'];
	print(getDeviceMacFromIp($ipAddress));
}

function getDeviceByHwId($deviceHwId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT * FROM s_devices WHERE hardwareId=\"".$deviceHwId."\" OR serialId = ".$deviceHwId;
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($row = mysqli_fetch_row($result))
	{
		$deviceId = $row[0];
		$deviceName = $row[1];
		$deviceType = $row[3];
		$deviceScreenWidth = $row[4];
		$deviceScreenHeight = $row[5];

		$output = "{\"Id\":\"".$deviceId."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$deviceHwId."\",
				\"Type\":\"".$deviceType."\"}";
				
		print($output);
	}
	else {
		$deviceId = addUsbDevice($deviceHwId, "USB");
		
	}
	
}

function getDeviceById($deviceId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT * FROM s_devices WHERE hardwareId=\"".$deviceId."\"";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($row = mysqli_fetch_row($result))
	{
		$deviceId = $row[0];
		$deviceName = $row[1];
		$deviceType = $row[3];
		$deviceScreenWidth = $row[4];
		$deviceScreenHeight = $row[5];
		$user = $row[6];
		$pwd = $row[7];

		$output = "{\"Id\":\"".$deviceId."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$macAdress."\",
				\"User\":\"".$user."\",
				\"Pwd\":\"".$pwd."\",
				\"Type\":\"".$deviceType."\"}";
				
		print($output);
	}
	else {
		print("KO");
	}
	
}

function getDevice()
{
	$macAdress = getDeviceMacFromIp($_SERVER['REMOTE_ADDR']);
	
	$output = getExistingDevice($macAdress);
	/*
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT * FROM s_devices WHERE hardwareId=\"".$macAdress."\"";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	*/
	error_log("OUTPUT :: ".$output);
	if($output != null)
	{
		$outputJson = "{\"Id\":\"".$output["deviceId"]."\",
				\"Name\":\"".$output["deviceName"]."\",
				\"HwId\":\"".$macAdress."\",
				\"Type\":\"".$output["deviceType"]."\",
				\"ScreenWidth\":\"".$output["deviceScreenWidth"]."\",
				\"ScreenHeight\":\"".$output["deviceScreenHeight"]."\"}";
				
		print($outputJson);
	}
	else {
		print("KO");
		//addDevice();
	}
}

function getBox()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT a1.id, a1.name, a1.hardwareId, a1.hardwareType, a1.screenWidth, a1.screenHeight, a2.label FROM s_devices a1 LEFT JOIN d_hardware_types a2 ON a1.hardwareType = a2.id WHERE a1.hardwareType = 0";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$devices = Array();
	$i=0;
	while($row = mysqli_fetch_row($result))
	{
		$devices[$i]['Id'] = $row[0];
		$devices[$i]['Name'] = $row[1];
		$devices[$i]['HwId'] = $row[2];
		$devices[$i]['Type'] = $row[3];
		$devices[$i]['FriendlyType'] = $row[6];
		$devices[$i]['ScreenWidth'] = $row[4];
		$devices[$i]['ScreenHeight'] = $row[5];
		$i++;
	}

	
	$output = "[";
	for ($i=0; $i < count($devices) ; $i++)
	{
		$output = $output."{\"Id\":\"".$devices[$i]['Id']."\",\"Name\":\"".$devices[$i]['Name']."\",\"HwId\":\"".$devices[$i]['HwId']."\",\"Type\":\"".$devices[$i]['Type']."\",\"FriendlyType\":\"".$devices[$i]['FriendlyType']."\",\"ScreenWidth\":\"".$devices[$i]['ScreenWidth']."\",\"ScreenHeight\":\"".$devices[$i]['ScreenHeight']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getAvailableNetworkDevices()
{
	$ids = "";
	$devices = getNetworkDrives();
	if(count($devices) == 0)
	{
		print("[]");
		return;
	}
	
	$output = "[";
	
	foreach($devices as $device)
	{
		error_log("TRY MOUNT device :: ".$device['HWID'] ." :: ". $device['IP']);
		if(!mountRemoteDrive($device['HWID'], $device['IP']))
		{
			$output = $output."{
			\"Name\":\"".$device['LABEL']."\",
			\"MountPoint\":\"".$device['MOUNT']."\",
			\"Type\":\"17\",
			\"FriendlyType\":\"Remote\",
			\"HwId\":\"".$device['HWID']."\"}," ;
		}
	}
	
	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
}

function getKnownAvailableNetworkDevices()
{
	$ids = "";
	$devices = getKnownNetworkDrives();
	if(count($devices) == 0)
	{
		print("[]");
		return;
	}
	
	$output = "[";
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	foreach($devices as $device)
	{
		error_log("TRY MOUNT device :: ".$device['HWID'] ." :: ". $device['IP']);
		if(mountRemoteDrive($device['HWID'], $device['IP']))
		{	
			$queryString = "SELECT name FROM s_devices WHERE hardwareType = 17 AND hardwareId = \"".$device['HWID']."\"";
			
		
			error_log($queryString);
			$result = mysqli_query($link, $queryString);
			$row = mysqli_fetch_row($result);
			error_log("DRIVE MOUNT :: ".$device['MOUNT']);
			$output = $output."{
			\"RawName\":\"".$device['LABEL']."\",
			\"Name\":\"".$row[0]."\",
			\"MountPoint\":\"".$device['MOUNT']."\",
			\"Type\":\"17\",
			\"FriendlyType\":\"Remote\",
			\"HwId\":\"".$device['HWID']."\"}," ;
		}
	}
	
	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
}

function getAvailableUsbDevices()
{
	$ids = "";
	$devices = getUsbDevices();
	if(count($devices) == 0)
	{
		print("[]");
		return;
	}
	
	foreach($devices as $device)
	{
		$ids = $ids."\"".$device['ID']."\",";
	} 
	$ids = trim($ids, ",");
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT a1.id, a1.name, a1.hardwareId, a1.hardwareType, a1.screenWidth, a1.screenHeight, a2.label FROM s_devices a1 LEFT JOIN d_hardware_types a2 ON a1.hardwareType = a2.id WHERE hardwareId IN (".$ids.") OR serialId IN (".$ids.")";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$devicesOut = Array();
	$i=0;
	while($row = mysqli_fetch_row($result))
	{
		$mountPoint = "/mnt/".$devices[$i]['MOUNT']."/";
		$devicesOut[$i]['Id'] = $row[0];
		$devicesOut[$i]['Name'] = $row[1];
		$devicesOut[$i]['MountPoint'] = $mountPoint ;
		$devicesOut[$i]['FreeDisk'] = getUSBDiskUsage($mountPoint);
		$devicesOut[$i]['HwId'] = $row[2];
		$devicesOut[$i]['Type'] = $row[3];
		$devicesOut[$i]['FriendlyType'] = $row[6];
		$devicesOut[$i]['ScreenWidth'] = $row[4];
		$devicesOut[$i]['ScreenHeight'] = $row[5];
		$i++;
	}

	
	$output = "[";
	for ($i=0; $i < count($devicesOut) ; $i++)
	{
		$output = $output."{\"Id\":\"".$devicesOut[$i]['Id']."\",\"Name\":\"".$devicesOut[$i]['Name']."\",\"MountPoint\":\"".$devicesOut[$i]['MountPoint']."\",\"FreeDisk\":\"".$devicesOut[$i]['FreeDisk']."\",\"HwId\":\"".$devicesOut[$i]['HwId']."\",\"Type\":\"".$devicesOut[$i]['Type']."\",\"FriendlyType\":\"".$devicesOut[$i]['FriendlyType']."\",\"ScreenWidth\":\"".$devicesOut[$i]['ScreenWidth']."\",\"ScreenHeight\":\"".$devicesOut[$i]['ScreenHeight']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getAvailableDevices()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT a1.id, a1.name, a1.hardwareId, a1.hardwareType, a1.screenWidth, a1.screenHeight, a2.label FROM s_devices a1
	RIGHT JOIN t_online_devices a3 ON a1.hardwareId = a3.hardwareId
	LEFT JOIN d_hardware_types a2 ON a1.hardwareType = a2.id";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$devicesOut = Array();
	$i=0;
	while($row = mysqli_fetch_row($result))
	{
		$devicesOut[$i]['Id'] = $row[0];
		$devicesOut[$i]['Name'] = $row[1];
		$devicesOut[$i]['MountPoint'] = getMountPointFromDeviceId($row[2])."/";
		$devicesOut[$i]['HwId'] = $row[2];
		$devicesOut[$i]['Type'] = $row[3];
		$devicesOut[$i]['FriendlyType'] = $row[6];
		$devicesOut[$i]['ScreenWidth'] = $row[4];
		$devicesOut[$i]['ScreenHeight'] = $row[5];
		$i++;
	}

	
	$output = "[";
	for ($i=0; $i < count($devicesOut) ; $i++)
	{
		$output = $output."{\"Id\":\"".$devicesOut[$i]['Id']."\",\"Name\":\"".$devicesOut[$i]['Name']."\",\"MountPoint\":\"".$devicesOut[$i]['MountPoint']."\",\"HwId\":\"".$devicesOut[$i]['HwId']."\",\"Type\":\"".$devicesOut[$i]['Type']."\",\"FriendlyType\":\"".$devicesOut[$i]['FriendlyType']."\",\"ScreenWidth\":\"".$devicesOut[$i]['ScreenWidth']."\",\"ScreenHeight\":\"".$devicesOut[$i]['ScreenHeight']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function addDevice()
{
	$macAdress = ($_GET['hwId'] != "" && $_GET['hwId'] != null) ? $_GET['hwId'] : getDeviceMacFromIp($_SERVER['REMOTE_ADDR']);
	$deviceName = $_GET['deviceName'];
	$deviceType = $_GET['deviceType'];
	$deviceScreenWidth = $_GET['deviceScreenWidth'];
	$deviceScreenHeight = $_GET['deviceScreenHeight'];
	$user = $_GET['user'];
	$pwd = $_GET['pwd'];
	
 	$newId = addNewDevice($macAdress, $deviceName, $deviceType, $deviceScreenWidth, $deviceScreenHeight);
	
	/*$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "INSERT INTO s_devices (name, hardwareId, hardwareType, screenWidth, screenHeight) VALUES (\"".$deviceName."\",\"".$macAdress."\",".$deviceType.",".$deviceScreenWidth.",".$deviceScreenHeight.")";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	*/
	if($newId != null)
	{
		$outputJson = "{\"Id\":\"".$newId."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$macAdress."\",
				\"Type\":\"".$deviceType."\",
				\"ScreenWidth\":\"".$deviceScreenWidth."\",
				\"ScreenHeight\":\"".$deviceScreenHeight."\"}";
			
		print($outputJson);
	}
	else {
		print("KO");
	}
}

function addRemoteDevice()
{
	$macAdress = $_GET['hwId'];
	$deviceName = $_GET['deviceName'];
	$deviceType = $_GET['deviceType'];
	$user = $_GET['user'];
	$pwd = $_GET['pwd'];
	
 	$output = addNewRemoteDevice($macAdress, $deviceName, $deviceType, $user, $pwd);
	
	/*$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "INSERT INTO s_devices (name, hardwareId, hardwareType, screenWidth, screenHeight) VALUES (\"".$deviceName."\",\"".$macAdress."\",".$deviceType.",".$deviceScreenWidth.",".$deviceScreenHeight.")";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	*/
	if($output != null)
	{
		$outputJson = "{\"Id\":\"".$output."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$macAdress."\",
				\"Type\":\"".$deviceType."\",
				\"ScreenWidth\":\"".$deviceScreenWidth."\",
				\"ScreenHeight\":\"".$deviceScreenHeight."\"}";
			
		print($outputJson);
	}
	else {
		print("KO");
	}
}

/*
function addUsbDevice($deviceName, $deviceHwId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "INSERT INTO s_devices (name, hardwareId, hardwareType) VALUES (\"".$deviceName."\",\"".$deviceHwId."\",14)";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($result)
	{
		$output = "{\"Id\":\"".mysqli_insert_id($link)."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$deviceHwId."\",
				\"Type\":\"14\"";
			
		//print($output);
		return mysqli_insert_id($link);
	}
	else {
		print("KO");
	}
}
*/

function getAllDevices()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT * FROM s_devices WHERE 1";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$devices = Array();
	$i=0;
	while($row = mysqli_fetch_row($result))
	{
		$devices[$i]['Id'] = $row[0];
		$devices[$i]['Name'] = $row[1];
		$devices[$i]['HwId'] = $row[2];
		$devices[$i]['Type'] = $row[3];
		$devices[$i]['ScreenWidth'] = $row[4];
		$devices[$i]['ScreenHeight'] = $row[5];
		$devices[$i]['user'] = $row[7];
		$devices[$i]['pwd'] = $row[8];
		$i++;
	}

	
	$output = "[";
	for ($i=0; $i < count($devices) ; $i++)
	{
		$output = $output."{\"Id\":\"".$devices[$i]['Id']."\",\"Name\":\"".$devices[$i]['Name']."\",\"HwId\":\"".$devices[$i]['HwId']."\",\"Type\":\"".$devices[$i]['Type']."\",\"ScreenWidth\":\"".$devices[$i]['ScreenWidth']."\",\"ScreenHeight\":\"".$devices[$i]['ScreenHeight']."\",\"User\":\"".$devices[$i]['user']."\",\"Pwd\":\"".$devices[$i]['pwd']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getOfflineDevices()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT * FROM s_devices a1 INNER JOIN (SELECT deviceId FROM s_files GROUP BY deviceId) a2 ON a1.id = a2.deviceId LEFT JOIN  t_online_devices a3 ON a1.hardwareId = a3.hardwareId WHERE a3.hardwareId IS NULL";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$devices = Array();
	$i=0;
	while($row = mysqli_fetch_row($result))
	{
		$devices[$i]['Id'] = $row[0];
		$devices[$i]['Name'] = $row[1];
		$devices[$i]['HwId'] = $row[2];
		$devices[$i]['Type'] = $row[3];
		$devices[$i]['ScreenWidth'] = $row[4];
		$devices[$i]['ScreenHeight'] = $row[5];
		$devices[$i]['user'] = $row[7];
		$devices[$i]['pwd'] = $row[8];
		$i++;
	}

	
	$output = "[";
	for ($i=0; $i < count($devices) ; $i++)
	{
		$output = $output."{\"Id\":\"".$devices[$i]['Id']."\",\"Name\":\"".$devices[$i]['Name']."\",\"HwId\":\"".$devices[$i]['HwId']."\",\"Type\":\"".$devices[$i]['Type']."\",\"ScreenWidth\":\"".$devices[$i]['ScreenWidth']."\",\"ScreenHeight\":\"".$devices[$i]['ScreenHeight']."\",\"User\":\"".$devices[$i]['user']."\",\"Pwd\":\"".$devices[$i]['pwd']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getDevices()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_devices a1 INNER JOIN (SELECT deviceId FROM s_files GROUP BY deviceId) a2 ON a1.id = a2.deviceId LEFT JOIN t_online_devices a3 ON a1.hardwareId = a3.hardwareId LEFT JOIN d_hardware_types a4 ON a1.hardwareType = a4.id";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$devices = Array();
	$i=0;
	while($row = mysqli_fetch_row($result))
	{
		$devices[$i]['Id'] = $row[0];
		$devices[$i]['Name'] = $row[1];
		$devices[$i]['HwId'] = $row[2];
		$devices[$i]['Type'] = $row[3];
		$devices[$i]['ScreenWidth'] = $row[4];
		$devices[$i]['ScreenHeight'] = $row[5];
		$devices[$i]['user'] = $row[7];
		$devices[$i]['pwd'] = $row[8];
		$devices[$i]['FriendlyType'] = $row[16];
		//$devices[$i]['isReachable'] = ($row[13] != NULL) ? "true" : "false";
		$devices[$i]['mount'] = ($row[13] != NULL) ? $row[13]."/" : "";
		$i++;
	}

	
	$output = "[";
	for ($i=0; $i < count($devices) ; $i++)
	{
		$output = $output."{\"Id\":\"".$devices[$i]['Id']."\",\"MountPoint\":\"".$devices[$i]['mount']."\",\"FriendlyType\":\"".$devices[$i]['FriendlyType']."\",\"Name\":\"".$devices[$i]['Name']."\",\"HwId\":\"".$devices[$i]['HwId']."\",\"Type\":\"".$devices[$i]['Type']."\",\"ScreenWidth\":\"".$devices[$i]['ScreenWidth']."\",\"ScreenHeight\":\"".$devices[$i]['ScreenHeight']."\",\"User\":\"".$devices[$i]['user']."\",\"Pwd\":\"".$devices[$i]['pwd']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getStorageByTypes()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$queryString = "SELECT * FROM d_storage_by_types WHERE 1";
	

	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$nameValues = Array();
	$i=0;
	while($row = mysqli_fetch_row($result))
	{
		$nameValues[$i]['id'] = $row[0];
		$nameValues[$i]['name'] = $row[1];
		$i++;
	}

	outputNameValue($nameValues);
}

function removeFile($fileId)
{
	removeFileFromId($fileId);
}

function updateDevice()
{
	$deviceHwId = $_GET['deviceHwId'];
	$newName = $_GET['newName'];
	$newType = $_GET['newType'];
	$newUser = $_GET['newUser'];
	$newPwd = $_GET['newPwd'];
		
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "UPDATE s_devices SET";
	if($newName != null && $newName != "")
	{
		$queryString = $queryString." name = \"".$newName."\", ";
	}
	if($newType != null && $newType != "")
	{
		$queryString = $queryString." hardwareType = ".$newType;
	}
	if($newUser != null && $newUser != "")
	{
		$queryString = $queryString." user = ".$newUser;
	}
	if($newPwd != null && $newPwd != "")
	{
		$queryString = $queryString." user = ".$newPwd;
	}
	else {
		$queryString = substr($queryString,0,-2);
	}
	$queryString = $queryString." WHERE hardwareId =\"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
}

function getNbFolders()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	if (mysqli_connect_errno()) {
    	exit();
	}
	
	$queryString = "SELECT COUNT( * ) FROM (SELECT COUNT( * ) AS count FROM s_folders a1 RIGHT JOIN a_folder_file a2 ON a1.id = a2.folderId RIGHT JOIN s_files a3 ON a2.fileId = a3.id WHERE a1.ownerId =11 GROUP BY a2.folderId)a4";
//	$queryString = "SELECT COUNT( * ) FROM s_folders";
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}

function getFolderById()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT a1.name, a1.thumbUrl, a1.id FROM s_folders a1 WHERE id=".$_GET['folderId'];
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	$folders = [];
	$folders['image'] = ($row[3] == "1") ? "http://sunnyv1.local/ressources/thumbs/".floor($row[1] / 1000)."/".$row[1] : $publicDirectory.$row[1];
	$folders['thumb'] = $publicDirectory."thumbs/".floor($row[2] / 1000)."/".$row[1].".jpg";
	$folders['name'] = $row[0];
	$folders['id'] = $row[2];
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "{
		\"ThumbUrl\":\"".$folders['thumb']."\",
		\"Title\":\"".$folders['name']."\",
		\"Id\":\"".$folders['id']."\"}" ;

	print($output);
}

function api_getFolders($owner, $allPublic, $offset, $count)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if ($allPublic == "true")
	{
		$queryString = "SELECT a1.name, a3.filename, a3.storageType, a3.id, a1.id, a3.url, a3.deviceId FROM s_folders a1
						RIGHT JOIN a_folder_file a2 ON a1.id = a2.folderId 
						LEFT JOIN s_files a3 ON a2.fileId = a3.id
						WHERE a1.ownerId = ".$owner." OR a1.rightsId=2 
						GROUP BY a2.folderId 
						LIMIT ".$offset.",".$count;
	}
	else
	{
		$queryString = "SELECT a1.name, a3.filename, a3.storageType, a3.id, a1.id, a3.url, a3.deviceId FROM s_folders a1
						RIGHT JOIN a_folder_file a2 ON a1.id = a2.folderId 
						LEFT JOIN s_files a3 ON a2.fileId = a3.id
						WHERE a1.ownerId = ".$owner." 
						GROUP BY a2.folderId 
						LIMIT ".$offset.",".$count;
	}
	error_log("QUERY :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	
	$folders = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$folders[$i]['image'] = ($row[2] == "1") ? "http://sunnyv1.local/ressources/thumbs/".floor($row[1] / 1000)."/".$row[1] : $publicDirectory.$row[1];
		error_log("Storage Type :: ".$row[2]);
		//$folders[$i]['thumb'] = $row[2] ;
		$folders[$i]['thumb'] = $publicDirectory."thumbs/".floor($row[3] / 1000)."/".$row[3].".jpg";
		$folders[$i]['name'] = $row[0];
		$folders[$i]['id'] = $row[4];
		$folders[$i]['deviceId'] = $row[6];
		$folders[$i]['imageUrl'] = addslashes($row[5]);
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($folders) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$folders[$i]['thumb']."\",\"Title\":\"".$folders[$i]['name']."\",\"Id\":\"".$folders[$i]['id']."\",\"DeviceId\":\"".$folders[$i]['deviceId']."\",\"ImageUrl\":\"".$folders[$i]['imageUrl']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getLocations()
{
	$owner = $_GET['owner'];
	$allPublic = $_GET['allPublic'];
	$count = $_GET['count'];
	$offset = $_GET['offset'];	
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM (SELECT * FROM a_file_location GROUP BY locationId)a1 
	LEFT JOIN s_files a2 ON a1.fileId = a2.id
	 LEFT JOIN s_locations a3 ON a3.id = a1.locationId";
	/*
	if ($allPublic == "true")
	{
		$queryString = "SELECT a1.name, a3.filename, a1.thumbUrl, a3.storageType, a3.id, a1.id FROM s_folders a1
						RIGHT JOIN a_folder_file a2 ON a1.id = a2.folderId RIGHT JOIN s_files a3 ON a2.fileId = a3.id
						WHERE a1.ownerId = ".$owner." OR a1.rightsId=2 GROUP BY a2.folderId LIMIT ".$offset.",".$count;
	}
	else
	{
		$queryString = "SELECT a1.name, a3.filename, a1.thumbUrl, a3.storageType, a3.id, a1.id FROM s_folders a1
						RIGHT JOIN a_folder_file a2 ON a1.id = a2.folderId RIGHT JOIN s_files a3 ON a2.fileId = a3.id
						WHERE a1.ownerId = ".$owner." GROUP BY a2.folderId LIMIT ".$offset.",".$count;
	}*/
	error_log("QUERY :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	
	$locations = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$locations[$i]['image'] = getUSBRemotePath(getDeviceHwId($row[14]), addslashes($row[0]));
		error_log("Storage Type :: ".$row[12]);
		//$folders[$i]['thumb'] = $row[2] ;
		$locations[$i]['thumb'] = "http://sunnyv1.local/ressources/thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg";
		$locations[$i]['name'] = $row[22];
		$locations[$i]['id'] = $row[21];
		$locations[$i]['city'] = $row[22];
		$locations[$i]['country'] = $row[23];
		$locations[$i]['zipCode'] = $row[24];
		$locations[$i]['imageUrl'] = getUSBRemotePath(getDeviceHwId($row[14]), addslashes($row[0]));
		$locations[$i]['deviceId'] = getDeviceHwId($row[14]);
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($locations) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$locations[$i]['thumb']."\",
							\"Title\":\"".$locations[$i]['name']."\",
							\"Id\":\"".$locations[$i]['id']."\",
							\"DeviceId\":\"".$locations[$i]['deviceId']."\",
							\"ImageUrl\":\"".$locations[$i]['imageUrl']."\",
							\"City\":\"".$locations[$i]['city']."\",
							\"Country\":\"".$locations[$i]['country']."\",
							\"ZipCode\":\"".$locations[$i]['zipCode']."\"
							}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getTags()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	/*if($allPublic != null)
	{	
		$queryString = "SELECT a3.name AS Name, a3.id AS Id FROM a_owner_right_file a1
						RIGHT JOIN a_tag_file a2 ON a1.fileId = a2.fileId
						RIGHT JOIN s_tags a3 ON a2.tagId = a3.id
						WHERE a1.ownerId=".$owner." OR a1.rightId=2 GROUP BY a3.id";
	}
	else
	{
		$queryString = "SELECT a3.name AS Name, a3.id AS Id FROM a_owner_right_file a1
						RIGHT JOIN a_tag_file a2 ON a1.fileId = a2.fileId
						RIGHT JOIN s_tags a3 ON a2.tagId = a3.id
					WHERE a1.ownerId=".$owner." GROUP BY a3.id";
	}*/
	
	$queryString = "SELECT b.id, b.name FROM (SELECT tagId FROM a_tag_file
GROUP BY tagId)a
INNER JOIN s_tags b ON b.id = a.tagId";
	
	error_log("QUERY :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	
	$folders = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$folders[$i]['id'] = $row[0];
		$folders[$i]['name'] = $row[1];
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	outputNameValue($folders);
}
	
	
function add()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT folderId,fileId FROM a_folder_file WHERE 1";
	$result = mysqli_query($link, $queryString);
	
	while($row = mysqli_fetch_row($result))
	{
		$queryString2 = "UPDATE s_files SET folderId=\"".$row[0]."\" WHERE id=".$row[1];
		error_log("UPDATE :: ".$queryString2);
		$result2 = mysqli_query($link, $queryString2);
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getPhotosOverview()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT(*) AS nb, FLOOR(SUM(a.size)/1000/1000) AS mo FROM (SELECT *
FROM s_files
WHERE fileType < 20) a";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Nb\":\"".$row[0]."\",
							\"Mo\":\"".$row[1]."\"
							}" ;
	}
	$output = ($output == "") ? "{}" : $output;
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getVideosOverview()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT(*) AS nb, FLOOR(SUM(a.size)/1000/1000) AS mo FROM (SELECT *
FROM s_files
WHERE fileType >= 20) a";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Nb\":\"".$row[0]."\",
							\"Mo\":\"".$row[1]."\"
							}" ;
	}
	$output = ($output == "") ? "{}" : $output;
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getPhotosDuplicatesOverview()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT SUM(nbDuplicates), FLOOR(SUM(sizeDuplicates) / 1000 / 1000) FROM (SELECT id, (SUM(size)-size) AS sizeDuplicates, (COUNT(*)-1) AS nbDuplicates
FROM s_files
WHERE fileType <20
GROUP BY size, dateCreated
HAVING COUNT( * ) >1)a";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Nb\":\"".$row[0]."\",
							\"Mo\":\"".$row[1]."\"
							}" ;
	}
	$output = ($output == "") ? "{}" : $output;
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getVideosDuplicatesOverview()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT( * ) AS nb, FLOOR( SUM( a.size ) /1000 /1000 ) AS mo
FROM (

SELECT *
FROM s_files
WHERE fileType >= 20
GROUP BY size
HAVING COUNT( * ) >1
)a";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"Nb\":\"".$row[0]."\",
							\"Mo\":\"".$row[1]."\"
							}" ;
	}
	$output = ($output == "") ? "{}" : $output;
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getDevicesDiagnostics()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT devicesId, devicesName AS DEVICE, photoCount AS NBPHOTOS, photoUCount AS NBPHOTOSUNIQUES, (photoCount - photoUCount) AS DOUBLONSPHOTOS, FLOOR(photoSize/1000/1000) AS MoPHOTOS, FLOOR(photoUSize/1000/1000) AS MoPHOTOSUNIQUES, FLOOR((photoSize - photoUSize)/1000/1000) AS MoBOUBLONSPHOTOS, videoCount AS NBVIDEOS, videoUCount AS NBVIDEOSUNIQUES, (videoCount - videoUCount) AS DOUBLONSVIDEOS, FLOOR((videoSize - videoUSize)/1000/1000) AS MoBOUBLONSVIDEOS, FLOOR(videoSize/1000/1000) AS MoVIDEOS, FLOOR(videoUSize/1000/1000) AS MoVIDEOSUNIQUES, FLOOR( (
photoSize + videoSize
) /1000 /1000 ) AS TOTALDEVICE, FLOOR( (
photoUSize + videoUSize
) /1000 /1000 ) AS TOTALDEVICEUNIQUE, FLOOR( (
photoSize + videoSize - photoUSize - videoUSize
) /1000 /1000 ) AS TOTALDEVICEDOUBLON
FROM (SELECT b.id AS devicesId, b.name AS devicesName FROM s_files a
RIGHT JOIN s_devices b ON a.deviceId = b.id
GROUP BY a.deviceId) devicesId
LEFT JOIN
(SELECT b.id AS photoDeviceId, COUNT( * ) AS photoCount , SUM( a.size ) AS photoSize
FROM s_files a
RIGHT JOIN s_devices b ON a.deviceId = b.id
WHERE a.fileType <20
GROUP BY a.deviceId
)photos
ON devicesId = photoDeviceId
LEFT JOIN (SELECT b.id AS videoDeviceId, b.name, COUNT(*) AS videoCount, SUM( a.size ) AS videoSize FROM s_files a
RIGHT JOIN s_devices b ON a.deviceId = b.id
WHERE a.fileType >= 20
GROUP BY a.deviceId
)videos ON devicesId = videoDeviceId

LEFT JOIN (SELECT b.id AS photoUDeviceId, COUNT( * ) AS photoUCount, SUM( a.size ) AS photoUSize
FROM (SELECT *
FROM s_files
WHERE fileType <20
GROUP BY size, dateCreated
)a
RIGHT JOIN s_devices b ON a.deviceId = b.id
GROUP BY a.deviceId
)photosU ON devicesId = photoUDeviceId
LEFT JOIN (
SELECT b.id AS videoUDeviceId, b.name, COUNT( * ) AS videoUCount, SUM( a.size ) AS videoUSize
FROM (SELECT *
FROM s_files
WHERE fileType >=20
GROUP BY size
)a
RIGHT JOIN s_devices b ON a.deviceId = b.id
GROUP BY a.deviceId
)videosU ON devicesId = videoUDeviceId";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$output = "[";
	while ($row = mysqli_fetch_row($result))
	{
		$output = $output."{\"DeviceId\":\"".$row[0]."\",
							\"DeviceName\":\"".$row[1]."\",
							\"PhotosNbAll\":\"".$row[2]."\",
							\"PhotosNbUnique\":\"".$row[3]."\",
							\"PhotosNbDoublons\":\"".$row[4]."\",
							\"PhotosMoAll\":\"".$row[5]."\",
							\"PhotosMoUnique\":\"".$row[6]."\",
							\"PhotosMoDoublons\":\"".$row[7]."\",
							\"VideosNbAll\":\"".$row[8]."\",
							\"VideosNbUnique\":\"".$row[9]."\",
							\"VideosNbDoublons\":\"".$row[10]."\",
							\"VideosMoAll\":\"".$row[11]."\",
							\"VideosMoUnique\":\"".$row[12]."\",
							\"VideosMoDoublons\":\"".$row[13]."\",
							\"TotalMoAll\":\"".$row[14]."\",
							\"TotalMoUnique\":\"".$row[15]."\",
							\"TotalMoDoublons\":\"".$row[16]."\"
							}," ;
	}
	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getDeviceDiagnostics($deviceId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT
photoCount AS NBPHOTOS, photoUCount AS NBPHOTOSUNIQUES, (photoCount - photoUCount) AS DOUBLONSPHOTOS, FLOOR(photoSize/1000/1000) AS MoPHOTOS, FLOOR(photoUSize/1000/1000) AS MoPHOTOSUNIQUES, FLOOR((photoSize - photoUSize)/1000/1000) AS MoBOUBLONSPHOTOS, videoCount AS NBVIDEOS, videoUCount AS NBVIDEOSUNIQUES, (videoCount - videoUCount) AS DOUBLONSVIDEOS, FLOOR((videoSize - videoUSize)/1000/1000) AS MoBOUBLONSVIDEOS, FLOOR(videoSize/1000/1000) AS MoVIDEOS, FLOOR(videoUSize/1000/1000) AS MoVIDEOSUNIQUES, FLOOR( (
photoSize + videoSize) /1000 /1000 ) AS TOTALDEVICE, FLOOR( (photoUSize + videoUSize) /1000 /1000 ) AS TOTALDEVICEUNIQUE, FLOOR( (photoSize + videoSize - photoUSize - videoUSize) /1000 /1000 ) AS TOTALDEVICEDOUBLON
FROM
(SELECT COUNT( * ) AS photoCount , SUM( size ) AS photoSize, deviceId AS device FROM s_files WHERE deviceId = ".$deviceId." AND fileType <20 )photos 

LEFT JOIN
(SELECT COUNT(*) AS videoCount, SUM( size ) AS videoSize, deviceId FROM s_files WHERE deviceId = ".$deviceId." AND fileType >= 20 )videos ON videos.deviceId = photos.device

LEFT JOIN
(SELECT COUNT( * ) AS photoUCount, SUM( size ) AS photoUSize, deviceId AS device FROM (SELECT * FROM s_files WHERE deviceId = ".$deviceId." AND fileType <20 GROUP BY size, dateCreated )a )photosU ON photosU.device = photos.device

LEFT JOIN
(SELECT COUNT( * ) AS videoUCount, SUM( size ) AS videoUSize, deviceId AS device FROM (SELECT * FROM s_files WHERE deviceId = ".$deviceId." AND fileType >=20 GROUP BY size )a )videosU ON videosU.device = photos.device";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$row = mysqli_fetch_row($result);
	
	//$newPhotoFiles = getSinglePhotoFiles($deviceId);
	//$newVideoFiles = getSingleVideoFiles($deviceId);
	
	$output = "{\"DeviceId\":\"".$deviceId."\",
	\"DeviceName\":\"\",
	\"PhotosNbAll\":\"".$row[0]."\",
	\"PhotosNbUnique\":\"".$row[1]."\",
	\"PhotosNbDoublons\":\"".$row[2]."\",
	\"PhotosMoAll\":\"".$row[3]."\",
	\"PhotosMoUnique\":\"".$row[4]."\",
	\"PhotosMoDoublons\":\"".$row[5]."\",
	\"VideosNbAll\":\"".$row[6]."\",
	\"VideosNbUnique\":\"".$row[7]."\",
	\"VideosNbDoublons\":\"".$row[8]."\",
	\"VideosMoAll\":\"".$row[9]."\",
	\"VideosMoUnique\":\"".$row[10]."\",
	\"VideosMoDoublons\":\"".$row[11]."\",
	\"TotalMoAll\":\"".$row[12]."\",
	\"TotalMoUnique\":\"".$row[13]."\",
	\"TotalMoDoublons\":\"".$row[14]."\"
	}" ;
	
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getStatistics($type)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	switch ($type) {
		case 'Year':
			$queryString = "SELECT YEAR( dateCreated ) AS Year, COUNT( * ) AS Nombre
FROM s_files
GROUP BY YEAR( dateCreated )";

			$result = mysqli_query($link, $queryString);
			
			$output = "[";
			while ($row = mysqli_fetch_row($result))
			{
				$output = $output."{\"Name\":\"".$row[0]."\",\"Value\":\"".$row[1]."\"}," ;
			}
			break;
		
		case 'Device':
			$queryString = "SELECT a2.name, COUNT( * )
FROM s_files a1
INNER JOIN s_devices a2 ON a1.deviceId = a2.id
GROUP BY a1.deviceId";

			$result = mysqli_query($link, $queryString);
			
			$output = "[";
			while ($row = mysqli_fetch_row($result))
			{
				$output = $output."{\"Name\":\"".$row[0]."\",\"Value\":\"".$row[1]."\"}," ;
			}
			break;
		
		case "Month":
			$queryString = "SELECT MONTHNAME(dateCreated) AS Month, COUNT( * ) AS Nombre
FROM s_files
GROUP BY MONTH(dateCreated)";

			$result = mysqli_query($link, $queryString);
			
			$output = "[";
			while ($row = mysqli_fetch_row($result))
			{
				$output = $output."{\"Name\":\"".$row[0]."\",\"Value\":\"".$row[1]."\"}," ;
			}
			break;
			
		case "Camera":
			$queryString = "SELECT CONCAT(cameraMake,\" \",cameraModel) AS Camera, COUNT( * ) AS Nombre
FROM s_files
GROUP BY CONCAT(cameraMake,\" \",cameraModel)";

			$result = mysqli_query($link, $queryString);
			
			$output = "[";
			while ($row = mysqli_fetch_row($result))
			{
				$output = $output."{\"Name\":\"".$row[0]."\",\"Value\":\"".$row[1]."\"}," ;
			}
			break;
			
			case "Duplicates":
			
			$queryString = "SELECT deviceId FROM s_files GROUP BY deviceId";
			$result = mysqli_query($link, $queryString);
			
			$devices = [];
			while ($row = mysqli_fetch_row($result))
			{
				array_push($devices,$row[0]);
			}
			
			$output = "[";
			foreach($devices as $deviceId)
			{
				$queryString = "SELECT deviceId, COUNT( * ) AS total, a2.name FROM (SELECT * FROM s_files WHERE deviceId =".$deviceId." GROUP BY size HAVING COUNT( * ) >1)a1 INNER JOIN s_devices a2 ON a1.deviceId = a2.id";
				$result = mysqli_query($link, $queryString);
				$row = mysqli_fetch_row($result);
				if($row[1] != "0")
				{
					$output = $output."{\"Name\":\"".$row[2]."\",\"Value\":\"".$row[1]."\"}," ;
				}
			}
			break;
	}
	

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getImageById()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_files a1 
	RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId 
	LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId
	WHERE id=".$_GET['fileId'];
		
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	$image = Array() ;
	$image['Id'] = $row[0] ;
	$image['Image'] = addslashes($row[11]) ;
	$image['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
	$image['Date'] = $row[3] ;
	$image['Device'] = $row[12];
	$image['Name'] = $row[1];
	$image['StorageType'] = $row[13];
	$image['Size'] = $row[8];
	$image['Width'] = $row[6];
	$image['Height'] = $row[7];
	$image['GpsLongitude'] = $row[10];
	$image['GpsLatitude'] = $row[9];
	$image['DateModified'] = $row[5];
	$image['DateCreated'] = $row[4];
	$image['CameraModel'] = $row[15];
	$image['CameraMake'] = $row[14];
	$image['Owner'] = $row[18];
	$image['Rights'] = $row[19];
	$image['FolderId'] = $row[22];
	
	outputSingleToutesSchema($image);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getNbBackupedImages()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_backuped_files WHERE 1";

	error_log("GET ALL IMAGES :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	$nb = mysqli_num_rows($result);
	print($nb);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function getBackupedImages()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_backuped_files WHERE 1";

	error_log("GET ALL IMAGES :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	
	$images = Array() ;
	$i = 0 ;
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['scanId'] = $row[1] ;
		$images[$i]['backupId'] = $row[2] ;
		$images[$i]['FilePath'] = addslashes($row[3]) ;
		$images[$i]['DeviceId'] = $row[4] ;
		
		$i++;
	}
	
	outputBackupedSchema($images);
	
	mysqli_free_result($result);
	mysqli_close($link);
}

function api_get()
{
	$owner = $_GET["owner"];
	$allPublic = $_GET["allPublic"];
	$offset = $_GET["offset"];
	$count = $_GET["count"];
	$orderBy = $_GET["orderBy"];
	$filterBy = $_GET["filterBy"];
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$offset = ($offset != "") ? $offset : "0";
	$count = ($count != "") ? $count : "1000";
	
	$queryString = "SELECT * FROM s_files a1 RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId";
	
	//$queryString = "SELECT a2.name AS Owner, a1.filename AS Name, a1.date AS Date FROM s_files a1 RIGHT JOIN s_users a2 ON a2.id = a1.owner WHERE 1";
	if($allPublic == "true")
	{
		$queryString = $queryString . " WHERE (a2.ownerId =".$owner." OR a2.rightId=2)";
	}
	else {
		$queryString = $queryString . " WHERE a2.ownerId =".$owner;
	}
	
	if($_GET['deviceId'] != "")
	{
		$queryString = $queryString . " AND a1.deviceId = ".$_GET['deviceId'];
	}
	//$queryString = $queryString . " AND a1.cameraMake = \"Nokia\"";

	if($filterBy == "vertical")
	{
		$queryString = $queryString . " AND (a1.width <= a1.height)";
	}
	else if($filterBy == "horizontal")
	{
		$queryString = $queryString . " AND (a1.width >= a1.height)";
	}
	else if($filterBy == "backuped")
	{
		$queryString = $queryString . " AND a1.deviceId = 0";
	}
	
	$queryString = $queryString . " AND a1.fileType != 4";
	
	switch ($orderBy) {
		case "dateASC":
			$queryString = $queryString . " ORDER BY a1.dateCreated ASC";
			break;
		case "dateDESC":
			$queryString = $queryString . " ORDER BY a1.dateCreated DESC";
			break;
		case "nameASC":
			$queryString = $queryString . " ORDER BY a1.filename ASC";
			break;
		case "nameDESC":
			$queryString = $queryString . " ORDER BY a1.filename DESC";
			break;
		case "sizeDESC":
			$queryString = $queryString . " ORDER BY a1.size DESC";
			break;
		case "sizeASC":
			$queryString = $queryString . " ORDER BY a1.size ASC";
			break;
		default:
			break;
	}

	if($count == "-1")
	{
		error_log("GET ALL IMAGES :: ".$queryString);
		$result = mysqli_query($link, $queryString);
		$nb = mysqli_num_rows($result);
		print($nb);
		mysqli_free_result($result);
		mysqli_close($link);
		exit;
	}
	else {
		$queryString = $queryString . " LIMIT ".$offset." , ".$count;
		error_log("GET ALL IMAGES :: ".$queryString);
		$result = mysqli_query($link, $queryString);
	}
	
	$images = Array() ;
	$i = 0 ;
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[23];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;

	error_log("AVANT :: ".count($images));
	outputToutesSchema($images);
}

function outputNameValue($nameValues)
{
	$output = "[";
	for ($i=0; $i < count($nameValues) ; $i++)
	{
		$output = $output."{\"Value\":\"".$nameValues[$i]['id']."\",\"Name\":\"".$nameValues[$i]['name']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function outputToutesSchema($images)
{
	$output = "[";
	//error_log("OUTPUT :: ".count($images));
	for ($i=0; $i < count($images) ; $i++)
	{
		$output = $output."{\"Id\":".$images[$i]['Id'].",
							\"DeviceId\":\"".$images[$i]['Device']."\",
							\"ThumbUrl\":\"".(($images[$i]['isThumb'] == "1") ? $images[$i]['Thumb'] : "" )."\",
							\"ImageUrl\":\"".$images[$i]['Image']."\",
							\"remoteURL\":\"".$images[$i]['remoteURL']."\",
							\"localPath\":\"".$images[$i]['localPath']."\",
							\"dateCreated\":\"".$images[$i]['Date']."\",
							\"DateCreated\":\"".$images[$i]['DateCreated']."\",
							\"Name\":\"".$images[$i]['Name']."\",
							\"MediaType\":\"".$images[$i]['MediaType']."\",
							\"Duration\":\"".$images[$i]['Duration']."\",
							\"StorageType\":\"".$images[$i]['StorageType']."\",
							\"Size\":\"".$images[$i]['Size']."\",
							\"Width\":\"".$images[$i]['Width']."\",
							\"Height\":\"".$images[$i]['Height']."\",
							\"Latitude\":\"".$images[$i]['GpsLatitude']."\",
							\"Longitude\":\"".$images[$i]['GpsLongitude']."\",
							\"CameraMake\":\"".$images[$i]['CameraMake']."\",
							\"CameraModel\":\"".$images[$i]['CameraModel']."\",
							\"FolderId\":\"".$images[$i]['FolderId']."\",
							\"Owner\":\"".$images[$i]['Owner']."\",
							\"Count\":\"".(($images[$i]['Duplicates'] != null) ? $images[$i]['Duplicates'] : "")."\",
							\"Rights\":\"".$images[$i]['Rights']."\"}," ;
	}

	$output = (count($images) == 0) ? "[]" : substr($output,0,-1)."]";
	
	print($output);
}

function outputDuplicateSchema($images)
{
	$output = "[";
	//error_log("OUTPUT :: ".count($images));
	for ($i=0; $i < count($images) ; $i++)
	{
		$output = $output."{\"Id\":".$images[$i]['Id'].",
							\"DeviceId\":\"".$images[$i]['Device']."\",
							\"ThumbUrl\":\"".$images[$i]['Thumb']."\",
							\"ImageUrl\":\"".$images[$i]['Image']."\",
							\"dateCreated\":\"".$images[$i]['Date']."\",
							\"DateCreated\":\"".$images[$i]['DateCreated']."\",
							\"Name\":\"".$images[$i]['Name']."\",
							\"MediaType\":\"".$images[$i]['MediaType']."\",
							\"Duration\":\"".$images[$i]['Duration']."\",
							\"StorageType\":\"".$images[$i]['StorageType']."\",
							\"Size\":\"".$images[$i]['Size']."\",
							\"Width\":\"".$images[$i]['Width']."\",
							\"Height\":\"".$images[$i]['Height']."\",
							\"Latitude\":\"".$images[$i]['GpsLatitude']."\",
							\"Longitude\":\"".$images[$i]['GpsLongitude']."\",
							\"CameraMake\":\"".$images[$i]['CameraMake']."\",
							\"CameraModel\":\"".$images[$i]['CameraModel']."\",
							\"FolderId\":\"".$images[$i]['FolderId']."\",
							\"DuplicateType\":\"".$images[$i]['DuplicateType']."\",
							\"Owner\":\"".$images[$i]['Owner']."\",
							\"Rights\":\"".$images[$i]['Rights']."\"}," ;
	}

	$output = (count($images) == 0) ? "[]" : substr($output,0,-1)."]";
	
	print($output);
}

function outputSingleToutesSchema($image)
{
	$output = $output."{\"Id\":".$image['Id'].",\"ThumbUrl\":\"".$image['Thumb']."\",\"ImageUrl\":\"".$image['Image']."\",\"dateCreated\":\"".$image['Date']."\",\"DeviceId\":\"".$image['Device']."\",\"Name\":\"".$image['Name']."\",\"StorageType\":\"".$image['StorageType']."\",\"Size\":\"".$image['Size']."\",\"Width\":\"".$image['Width']."\",\"Height\":\"".$image['Height']."\",\"CameraMake\":\"".$image['CameraMake']."\",\"CameraModel\":\"".$image['CameraModel']."\",\"FolderId\":\"".$image['FolderId']."\",\"Owner\":\"".$image['Owner']."\",\"Rights\":\"".$image['Rights']."\"}" ;
	print($output);
}

function outputBackupedSchema($images)
{
	$output = "[";
	//error_log("COUNT :: ".count($images));
	for ($i=0; $i < count($images) ; $i++)
	{
		$output = $output."{\"DeviceId\":".$images[$i]['DeviceId'].",\"FilePath\":\"".$images[$i]['FilePath']."\"}," ;
	}

	$output = (count($images) == 0) ? "[]" : substr($output,0,-1)."]";
	
	print($output);
}

function api_getImagesByCamera($camera, $owner, $allPublic, $offset, $count)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
/////////////////////////////////////////////
///////////// TOTAL COUNT ///////////////////
/////////////////////////////////////////////
	if($count == "-1")
	{
		if($allPublic == "true")
		{
			$queryString = "SELECT COUNT( * )
FROM s_files a1
RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId
WHERE CONCAT(a1.cameraMake,\" \",a1.cameraModel) =\"".$camera."\"
AND (a2.ownerId =".$owner."
 OR a2.rightId =2)";
		}
		else
		{
			$queryString = "SELECT COUNT( * )
FROM s_files a1
RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId
WHERE CONCAT(a1.cameraMake,\" \",a1.cameraModel) =\"".$camera."\"
AND (a2.ownerId =".$owner;
		}
		error_log("QUERY COUNT :: ".$queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		print($row[0]);
	}
////////////////////////////////////////////
////////////////////////////////////////////
else
{
	
	if($allPublic == "true")
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
						LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId
						WHERE CONCAT(a1.cameraMake,\" \",a1.cameraModel) =\"".$camera."\" AND (a2.ownerId=".$owner." OR a2.rightId=2)";
	
	}
	else
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
						LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId
						WHERE CONCAT(a1.cameraMake,\" \",a1.cameraModel) =\"".$camera."\" AND a2.ownerId=".$owner;
	
	}
	
	$queryString = $queryString . " ORDER BY a1.dateCreated DESC";
	
	$queryString = $queryString . " LIMIT ".$offset.",".$count;
	
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[25];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
	
	}
}

function api_getImagesByStorage()
{
	$storage = $_GET['storage'];
	$owner = $_GET['owner'];
	$allPublic = $_GET['allPublic'];
	$offset = $_GET['offset'];
	$count = $_GET['count'];
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
/////////////////////////////////////////////
///////////// TOTAL COUNT ///////////////////
/////////////////////////////////////////////
	if($count == "-1")
	{
		if($allPublic == "true")
		{
			$queryString = "SELECT COUNT( * )
FROM s_files a1
RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
WHERE a1.deviceId =".$storage."
AND (a2.ownerId =".$owner."
 OR a2.rightId =2)";
		}
		else
		{
			$queryString = "SELECT COUNT( * )
FROM s_files a1
RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
WHERE a1.deviceId =".$storage."
AND a2.ownerId =".$owner;
		}
		error_log("QUERY COUNT :: ".$queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		print($row[0]);
	}
////////////////////////////////////////////
////////////////////////////////////////////
else
{
	
	if($allPublic == "true")
	{
		$queryString = "SELECT *
		FROM s_files a1
RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId
LEFT JOIN a_file_thumb a7 ON a7.fileId = a1.id
WHERE a1.deviceId =".$storage."
AND (a2.ownerId =".$owner."
 OR a2.rightId =2)
 LIMIT ".$offset.",".$count;
	}
	else
	{
		$queryString = "SELECT * FROM s_files a1
RIGHT JOIN a_owner_right_file a2 ON a2.fileId = a1.id
LEFT JOIN a_folder_file a3 ON a1.id = a3.fileId
LEFT JOIN a_file_thumb a7 ON a7.fileId = a1.id
WHERE a1.deviceId =".$storage."
AND a2.ownerId =".$owner."
LIMIT ".$offset.",".$count;
	}
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$images[$i]['Duplicates'] = $row[26];
		$images[$i]['isThumb'] = $row[28];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
	
	}
}


function api_getImagesByFolder($folder, $owner, $allPublic, $offset, $count)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
/////////////////////////////////////////////
///////////// TOTAL COUNT ///////////////////
/////////////////////////////////////////////
	if($count == "-1")
	{
		if($allPublic == "true")
		{
			$queryString = "SELECT COUNT( * )
FROM s_folders a1
RIGHT JOIN a_folder_file a2 ON a1.id = a2.folderId
LEFT JOIN s_files a3 ON a2.fileId = a3.id
RIGHT JOIN a_owner_right_file a4 ON a4.fileId = a3.id
 
WHERE a1.id =".$folder."
AND (a4.ownerId =".$owner."
 OR a4.rightId =2)";
		}
		else
		{
			$queryString = "SELECT COUNT( * )
FROM s_folders a1
LEFT JOIN a_folder_file a2 ON a1.id = a2.folderId
RIGHT JOIN s_files a3 ON a2.fileId = a3.id
RIGHT JOIN a_owner_right_file a4 ON a4.fileId = a3.id
 
WHERE a1.id =".$folder."
AND (a4.ownerId =".$owner;
		}
		error_log("QUERY COUNT :: ".$queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		print($row[0]);
	}
////////////////////////////////////////////
////////////////////////////////////////////
else
{
	
	if($allPublic == "true")
	{
		$queryString = "SELECT * FROM s_folders a1
LEFT JOIN a_folder_file a2 ON a1.id = a2.folderId
RIGHT JOIN s_files a3 ON a2.fileId = a3.id
RIGHT JOIN a_owner_right_file a4 ON a4.fileId = a3.id
 
WHERE a1.id =".$folder."
AND (a4.ownerId =".$owner."
 OR a4.rightId =2)";
	}
	else
	{
		$queryString = "SELECT * FROM s_folders a1
LEFT JOIN a_folder_file a2 ON a1.id = a2.folderId
RIGHT JOIN s_files a3 ON a2.fileId = a3.id
RIGHT JOIN a_owner_right_file a4 ON a4.fileId = a3.id
 
WHERE a1.id =".$folder."
AND a4.ownerId =".$owner;
	}
	
	$queryString = $queryString . " ORDER BY a3.dateCreated DESC";
	
	$queryString = $queryString . " LIMIT ".$offset.",".$count;
	
	error_log("QUERY BY FOLDER :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[9] ;
		$images[$i]['Image'] = addslashes($row[22]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[9] / 1000)."/".$row[9].".jpg" ;
		$images[$i]['Date'] = $row[14] ;
		$images[$i]['Device'] = $row[23];
		$images[$i]['Name'] = $row[12];
		$images[$i]['StorageType'] = $row[25];
		$images[$i]['MediaType'] = ($row[13] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[0];
		$images[$i]['Size'] = $row[19];
		$images[$i]['Width'] = $row[17];
		$images[$i]['Height'] = $row[18];
		$images[$i]['GpsLongitude'] = $row[21];
		$images[$i]['GpsLatitude'] = $row[20];
		$images[$i]['DateModified'] = $row[16];
		$images[$i]['DateCreated'] = $row[15];
		$images[$i]['CameraModel'] = $row[26];
		$images[$i]['CameraMake'] = $row[25];
		$images[$i]['Owner'] = $row[30];
		$images[$i]['Rights'] = $row[31];
		$images[$i]['Duration'] = $row[29];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
	
	}
}

function getNbImagesByTags()
{
		
//	$tags = explode(",", $_GET['tags']);
	$tags = $_GET['tags'];
	$owner = $_GET['owner'];
	$allPublic = $_GET['allPublic'];
	
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT(*) FROM s_files a1
						RIGHT JOIN a_tag_file a2 ON a1.id = a2.fileId
						RIGHT JOIN a_owner_right_file a3 ON a1.id = a3.fileId
						LEFT JOIN a_folder_file a4 ON a1.id = a4.fileId
						WHERE a2.tagId = ".$tags;
	
	/*if($allPublic == "true")
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_tag_file a2 ON a1.id = a2.fileId
						RIGHT JOIN a_owner_right_file a3 ON a1.id = a3.fileId
						LEFT JOIN a_folder_file a4 ON a1.id = a4.fileId
						WHERE a2.tagId =".$tag." AND a3.ownerId=".$owner;
	
	}
	else
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_tag_file a2 ON a1.id = a2.fileid
						RIGHT JOIN a_owner_right_file a3 ON a1.id = a3.fileId
						WHERE a2.tagId =".$tag." AND a3.ownerId=".$owner." OR a3.rightId=2";
	}*/
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}

function getImagesByTags()
{
		error_log($_GET['tags']);
	$tags = explode(",", $_GET['tags']);
	$owner = $_GET['owner'];
	$allPublic = $_GET['allPublic'];
	$count = $_GET['count'];
	$offset = $_GET['offset'];
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	
	$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_tag_file a2 ON a1.id = a2.fileId
						RIGHT JOIN a_owner_right_file a3 ON a1.id = a3.fileId
						LEFT JOIN a_folder_file a4 ON a1.id = a4.fileId";
						
						if(count($tags) == 1)
						{
							$queryString = $queryString." WHERE a2.tagId =".$tags[0];
						}
						else if(count($tags) > 1)
						{
							$queryString = $queryString." WHERE 1 AND (";
							foreach($tags as $tag)
							{
								$queryString = $queryString."a2.tagId =".$tag." OR ";
							}
							$queryString = substr($queryString,0,-4).")";
						}
	
	$queryString = $queryString . " ORDER BY a1.dateCreated DESC";
	
	/*if($allPublic == "true")
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_tag_file a2 ON a1.id = a2.fileId
						RIGHT JOIN a_owner_right_file a3 ON a1.id = a3.fileId
						LEFT JOIN a_folder_file a4 ON a1.id = a4.fileId
						WHERE a2.tagId =".$tag." AND a3.ownerId=".$owner;
	
	}
	else
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_tag_file a2 ON a1.id = a2.fileid
						RIGHT JOIN a_owner_right_file a3 ON a1.id = a3.fileId
						WHERE a2.tagId =".$tag." AND a3.ownerId=".$owner." OR a3.rightId=2";
	}*/
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['remoteURL'] = getUSBRemotePath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['localPath'] = getUSBLocalPath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$i++;
	}
	 mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getNbImagesByLocations()
{
		
	$locations = explode(",", $_GET['locations']);
	$owner = $_GET['owner'];
	$allPublic = $_GET['allPublic'];
	$count = $_GET['count'];
	$offset = $_GET['offset'];
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT(*) FROM s_files a1
						RIGHT JOIN a_file_location a2 ON a1.id = a2.fileId
						RIGHT JOIN a_owner_right_file a3 ON a1.id = a3.fileId WHERE a2.locationId =".$locations[0];
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	print($row[0]);
}	

function getImagesByLocations()
{
	error_log($_GET['locations']);
	$locations = explode(",", $_GET['locations']);
	$owner = $_GET['owner'];
	$allPublic = $_GET['allPublic'];
	$count = $_GET['count'];
	$offset = $_GET['offset'];
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	
	$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_file_location a2 ON a1.id = a2.fileId";
						
						if(count($locations) == 1)
						{
							$queryString = $queryString." WHERE a2.locationId=".$locations[0];
						}
						else if(count($locations) > 1)
						{
							$queryString = $queryString." WHERE 1 AND (";
							foreach($locations as $location)
							{
								$queryString = $queryString."a2.locationId =".$location." OR ";
							}
							$queryString = substr($queryString,0,-4).")";
						}
		/*				
	$queryString = $queryString . " ORDER BY a1.dateCreated DESC";
	
	$queryString = $queryString." LIMIT ".$offset.",".$count;
	*/
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['remoteURL'] = getUSBRemotePath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['localPath'] = getUSBLocalPath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[23];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$i++;
	}

 
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getImagesBySpecialDate()
{
	$special = $_GET['special'];
	
		
		
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	switch ($special) {
		case 'night':
			$specialQuery = "SELECT * FROM s_files a1
							RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId
		LEFT JOIN a_folder_file a3 ON a3.fileId = a1.id
		 WHERE (MONTH( a1.dateCreated ) NOT BETWEEN '05' AND '10') AND HOUR(a1.dateCreated) NOT BETWEEN '07' AND '19'";
			break;
		
		case 'xmas':
			$imgIds = getSequencesFromDate("2015-12-25 12:00:00");
			$specialQuery = "SELECT * FROM s_files a1
							RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId
		LEFT JOIN a_folder_file a3 ON a3.fileId = a1.id
		 WHERE (MONTH( a1.dateCreated ) NOT BETWEEN '05' AND '10') AND HOUR(a1.dateCreated) NOT BETWEEN '07' AND '19'";
			break;
			
		default:
			
			break;
	}
	
	$result = mysqli_query($link, $specialQuery);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

/*
function getNbImages($type)
{
	switch($type)
	{
		case "byYear":
			getNbImagesByYear($year)
			break;
		
	}
}
 * */

function getNbImagesByDates($startDate, $endDate, $noDuplicates)
{
		
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($noDuplicates == "true")
	{
		$queryString = "SELECT COUNT(*) FROM (SELECT * FROM s_files GROUP BY size, dateCreated) a1
RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId
LEFT JOIN a_folder_file a3 ON a3.fileId = a1.id
WHERE a1.dateCreated >= '".$startDate." 00:00:00' AND a1.dateCreated <= '".$endDate." 23:59:59'";
	}
	else {
		$queryString = "SELECT COUNT(*) FROM s_files a1
							RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId
		LEFT JOIN a_folder_file a3 ON a3.fileId = a1.id
		 WHERE a1.dateCreated >= '".$startDate." 00:00:00' AND a1.dateCreated <= '".$endDate." 23:59:59'";
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getNbAllImages($excludeParams)
{
		
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$excludeParamsArr = explode(",", $excludeParams);
	
	$queryString = "SELECT COUNT(*) FROM s_files a1";
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "lastAdded":
				$queryString = $queryString . " RIGHT JOIN a_date_file a2 ON a1.id = a2.fileId";
				break;
			case "foldersOut":
				$queryString = $queryString . " RIGHT JOIN a_folder_file a3 ON a1.id = a3.fileId";
				break;
			case "online":
				$macAdress = getDeviceId(getDeviceMacFromIp($_SERVER['REMOTE_ADDR']));
				$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
	RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON (a1.deviceId = a6.id OR a1.deviceId = \"".$macAdress."\")";
				break;
		}
	}
	
	//$queryString = "SELECT COUNT(*) FROM s_files";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getAllImages($offset, $count, $excludeParams)
{
	setServerState(1);
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
		
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$excludeParamsArr = explode(",", $excludeParams);
	
	$queryString = "SELECT * FROM s_files a1";
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "lastAdded":
				$queryString = $queryString . " RIGHT JOIN a_date_file a2 ON a1.id = a2.fileId";
				break;
			case "foldersOut":
				$queryString = $queryString . " RIGHT JOIN a_folder_file a3 ON a1.id = a3.fileId";
				break;
			case "online":
				$isOnline = true;
				$macAdress = getDeviceId(getDeviceMacFromIp($_SERVER['REMOTE_ADDR']));
				$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
	RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON (a1.deviceId = a6.id OR a1.deviceId = \"".$macAdress."\")";
				break;
				
		}
	}
	
	$queryString = $queryString . " LEFT JOIN a_file_thumb a7 ON a7.fileId = a1.id";
	//$queryString = $queryString . " LEFT JOIN (SELECT a4.id, a4.MD5, nb FROM s_files a4 INNER JOIN (SELECT id, COUNT(*) AS nb FROM s_files GROUP BY MD5 HAVING COUNT( * ) >1 AND MD5 != '')a5 ON a4.id = a5.id) a6 ON a1.MD5 = a6.MD5";
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "lastAdded":
				$queryString = $queryString . "";
				break;
			case "foldersOut":
				$queryString = $queryString . " WHERE a3.folderId NOT IN (3087)";
				break;
		}
	}
	
	
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "lastAdded":
				$queryString = $queryString . " ORDER BY a2.addDate DESC";
				break;
			case "foldersOut":
				$queryString = $queryString . "";
				break;
		}
	}

	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$images[$i]['Duplicates'] = $row[27];
		$images[$i]['isThumb'] = ($isOnline) ? $row[28] : $row[25] ;
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
	
	setServerState(0);
}

function getNbFilesByStorage($deviceId, $noDuplicates)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
		
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($noDuplicates == "true")
	{
		$queryString = "SELECT COUNT(*) FROM (SELECT * FROM s_files a1 WHERE deviceId = ".$deviceId." GROUP BY size, dateCreated )groups";
	
		//$queryString = $queryString . " GROUP BY MD5";
	}
	else {
		$queryString = "SELECT COUNT(*) FROM s_files a1 WHERE deviceId = ".$deviceId;
	
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getNbImagesByStorage($deviceId, $noDuplicates)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
		
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($noDuplicates == "true")
	{
		$queryString = "SELECT COUNT(*) FROM (SELECT * FROM s_files a1 WHERE fileType < 20 AND deviceId = ".$deviceId." GROUP BY size, dateCreated)groups";
	
		//$queryString = $queryString . " GROUP BY MD5";
	}
	else {
		$queryString = "SELECT COUNT(*) FROM s_files a1 WHERE fileType < 20 AND deviceId = ".$deviceId;
	
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getNbVideosByStorage($deviceId, $noDuplicates)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
		
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($noDuplicates == "true")
	{
		$queryString = "SELECT COUNT(*) FROM (SELECT * FROM s_files a1 WHERE fileType >= 20 AND deviceId = ".$deviceId." GROUP BY size, dateCreated )groups";
	
		//$queryString = $queryString . " GROUP BY MD5";
	}
	else {
		$queryString = "SELECT COUNT(*) FROM s_files a1 WHERE fileType >= 20 AND deviceId = ".$deviceId;
	
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getImagesByStorage($deviceId, $noDuplicates, $offset, $count)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
		
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_files a1";
	$queryString = $queryString . " LEFT JOIN a_file_thumb a7 ON a7.fileId = a1.id";
	//$queryString = $queryString . " LEFT JOIN (SELECT a4.id, a4.MD5, nb FROM s_files a4 INNER JOIN (SELECT id, COUNT(*) AS nb FROM s_files GROUP BY MD5 HAVING COUNT( * ) >1 AND MD5 != '')a5 ON a4.id = a5.id) a6 ON a1.MD5 = a6.MD5";
	
	$queryString = $queryString . " WHERE deviceId = ".$deviceId;
	
	if($noDuplicates == "true")
	{
		$queryString = $queryString . " GROUP BY size, dateCreated";
		//$queryString = $queryString . " GROUP BY MD5";
	}
	
	$queryString = $queryString . " ORDER BY a1.dateCreated DESC";
	
	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$images[$i]['isThumb'] = $row[20];
		//$images[$i]['Duplicates'] = $row[21];
		//$images[$i]['FolderId'] = $row[22];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getNbSelfies($noDuplicates)
{
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
			$queryString = "SELECT COUNT(*)
FROM s_files a1
WHERE a1.width = (
SELECT frontCameraWidth
FROM d_device_specs
WHERE brand = a1.cameraMake
AND model = a1.cameraModel ) OR a1.height = (
SELECT frontCameraHeight
FROM d_device_specs
WHERE brand = a1.cameraMake
AND model = a1.cameraModel )";
	
	if($noDuplicates == "true")
	{
		$queryString = $queryString . " GROUP BY a1.size, a1.dateCreated";
		//$queryString = $queryString . " GROUP BY a1.dateCreated";
	}
	
	$queryString = $queryString . " ORDER BY a1.dateCreated ASC";
	
	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function getSelfies($noDuplicates, $offset, $count)
{
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
			$queryString = "SELECT * FROM s_files a1
			LEFT JOIN (SELECT a4.id, a4.MD5, nb FROM s_files a4 INNER JOIN (SELECT id, COUNT(*) AS nb FROM s_files GROUP BY MD5 HAVING COUNT( * ) >1 AND MD5 != '')a5 ON a4.id = a5.id) a6 ON a1.MD5 = a6.MD5
WHERE
( a1.width = ( SELECT frontCameraWidth FROM d_device_specs WHERE brand = a1.cameraMake AND model = a1.cameraModel )
AND a1.height = ( SELECT frontCameraHeight FROM d_device_specs WHERE brand = a1.cameraMake AND model = a1.cameraModel ))
OR
( a1.height = ( SELECT frontCameraWidth FROM d_device_specs WHERE brand = a1.cameraMake AND model = a1.cameraModel )
AND a1.width = ( SELECT frontCameraHeight FROM d_device_specs WHERE brand = a1.cameraMake AND model = a1.cameraModel ))";
	
	if($noDuplicates == "true")
	{
		$queryString = $queryString . " GROUP BY a1.size, a1.dateCreated";
		//$queryString = $queryString . " GROUP BY a1.dateCreated";
	}
	
	$queryString = $queryString . " ORDER BY a1.dateCreated ASC";
	
	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$images[$i]['Duplicates'] = $row[21];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getOriginalImage($imgId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_files 
	WHERE width >= (SELECT width FROM s_files WHERE id=".$imgId.") 
	AND height >= (SELECT height FROM s_files WHERE id=".$imgId.") 
	AND dateCreated = (SELECT dateCreated FROM s_files WHERE id=".$imgId.") 
	AND id != ".$imgId."";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getImagesByDates($startDate, $endDate, $noDuplicates, $offset, $count)
{
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_files a1 
	RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId 
	LEFT JOIN a_folder_file a3 ON a3.fileId = a1.id 
	LEFT JOIN a_file_thumb a7 ON a7.fileId = a1.id
	WHERE a1.dateTaken >= '".$startDate." 00:00:00' AND a1.dateTaken <= '".$endDate." 23:59:59'";
	
	if($noDuplicates == "true")
	{
		$queryString = $queryString . " GROUP BY a1.size, a1.dateTaken";
		//$queryString = $queryString . " GROUP BY a1.dateCreated";
	}
	
	$queryString = $queryString . " ORDER BY a1.dateTaken ASC";
	
	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$images[$i]['isThumb'] = $row[25];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getImagesByMonth($year, $month, $noDuplicates, $offset, $count)
{
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM s_files a1";
	
	$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
	RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id";
	
	$queryString = $queryString . " WHERE YEAR(a1.dateTaken) = ".$year." AND MONTH(a1.dateTaken) = ".$month;
	
	if($noDuplicates == "true")
	{
		$queryString = $queryString . " GROUP BY a1.size, a1.dateTaken";
		//$queryString = $queryString . " GROUP BY a1.dateCreated";
	}
	
	$queryString = $queryString . " ORDER BY a1.dateTaken ASC";
	
	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['remoteURL'] = getUSBRemotePath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['localPath'] = getUSBLocalPath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$images[$i]['Duplicates'] = $row[26];
		$images[$i]['isThumb'] = $row[23];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getTodayImages($deviceId)
{
		
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
			$queryString = "SELECT * FROM s_files a1
			RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
			RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id
		 	WHERE MONTH(a1.dateTaken) = MONTH(NOW())
		 	AND DAY(a1.dateTaken) = DAY(NOW())";
	
	$result = mysqli_query($link, $queryString);
	
	/*if(mysqli_num_rows($result) == 0)
	{
		$queryString = "SELECT COUNT(*) FROM s_files WHERE 1";
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		$random = rand(0, $row[0]-1);
		
		$queryString = "SELECT * FROM s_files a1
		WHERE 1
		LIMIT ".$random.",10";
	
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
	}*/
	
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['remoteURL'] = getUSBRemotePath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['localPath'] = getUSBLocalPath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}

function getYears($excludeParams)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$excludeParamsArr = explode(",", $excludeParams);
	
	$queryString = "SELECT a1.url, YEAR(a1.dateTaken), a1.id, a1.storageType, COUNT(*), a1.deviceId
			FROM s_files a1";
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "online":
				$macAdress = getDeviceId(getDeviceMacFromIp($_SERVER['REMOTE_ADDR']));
				$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
	RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id";
				
				break;
				
		}
	}
	
	$queryString = $queryString . " WHERE YEAR( a1.dateTaken ) > 1900
			GROUP BY YEAR( a1.dateTaken )";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$folders = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		//$folders[$i]['image'] = addslashes($row[0]);
		$folders[$i]['image'] = getUSBRemotePath(getDeviceHwId($row[5]), addslashes($row[0]));
		$folders[$i]['thumb'] = $publicDirectory."thumbs/".floor($row[2] / 1000)."/".$row[2].".jpg";
		$folders[$i]['name'] = $row[1];
		$folders[$i]['count'] = $row[4];
		$folders[$i]['deviceId'] = getDeviceHwId($row[5]);
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($folders) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$folders[$i]['thumb']."\",\"Title\":\"".$folders[$i]['name']."\",\"DeviceId\":\"".$folders[$i]['deviceId']."\",\"ImageUrl\":\"".$folders[$i]['image']."\",\"Count\":\"".$folders[$i]['count']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getMonths($year,$excludeParams)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$excludeParamsArr = explode(",", $excludeParams);
	
	//SET lc_time_names = 'fr_FR';
	//SELECT MONTHNAME(dateTaken) FROM `s_files` WHERE YEAR(dateTaken) = 2016 GROUP BY MONTH(dateTaken)
	
	$queryString = "SELECT a1.url, MONTH(a1.dateTaken), a1.id, a1.storageType, COUNT(*), a1.deviceId
			FROM s_files a1";
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "online":
				$macAdress = getDeviceId(getDeviceMacFromIp($_SERVER['REMOTE_ADDR']));
				$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
	RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id";
				
				break;
				
		}
	}
	
	$queryString = $queryString . " WHERE YEAR( a1.dateTaken ) = ".$year." GROUP BY MONTH( a1.dateTaken )";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$folders = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		//$folders[$i]['image'] = addslashes($row[0]);
		$folders[$i]['image'] = getUSBRemotePath(getDeviceHwId($row[5]), addslashes($row[0]));
		$folders[$i]['thumb'] = $publicDirectory."thumbs/".floor($row[2] / 1000)."/".$row[2].".jpg";
		$folders[$i]['name'] = $year."-".$row[1];
		$folders[$i]['count'] = $row[4];
		$folders[$i]['deviceId'] = getDeviceHwId($row[5]);
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($folders) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$folders[$i]['thumb']."\",\"Title\":\"".$folders[$i]['name']."\",\"DeviceId\":\"".$folders[$i]['deviceId']."\",\"ImageUrl\":\"".$folders[$i]['image']."\",\"Count\":\"".$folders[$i]['count']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getYearsAndMonth()
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT filename, YEAR( dateCreated ) , id, storageType, MONTH( dateCreated ), COUNT( * )
FROM s_files
GROUP BY YEAR( dateCreated ) , MONTH( dateCreated )
ORDER BY dateCreated DESC";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	$folders = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$folders[$i]['image'] = $publicDirectory.$row[0];
		$folders[$i]['thumb'] = $publicDirectory."thumbs/".floor($row[2] / 1000)."/".$row[2].".jpg";
		$folders[$i]['name'] = $row[4]." / ".$row[1];
		$folders[$i]['count'] = $row[5];
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($folders) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$folders[$i]['thumb']."\",\"Title\":\"".$folders[$i]['name']."\",\"ImageUrl\":\"".$folders[$i]['image']."\",\"Count\":\"".$folders[$i]['count']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getNbImagesByYear($year)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT COUNT(*)
			FROM s_files 
			WHERE YEAR( dateCreated ) =".$year;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	print($row[0]);
}

function api_getImagesByYear($year, $owner, $allPublic, $offset, $count, $excludeParams)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$enddate = (!$enddate) ? "NOW()" : "'".$enddate."'";
	
/////////////////////////////////////////////
///////////// TOTAL COUNT ///////////////////
/////////////////////////////////////////////
	if($count == "-1")
	{
		$queryString = "SELECT COUNT(*) FROM s_files a1
			RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId";
		
		$excludeParamsArr = explode(",", $excludeParams);
		
		foreach ($excludeParamsArr as $key) {
			switch($key)
			{
				case "lastAdded":
					$queryString = $queryString . " RIGHT JOIN a_date_file a2 ON a1.id = a2.fileId";
					break;
				case "foldersOut":
					$queryString = $queryString . " RIGHT JOIN a_folder_file a3 ON a1.id = a3.fileId";
					break;
				case "online":
					$macAdress = getDeviceId(getDeviceMacFromIp($_SERVER['REMOTE_ADDR']));
				//$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4
	//RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON (a1.deviceId = a6.id OR a1.deviceId = \"".$macAdress."\")";
		$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4 RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id";
				
					break;
			}
		}
		
		if($allPublic == "true")
		{
			$queryString = $queryString . "	WHERE YEAR( a1.dateTaken ) =".$year." AND a2.ownerId =11";
			//AND a1.fileType != 4";
		}
		else
		{
			$queryString = $queryString . "	WHERE YEAR( dateTaken ) =".$year." AND (a2.ownerId =11 OR a2.rightId =2)";
		}
		
		foreach ($excludeParamsArr as $key) {
			switch($key)
			{
				case "lastAdded":
					$queryString = $queryString . " ORDER BY a2.addDate DESC";
					break;
			}
		}
	
		if($offset != "")
		{
			$queryString = $queryString." LIMIT ".$offset.",".$count;
		}
		
		error_log("QUERY COUNT :: ".$queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		print($row[0]);
	}
////////////////////////////////////////////
////////////////////////////////////////////
else
{
	
	$queryString = "SELECT * FROM s_files a1
			RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId";
		
	$excludeParamsArr = explode(",", $excludeParams);
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "lastAdded":
				$queryString = $queryString . " RIGHT JOIN a_date_file a2 ON a1.id = a2.fileId";
				break;
			case "foldersOut":
				$queryString = $queryString . " RIGHT JOIN a_folder_file a3 ON a1.id = a3.fileId";
				break;
			case "online":
				$macAdress = getDeviceId(getDeviceMacFromIp($_SERVER['REMOTE_ADDR']));
				$queryString = $queryString . " RIGHT JOIN (SELECT a4.id, a4.hardwareId FROM s_devices a4 RIGHT JOIN t_online_devices a5 ON a4.hardwareId = a5.hardwareId)a6 ON a1.deviceId = a6.id";
				break;
		}
	}
	
	$queryString = $queryString . " LEFT JOIN a_file_thumb a7 ON a7.fileId = a1.id";
	
	if($allPublic == "true")
	{
		$queryString = $queryString . "	WHERE YEAR( a1.dateTaken ) =".$year." AND a2.ownerId =11";
		//AND a1.fileType != 4";
	}
	else
	{
		$queryString = $queryString . "	WHERE YEAR( dateTaken ) =".$year." AND (a2.ownerId =11 OR a2.rightId =2)";
	}
	
	foreach ($excludeParamsArr as $key) {
		switch($key)
		{
			case "lastAdded":
				$queryString = $queryString . " ORDER BY a2.addDate DESC";
				break;
		}
	}

	if($offset != "")
	{
		$queryString = $queryString." LIMIT ".$offset.",".$count;
	}
	
	error_log(" QUERY GET IMAGES BY YEAR :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Id'] = $row[0] ;
		$images[$i]['Image'] = addslashes($row[11]) ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[0] / 1000)."/".$row[0].".jpg" ;
		$images[$i]['remoteURL'] = getUSBRemotePath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['localPath'] = getUSBLocalPath(getDeviceHwId($row[12]), addslashes($row[11]));
		$images[$i]['Date'] = $row[3] ;
		$images[$i]['Device'] = $row[12];
		$images[$i]['Name'] = $row[1];
		$images[$i]['StorageType'] = $row[13];
		$images[$i]['MediaType'] = ($row[2] < 20) ? "image" : "video";
		$images[$i]['FolderId'] = $row[22];
		$images[$i]['Size'] = $row[8];
		$images[$i]['Width'] = $row[6];
		$images[$i]['Height'] = $row[7];
		$images[$i]['GpsLongitude'] = $row[10];
		$images[$i]['GpsLatitude'] = $row[9];
		$images[$i]['DateModified'] = $row[5];
		$images[$i]['DateCreated'] = $row[4];
		$images[$i]['CameraModel'] = $row[15];
		$images[$i]['CameraMake'] = $row[14];
		$images[$i]['Owner'] = $row[19];
		$images[$i]['Rights'] = $row[20];
		$images[$i]['Duration'] = $row[18];
		$images[$i]['Duplicates'] = $row[26];
		$images[$i]['isThumb'] = $row[23];
		
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	outputToutesSchema($images);
}
}

function api_getImagesByAddedDate($startdate, $enddate, $owner, $allPublic)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$enddate = (!$enddate) ? "NOW()" : "'".$enddate."'";
	if($allPublic == "true")
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId
						RIGHT JOIN a_date_file a3 ON a1.id = a3.fileId
						WHERE a2.ownerId=".$owner." OR a2.rightId=2 AND a3.dateCreated BETWEEN '".$startdate."' AND ".$enddate;
	
	}
	else
	{
		$queryString = "SELECT * FROM s_files a1
						RIGHT JOIN a_owner_right_file a2 ON a1.id = a2.fileId
						RIGHT JOIN a_date_file a3 ON a1.id = a3.fileId
						WHERE a2.ownerId=".$owner."AND a3.dateCreated BETWEEN '".$startdate."' AND ".$enddate;
	
	}
	$result = mysqli_query($link, $queryString);
	$images = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$images[$i] = Array() ;
		$images[$i]['Image'] = $publicDirectory.$row[1] ;
		$images[$i]['Thumb'] = $publicDirectory."thumbs/".floor($row[1] / 1000)."/".$row[1] ;
		$images[$i]['Title'] = $row[0] ;
		$images[$i]['EMAIL'] = $row[2] ;
		$images[$i]['Phone'] = $row[2] ;
		$i++;
	}

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	
	$output = "[";
	for ($i=0; $i < count($images) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$images[$i]['Thumb']."\",\"Title\":\"\",\"EMAIL\":\"\",\"Image\":\"".$images[$i]['Image']."\",\"Phone\":\"\"}," ;
	}

	$output = substr($output,0,-1)."]";
	print($output);
}

function getSavedPics($owner, $pics)
{
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$decodePics = json_decode($pics, true);
	$i=0;
	$images = Array() ;
	error_log($pics);
	foreach($decodePics as $pic)
	{
		$queryString = "SELECT * FROM s_files WHERE filename = \"".$pic["Name"]."\" AND dateCreated = '".$pic["Date"]."'";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		
		$row = mysqli_fetch_row($result);
		error_log($row);
		if($row)
		{
			$images[$i]["name"] = $row[1];
			$images[$i]["date"] = $row[6];
			$i++;
		}
		
		mysqli_free_result($result);
	}
	
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($images) ; $i++)
	{
		$output = $output."{\"ImageName\":\"".$images[$i]['name']."\",\"ImageDate\":\"".$images[$i]['date']."\"}," ;
	}

	$output = ($output == "[")?"[]":substr($output,0,-1)."]";
	print($output);
	
}

function api_getImagesAndFolders($startdate, $enddate, $owner, $allPublic)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
 
	//Enregistrement en BDD
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($allPublic == "true")
	{
		if($startdate)
		{
			$enddate = (!$enddate) ? "NOW()" : "'".$enddate."'";
			$queryString = "SELECT a3.name AS Folder, a1.filename AS Name FROM s_files a1
							RIGHT JOIN a_folder_file a2 ON a1.id = a2.fileid
							RIGHT JOIN s_folders a3 ON a3.id = a2.folderid
							RIGHT JOIN a_owner_right_file a4 ON a1.id = a4.fileId
							WHERE a4.ownerId=".$owner." OR a4.rightId=2 AND a1.dateCreated BETWEEN '".$startdate."' AND ".$enddate."
							ORDER BY a3.id";
		}
		else
		{
			$queryString = "SELECT a3.name AS Folder, a1.filename AS Name FROM s_files a1
							RIGHT JOIN a_folder_file a2 ON a1.id = a2.fileid
							RIGHT JOIN s_folders a3 ON a3.id = a2.folderid
							RIGHT JOIN a_owner_right_file a4 ON a1.id = a4.fileId
							WHERE a4.ownerId=".$owner." OR a4.rightId=2
							ORDER BY a3.id";
	
		}
	}
	else
	{
		if($startdate)
		{
			$enddate = (!$enddate) ? "NOW()" : "'".$enddate."'";
			$queryString = "SELECT a3.name AS Folder, a1.filename AS Name FROM s_files a1
							RIGHT JOIN a_folder_file a2 ON a1.id = a2.fileid
							RIGHT JOIN s_folders a3 ON a3.id = a2.folderid
							RIGHT JOIN a_owner_right_file a4 ON a1.id = a4.fileId
							WHERE a4.ownerId=".$owner." AND a1.dateCreated BETWEEN '".$startdate."' AND ".$enddate."
							ORDER BY a3.id";
		}
		$queryString = "SELECT a3.name AS Folder, a1.filename AS Name FROM s_files a1
						RIGHT JOIN a_folder_file a2 ON a1.id = a2.fileid
						RIGHT JOIN s_folders a3 ON a3.id = a2.folderid
						RIGHT JOIN a_owner_right_file a4 ON a1.id = a4.fileId
						WHERE a4.ownerId=".$owner."
						ORDER BY a3.id";
	}
	
	
	//print("QUERY :: ".$queryString);
	$result = mysqli_query($link, $queryString);
	
	$folders = Array();
	$images = Array() ;
	$i = 0 ;
	$folderIndex = -1;
	
	while ($row = mysqli_fetch_row($result))
	{
		if($row[0] != $folders[$folderIndex]['folder'])
		{
			$folderIndex++;
			$i = 0;
			$folders[$folderIndex]['folder'] = $row[0];
		}
		$folders[$folderIndex]['images'][$i] = Array() ;
		$folders[$folderIndex]['images'][$i]['Image'] = $publicDirectory.$row[1] ;
		$folders[$folderIndex]['images'][$i]['Thumb'] = $publicDirectory.$row[1] ;
		$folders[$folderIndex]['images'][$i]['Title'] = $row[1] ;
		$i++;
	}
//var_dump($folders);

 /* Libère le jeu de résultats */
    mysqli_free_result($result);
	mysqli_close($link);
	//var_dump($images) ;
	$output = "[";
	for ($i=0; $i < count($folders) ; $i++)
	{
		$output = $output."{\"Folder\":\"".$folders[$i]['folder']."\",\"Images\":";
		for($j=0; $j<count($folders[$i]['images']); $j++)
		{
			$output = $output."{\"ThumbUrl\":\"".$folders[$i]['images'][$j]['Thumb']."\",\"Title\":\"\",\"EMAIL\":\"\",\"Image\":\"".$folders[$i]['images'][$j]['Image']."\",\"Phone\":\"\"}," ;
		}
		
		$output = substr($output,0,-1)."},";
	}

	$output = substr($output,0,-1)."]";
	print($output);
}

function api_getDates($owner, $allPublic)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($allPublic == "true")
	{
		$queryString = "SELECT a2.filename, YEAR(a2.dateCreated), a2.id, a2.storageType FROM a_owner_right_file a1
						RIGHT JOIN s_files a2 ON a1.fileId = a2.id
						WHERE a1.ownerId=".$owner." OR a1.rightId=2
						GROUP BY YEAR(a2.dateCreated)";
	}
	else
	{
		$queryString = "SELECT a2.filename, YEAR(a2.dateCreated), a2.id, a2.storageType FROM a_owner_right_file a1
						RIGHT JOIN s_files a2 ON a1.fileId = a2.id
						WHERE a1.ownerId=".$owner."
						GROUP BY YEAR(a2.dateCreated)";
	}
	
	$result = mysqli_query($link, $queryString);
	
	$folders = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$folders[$i]['image'] = $publicDirectory.$row[0];
		$folders[$i]['thumb'] = $publicDirectory."thumbs/".floor($row[2] / 1000)."/".$row[2].".jpg";
		$folders[$i]['name'] = $row[1];
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($folders) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$folders[$i]['thumb']."\",\"Title\":\"".$folders[$i]['name']."\",\"ImageUrl\":\"".$folders[$i]['image']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function api_getCameras($owner, $allPublic)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	if($allPublic == "true")
	{
		$queryString = "SELECT a2.filename, YEAR(a2.dateCreated), a2.id, a2.storageType, a2.cameraMake, a2.cameraModel, a2.url, a2.deviceId FROM a_owner_right_file a1
						RIGHT JOIN s_files a2 ON a1.fileId = a2.id
						WHERE a1.ownerId=".$owner." OR a1.rightId=2
						GROUP BY a2.cameraModel";
	}
	else
	{
		$queryString = "SELECT a2.filename, YEAR(a2.dateCreated), a2.id, a2.storageType, a2.cameraMake, a2.cameraModel, a2.url, a2.deviceId FROM a_owner_right_file a1
						RIGHT JOIN s_files a2 ON a1.fileId = a2.id
						WHERE a1.ownerId=".$owner."
						GROUP BY a2.cameraModel";
	}
	
	$result = mysqli_query($link, $queryString);
	
	$folders = Array() ;
	$i = 0 ;
	
	while ($row = mysqli_fetch_row($result))
	{
		$folders[$i]['image'] = $publicDirectory.$row[0];
		$folders[$i]['thumb'] = $publicDirectory."thumbs/".floor($row[2] / 1000)."/".$row[2].".jpg";
		$folders[$i]['name'] = $row[4]." ".$row[5];
		$folders[$i]['deviceId'] = $row[7];
		$folders[$i]['imageUrl'] = addslashes($row[6]);
		$i++;
	}
	
	mysqli_free_result($result);
	mysqli_close($link);
	
	$output = "[";
	for ($i=0; $i < count($folders) ; $i++)
	{
		$output = $output."{\"ThumbUrl\":\"".$folders[$i]['thumb']."\",\"Title\":\"".$folders[$i]['name']."\",\"DeviceId\":\"".$folders[$i]['deviceId']."\",\"ImageUrl\":\"".$folders[$i]['imageUrl']."\"}," ;
	}

	$output = ($output == "[") ? "[]" : substr($output,0,-1)."]";
	print($output);
}

function getWifiAp()
{
	$aps = getAvailableWifiAP();
	$apJson = json_encode($aps, TRUE);
	print($apJson);
}


function setNetwork($mode)
{
	switch($mode)
	{
		case "Local":
			setLocalNetwork($_GET["name"], $_GET["pass"]);
			break;
			
		case "AP":
			setDirectAP();
			break;
	}
}

?>

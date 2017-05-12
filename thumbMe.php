<?php
error_log("thumbMe.php");
include_once("tools.php");
include_once("scanDevice.php");
include_once("sunnyweb.php");
//phpinfo();
//makeThumbs();
function makeThumbs()
{
	//$section = file_get_contents('/var/www/isThumbMeRunning.txt', NULL, NULL, 0, 7);
	$original = scan('/var/www/ressources/backup/');
	$thumbs = scan('/var/www/ressources/thumbs/');
	$missing['thumbs'] = array_diff($original, $thumbs);
	if(/*$section == "running" || */count($missing['thumbs']) <= 0)
	{
		exit;
	}
	else {
		doMakeThumbs();
	}
	makeThumbs();
}

mountUsbDevices();

/*
$devices = getUsbDevices();

$folders = [];
foreach($devices as $device)
{
	if($device['MOUNT'] != "")
	{
		$folders = getFoldersFromPath(getMountPointFromDeviceId($device['ID']), $folders);
	}
}
var_dump($folders);
*/

function getFilesFromUsb($mountPoint, $deviceId)
{
	$files = [];
	$allFiles = getFilesFromPath($mountPoint, $files);

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
					array_push($scannedFiles, [
					"filename" => $value2,
					"url" => $key.$value2, 
					"fileType" => $fileType, 
					"dateTaken" => $exif["EXIF"]["DateTimeOriginal"], 
					"latitude" =>  $exif["GPS"]["latitude"], 
					"longitude" => $exif["GPS"]["longitude"],
					"size" => $exif["FILE"]['FileSize'],
					"width" => ($exif["IFD0"]['Orientation'] == 6 || $exif["IFD0"]['Orientation'] == 6) ? $exif["EXIF"]['ExifImageWidth'] : $exif["EXIF"]['ExifImageLength'],
					"height" => ($exif["IFD0"]['Orientation'] == 6 || $exif["IFD0"]['Orientation'] == 6) ? $exif["EXIF"]['ExifImageLength'] : $exif["EXIF"]['ExifImageWidth'],
					"cameraManufacturer" => trim($exif["IFD0"]["Make"]),
					"cameraModel" => trim($exif["IFD0"]["Model"]),
					"ownerId" => 11,
					"rightId" => 2,
					"md5" => getMD5($key.$value2)]);
				}
			}
		}	
	}
	scanParams($deviceId, $userId, $userRights, $scannedFolder, $scannedFiles);
}
/*
$_POST['deviceId'];
$folder['folderName'];
$_POST['userId'];
$_POST['rights'];
$_POST["scanedFolder"];
addslashes($folder['folderUrl']);
$_POST['files'];
addslashes($fileJson["url"]);
$fileJson['fileType'];
$fileJson['dateTaken'];
$fileJson['dateCreated'];
$fileJson['dateModified'];
floatval($fileJson['latitude']);
floatval($fileJson['longitude']);
$fileJson['size'];
$fileJson['width'];
$fileJson['height'];
$fileJson['cameraManufacturer'];
$fileJson['cameraModel'];
 */

function doMakeThumbs()
{
	//file_put_contents('/var/www/isThumbMeRunning.txt', "running");
	$original = scan('/var/www/ressources/backup/');
	$thumbs = scan('/var/www/ressources/thumbs/');
	$missing['thumbs'] = array_diff($original, $thumbs);
	//$missing['original'] = array_diff($thumbs, $original);
	
	foreach ($missing['thumbs'] as $image)
	{
		$ImageNews = $image;
	 
		$ExtensionPresumee = explode('.', $ImageNews);
		$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
		if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg' || $ExtensionPresumee == 'JPG' || $ExtensionPresumee == 'JPEG')
		{
		  	error_log("NEW IF 1") ;
		  	$ImageNews = getimagesize("/var/www/ressources/backup/".$image);
		  	
			$ImageChoisie = imagecreatefromjpeg("/var/www/ressources/backup/".$image);
			$TailleImageChoisie = getimagesize("/var/www/ressources/backup/".$image);
			$NouvelleLargeur = 200; //Largeur choisie à 350 px mais modifiable
		 
		  		$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
		 
		  		$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
		 
		  		try
		  		{
		  			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
				}
				catch(exception $e)
				{
					//file_put_contents('/var/www/isThumbMeRunning.txt', "");
				}
		  		imagedestroy($ImageChoisie);
		        
				error_log("CREATION IMAGE") ;                             
			imagejpeg($NouvelleImage , "/var/www/ressources/thumbs/".$image, 100);
		}else{
			error_log("ELSE 1");
		}
	}

	//file_put_contents('/var/www/isThumbMeRunning.txt', "");
}

?>
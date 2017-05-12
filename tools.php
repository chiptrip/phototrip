<?php
include_once("scanDevice.php");
session_start();
//$link = mysqli_connect("localhost", "root", "sunny", "sunny");
// renvoi la distance en mètres
function get_distance_m($lat1, $lng1, $lat2, $lng2) {
  $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
  $rlo1 = deg2rad($lng1);
  $rla1 = deg2rad($lat1);
  $rlo2 = deg2rad($lng2);
  $rla2 = deg2rad($lat2);
  $dlo = ($rlo2 - $rlo1) / 2;
  $dla = ($rla2 - $rla1) / 2;
  $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo
));
  $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
  return ($earth_radius * $d);
}

function recursiveSearch($array, $key)
{
	foreach($array as $item) {
		if(isset($item->$key)) {
            error_log("TROUVE !! :: ".$item);
        }
	}
}

function getAddressFromCoordinate($lat, $long)
{
	//$lat="54.1456123";
	//$long = "10.413456";
	
	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false";
	error_log($url);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_ENCODING, "");
	$curlData = curl_exec($curl);
	
	curl_close($curl);
	/*
	
	*/
	$address = json_decode($curlData, true);

	$zip = null;
	$city = null;
	$country = null;
	$cityLat = null;
	$cityLong = null;
	
	for($i=0;$i<count($address['results']);$i++)
	{
		switch($address['results'][$i]['types'][0])
		{
			case "street_address":
				$zip = ($zip == null ) ? $address['results'][$i]['address_components'][6]['long_name'] : $zip;
				$city = ($city == null ) ? $address['results'][$i]['address_components'][2]['long_name'] : $city;
				$country = ($country == null ) ? $address['results'][$i]['address_components'][5]['long_name'] : $country;
				break;
			case "route":
				$zip = ($zip == null ) ? $address['results'][$i]['address_components'][5]['long_name']: $zip;
				$city = ($city == null ) ? $address['results'][$i]['address_components'][1]['long_name'] : $city;
				$country = ($country == null ) ? $address['results'][$i]['address_components'][4]['long_name'] : $country;
				break;
			case "postal_code":
				$zip = ($zip == null ) ? $address['results'][$i]['address_components'][0]['long_name'] : $zip;
				$city = ($city == null ) ? $address['results'][$i]['address_components'][1]['long_name'] : $city;
				$country = ($country == null ) ? $address['results'][$i]['address_components'][4]['long_name'] : $country;
				break;
			case "locality":
				$city = ($city == null ) ? $address['results'][$i]['address_components'][0]['long_name'] : $city;
				$country = ($country == null ) ? $address['results'][$i]['address_components'][3]['long_name'] : $country;
				$cityLat = $address['results'][$i]['geometry']['location']['lat'];;
				$cityLong = $address['results'][$i]['geometry']['location']['lng'];;
				break;
		}
	}

	$return = [$zip, $city, $country, $cityLat, $cityLong];
	
	return $return;
}
 
function getCoordinatesFromAddress($address){
    $address = urlencode($address);
    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
    $response = file_get_contents($url);
    $json = json_decode($response,true);
 
    $lat = $json['results'][0]['geometry']['location']['lat'];
    $lng = $json['results'][0]['geometry']['location']['lng'];
 
	print_r($coords);
    return array($lat, $lng);
}

function testExif()
{
	$exif = read_exif_data ("http://".$_SERVER['SERVER_ADDR']."/ressources/thumbs/67584.jpg", O, true);
	
	$imageInfo["make"] = $exif["IFD0"]["Make"];
	$imageInfo["date"] = $exif["EXIF"]["DateTimeOriginal"]; 
	$imageInfo["width"] = $exif["EXIF"]['ExifImageWidth'] ;
	$imageInfo["height"] = $exif["EXIF"]['ExifImageLength'] ;
	$imageInfo["size"] = $exif["FILE"]['FileSize'] ;
	
	foreach ($imageInfo as $key => $value) {
	error_log($key." :: ".$value);
	}
}

function getMD5($url)
{
	return;
	error_log("FILE NAME :: ".$url);
	$url = str_replace("(", "\(",$url);
	$url = str_replace(")", "\)",$url);
	$url = str_replace("_", "\_",$url);
	$md5=`md5sum $url`;
	error_log("MD5 :: ".$md5);
	$md5 = preg_split('/\s+/', trim($md5))[0];
	return $md5;
}

function getDeviceIdFromMountPoint($mountPoint)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		
    	exit();
	}
	
	$queryString = "SELECT hardwareId FROM t_online_devices WHERE mount=\"".$mountPoint."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	while ($row = mysqli_fetch_row($result))
	{
	 	$deviceId = $row[0];
	}
	
	return getDeviceId($deviceId);
}

function getDeviceMacFromIp($ipAddress)
{
	$macAddr=false;
	
	$arp=`/usr/sbin/arp -n $ipAddress`;
	error_log("Device Mac from IP :: ".$arp);
	$lines=explode("\n", $arp);
	foreach($lines as $line)
	{
	   $cols=preg_split('/\s+/', trim($line));
	   if ($cols[0]==$ipAddress)
	   {
	       $macAddr=$cols[2];
	   }
	}
	return $macAddr;
}

function getAvailableWifiAP()
{
	$wifiAp = [];
	$currentAp = -1;
	$command = `sudo /mnt/tools/getWifiAp.sh`;
	error_log("WIFI cmd :: ".$command);
	$lines=explode("\n", $command);
	foreach($lines as $line)
	{
		error_log("WIFI line :: ".$line);
		$split = split(":", $line);
		if($split[0] == "Name")
		{
			error_log("WIFI AP name :: ".$line);
			$currentAp ++ ;
			
			$wifiAp[$currentAp] = [$split[0] => $split[1]];
		}
		else if($line != "") {
			//$wifiAp[$currentAp][$split[0]]= $split[1];
		}
		//error_log("WIFI AP :: ".$line);
		
	}
	
	//error_log($wifiAp);
	return $wifiAp;
}

function setLocalNetwork($APName, $passphrase)
{
	$command = `sudo cp /mnt/tools/interfacesDhcp /mnt/tools/interfacesToModify`;
	$command = `sudo /mnt/tools/setLocalAreaInterface.sh $APName $passphrase`;
	$command = `sudo cp /mnt/tools/interfacesToModify /etc/network/interfaces`;
	error_log("SET LOCAL DONE :: ".$command);
	//$restart = `sudo /usr/sbin/service networking restart`;
	$restart = `sudo /sbin/ifup wlan0`;
	$restart = `sudo /usr/sbin/service networking restart`;
	
}

function setDirectAP()
{
	$command = `cp /mnt/tools/interfacesAP /etc/network/interfaces`;
	error_log("SET AP DONE :: ".$command);
	//$restart = `sudo /usr/sbin/service networking restart`;
	$restart = `/sbin/ifdown wlan0`;
	$restart = `/sbin/hostapd /etc/hostapd.conf`;
	return "OK";
}

function mountUsbDevices()
{
	error_log("MOUNT USB DEVICES");
	$usbDevices = [];
	$mountedDevices = [];
	$keyMount = "";
	
	$usb=`sudo /sbin/blkid | grep /dev/sd`;
	error_log("MOUNT USB DEVICES :: ".$usb);
	$lines = explode("\n", $usb);
	array_pop($lines);
	foreach($lines as $line)
	{
		error_log("USB DEVICES FROM BLKID :: ".$line);
		$cols=preg_split('/\s+/', trim($line));

		$port = trim($cols[0],":");

		array_push($usbDevices, $port);
	}
	
	$mount=`mount | grep /dev/sd`;
	$lines = explode("\n", $mount);
	array_pop($lines);
	foreach($lines as $line)
	{
		error_log("USB DEVICES ALLREADY MOUNTED :: ".$line);
		$cols=preg_split('/\s+/', trim($line));
		
		$mount = $cols[0];
		
		array_push($mountedDevices, $mount);
	}
	
	$toMountArr = array_diff($usbDevices, $mountedDevices);
	foreach($toMountArr as $toMount)
	{
		error_log("NEW DEVICE TO MOUNT :: ".$toMount);
		
			$mountPoint = split("/", $toMount);
			$mountPoint = "/mnt/".$mountPoint[count($mountPoint)-1];
		
		$mountDir = `sudo mkdir $mountPoint`;
		//error_log("toMount :: ".$toMount." :: MountPoint :: ".$mountPoint);
		
		/*
		if($mountPoint == "/mnt/key2")
			{
				error_log(`sudo mount $toMount $mountPoint`);
			}
		else
			{*/
				//error_log(`sudo mount $toMount -o umask=0022,gid=33,uid=33 $mountPoint`);
				$command = `sudo mount $toMount $mountPoint -o umask=0022,gid=33,uid=33`;
				//$command = `sudo mount $toMount $mountPoint`;
				error_log("MOUNT COMMAND :: ".$command);
				
				if($command == "")
				{
					//
				}
				
				$mountPointSplit = split("/", $mountPoint);
				$linkfolder = "/var/www/html/ressources/usb".$mountPointSplit[count($mountPointSplit)-1];
				error_log("ln -s ".$mountPoint." ".$linkfolder);
				$rmLink = `sudo rm $linkfolder`;
				$slink = `sudo ln -s $mountPoint $linkfolder`;
				error_log("LINK FOLDER :: ".$linkfolder." RESULT LN ::".$slink);
				`sudo chown -R www-data:www-data $linkfolder`;
			//}
	}
	
	if(count($toMountArr) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function umountUsbDevices()
{
	error_log("UMOUNT USB DEVICES");
	$usbDevices = [];
	$mountedDevices = [];
	
	$usb=`/sbin/blkid | grep /dev/sd`;
	$lines = explode("\n", $usb);
	array_pop($lines);
	foreach($lines as $line)
	{
		//error_log("USB :: ".$line);
		$cols=preg_split('/\s+/', trim($line));
		
		$port = trim($cols[0],":");
		
		//error_log("USB PORT :: ".$port);
		//$port = $port[count($port)-1];
		array_push($usbDevices, $port);
	}
	
	$mount=`mount | grep /dev/sd`;
	$lines = explode("\n", $mount);
	array_pop($lines);
	foreach($lines as $line)
	{
		//error_log("MOUNTED :: ".$line);
		$cols=preg_split('/\s+/', trim($line));
		//$mount = split("/", split(":", $cols[0])[0]);
		$mount = $cols[0];
		//$mount = $mount[count($mount)-1];
		array_push($mountedDevices, $mount);
	}
	
	$toUmountArr = array_diff($mountedDevices, $usbDevices);
	foreach($toUmountArr as $toUmount)
	{
		$mountPoint = `mount | grep $toUmount`;
		$mountPoint=preg_split('/\s+/', trim($mountPoint))[2];
		//$mountPoint = "/mnt/".$mountPoint[count($mountPoint)-1];
		error_log("toUmount :: ".$toUmount." :: MountPoint :: ".$mountPoint);
		$umount = `sudo umount $mountPoint`;
		error_log("UMOUNT RESULT :: ".$umount);
		removeOnlineUsbDevice($mountPoint);
		//error_log("RM dir :: ".$mountPoint);
		$rmDir = `sudo rm $mountPoint`;
		$mountPointSplit = split("/", $mountPoint);
		$linkedfolder = "/var/www/html/ressources/usb".$mountPointSplit[count($mountPointSplit)-1];
		
		$rmLinkedDir = `sudo rm $linkedfolder`;
		error_log("RM link :: ".$linkedfolder." RM RESULT :: ".$rmLinkedDir);
	}
}

function getMountPointFromDeviceId($deviceHwId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT hardwareType FROM s_devices WHERE hardwareId = \"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$row = mysqli_fetch_row($result);
	
	switch($row[0])
	{
		case "0":
			return "/var/www/html/ressources/boxUserStorage";
		case "17":
		 	$ip = getDeviceIp($deviceHwId);
			return "/mnt/".$ip;
			break;
		default :
			
			$queryString = "SELECT mount FROM  t_online_devices WHERE hardwareId = \"".$deviceHwId."\"";
			error_log($queryString);
			$result = mysqli_query($link, $queryString);
			
			$row = mysqli_fetch_row($result);
			return $row[0];
			/*
			$usb=`/sbin/blkid | grep /dev/sd`;
			$lines=explode("\n", $usb);
			array_pop($lines);
			foreach($lines as $line)
			{
			    $cols=preg_split('/\s+/', trim($line));
			    if(strstr($cols[0], "/dev/sd"))
			    {
			   		$MOUNT = split("/", split(":", $cols[0])[0]);
			   		$MOUNT = $MOUNT[count($MOUNT)-1];
			   		foreach($cols as $col)
			   		{
			   			error_log("DANS FOREACH :: ".$col);
			   			if(strstr($col, "UUID"))
			   			{
			   				$ID = trim(split("=", $col)[1], "\"");
							error_log("USB DEVICE ID :: ".$ID);
							if($ID == $deviceHwId)
							{
								error_log("MOUNT :: ".$MOUNT);
								$mount=`mount | grep $MOUNT`;
								error_log("USB DEVICE FOUND :: ".trim($mount));
								$cols=preg_split('/\s+/', trim($mount));
								return $cols[2];
							}
						}
					}
			   }
			}*/
			break;
	}
}

function addOnlineUsbDevice($deviceHwId, $mountPoint)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "INSERT INTO t_online_devices (hardwareId, type, mount) VALUES (\"".$deviceHwId."\",14,\"".$mountPoint."\")";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function removeOnlineUsbDevice($mountPoint)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "DELETE FROM t_online_devices WHERE mount = \"".$mountPoint."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function addUsbDevice($deviceId, $deviceName)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$deviceName = ($deviceName == "" || $deviceName == null) ? "USB_device" : $deviceName;
	$queryString = "INSERT INTO s_devices (name, hardwareId, hardwareType) VALUES (\"".$deviceName."\",\"".$deviceId."\",14)";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($result)
	{
		$output = "{\"Id\":\"".mysqli_insert_id($link)."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$macAdress."\",
				\"Type\":\"".$deviceType."\"";
			
		print($output);
	}
	else {
		print("KO");
	}
}

function removeOnlineRemoteDevice($mountPoint)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "DELETE FROM t_online_devices WHERE mount = \"".$mountPoint."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function addNewDevice($macAdress, $deviceName, $deviceType, $deviceScreenWidth, $deviceScreenHeight)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$deviceName = ($deviceName == "" || $deviceName == null) ? "NEW_device" : $deviceName;
	$queryString = "INSERT INTO s_devices (name, hardwareId, hardwareType, screenWidth, screenHeight) VALUES (\"".$deviceName."\",\"".$macAdress."\",".$deviceType.",\"".$deviceScreenWidth."\",\"".$deviceScreenHeight."\")";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($result)
	{			
		return mysqli_insert_id($link);
	}
}

function addNewRemoteDevice($macAdress, $deviceName, $deviceType, $user, $pwd)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
		
	$deviceName = ($deviceName == "" || $deviceName == null) ? "REMOTE_device" : $deviceName;
	$queryString = "INSERT INTO s_devices (name, hardwareId, hardwareType, user, pwd) VALUES (\"".$deviceName."\",\"".$macAdress."\",17,\"".$user."\",\"".$pwd."\")";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($result)
	{
		$output = "{\"Id\":\"".mysqli_insert_id($link)."\",
				\"Name\":\"".$deviceName."\",
				\"HwId\":\"".$macAdress."\",
				\"Type\":\"".$deviceType."\"";
			
		print($output);
		
		mountRemoteDrive($macAdress, getDeviceIp($macAdress));
		
		$url = "http://".$_SERVER['SERVER_ADDR']."/scanDevice.php?action=quickScanFromUsb&deviceHwId=".$macAdress;
		$options=array(
	      CURLOPT_URL            => $url, 
	      CURLOPT_RETURNTRANSFER => true, 
	      CURLOPT_HEADER         => false
		);
		
		$CURL=curl_init();
		curl_setopt_array($CURL,$options);
	    curl_exec($CURL);
		curl_close($CURL);
	}
	else {
		print("KO");
	}
}

function isUsbFolderSynchro($folderPath, $deviceId)
{
	error_log("SYNCH FOLDER :: ".$folderPath);
	if($folderPath == "" || $folderPath == null) return false;
	//error_log("CALL IsFolderSynchro");
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$files = [];
	$files = getFilesFromPath($folderPath, $files, "false");
	
	foreach($files[$folderPath] as $file)
	{
		$queryString = "SELECT * FROM s_files WHERE deviceId=\"".$deviceId."\" AND url=\"".substr($folderPath.$file, 9)."\"";
		
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		if($row)
		{
			return "1";
		}
		else {
			return "0";
		}
	}
}

function getUsbDevice($deviceHwId)
{
	$usbDevices = getUsbDevices();
	foreach($usbDevices as $device)
	{
		if($device['ID'] == $deviceHwId)
		{
			return $device;
		}
	}
	
	return null;
}

function getUSB()
{
	$devices = [];
	$usb=`lsusb -t | grep storage`;
	//print($usb);
	$lines=explode("\n", $usb);
	array_pop($lines);
	$ids = [];
	foreach($lines as $line)
	{
		$lines=explode(",", $line);
		$lines=explode(" ", $lines[0]);
		error_log("USB DEVICE :: ".$lines[count($lines)-1]);
		array_push($ids, $lines[count($lines)-1]);
	}
	
	foreach($ids as $id)
	{
		$usbSerial = `lsusb -s $id -v | grep iSerial`;
		$result=explode(" ", $usbSerial);
		error_log("USB DEVICE SERIAL :: ".$result[count($result)-1]);
	}
}

function getUsbDevices()
{
	//getUSB();	
	$devices = [];
	$usb=`/sbin/blkid | grep /dev/sd`;
	//print($usb);
	$lines=explode("\n", $usb);
	array_pop($lines);
	foreach($lines as $line)
	{
		$device = [];
	   $cols=preg_split('/\s+/', trim($line));
	   //error_log("POURQUOI ?? |".$cols[0]."|");
	   if(strstr($cols[0], "/dev/sd"))
	   {
	   		$device = [];
	   		$MOUNT = split("/", split(":", $cols[0])[0]);
	   		$MOUNT = $MOUNT[count($MOUNT)-1];
			error_log("USB DEVICE MOUNT :: ".$MOUNT);
			$device['MOUNT'] = $MOUNT;
	   		foreach($cols as $col)
	   		{
	   			
	   			if(strstr($col, "UUID"))
	   			{
	   				$ID = trim(split("=", $col)[1], "\"");
					error_log("USB DEVICE ID :: ".$ID);
					$device['ID'] = $ID;
				}
				if(strstr($col, "LABEL"))
	   			{
	   				$LABEL = trim(split("=", $col)[1], "\"");
					error_log("USB DEVICE LABEL :: ".$LABEL);
					$device['LABEL'] = $LABEL;
				}
	   		}
			//if($device['ID'] != "")
			//{
				array_push($devices, $device);
			//}
	   }
	}
	return $devices;
}

function scanNetwork()
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "DELETE a FROM t_network_devices a";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$queryString = "DELETE FROM t_online_devices WHERE type = 17";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	//$networkRaw = `/usr/bin/nmap -sP -n 192.168.1.1/24 | grep report`;
	$networkRaw = `/usr/bin/arp-scan 192.168.1.1/24 | grep 192.168`;
	error_log($networkRaw);
	
	$lines = explode("\n", $networkRaw);
	//var_dump($lines);
	array_pop($lines);
	foreach($lines as $line)
	{
		error_log($line);
		$cols=preg_split('/\s+/', trim($line));
		//$cmd = "/usr/bin/nmap -sP -v ".$cols[4];
		//$deviceRaw = `$cmd`;
		//$deviceRaw = shell_exec($cmd);
		//error_log("TEST !!!! ".$cmd);
		//error_log("TEST !!!! ".$deviceRaw);
		//$lines2 = explode("\n", $deviceRaw);
		//array_pop($lines2);
		//$cols2=preg_split('/\s+/', $lines2[0]);
		$deviceIP = $cols[0];
		$deviceMAC = $cols[1];
	
		$queryString = "INSERT INTO t_network_devices (hardwareId, ip) VALUES (\"".$deviceMAC."\",\"".$deviceIP."\")";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
	}
}

function getNetworkDrives()
{
	$drives = [];
	
	//`ping 255.255.255.255 -b`;
	$rawDrives = `/usr/sbin/arp -a`;
	
	$lines = explode("\n", $rawDrives);
	array_pop($lines);
	foreach($lines as $line)
	{
		error_log("DRIVE :: ".$line);
		$cols=preg_split('/\s+/', trim($line));
		error_log("NAME :: ".$cols[0]);
		error_log("IP :: ".trim($cols[1], "()"));
		error_log("HwId :: ".$cols[3]);
		
		$drive = [];
		$drive["LABEL"] = $cols[0];
		$drive["HWID"] = $cols[3];
		$drive["IP"] = trim($cols[1], "()");
		$drive["MOUNT"] = "/mnt/".trim($cols[1], "()")."/";
		
		array_push($drives, $drive);
	}
	
	return $drives;
}

function getKnownNetworkDrives()
{
	error_log("GET KNOWN NETWORK DRIVES");	
	$knownDrives = [];
	
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT hardwareId FROM s_devices WHERE hardwareType = 17";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	while($row = mysqli_fetch_row($result))
	{
		error_log("SAVED DRIVE :: ".$row[0]);
		$knownDrive = $row[0];
		array_push($knownDrives, $knownDrive);
	}
	
	$drives = [];
	
	//`ping 255.255.255.255 -b`;
	$rawDrives = `/usr/sbin/arp -a`;
	
	$lines = explode("\n", $rawDrives);
	array_pop($lines);
	foreach($lines as $line)
	{
		$cols=preg_split('/\s+/', trim($line));
		error_log("DRIVE :: ".$cols[3]);
		error_log("ARRAY SEARCH :: ".in_array($cols[3], $knownDrives));
		if(in_array($cols[3], $knownDrives))
		{
			error_log("NAME :: ".$cols[0]);
			error_log("IP :: ".trim($cols[1], "()"));
			error_log("HwId :: ".$cols[3]);
			
			$drive = [];
			$drive["LABEL"] = $cols[0];
			$drive["HWID"] = $cols[3];
			$drive["IP"] = trim($cols[1], "()");
			$drive["MOUNT"] = "/mnt/".trim($cols[1], "()")."/";
			
			array_push($drives, $drive);
		}
	}
	
	return $drives;
}

function mountRemoteDrive($deviceHwId, $deviceIp)
{
	$toReturn = false;
	
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT user, pwd FROM s_devices WHERE hardwareType = 17 AND hardwareId = \"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	if($row = mysqli_fetch_row($result))
	{
		$DriveUmountFolders = "/mnt/".$deviceIp."/*";
		$umount = `umount $DriveUmountFolders`;
		$DriveUmount = "/mnt/".$deviceIp;
		$umount = `umount $DriveUmount`;
		
		$remoteDrive = "//".$deviceIp;
		$DriveMountPoint = "/mnt/".$deviceIp;
		$mkdir = `sudo mkdir $DriveMountPoint`;
		
		$DriveDistantPath = "/var/www/html/ressources/".$deviceIp;
		error_log("LN -S ".$DriveMountPoint." ".$DriveDistantPath);
		$slink = `sudo rm $DriveDistantPath`;
		$slink = `ln -s $DriveMountPoint $DriveDistantPath`;
		
		error_log("START DISCOVER :: smbclient -L ".$remoteDrive." -U ".$row[0]."%".$row[1]." --signing=off | grep Disk");
		$discoverFolders = `smbclient -L $remoteDrive -U $row[0]\%$row[1] --signing=off | grep Disk`;
		error_log("END DISCOVER :: ".$discoverFolders);
		
		$lines = explode("\n", $discoverFolders);
		array_pop($lines);
		foreach($lines as $line)
		{
			$toReturn = true;
			error_log("FOLDER :: ".$line);
			$cols=preg_split('/\s+/', trim($line));
			error_log("NAME :: ".$cols[0]);
			
			//$cols[0];
			$folder = $remoteDrive."/".$cols[0];
			$folderMountPoint = $DriveMountPoint."/".$cols[0];
			$mkdir = `sudo mkdir $folderMountPoint`;
			error_log("MOUNT REMOTE DRIVE :: mount -t cifs ".$folder." ".$folderMountPoint." -o user=guest,file_mode=0777,dir_mode=0777,gid=33,uid=33");
			//$mount = `mount -t cifs $folder $folderMountPoint -o user=guest,file_mode=0777,dir_mode=0777,umask=0022,gid=33,uid=33`;
			$mount = `sudo mount -t cifs $folder $folderMountPoint -o user=$row[0],password=$row[1],file_mode=0777,dir_mode=0777,gid=33,uid=33`;
			
			
			if($mount == "")
			{
				$queryString = "INSERT INTO t_online_devices (hardwareId, type, mount) VALUES (\"".$deviceHwId."\",17,\"".$DriveMountPoint."\")";
				error_log($queryString);
				$result = mysqli_query($link, $queryString);
			}
		}
		
		scanDevice($deviceHwId);
	}
	
	return $toReturn;
}

function getMountedUsbDevices()
{
	$mountedDevices = [];
	
	$mount=`mount | grep /dev/sd`;
	$lines = explode("\n", $mount);
	array_pop($lines);
	foreach($lines as $line)
	{
		error_log("MOUNTED :: ".$line);
		$cols=preg_split('/\s+/', trim($line));
		//$mount = split("/", split(":", $cols[0])[0]);
		$mount = $cols[2];
		//$mount = $mount[count($mount)-1];
		if($mount != "/mnt/key")
		{
			array_push($mountedDevices, $mount);
		}
	}
	
	return $mountedDevices;
}

function getUSBRemotePath($deviceHwId, $localPath)
{
	error_log("getUSBRemotePath :: ".$deviceHwId);
	$baseDistantPath = "http://sunnyv1.local/ressources/usb";
	
	$mountpoint = getMountPointFromDeviceId($deviceHwId);
	$mountpoint = str_replace("/mnt/","",$mountpoint);
	
	return $baseDistantPath.$mountpoint.$localPath;
}

function getUSBLocalPath($deviceHwId, $localPath)
{
	$mountpoint = getMountPointFromDeviceId($deviceHwId);
	
	return $mountpoint.$localPath;
}


function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) != FALSE);
}

function getFileType($fileId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT fileType FROM s_files WHERE id=".$fileId;
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	return ($row[0] >= 20) ? "video" : "image";
}

function getFilesFromPath($path, $returnArray, $isRecursive, $flat) {
	error_log("GET FILES FROM PATH :: ".$path." IS RECURSIVE :: ".$isRecursive);
 	$dir = opendir($path);
	//error_log("OPENDIR :: ".$dir);
	if(!$flat)
	{
		$returnArray[$path] = [];
	}
  	
	while($f = readdir($dir))
  	{
  		if(!is_dir($path.$f) && !startsWith($f, ".") && !startsWith($f, "$") && $f != "." && $f != ".." && (
  				strstr(strtolower($f), ".jpg") 
				|| strstr(strtolower($f), ".png") 
				|| strstr(strtolower($f), ".gif") 
				|| strstr(strtolower($f), ".jpeg") 
				|| strstr(strtolower($f), ".dng")
				|| strstr(strtolower($f), ".mov")
				|| strstr(strtolower($f), ".mp4")
				|| strstr(strtolower($f), ".mpeg")
				|| strstr(strtolower($f), ".avi")))
	  	{
	  		//error_log("new FILE GET FILES FROM PATH :: ".$f);
	  		if($flat)
			{
				array_push($returnArray, $path.$f);
			}
			else {
				array_push($returnArray[$path], $f);
			}
	  		
	  	}
		else if(is_dir($path.$f) && !startsWith($f, ".") && !startsWith($f, "$") && $isRecursive && $f != "." && $f != ".." && filetype($path.$f) != "")
		{
			//error_log("New DIRECTORY :: ".$path.$f."/");
			$returnArray = getFilesFromPath($path.$f."/", $returnArray, true, $flat);
		}
		else {
			//error_log("ELSE !");
		}
  	}
	
return $returnArray;
}

function getNbImgsFromPath($path) {
	error_log("GET NB IMG FROM PATH :: ".$path);
 	$dir = opendir($path);
  	$nb = 0;
	while($f = readdir($dir))
  	{
  		if(!is_dir($path.$f) && !startsWith($f, ".") && !startsWith($f, "$") && $f != "." && $f != ".." && (
  				strstr(strtolower($f), ".jpg") 
				|| strstr(strtolower($f), ".png") 
				|| strstr(strtolower($f), ".gif") 
				|| strstr(strtolower($f), ".jpeg") 
				|| strstr(strtolower($f), ".dng")))
	  	{
	  		$nb++;
	  	}
  	}
	
return $nb;
}

function getNbVideosFromPath($path) {
	error_log("GET NB VIDEO FROM PATH :: ".$path);
 	$dir = opendir($path);
  	$nb = 0;
	while($f = readdir($dir))
  	{
  		if(!is_dir($path.$f) && !startsWith($f, ".") && !startsWith($f, "$") && $f != "." && $f != ".." && (
  				strstr(strtolower($f), ".mp4") 
				|| strstr(strtolower($f), ".mpeg") 
				|| strstr(strtolower($f), ".mpeg4") 
				|| strstr(strtolower($f), ".avi") 
				|| strstr(strtolower($f), ".mov")))
	  	{
	  		$nb++;
	  	}
  	}
	
return $nb;
}

function getNbSubfoldersFromPath($path) {
	error_log("GET NB SUB FOLDERS FROM PATH :: ".$path);
 	$dir = opendir($path);
  	$nb = 0;
	while($f = readdir($dir))
  	{
  		error_log("IS DIRECTORY ?? :: ".$path.$f);
  		if(is_dir($path.$f) && $f != "." && $f != "..")
	  	{
	  		$nb++;
	  	}
  	}
	
return $nb;
}

function scanDevice($deviceHwId)
{
	error_log("SCAN DEVICE :: ".$deviceHwId." :: ".$_SERVER['SERVER_ADDR']);
	//$folderPath = getMountPointFromDeviceId($deviceHwId);
	//$url = "http://sunnyv1.local/scanDevice.php?action=quickScanFromUsb&deviceHwId=".$deviceHwId;
	//$url = "http://sunnyv1.local/scanDevice.php?action=scanNewFilesFromUsb&deviceId=".$deviceHwId."&makeThumb=&makeMD5=true";
	//$url = "http://".$_SERVER['SERVER_ADDR']."/scanDevice.php?action=scanDeeperFromUsb&deviceHwId=".$deviceHwId."&makeThumb=false&makeMD5=true";
	
	/*$options=array(
      CURLOPT_URL            => $url, 
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_HEADER         => false
	);
	
	$CURL=curl_init();
	curl_setopt_array($CURL,$options);
    curl_exec($CURL);
	curl_close($CURL);*/
	
	scanNewFilesFromUsb($deviceHwId, false, false); //deviceHwId,thumb,md5
}

function getNoDuplicatedFiles($deviceHwId)
{
	$files = [];
	
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		
    	exit();
	}

	$deviceHwId = getDeviceHwId($deviceId);
	error_log("START GET MOUNT POINT :: ".$deviceHwId);
	$mountPoint = getMountPointFromDeviceId($deviceHwId)."/";
	error_log("MOUNT POINT ::: ".$mountPoint);
	
	if($mountPoint == "/")
	{
		return $files;
	}
	
	$filesFound = [];
	$filesSaved = [];
	
	error_log("START GET FILES FROM DEVICE :: ".$mountPoint);
	$filesFound = getFilesFromPath($mountPoint, $filesFound, true, true);
	error_log("FILES FOUND :: ".count($filesFound));
	foreach ($filesFound as $key => $value)
	{
		$filesFound[$key] = str_replace($mountPoint, "/", $value);
	}
	
	$queryString = "SELECT a.url FROM (SELECT * FROM s_files WHERE deviceId =".$deviceId." GROUP BY size, dateCreated)a";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	error_log("START GET ALREADY SCANNED FILES");
	
	while ($row = mysqli_fetch_row($result))
	{
	 	array_push($filesSaved, $row[0]);
	}
	
	//$diffSaved = array_diff($filesSaved, $filesFound); //removed files
	$diffFound = array_diff($filesFound, $filesSaved); //new file
	
	error_log("DIFF FOUND :: ".count($diffFound));
	
	$files = $diffFound;
	
	return $files;
}

function getNewFiles($deviceHwId)
{
	$files = [];
	
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}

	$url = "http://".$_SERVER['SERVER_ADDR']."/sunnyweb.php?action=getScannedFiles&deviceId=".getDeviceId($deviceHwId);
	
	$options=array(
      CURLOPT_URL            => $url, 
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_HEADER         => false
	);
	
	$CURL=curl_init();
	curl_setopt_array($CURL,$options);
    $scanned = curl_exec($CURL);
	curl_close($CURL);
	
	$filesScannedRaw = json_decode($scanned, true);
	
	//error_log("FILES ALREADY SCANNED :: ".count($filesScannedRaw));
	
	error_log("START GET MOUNT POINT ::".$deviceHwId);
	$mountPoint = getMountPointFromDeviceId($deviceHwId)."/";
	error_log("MOUNT POINT :::: ".$mountPoint);
	
	if($mountPoint == "/")
	{
		return $files;
	}
	
	$filesFound = [];
	$filesScanned = [];
	
	
	error_log("START GET FILES FROM DEVICE :: ".$mountPoint);
	$filesFound = getFilesFromPath($mountPoint, $filesFound, true, true);
	error_log("FILES FOUND :: ".count($filesFound));
	foreach ($filesFound as $key => $value)
	{
		$filesFound[$key] = str_replace($mountPoint, "/", $value);
	}
	
	
	$queryString = "SELECT url FROM s_files WHERE deviceId = ".getDeviceId($deviceHwId);
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	error_log("START GET ALREADY SCANNED FILES");
	
	while ($row = mysqli_fetch_row($result))
	{
	 	array_push($filesScanned, $row[0]);
	}
	
	$diffScanned = array_diff($filesScanned, $filesFound); //removed files
	$diffFound = array_diff($filesFound, $filesScanned); //new files
	
	$idsToRemove = "(";
	
	foreach($diffScanned as $diffs)
	{
		//error_log("DIFF SCANNED :: ".$diffs);
		foreach ($filesScannedRaw as $fileScanned)
		{
			if($fileScanned['url'] == $diffs)
			{
				error_log("ADD REMOVE FILE :: ".$diffs);
				$idsToRemove =  $idsToRemove.$fileScanned['id'].",";
			}
		}
	}
	$idsToRemove = substr($idsToRemove,0,-1);
	$idsToRemove = $idsToRemove.")";
	
	
	
	$queryString = "DELETE FROM s_files WHERE id IN ".$idsToRemove;
	//error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	//error_log("DIFF FOUND :: ".count($diffFound));
	
	$files = $diffFound;
	
	return $files;
	
	//error_log("FOUND :: ".count($filesFound));
}

function getFileIdFromPath($path)
{
	$mountPoint = substr($path, 0, 9);
	$deviceId = getDeviceIdFromMountPoint($mountPoint);
	
	$filePath = substr($path, 9);
	
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	
	if (mysqli_connect_errno()) {
   		
    	exit();
	}
	
	$queryString = "SELECT id FROM s_files WHERE deviceId=\"".$deviceId."\" AND url=\"".$filePath."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	while ($row = mysqli_fetch_row($result))
	{
	 	$fileId = $row[0];
	}
	
	return $fileId;
}

function getFiles($deviceHwId, $noThumb, $noMD5, $noExif)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$deviceId = getDeviceId($deviceHwId);
	$mountPoint = getMountPointFromDeviceId($deviceHwId);
	
	$queryString = "SELECT a1.id, a1.url FROM s_files a1";
	if($noThumb != null)
	{
		$queryString = $queryString . " LEFT JOIN a_file_thumb a2 ON a1.id = a2.fileId";
	}
	/*
	if($noMD5 != null)
	{
		$queryString = $queryString . "";
	}
	*/
	if($noExif != null)
	{
		$queryString = $queryString . "";
	}
	
	$queryString = $queryString . " WHERE a1.deviceId = ".$deviceId;
	
	
	if($noThumb != null)
	{
		$queryString = $queryString . " AND a2.thumb IS NULL";
	}
	
	if($noMD5 != null)
	{
		$queryString = $queryString . " AND a1.MD5 = \"\"";
	}
	if($noExif != null)
	{
		$queryString = $queryString . "";
	}
	
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$files = [];
	
	while($row = mysqli_fetch_row($result))
	{
		array_push($files, ['id' => $row[0], 'url' => $row[1]]);
	}
	
	return $files;
	
	//error_log("FOUND :: ".count($filesFound));
}

function browseFile($path)
{
	
}

function browseFolder($path, $returnArray, $isRecursive, $filesOnly)
{
	error_log("BROWSE FOLDER :: ".$path);
	//$returnArray = [];
	//$i = 0;
	
	$dir = opendir($path);
	while($f = readdir($dir))
  	{
  		error_log("PATH :: ".$path);
  		error_log("FILE :: ".$f);
  		error_log("FILE IS DIR PATH F :: ".is_dir($path.$f));
  		error_log("FILE IS F :: ".is_dir($f));
  		if(is_dir($path.$f) && $f != "." && $f != ".." && !strstr($f,".Trashes") && !strstr($f,".Spotlight") && !startsWith($f, ".") && !startsWith($f, "$") && filetype($path.$f) != "" )
		{
			error_log("New DIRECTORY :: ".$path.$f."/");
			if(!$filesOnly)
			{
				array_push($returnArray, ["name" => $f,
								"url" => $path.$f, 
								"type" => "folder", 
								"imgNb" => getNbImgsFromPath($path.$f."/"), 
								"videoNb" => getNbVideosFromPath($path.$f."/"),
								"subfolderNb" => getNbSubfoldersFromPath($path.$f."/")
								]);
			}
			
			if($isRecursive)
			{
				$returnArray = browseFolder($path.$f."/", $returnArray, true, $filesOnly);
			}
		}
		else if(!startsWith($f, ".") && !startsWith($f, "$") && (strstr(strtolower($f), ".jpg") 
				|| strstr(strtolower($f), ".png") 
				|| strstr(strtolower($f), ".gif") 
				|| strstr(strtolower($f), ".jpeg") 
				|| strstr(strtolower($f), ".dng")))
				{
					error_log("new IMAGE :: ".$f);	
					array_push($returnArray, ["name" => $f,
										"url" => $path.$f, 
										"type" => "image", 
										"imgNb" =>"0", 
										"videoNb" => "0",
										"subfolderNb" => "0"]);
				}
		else if(!startsWith($f, ".") && !startsWith($f, "$") && (strstr(strtolower($f), ".avi") 
				|| strstr(strtolower($f), ".mpeg") 
				|| strstr(strtolower($f), ".mp4") 
				|| strstr(strtolower($f), ".mov")))
				{
					error_log("new VIDEO :: ".$f);
					array_push($returnArray, ["name" => $f,
										"url" => $path.$f, 
										"type" => "video", 
										"imgNb" => "0", 
										"videoNb" =>"0",
										"subfolderNb" => "0"]);
				}
				$i++;
			}
	
	return $returnArray;
}

function getFoldersFromPath($path, $name, $returnArray, $deep, $i, $originalPath) {
	error_log($path." :: ".$deep);
	if($path == "" || $path == "/") return;
	if($deep == "true" ||($deep == "false" && is_null($i)))
	{
		//error_log("VALEUR DE I :: ".$i);
		if(is_null($i))
		{
			$i = 0;
		}
		else
		{
			$i++;
		}
		
		//error_log("NEW DIRECTORY :: ".$name." :: ".$path);
		$returnArray[$path] = ["name" => $name,"url" => $path];
		$returnArray[$path]["imagesCount"] = 0;
		$returnArray[$path]["videosCount"] = 0;
		$returnArray[$path]["foldersCount"] = 0;
		
		$originalPath = $path;
	}
	$arrayPath = ($deep == "false") ? $originalPath : $path ;
 	$dir = opendir($path);
	$isFiles = false;
	$isFolders = false;
	while($f = readdir($dir))
  	{
  		//error_log($f);
  		if(is_dir($path.$f) && $f != "." && $f != ".." && !strstr($f,".Trashes") && !strstr($f,".Spotlight") && filetype($path.$f) != "")
		{
			//error_log("New DIRECTORY :: ".$path.$f."/ :: ".$deep);
			$returnArray[$path]["foldersCount"]++;
			$isFolders = true;
			//$returnArray[$path.$f."/"] = ["name" => $f,"url" => $path.$f."/"];
			//$i = (is_null($i)) ? 0 : $i;
			$returnArray = getFoldersFromPath($path.$f."/", $f, $returnArray, $deep, $i, $originalPath);
		}
		/*else if(
			!is_dir($path.$f) 
			&& $imagesCount == 0 
			&& $f != "." 
			&& $f != ".." 
			&& filetype($path.$f) != "" 
			&& (strstr(strtolower($f), ".jpg") 
				|| strstr(strtolower($f), ".png") 
				|| strstr(strtolower($f), ".gif") 
				|| strstr(strtolower($f), ".jpeg") 
				|| strstr(strtolower($f), ".dng")))
		{
			//$thumb = `cp $path$f /mnt/key/temp/$f`;
			//$thumb = `mogrify /mnt/key/temp/$f -resize 15%`;
			//$returnArray[$path]["thumb"] = "http://".$_SERVER['SERVER_ADDR']."/ressources/temp/".$f;
			$imagesCount++;
			
			$returnArray[$path]["thumb"] = str_replace(substr($path, 0, 9), "http://".$_SERVER['SERVER_ADDR']."/ressources/usb".substr($path, 5, 4), $path).$f;
		}*/
		else if(!startsWith($f, ".") && !startsWith($f, "$") && (strstr(strtolower($f), ".jpg") 
				|| strstr(strtolower($f), ".png") 
				|| strstr(strtolower($f), ".gif") 
				|| strstr(strtolower($f), ".jpeg") 
				|| strstr(strtolower($f), ".dng")))
				{
					//error_log("new IMAGE :: ".$f);	
					$isFiles = true;
					$returnArray[$path]["imagesCount"]++;
				}
		else if(!startsWith($f, ".") && !startsWith($f, "$") && (strstr(strtolower($f), ".avi") 
				|| strstr(strtolower($f), ".mpeg") 
				|| strstr(strtolower($f), ".mp4") 
				|| strstr(strtolower($f), ".mov")))
				{
					//error_log("new VIDEO :: ".$f);	
					$isFiles = true;
					$returnArray[$path]["videosCount"]++;
				}
  	}
	//$returnArray[$path]["imagesCount"] = $imagesCount;
	//$returnArray[$path]["videosCount"] = $videosCount;
	//$returnArray[$path]["foldersCount"] = $foldersCount;
	/*
	if(!$isFiles)
	{
		$returnArray[$i]["foldersCount"]--;
		if($deep == "true")
		{
			array_splice($returnArray, $i, 1);
			$i--;
		}
	}*/
	return $returnArray;
}

function getDeviceName($deviceHwId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT name FROM s_devices WHERE hardwareId=\"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function getDeviceType($deviceHwId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT hardwareType FROM s_devices WHERE hardwareId=\"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function getExistingDevices()
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$devices = [];
	
	$queryString = "SELECT * FROM s_devices";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	while($row = mysqli_fetch_row($result))
	{
		$device = [];
		$device["deviceId"] = $row[0];
		$device["deviceName"] = $row[1];
		$device["deviceType"] = $row[3];
		$device["deviceScreenWidth"] = $row[4];
		$device["deviceScreenHeight"] = $row[5];
		
		array_push($devices, $device);
	}
	
	return $devices;
}

function getExistingDevice($deviceHwId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$device = null;
	
	$queryString = "SELECT * FROM s_devices WHERE hardwareId = \"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	if($row[0] != null)
	{
		$device = [];
		$device["deviceId"] = $row[0];
		$device["deviceName"] = $row[1];
		$device["deviceType"] = $row[3];
		$device["deviceScreenWidth"] = $row[4];
		$device["deviceScreenHeight"] = $row[5];
	}
	
	return $device;
}

function getDeviceIp($deviceHwId)
{
	//`ping 255.255.255.255 -b`;
	$rawDrives = `/usr/sbin/arp -a`;
	
	$lines = explode("\n", $rawDrives);
	array_pop($lines);
	foreach($lines as $line)
	{
		$cols=preg_split('/\s+/', trim($line));
		if($cols[3] == $deviceHwId)
		{
			return trim($cols[1], "()");
		}
	}
}

function getDeviceId($deviceHwId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT id FROM s_devices WHERE hardwareId=\"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function isNetworkDeviceOnline($deviceHwId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT ip FROM t_network_devices WHERE hardwareId=\"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function isServerFree()
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM  t_server_is_working";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return ($row[0] == 0);
}

function setServerState($state)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "UPDATE t_server_is_working SET state = ".$state;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
}

function isDeviceOnline($deviceHwId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT * FROM t_online_devices WHERE hardwareId=\"".$deviceHwId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return ($row[1] != null);
}

function getDeviceHwId($deviceId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT hardwareId FROM s_devices WHERE id=\"".$deviceId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function getDeviceScreenWidth($deviceId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT screenWidth FROM s_devices WHERE id=\"".$deviceId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function getDeviceScreenHeight($deviceId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT screenHeight FROM s_devices WHERE id=\"".$deviceId."\"";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function makeThumb($imgUrl, $imgId)
{
	$startTime = date_create();
		
	$ExtensionPresumee = explode('.', $imgUrl);
	$imgName = explode('/', $ExtensionPresumee[count($ExtensionPresumee)-2]);
	$imgName = $imgName[count($imgName)-1];	
	
	$subFolder = floor($imgId / 1000) ;
	$newUrl = "/var/www/html/ressources/thumbs/".$subFolder."/". $imgId.".jpg";
	
	if(!file_exists($newUrl))
	{	
		$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
		
		if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg')
		{
		  	error_log("CREATION DU RESIZE :: ".$imgUrl) ;
			
			$exif = read_exif_data($imgUrl, O, true);
			error_log("CREATION DU RESIZE :: STEP 1") ;
		  	$ImageNews = getimagesize($imgUrl);
			error_log("CREATION DU RESIZE :: STEP 2") ;
		  	
			$ImageChoisie = imagecreatefromjpeg($imgUrl);
			error_log("CREATION DU RESIZE :: STEP 3") ;
			$TailleImageChoisie = getimagesize($imgUrl);
			error_log("CREATION DU RESIZE :: STEP 4") ;
			
			$orientation = $exif["IFD0"]['Orientation'];
			
			$hauteur = $TailleImageChoisie[1] ;
			$largeur = $TailleImageChoisie[0];
			
			$NouvelleLargeur = min(300, $largeur);
			$NouvelleHauteur = ( ($hauteur * ((300)/$largeur)) );
			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
			error_log("CREATION DU RESIZE :: STEP 5") ;
	
			try
	  		{
	  			imagecopyresized($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $largeur,$hauteur);
				error_log("CREATION DU RESIZE :: STEP 6") ;
			}
			catch(exception $e)
			{
				//file_put_contents('/var/www/isThumbMeRunning.txt', "");
			}
	
			switch($orientation) {
		        case 3:
		            $NouvelleImage = imagerotate($NouvelleImage, 180, 0);
		            error_log("CREATION DU RESIZE :: STEP 7") ;
		            break;
		        case 6:
		            $NouvelleImage = imagerotate($NouvelleImage, -90, 0);
					error_log("CREATION DU RESIZE :: STEP 8") ;
		            break;
		        case 8:
		            $NouvelleImage = imagerotate($NouvelleImage, 90, 0);
					error_log("CREATION DU RESIZE :: STEP 9") ;
		            break;
		    }
			
	  		imagedestroy($ImageChoisie);
		    error_log("CREATION DU RESIZE :: STEP 10") ;
										    
			imagejpeg($NouvelleImage , $newUrl, 100);
			error_log("CREATION DU RESIZE :: STEP 11") ;
		}
		else if($ExtensionPresumee == 'mov' || $ExtensionPresumee == 'mp4')
		{
			error_log("MAKE THUMB VIDEO");
			$cmd = "convert -size 20% ".$imgUrl."[30] ".$newUrl;
			shell_exec($cmd);
			//`convert -size 20% $imgUrl[30] $newUrl`;
		}
	}
	$endTime = date_create();
	$elapsedTime = date_timestamp_get($endTime) - date_timestamp_get($startTime);
	error_log($elapsedTime." :: IMG PATH :: "."http://".$_SERVER['SERVER_ADDR']."/".substr($newUrl, 9));
	return "http://".$_SERVER['SERVER_ADDR']."/".substr($newUrl, 9);
}

function makeThumbConvert($imgUrl, $imgId)
{
	$startTime = date_create();
		
	$ExtensionPresumee = explode('.', $imgUrl);
	$imgName = explode('/', $ExtensionPresumee[count($ExtensionPresumee)-2]);
	$imgName = $imgName[count($imgName)-1];	
	
	$subFolder = floor($imgId / 1000) ;
	$newUrl = "/var/www/html/ressources/thumbs/".$subFolder."/". $imgId.".jpg";
	
	if(!file_exists($newUrl))
	{	
			error_log("MAKE THUMB");
			$cmd = "convert -size 20% ".$imgUrl." ".$newUrl;
			shell_exec($cmd);
			//`convert -size 20% $imgUrl[30] $newUrl`;
	}
	$endTime = date_create();
	$elapsedTime = date_timestamp_get($endTime) - date_timestamp_get($startTime);
	error_log($elapsedTime." :: IMG PATH :: "."http://".$_SERVER['SERVER_ADDR']."/".substr($newUrl, 9));
	return "http://".$_SERVER['SERVER_ADDR']."/".substr($newUrl, 9);
}

function imgResize($imgUrl, $newWidth, $newPath)
{
	$startTime = date_create();
	//$exif = read_exif_data($imgUrl, O, true);
	//gm identify -format %[EXIF:Model]
	
	$array = explode('.', $imgUrl);
	$ExtensionPresumee = end($array);

	//$ExtensionPresumee = `gm identify -format %e $imgUrl`;
	error_log("EXTENSION :: ".$ExtensionPresumee);
	//$ExtensionPresumee = explode("\n", $ExtensionPresumee)[0];
	//error_log("EXTENSION 2 :: ".$ExtensionPresumee);
	$array = explode('/', $imgUrl);
	$imgName = end($array);
	
	//$imgName = `gm identify -format %f $imgUrl`;
	error_log("IMAGE NAME :: ".$imgName);
	//$imgName = explode("\n", $imgName)[0];
	//error_log("IMAGE NAME 2 :: ".$imgName);
	$imgName = str_replace(".".$ExtensionPresumee, '.jpg', $imgName);
	error_log("IMAGE NAME 3 :: ".$imgName);
	
	$newUrl = ($newPath != "" && $newPath != null) ? $newPath.$imgName :"/var/www/html/ressources/resized/".$imgName;
	$newUrl = str_replace(" ", '\ ', $newUrl);
	error_log("IMAGE SIZE :: ".$ExtensionPresumee);
	error_log("NEW URL :: ".$newUrl);
	error_log("NEW URL EXISTS :: ".file_exists($newUrl));
	if(!file_exists($newUrl))
	{	
		$ExtensionPresumee = strtolower($ExtensionPresumee);
		
		if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg' || $ExtensionPresumee == "png")
		{
		  	error_log("CREATION DU RESIZE :: ".$imgUrl) ;
		  	
			/*if($ExtensionPresumee == "png")
			{
				$ImageChoisie = imagecreatefrompng($imgUrl);
			}
			else {
				$ImageChoisie = imagecreatefromjpeg($imgUrl);
			}*/
			
			error_log("CREATION DU RESIZE :: 1") ;
			//$TailleImageChoisie = getimagesize($imgUrl);
			//$TailleImageChoisie = `gm identify -format %f $imgUrl`;
			
			error_log("CREATION DU RESIZE :: 2") ;
			//$orientation = $exif["IFD0"]['Orientation'];
			$orientation = `gm identify -format %[EXIF:Orientation] $imgUrl`;
			error_log("CREATION DU RESIZE :: 3") ;
			$hauteur = `gm identify -format %h $imgUrl` ;
			$largeur = `gm identify -format %w $imgUrl`;
			
			$NouvelleLargeur = min($newWidth, $largeur);
			$NouvelleHauteur = ( ($hauteur * (($NouvelleLargeur)/$largeur)) );
			$NouvelleTaille = $NouvelleLargeur."x".$NouvelleHauteur;
			//$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
			error_log("CREATION DU RESIZE :: 4") ;
			try
	  		{
	  			//imagecopyresized($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $largeur,$hauteur);
			}
			catch(exception $e)
			{
				//file_put_contents('/var/www/isThumbMeRunning.txt', "");
			}
	
			switch($orientation) {
		        case 3:
		            //$NouvelleImage = imagerotate($NouvelleImage, 180, 0);
					//$cmd = `convert $imgUrl -rotate 180 -resize $NouvelleTaille $newUrl`;
					
					$cmd = `gm convert -rotate -90 -size $NouvelleTaille $imgUrl $newUrl`;
					error_log("CREATION DU RESIZE IMAGEMAGICK :: ".$cmd) ;
		            break;
		        case 6:
		            //$NouvelleImage = imagerotate($NouvelleImage, -90, 0);
		            
					$cmd = `gm convert -rotate 90 -size $NouvelleTaille $imgUrl $newUrl`;
			error_log("CREATION DU RESIZE IMAGEMAGICK :: ".$cmd) ;
		            break;
		        case 8:
		            //$NouvelleImage = imagerotate($NouvelleImage, 90, 0);
					
					$cmd = `gm convert -rotate 90 -size $NouvelleTaille $imgUrl $newUrl`;
					error_log("CREATION DU RESIZE IMAGEMAGICK :: ".$cmd) ;
		            break;
				default:
					$cmd = `gm convert -size $NouvelleTaille $imgUrl $newUrl`;
					error_log("CREATION DU RESIZE IMAGEMAGICK :: ".$cmd) ;
					break;
		    }
			error_log("CREATION DU RESIZE :: 5") ;
	  		//imagedestroy($ImageChoisie);
		    error_log("URL resized :: ".$newUrl);        
			                 
			//imagejpeg($NouvelleImage , $newUrl, 100);
		}
		else if($ExtensionPresumee == 'dng')
		{
			//$cmd = `dcraw -h -c $imgUrl | cjpeg -dct fast -qual 70 > $newUrl`;
			//$cmd = `gm convert -size $NouvelleTaille $imgUrl $newUrl`;
			return "http://sunnyv1.local/ressources/default.jpg";
		}
		else {
			{
				return "http://sunnyv1.local/ressources/default.jpg";
			}
}
	}
	$endTime = date_create();
	$elapsedTime = date_timestamp_get($endTime) - date_timestamp_get($startTime);
	error_log($elapsedTime." :: IMG PATH :: "."http://sunnyv1.local/".substr($newUrl, 14));
	//return "http://".$_SERVER['SERVER_ADDR']."/".substr($newUrl, 9);
	return "http://sunnyv1.local/".substr($newUrl, 14);
	
}

function remove_special_chars($str){
    $str = trim($str);
    $str = strtr($str,"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ!@#%&*()[]{}+=?",
                      "YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy_______________");
    $str = str_replace("..","",str_replace("/","",str_replace("\\","",str_replace("\$","",$str))));
    return $str;
}

function getCleanFileName($fileName)
{
	$cleanFileName = str_replace("(", "\(",$fileName);
	$cleanFileName = str_replace(")", "\)",$cleanFileName);
	$cleanFileName = str_replace("_", "\_",$cleanFileName);
	$cleanFileName = str_replace(" ", "",$cleanFileName);
	$cleanFileName = str_replace("*", "",$cleanFileName);
	$cleanFileName = str_replace(":", "",$cleanFileName);
	$cleanFileName = str_replace("$", "",$cleanFileName);
	$cleanFileName = str_replace("+", "",$cleanFileName);
	$cleanFileName = str_replace("=", "",$cleanFileName);
	$cleanFileName = str_replace("?", "",$cleanFileName);
	
	return $cleanFileName;
}

function getEscapedPath($path)
{
	$cleanPath = str_replace("(", "\(",$path);
	$cleanPath = str_replace(")", "\)",$cleanPath);
	//$cleanPath = str_replace("_", "\_",$cleanPath);
	$cleanPath = str_replace(" ", "\ ",$cleanPath);
	$cleanPath = str_replace("*", "\*",$cleanPath);
	$cleanPath = str_replace(":", "\:",$cleanPath);
	$cleanPath = str_replace("$", "\$",$cleanPath);
	$cleanPath = str_replace("+", "\+",$cleanPath);
	$cleanPath = str_replace("=", "\=",$cleanPath);
	$cleanPath = str_replace("?", "\?",$cleanPath);
	
	return $cleanPath;
}

function getSinglePhotoFiles($deviceId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT a.id FROM (
	SELECT * FROM s_files WHERE deviceId =".$deviceId." AND fileType < 20)a
	INNER JOIN (
	SELECT * FROM s_files WHERE deviceId !=".$deviceId." AND fileType < 20)b
	ON a.size = b.size AND (a.filename = b.filename OR a.dateCreated = b.dateCreated)";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$alreadySaved =[];
	while ($row = mysqli_fetch_row($result))
	{
		array_push($alreadySaved, $row[0]);
	}
	
	$queryString = "SELECT id FROM s_files WHERE fileType < 20 AND deviceId =".$deviceId;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$allFiles =[];
	while ($row = mysqli_fetch_row($result))
	{
		array_push($allFiles, $row[0]);
	}
	
	$newFiles = array_diff($allFiles, $alreadySaved); //new files
	return $newFiles;
}

function getSingleVideoFiles($deviceId)
{
	$publicDirectory = "http://".$_SERVER['SERVER_ADDR']."/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT a.id FROM (
	SELECT * FROM s_files WHERE deviceId =".$deviceId." AND fileType >= 20)a
	INNER JOIN (
	SELECT * FROM s_files WHERE deviceId !=".$deviceId." AND fileType >= 20)b
	ON a.size = b.size AND (a.filename = b.filename OR a.dateCreated = b.dateCreated)";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$alreadySaved =[];
	while ($row = mysqli_fetch_row($result))
	{
		array_push($alreadySaved, $row[0]);
	}
	
	$queryString = "SELECT id FROM s_files WHERE fileType >= 20 AND deviceId =".$deviceId;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	$allFiles =[];
	while ($row = mysqli_fetch_row($result))
	{
		array_push($allFiles, $row[0]);
	}
	
	$newFiles = array_diff($allFiles, $alreadySaved); //new files
	return $newFiles;
}

function isFileExists($fileName, $deviceId, $imgSize, $imgWidth, $imgHeight)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT filename FROM s_files WHERE deviceId =".$deviceId." AND filename=\"".$fileName."\" AND size=".$imgSize." AND width=".$imgWidth." AND height=".$imgHeight;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	if($row = mysqli_fetch_row($result))
	{
		error_log(":::::::::: FILE ALREADY EXISTS :::::::::");
		return true;
	}
	else {
		error_log(":::::::::: NEW FILE TO BACKUP :::::::::");
		return false;
	}
}

function isNewFile($filePath, $fromDeviceHwId, $toDeviceHwId)
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$filePath = str_replace(getMountPointFromDeviceId($fromDeviceHwId), "", $filePath);
	
	$queryString = "SELECT filename,size,width,height FROM s_files WHERE deviceId=".getDeviceId($fromDeviceHwId)." AND url=\"".$filePath."\"";
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	if($row = mysqli_fetch_row($result))
	{
		$imgName = $row[0];
		$imgSize = $row[1];
		$imgWidth = $row[2];
		$imgHeight = $row[3];
	}
	
	$queryString = "SELECT filename FROM s_files WHERE deviceId =".getDeviceId($toDeviceHwId)." AND filename=\"".$imgName."\" AND size=".$imgSize." AND width=".$imgWidth." AND height=".$imgHeight;
	
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	if($row = mysqli_fetch_row($result))
	{
		error_log(":::::::::: FILE ALREADY EXISTS :::::::::");
		return false;
	}
	else {
		error_log(":::::::::: NEW FILE TO BACKUP :::::::::");
		return true;
	}
}

function backupUniqueFile($filePath, $fromDeviceHwId, $toDeviceHwId)
{
	if(isNewFile($filePath, $fromDeviceHwId, $toDeviceHwId))
	{
		error_log("COPY FILE :: ".$filePath." TO ".$toDeviceHwId);
		$fromPath = getEscapedPath($filePath);
		//$fileName = getCleanFileName(array_pop(explode("/",$fromPath)));
		$fileName = getMountPointFromDeviceId($toDeviceHwId).$fileName;
		error_log("COPY FILE ALL PARAMS :: FROM ".$fromPath." TO ".$fileName);
		$copy = `sudo cp -p $fromPath $fileName`;
		return true;
	}
	else
	{
		return false;
	}
}

function backupFolder($folderPath, $fromDeviceHwId, $toDeviceHwId)
{
	$files = [];
	$files = getFilesFromPath($folderPath, $files, true, true);
	foreach ($files as $file) {
		backupUniqueFile($file, $fromDeviceHwId, $toDeviceHwId);
	}
	
	scanDevice($toDeviceHwId);
}

function deleteFile($fileUrl)
{
	error_log("DELETE FILE :: ".$fileUrl);
	$remove = `sudo rm $fileUrl`;
	removeFileFromId(getFileIdFromPath($fileUrl));
	
	return true;
}

function removeFileFromId($fileId)
{
	$publicDirectory = "http://sunnyv1.local/ressources/" ;
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "DELETE FROM s_files WHERE id = ".$fileId;
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	
	//print("OK");
}

function copyFile($fromPath, $toPath)
{
	error_log("COPY FILE :: ".$fromPath." TO ".$toPath);
	$fromPath = getEscapedPath($fromPath);
	$fileName = getCleanFileName(array_pop(explode("/",$fromPath)));
	//cp -p
	$copy = `sudo cp -p $fromPath $toPath$fileName`;
	//$copy = `sudo rsync -a --progress $fromPath $toPath$fileName`;
	//$copy = `rsync -a --progress $fromPath $toPath$fileName > /tmp/copyFile.log`;
	return true;
}

function getProgressCP()
{
	$rawProgress = `tail -f /tmp/copyFile.log`;
	error_log("progress :: ".$rawProgress);
	$lines = explode("\n", $rawDrives);
	array_pop($lines);
	foreach($lines as $line)
	{
		$cols=preg_split('/\s+/', trim($line));
		foreach($cols as $col)
		{
			error_log("progress :: ".$col);
			if(strstr($col, "%"))
			{
				return trim($cols[1], "%");
			}
		}
	}
}

function copyFolder($fromPath, $toPath)
{
	error_log("COPY FOLDER :: ".$fromPath." TO ".$toPath);
	$fromPath = getEscapedPath($fromPath);
	//$copy = `sudo rsync --progress $fromPath $toPath`;
	//error_log("COPY FOLDER RESULt :: ".$copy);
	$command = `sudo cp -R $fromPath $toPath`;
	return true;
}

function transfertImage($path, $imgName)
{
	error_log("TRANSFERT :: ".$path." :: ".$imgName);
	$path = getEscapedPath($path);
	$copy = `cp -p $path /var/www/ressources/transfert/$imgName`;
	return true;
}

function getBackupDriveId()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT id FROM s_devices WHERE backup = 1";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function getBackupDriveHwId()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
   		//print("Échec de la connexion");
    	exit();
	}
	
	$queryString = "SELECT hardwareId FROM s_devices WHERE backup = 1";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$row = mysqli_fetch_row($result);
	
	return $row[0];
}

function getTransfertPath($transfertType, $backupDeviceHwId)
{
	error_log("!!!!!!!! getTransfertPath :: ".$transfertType." :: ".$backupDeviceHwId);
	$path = "";
	switch($transfertType)
	{
		case "backup":
			if($backupDeviceHwId == "")
			{
				$backupDeviceHwId = getBackupDriveHwId();
			}
			$mountPoint = getMountPointFromDeviceId($backupDeviceHwId);
			$path = $mountPoint."/backup/";
			`mkdir $path`;
			break;
		case "transfert":
			$path = "/sunnyBox/";
			
			$mountPoint = getMountPointFromDeviceId($backupDeviceHwId);
			$path = $mountPoint.$path;
			$createPath = `mkdir $path`;
			return $path;

			break;
		case "view":
			$path = "/var/www/ressources/boxUserStorage/view/";
			break;
		default:
			$path = "/var/www/ressources/boxUserStorage/backup/";
			break;
	}
	
	return $path;
}

function displayOnTV($fileType, $imgUrl, $deviceId, $previousImg, $autoRotate)
{
	error_log("DISPLAY :: ".$imgUrl);
	if($deviceId != null || $deviceId != "")
	{
		error_log("GET MOUNT POINT");
		$deviceHwId = getDeviceHwId($deviceId);
		$mountPoint = getMountPointFromDeviceId($deviceHwId);
		$imgUrl = $mountPoint.$imgUrl;
		error_log("PATH :: ".$imgUrl);
	}
	
	if($fileType == null || $fileType == "")
	{
		error_log("GET FILE TYPE");
		$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
		/* Vérification de la connexion */
		if (mysqli_connect_errno()) {
	   		//print("Échec de la connexion");
	    	exit();
		}
		$typeArr = explode(".", $imgUrl);
		$typeStr = strtolower($typeArr[count($typeArr)-1]);
		$queryString = "SELECT id FROM d_file_types WHERE keywords LIKE '%".$typeStr."%'";
		error_log($queryString);
		$result = mysqli_query($link, $queryString);
		$row = mysqli_fetch_row($result);
		
		$fileType = $row[0];
		error_log("FILE TYPE :: ".$fileType);
	}
	
	$command = `pidof fbi`;
	
	$imgUrl = str_replace("(", "\(",$imgUrl);
	$imgUrl = str_replace(")", "\)",$imgUrl);
	$imgUrl = str_replace("_", "\_",$imgUrl);
	$imgUrl = str_replace(" ", "\ ",$imgUrl);
	
	$newImg = null;
	
	if($fileType >= 20)
	{
		error_log("START PLAYER VIDEO");
		$cmd = "omxplayer ".$imgUrl." >/dev/null 2>/dev/null &";
		shell_exec($cmd);
		//`sudo omxplayer $imgUrl`;
		$waitfor = getVideoDuration($imgUrl) + 3;
	}
	else
	{
		error_log("START IMAGE VIEWER");
		$pathArr = explode("/", $imgUrl);
		$imgName = $pathArr[count($pathArr) -1];
		$newImg = "/var/www/ressources/temp/".$imgName;
		
		`cp $imgUrl $newImg`;
		
		if($autoRotate)
		{
			$orientation = `identify -format %[EXIF:Orientation] $newImg`;
			$orientation = explode("\n", $orientation)[0];
			error_log("ORIENTATION :: ".$orientation);
			switch ($orientation) {
				case '6':
					$rotate = 90;
					$newOrientation = "Top-Left";
					break;
				case '8':
					$rotate = -90;
					$newOrientation = "Top-Left";
					break;
				
				default:
					$rotate = 0;
					$newOrientation = "Top-Left";
					break;
			}
			
			if($rotate != 0)
			{
				`mogrify -rotate $rotate $newImg`;
				`mogrify -orient $newOrientation $newImg`;
			}
		}
		
		`/usr/bin/fbi -a -v -noverbose -T 1 $newImg`;
		$waitfor = ($autoRotate && $rotate != 0) ? 2 : 6;
	}
	
	$command2 = `kill -9 $command`;
	
	if($previousImg)
	{
		`rm $previousImg`;
	}
	
	$returnObj = ["delai" => $waitfor, "imgRef" => $newImg];
	return $returnObj ;
}

function getVideoDuration($filePath)
{
	$movieDuration = `ffmpeg -i $filePath 2>&1 | grep Duration`;
	//$movieDuration = trim($movieDuration);
	$movieDuration = split(": ", split(",", trim($movieDuration))[0])[1];
	error_log("MOVIE DURATION :: ".$movieDuration);
	sscanf(trim($movieDuration), "%d:%d:%d.%d", $hours, $minutes, $seconds, $milli);
	$ms = $milli * 10 + $seconds * 1000 + $minutes * 60 * 1000 + $hours * 60 * 60 * 1000;
	
	return round($ms / 1000);
}

function getVideoResolution($filePath)
{
	$rawResolution = `ffmpeg -i $filePath 2>&1 | grep Video`;
	//$movieDuration = trim($movieDuration);
	$rawResolutionArr = split(",", trim($rawResolution));
	$movieResoltion = split(" ", trim($rawResolutionArr[2]))[0];
	error_log("MOVIE RESOLUTION :: ".$movieResoltion);
	
	return $movieResoltion;
}


function getFileSize($filePath)
{
	$rawData = `ls -l $filePath`;
	//$movieDuration = trim($movieDuration);
	$filesize = split(" ", $rawData)[4];
	error_log("FILE SIZE :: ".$filesize);
	
	
	return $filesize;
}

function endOfDiaporama()
{
	$command = `pidof omxplayer`;
	$command = `kill -9 $command`;
	$command = `/usr/bin/fbi -noverbose -a -v -T 1 -Q`;
	$command = `pidof fbi`;
	$command = `kill -9 $command`;
	//$command = `. /mnt/tools/freeMem.sh`;
}

/*
	$usb=`lsusb -t | grep -Ei usb-Storage`;
	print($usb);
	$lines=explode("\n", $usb);
	array_pop($lines);
	foreach($lines as $line)
	{
		error_log($line);
	   $cols=split(',', trim($line));
	   error_log("USB DEVICE ID :: ".substr($cols[0], count($cols[0])-2, 1));
	   $deviceId = substr($cols[0], count($cols[0])-2, 1);
	   //system("lsusb | grep -Ei 'Device 00".$deviceId."'");
	   $deviceMac=`lsusb | grep -Ei '(Device\ 00$deviceId)'`;
	   $deviceMac = preg_split('/\s+/', trim($deviceMac))[5];
		error_log($deviceMac);
	}
	return $deviceMac;
	*/
	
	function getBatteryLevel()
	{
		$command = `sudo /root/battery.sh | grep gauge`;
		error_log($command);
		$level = substr(split("=", trim($command))[1], 1);
		return (getBatteryChargingStatus() == "Sector") ? "Charging (".$level.")" : $level; //must be cahnged to put intelligence in sunnyweb.php
	}
	
	function getBatteryChargingStatus()
	{
		$command = `sudo /root/battery.sh | grep discharge`;
		error_log($command);
		$status = substr(split("=", trim($command))[1],1);
		
		if($status == "0mA")
		{
			return "Sector";
		}
		else {
			return "Battery";
		}
	}
	
	function getUSBDiskUsage($mountPoint)
	{
		$mountPoint = "/".trim($mountPoint, "/");
		
		$command = `df -h --output=pcent,target | grep $mountPoint`;
		$percent = split(" ", trim($command))[0];
		
		$command = `df -h --output=size,target | grep $mountPoint`;
		$total = split(" ", trim($command))[0];
		
		return $percent."(".$total.")";
	}
	
	function isWlan0Up()
	{
		$command = `sudo ifconfig | grep wlan0`;
		if($command != "")
		{
			return true;
		}else
		{
			return false;
		}
		
	}
	
	function getWlan0Ip()
	{
		$searchfor = "Bcast";
		$command = `sudo ifconfig wlan0 | grep -E $searchfor`;
		$IP = split(":", split(" ", trim($command))[1]);
		//return $command;
		return $IP[1];
	}
	
	function getWlan1Ip()
	{
		$searchfor = "Bcast";
		$command = `sudo ifconfig wlan1 | grep -E $searchfor`;
		$IP = split(":", split(" ", trim($command))[1]);
		//return $command;
		return $IP[1];
	}
	
	function setIddleMode($iddleOn)
	{
		if($iddleOn)
		{
			$command = `sudo killall hostapd`;
			$command = `sudo i2cset -f -y 0 0x34 0x93 0x0`;
		}
		else {
			$command = `sudo hostapd -B /etc/hostapd.conf`;
			$command = `sudo i2cset -f -y 0 0x34 0x93 0x1`;
		}
	}
	
	function shutDownChip()
	{
		$command = `sudo shutdown now`;
	}
?>

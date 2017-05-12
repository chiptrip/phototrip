<?php
include_once("tools.php");
//include_once("scanDevice.php");
include_once("sunnyweb.php");
error_log("MOUNTUSBDEVICES");
parse_str(implode('&', array_slice($argv, 1)), $_GET);
$_SERVER['SERVER_ADDR'] = $_GET['serverIP'];
umountUsbDevices();
if(mountUsbDevices())
{
	$devices = getUsbDevices();
	foreach($devices as $device)
	{
		if($device['MOUNT'] != "")
		{
			addUsbDevice($device['ID'], $device['LABEL']);
			addOnlineUsbDevice($device['ID'], "/mnt/".$device['MOUNT']);
			scanDevice($device['ID']);
			getNewFiles($device['ID']);
		}
	}
}

?>
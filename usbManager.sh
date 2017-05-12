#!/bin/sh
ip=`ifconfig wlan0 | awk '/inet addr/{print substr($2,6)}'` `php 
/var/www/html/usbManager.php serverIP=$ip 2>> 
/var/log/apache2/error.log`

<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Your page title here :)</title>
  <meta name"description" content="SunnyV1">
  <meta name="author" content="SunnyBox">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

</head>
<body>

<script>

function displayOnTvFromUpload(imgId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=viewOnTV&imgId='+imgId);
    xhr.send(null);
}

function displayOnTvFromBrowsing(localPath) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=viewOnTV&localPath='+localPath);
    xhr.send(null);
}

function addBoxMenuItem()
{
	var div1Element = document.createElement('div');
	div1Element.className = "one-third column feature";
	
	var form1Element = document.createElement('form');
	form1Element.onclick = loadItems(deviceHwId);
	var input1Element = document.createElement('input');
	input1Element.type = "button";
	input1Element.value = "Device "+name;
	input1Element.onclick = function() { loadBoxItems(); };

	form1Element.appendChild(input1Element);
	div1Element.appendChild(form1Element);

	var container1 = document.getElementById("menuDevices");
    container1.appendChild(div1Element);
}

function loadUsbDevices()
{
	var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=getAvailableUsbDevices');
    xhr.addEventListener('readystatechange', function() {
    if (xhr.readyState == 4 && xhr.status == 200)
	    {
	        var jsonObj = JSON.parse(xhr.responseText);
			for (var i=0; i < jsonObj.length; i++)
			{
				buildDeviceItem(jsonObj[i].Name, jsonObj[i].HwId);
			}
	    }

	}, false);
    xhr.send(null);
}

function buildDeviceItem(name, deviceHwId)
{
	var div1Element = document.createElement('div');
	div1Element.className = "one-third column feature";
	
	var form1Element = document.createElement('form');
	form1Element.onclick = function () { /*loadItems(deviceHwId);*/ scanUSBdevice(deviceHwId) };
	var input1Element = document.createElement('input');
	input1Element.type = "button";
	input1Element.value = "Device "+name;
	input1Element.onclick = function() { /*loadItems(deviceHwId);*/ scanUSBdevice(deviceHwId) };

	form1Element.appendChild(input1Element);
	div1Element.appendChild(form1Element);

	var container1 = document.getElementById("menuDevices");
    container1.appendChild(div1Element);
}

function loadItems(deviceHwId)
{
	var container = document.getElementById("gridItems");
    while (container.hasChildNodes()) {  
    container.removeChild(container.firstChild);
	}

	var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=getUsbFoldersToScan&folderDepth=false&deviceId='+deviceHwId);
    xhr.addEventListener('readystatechange', function() {
    if (xhr.readyState == 4 && xhr.status == 200)
	    {
	        var jsonObj = JSON.parse(xhr.responseText);
			for (var i=0; i < jsonObj.length; i++)
			{
				loadItemsFromPath(jsonObj[i].localPath);
			}
	    }

	}, false);
    xhr.send(null);
}

function loadItemsFromPath(localPath)
{
	var container = document.getElementById("gridItems");
    while (container.hasChildNodes()) {  
    container.removeChild(container.firstChild);
	}
    
	var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=getUsbFoldersToBrowse&deviceId=&folderPath='+localPath);
    xhr.addEventListener('readystatechange', function() {
    if (xhr.readyState == 4 && xhr.status == 200)
	    {
	        var jsonObj = JSON.parse(xhr.responseText);
			for (var i=0; i < jsonObj.length; i++)
			{
				if(jsonObj[i].type == "folder")
				{
					addBrowseFolder(jsonObj[i].name, jsonObj[i].localPath);
				}
				else
				{
					addBrowseItem(jsonObj[i].localPath);
				}
				
			}
	    }

	}, false);
    xhr.send(null);
}

function loadBoxItems()
{
	var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=getUsbFoldersToBrowse&deviceId=&folderPath=/var/www/ressources/boxUserStorage/backup/');
    xhr.addEventListener('readystatechange', function() {
    if (xhr.readyState == 4 && xhr.status == 200)
	    {
	        var jsonObj = JSON.parse(xhr.responseText);
			for (var i=0; i < jsonObj.length; i++)
			{
				addBrowseItem(jsonObj[i].localPath);
			}
	    }

	}, false);
    xhr.send(null);
}


function addUploadItem(itemId, itemUrl)
{
	var divElement = document.createElement('div');
	divElement.className = "one-third column feature";
	
	var imgElement = document.createElement('img');
	//imgElement.src = "http://192.168.1.43/ressources/thumbs/30/30938.jpg";
	var folder = Math.floor(itemId / 1000);
	var url = "http://192.168.1.67/ressources/thumbs/"+folder+"/"+itemId+".jpg";
	imgElement.src = url;
	
	var brElement = document.createElement('BR');
	
	var aElement = document.createElement('a');
	aElement.href = "http://192.168.1.43/ressources/boxUserStorage/backup/image.jpg";
	var t = document.createTextNode("télécharger");
	aElement.appendChild(t);
	
	var formElement = document.createElement('form');
	var inputElement = document.createElement('input');
	inputElement.type = "button";
	inputElement.value = "TV";

	divElement.appendChild(imgElement);
	divElement.appendChild(brElement);
	divElement.appendChild(aElement);
	formElement.appendChild(inputElement);
	divElement.appendChild(formElement);

	var container = document.getElementById("gridItems");
    container.appendChild(divElement);
}

function addBrowseItem(itemUrl)
{
	var divElement = document.createElement('div');
	divElement.className = "one-third column feature";
	
	var imgElement = document.createElement('img');
	var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=getSmartUsbImage&localPath='+itemUrl+'&makeThumb=true');
    xhr.addEventListener('readystatechange', function() {
	    if (xhr.readyState == 4 && xhr.status == 200)
	    {
	        //alert(xhr.responseText);
	        imgElement.src = xhr.responseText;
	    }
	}, false);
    xhr.send(null);
    
	//imgElement.src = "http://192.168.1.43/sunnyweb.php?action=getSmartUsbImage&localPath="+itemUrl+"&makeThumb=true";
	
	var brElement = document.createElement('BR');
	
	var aElement = document.createElement('a');
	aElement.href = itemUrl;
	var t = document.createTextNode("télécharger");
	aElement.appendChild(t);
	
	var formElement = document.createElement('form');
	var inputElement = document.createElement('input');
	inputElement.type = "button";
	inputElement.value = "TV";
	//inputElement.onclick = displayOnTvFromBrowsing(itemUrl);
	inputElement.onclick = function() { displayOnTvFromBrowsing(itemUrl); };

	divElement.appendChild(imgElement);
	divElement.appendChild(brElement);
	divElement.appendChild(aElement);
	formElement.appendChild(inputElement);
	divElement.appendChild(formElement);

	var container = document.getElementById("gridItems");
    container.appendChild(divElement);
}

function addBrowseFolder(itemName, itemUrl)
{
	var divElement = document.createElement('div');
	divElement.className = "one-third column feature";
	
	var imgElement = document.createElement('img');
	imgElement.src = "";
	
	var brElement = document.createElement('BR');
	
	var formElement = document.createElement('form');
	var inputElement = document.createElement('input');
	inputElement.type = "button";
	inputElement.value = itemName;
	inputElement.onclick = function() { loadItemsFromPath(itemUrl); };

	divElement.appendChild(imgElement);
	divElement.appendChild(brElement);
	formElement.appendChild(inputElement);
	divElement.appendChild(formElement);

	var container = document.getElementById("gridItems");
    container.appendChild(divElement);
}

function scanUSBdevice(deviceId)
{
	var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://192.168.1.43/sunnyweb.php?action=scanUSBDevice&deviceId='+deviceId);
    xhr.addEventListener('readystatechange', function() {
    if (xhr.readyState == 4 && xhr.status == 200)
	    {
	        
	    }

	}, false);
    xhr.send(null);
}

addBoxMenuItem();
loadUsbDevices();
loadBoxItems();
</script>
<div class="container">
<div id="menuDevices" class="container">
</div>
<div id="gridItems" class="container">
</div>
</div>
</body>
</html>
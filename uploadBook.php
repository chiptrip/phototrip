<?php

include("tools.php");

if ($_GET["action"] == "clearbooks" )
{
	clearBooks();
	return;
}

// Dans les versions de PHP antiéreures à 4.1.0, la variable $HTTP_POST_FILES
// doit être utilisée à la place de la variable $_FILES.
error_log("UPLOAD BOOK");
//require_once('./tools.php') ;
error_log($_POST['book']);
 

//CONNECT DB
$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
	    //error_log("Échec de la connexion");
	    exit();
	}
	
$bookJson = json_decode($_POST["book"], true);

$bookName = ($bookJson["name"] == "") ? "new book" : $bookJson["name"] ;

$queryString = "INSERT INTO s_books (name) VALUES (\"".$bookName."\")";
$result = mysqli_query($link, $queryString);
$bookId = mysqli_insert_id($link);

$pages = $bookJson["pages"];

foreach ($pages as $page)
{
	$queryString = "INSERT INTO s_book_pages (template) VALUES (\"".$page["templateName"]."\")";
	error_log($queryString);
	$result = mysqli_query($link, $queryString);
	$pageId = mysqli_insert_id($link);
	
	$queryString = "INSERT INTO a_book_page (bookId, pageId) VALUES (".$bookId.",".$pageId.")";
	$result = mysqli_query($link, $queryString);
	
	for($i = 0; $i < count($page["imgs"]); $i++)
	{
		$queryString = "INSERT INTO a_page_file (pageId, fileId, rank) VALUES (".$pageId.",".$page["imgs"][$i]["Id"].",".$i.")";
		$result = mysqli_query($link, $queryString);
	}
}

function clearBooks()
{
	$link = mysqli_connect("localhost", "root", "sunny", "sunny");
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
	    //error_log("Échec de la connexion");
	    exit();
	}
	
	$queryString = "DELETE a FROM s_books a";
	$result = mysqli_query($link, $queryString);
	
	$queryString = "DELETE a FROM s_book_pages a";
	$result = mysqli_query($link, $queryString);
	
	$queryString = "DELETE a FROM a_book_page a";
	$result = mysqli_query($link, $queryString);
	
	$queryString = "DELETE a FROM s_page_file a";
	$result = mysqli_query($link, $queryString);
}

?>
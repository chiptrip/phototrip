<?

$link = mysqli_connect("localhost", "root", "sunny", "sunny");	
/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    //print("Échec de la connexion");
    exit();
}

$queryString = "CALL CLEAR_FILES()";
$result = mysqli_query($link, $queryString);

mysqli_free_result($result);

header("Location:./index.html");
?>

<?php

// Use this namespace
use Steampixel\Route;

// Include router class
include 'src/Steampixel/Route.php';

// Define a global basepath
define('BASEPATH','/');

// If your script lives in a subfolder you can use the following example
// Do not forget to edit the basepath in .htaccess if you are on apache
// define('BASEPATH','/api/v1');
Route::add('/', function() {
    // session_start inicia a sessão
    session_start();
    echo "index";

},['GET']);
/* Add base route (startpage)
Route::add('/tokens', function() {
// session_start inicia a sessão
session_start();
// a variável de token recebem os dados digitados na página anterior
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
$ids = $_REQUEST["token"];
echo $_REQUEST["token"];
// puxa o banco de dados.
require_once("conexao.php");
if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}
$sql = 'Select * from tokens where token = "'.$ids.'";';
$result = $connection->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		if ($row["tempo"] == 0){
		echo "Token Invalido peça um novo token!";
		$removertokeninv = "DELETE FROM tokens where tempo=0;";
		$connection->query($removertokeninv);
		unset ($_SESSION['token']);
		header('location:token');
		}elseif ($row["tempo"] >= 1){
		echo "Token Valido!";
		$_SESSION["token"] = $ids;
		header('location:upload');
		}
	  }
	}  else {
		unset ($_SESSION['token']);
		header('location:token');
	  echo "0 results";
	}
 }
},['get','post']);
*/
// Add a 404 not found route
Route::pathNotFound(function($path) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 404 Not Found');
  echo 'Error 404 :-(<br>';
  echo 'The requested path "'.$path.'" was not found!';
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 405 Method Not Allowed');
  echo 'Error 405 :-(<br>';
  echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
});

// Return all known routes
Route::add('/known-routes', function() {
  $routes = Route::getAll();
  echo '<ul>';
  foreach($routes as $route) {
    echo '<li>'.$route['expression'].' ('.$route['method'].')</li>';
  }
  echo '</ul>';
});

// Run the Router with the given Basepath
Route::run(BASEPATH);

// Enable case sensitive mode, trailing slashes and multi match mode by setting the params to true
// Route::run(BASEPATH, true, true, true);

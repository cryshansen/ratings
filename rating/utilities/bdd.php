<?php
require_once('util/pdo_connection.php');

try {

$dsn = "mysql:host=$servername;dbname=$database;charset=$charset";
$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Connection Okay";

return $pdo;

}

catch (PDOException $e)

{
echo "Connection failed: ". $e->getMessage();
}

?>
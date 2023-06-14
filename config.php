
<?php

$dsn = "mysql:host=localhost;dbname=familyfresh";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected";
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>


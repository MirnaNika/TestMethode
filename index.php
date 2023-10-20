<?php

$host = "localhost";
$username = "mirna";
$password = "1234";
$database = "testDB";

// Number of records to insert
$numRecords = 1000;

// MySQLi connection
$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("MySQLi Connection failed: " . $mysqli->connect_error);
}

$start_time = microtime(true);

for ($i = 1; $i <= $numRecords; $i++) {
    $name = "Name $i";
    $email = "email$i@example.com";
    $mysqli->query("INSERT INTO performance_test (name, email) VALUES ('$name', '$email')");
}

$end_time = microtime(true);
$mysqli_time = $end_time - $start_time;

$mysqli->close();

// PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
} catch (PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

$start_time = microtime(true);

for ($i = 1; $i <= $numRecords; $i++) {
    $name = "Name $i";
    $email = "email$i@example.com";
    $stmt = $pdo->prepare("INSERT INTO performance_test (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);
}

$end_time = microtime(true);
$pdo_time = $end_time - $start_time;

$pdo = null;

echo "MySQLi Insert Time: $mysqli_time seconds<br>";
echo "PDO Insert Time: $pdo_time seconds";
?>

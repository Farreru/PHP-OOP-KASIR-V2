<?php

$DB_HOSTNAME;
$DB_PORT;
$DB_USERNAME;
$DB_PASSWORD;
$DB_DATABASE;

$configContents = file_get_contents(__DIR__ . '/../config.json');
$configData = json_decode($configContents, true);

if ($configData !== null) {
    $DB_HOSTNAME = $configData['DB_HOSTNAME'] ?? '';
    $DB_PORT = $configData['DB_PORT'] ?? '';
    $DB_USERNAME = $configData['DB_USERNAME'] ?? '';
    $DB_PASSWORD = $configData['DB_PASSWORD'] ?? '';
    $DB_DATABASE = $configData['DB_DATABASE'] ?? '';
} else {
    throw new Exception("Error reading configuration from config.json");
}

try {
    $db = new PDO("mysql:host=$DB_HOSTNAME;port=$DB_PORT;dbname=$DB_DATABASE", $DB_USERNAME, $DB_PASSWORD);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

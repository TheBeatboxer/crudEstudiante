
<?php
$host = 'localhost';
$dbname = 'universidad';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexion exitosa";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>
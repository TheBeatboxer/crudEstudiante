
<?php
$host = '192.168.150.135';
$dbname = 'UNIVERSIDAD';
$username = 'efer';
$password = 'efertello2002';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexion exitosa";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>
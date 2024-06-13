
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'create':
        try {
            // Depurar datos recibidos
            var_dump($_POST);

            // Validar que todos los campos están presentes
            if (isset($_POST['codigo'], $_POST['nombre'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['DNI'], $_POST['facultad'])) {
                $codigo = $_POST['codigo'];
                $nombre = $_POST['nombre'];
                $apellidoPaterno = $_POST['apellidoPaterno'];
                $apellidoMaterno = $_POST['apellidoMaterno'];
                $DNI = $_POST['DNI'];
                $facultad = $_POST['facultad'];

                $stmt = $pdo->prepare("INSERT INTO estudiante (codigo, nombre, apellidoPaterno, apellidoMaterno, DNI, facultad) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$codigo, $nombre, $apellidoPaterno, $apellidoMaterno, $DNI, $facultad]);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'read':
        try {
            $stmt = $pdo->query("SELECT * FROM estudiante");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'update':
        try {
            if (isset($_POST['id'], $_POST['codigo'], $_POST['nombre'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['DNI'], $_POST['facultad'])) {
                $id = $_POST['id'];
                $codigo = $_POST['codigo'];
                $nombre = $_POST['nombre'];
                $apellidoPaterno = $_POST['apellidoPaterno'];
                $apellidoMaterno = $_POST['apellidoMaterno'];
                $DNI = $_POST['DNI'];
                $facultad = $_POST['facultad'];

                $stmt = $pdo->prepare("UPDATE estudiante SET codigo = ?, nombre = ?, apellidoPaterno = ?, apellidoMaterno = ?, DNI = ?, facultad = ? WHERE id = ?");
                $stmt->execute([$codigo, $nombre, $apellidoPaterno, $apellidoMaterno, $DNI, $facultad, $id]);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'delete':
        try {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];

                $stmt = $pdo->prepare("DELETE FROM estudiante WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        break;
}
?>
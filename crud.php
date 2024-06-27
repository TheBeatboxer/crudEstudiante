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
            if (isset($_POST['titulo'], $_POST['autor'], $_POST['editorial'], $_POST['fechaPublicacion'], $_POST['numeroPaginas'])) {
                $titulo = $_POST['titulo'];
                $autor = $_POST['autor'];
                $editorial = $_POST['editorial'];
                $fechaPublicacion = $_POST['fechaPublicacion'];
                $numeroPaginas = $_POST['numeroPaginas'];

                $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor, editorial, fechaPublicacion, numeroPaginas) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$titulo, $autor, $editorial, $fechaPublicacion, $numeroPaginas]);
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
            $stmt = $pdo->query("SELECT * FROM libros");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'update':
        try {
            if (isset($_POST['id'], $_POST['titulo'], $_POST['autor'], $_POST['editorial'], $_POST['fechaPublicacion'], $_POST['numeroPaginas'])) {
                $id = $_POST['id'];
                $titulo = $_POST['titulo'];
                $autor = $_POST['autor'];
                $editorial = $_POST['editorial'];
                $fechaPublicacion = $_POST['fechaPublicacion'];
                $numeroPaginas = $_POST['numeroPaginas'];

                $stmt = $pdo->prepare("UPDATE libros SET titulo = ?, autor = ?, editorial = ?, fechaPublicacion = ?, numeroPaginas = ? WHERE id = ?");
                $stmt->execute([$titulo, $autor, $editorial, $fechaPublicacion, $numeroPaginas, $id]);
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

                $stmt = $pdo->prepare("DELETE FROM libros WHERE id = ?");
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


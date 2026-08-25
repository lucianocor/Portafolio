<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'conexion.php';

$metodo = $_SERVER['REQUEST_METHOD'];

// -------------------------------------------------------------
// LEER (GET)
// -------------------------------------------------------------
if ($metodo === 'GET') {
    $sql = "SELECT MateriaId, NombreMateria, Anio, Estado FROM materias ORDER BY Anio ASC, NombreMateria ASC";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        http_response_code(500);
        echo json_encode(['error' => mysqli_error($conn)]);
        exit;
    }

    $materias = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $materias[] = $fila;
    }

    echo json_encode($materias);
    exit;
}

// -------------------------------------------------------------
// CREAR Y ELIMINAR (POST)
// -------------------------------------------------------------
if ($metodo === 'POST') {
    $accion = $_POST['accion'] ?? 'crear';

    // ELIMINAR
    if ($accion === 'eliminar') {
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de materia inválido']);
            exit;
        }

        $stmt = mysqli_prepare($conn, "DELETE FROM materias WHERE MateriaId = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => mysqli_error($conn)]);
        }

        mysqli_stmt_close($stmt);
        exit;
    }
    if ($accion === 'editar') {
        $id     = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $estado = trim($_POST['estado'] ?? '');
        $anio   = isset($_POST['anio']) ? (int)$_POST['anio'] : null;

        if (!$id || empty($nombre) || empty($estado) || !$anio) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos para actualizar']);
            exit;
        }

        $stmt = mysqli_prepare($conn, "UPDATE materias SET NombreMateria = ?, Estado = ?, Anio = ? WHERE MateriaId = ?");
        mysqli_stmt_bind_param($stmt, "ssii", $nombre, $estado, $anio, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => mysqli_error($conn)]);
        }

        mysqli_stmt_close($stmt);
        exit;
    }
    // CREAR
    if ($accion === 'crear') {
        $nombre = trim($_POST['nombre'] ?? '');
        $estado = trim($_POST['estado'] ?? 'Cursando');
        $anio   = isset($_POST['anio']) ? (int)$_POST['anio'] : 1;

        if (empty($nombre)) {
            http_response_code(400);
            echo json_encode(['error' => 'El nombre de la materia es obligatorio']);
            exit;
        }

        $stmt = mysqli_prepare($conn, "INSERT INTO materias (NombreMateria, Estado, Anio) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $estado, $anio);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                'success' => true,
                'MateriaId' => mysqli_insert_id($conn),
                'NombreMateria' => $nombre,
                'Estado' => $estado,
                'Anio' => $anio
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => mysqli_error($conn)]);
        }

        mysqli_stmt_close($stmt);
        exit;
    }
}
?>
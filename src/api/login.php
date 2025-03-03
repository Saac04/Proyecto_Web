<?php
header("Content-Type: application/json");
require "db.php"; // Importamos la conexión a la base de datos

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["nombre_usuario"]) || !isset($data["contraseña"])) {
    echo json_encode(["error" => "Por favor, ingresa tu nombre de usuario y contraseña."]);
    exit;
}

$nombre_usuario = $data["nombre_usuario"];
$contraseña = $data["contraseña"];

try {
    $stmt = $pdo->prepare("SELECT id, contraseña FROM usuarios WHERE nombre_usuario = ?");
    $stmt->execute([$nombre_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if ($contraseña === $usuario["contraseña"]) { // Aquí luego usaremos password_verify()
            echo json_encode(["success" => "¡Bienvenido de nuevo! Has iniciado sesión exitosamente.", "user_id" => $usuario["id"]]);
        } else {
            echo json_encode(["error" => "La contraseña que ingresaste ta mal. Por favor, deja de tener sida."]);
        }
    } else {
        echo json_encode(["error" => "El nombre de usuario no existe. ¿Bro y si registras?"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Hubo un problema al procesar tu solicitud. Intenta de nuevo más tarde."]);
}
?>

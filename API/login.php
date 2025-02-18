<?php
header("Content-Type: application/json");
require "db.php"; // Importamos la conexión a la BD

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["nombre_usuario"]) || !isset($data["contraseña"])) {
    echo json_encode(["error" => "Faltan datos"]);
    exit;
}

$nombre_usuario = $data["nombre_usuario"];
$contraseña = $data["contraseña"];

try {
    $stmt = $pdo->prepare("SELECT id, contraseña FROM usuarios WHERE nombre_usuario = ?");
    $stmt->execute([$nombre_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $contraseña === $usuario["contraseña"]) { // Aquí luego usaremos password_verify()
        echo json_encode(["success" => "Login exitoso", "user_id" => $usuario["id"]]);
    } else {
        echo json_encode(["error" => "Usuario o contraseña incorrectos"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>

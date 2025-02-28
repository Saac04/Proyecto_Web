<?php
header("Content-Type: application/json");
require "db.php"; // Importamos la conexión a la base de datos

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["nombre_usuario"]) || !isset($data["email"]) || !isset($data["contraseña"])) {
    echo json_encode(["error" => "Por favor, ingresa todos los datos: nombre de usuario, email y contraseña."]);
    exit;
}

$nombre_usuario = $data["nombre_usuario"];
$email = $data["email"];
$contraseña = $data["contraseña"];

// Validar el formato del email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Por favor, ingresa un email válido."]);
    exit;
}

// Validar que el nombre de usuario no exista ya en la base de datos
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
$stmt->execute([$nombre_usuario]);
if ($stmt->rowCount() > 0) {
    echo json_encode(["error" => "El nombre de usuario ya está en uso."]);
    exit;
}

// Guardar la contraseña sin hash (solo temporalmente)
$hashed_password = $contraseña;

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, email, contraseña) VALUES (?, ?, ?)");
    $stmt->execute([$nombre_usuario, $email, $hashed_password]);

    echo json_encode(["success" => "¡Te has registrado exitosamente! Ahora puedes iniciar sesión."]);
} catch (Exception $e) {
    echo json_encode(["error" => "Hubo un problema al procesar tu solicitud. Intenta de nuevo más tarde."]);
}
?>

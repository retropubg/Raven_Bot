<?php

// Configurar el manejo de errores para Railway
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php_errors.log');

// Incluir archivos necesarios
try {
    require_once __DIR__ . '/bot.php'; // Ajusta según tu estructura
} catch (Exception $e) {
    error_log("Error al cargar bot.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
    exit;
}

// Configurar el servidor para Railway
$port = getenv('PORT') ?: 8080; // Railway asigna dinámicamente el puerto

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if ($data) {
        $response = handle_bot_request($data);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo "Raven Bot is running on port $port";
}

// Mantener el script en ejecución
while (true) {
    sleep(10);
}

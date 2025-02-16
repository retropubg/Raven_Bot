<?php

// Configurar el manejo de errores para Railway
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php_errors.log');
error_log("Script iniciado en Railway");

// Incluir archivos necesarios
try {
    require_once '/bot.php'; // Asegúrate de que bot.php existe y está correctamente estructurado
} catch (Exception $e) {
    error_log("Error al cargar bot.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
    exit;
}

// Obtener el puerto asignado por Railway
defined('PORT') or define('PORT', getenv('PORT') ?: 8080);

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
    echo "Raven Bot is running on port " . PORT;
}

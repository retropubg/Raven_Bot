<?php

// Configurar el manejo de errores para Railway
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php_errors.log');
error_log("Script iniciado en Railway");



// Incluir archivos necesarios
try {
    require_once __DIR__ . '/bot.php'; // Ajusta según tu estructura
} catch (Exception $e) {
    error_log("Error al cargar bot.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
    exit;
}

// Configurar el puerto asignado por Railway
$port = getenv('PORT');
if (!$port || !is_numeric($port)) {
    $port = 8080; // Valor por defecto si no está definido correctamente
}

// Función para manejar las solicitudes
function handle_request() {
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
        echo "Raven Bot is running on port " . getenv('PORT');
    }
}

// Iniciar el servidor PHP embebido
$command = "php -S 0.0.0.0:$port -t public"; // Asegúrate de que "public" es tu carpeta con index.php
error_log("Iniciando servidor en Railway con el comando: $command");
exec($command);

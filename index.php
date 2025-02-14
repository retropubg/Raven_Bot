<?php

// Activar la visualización de errores para depuración (desactívalo en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir archivos necesarios (ajusta según tu estructura de proyecto)
require_once 'bot.php'; // Asegúrate de que este archivo existe y contiene la lógica del bot

// Verificar si la solicitud es válida (puedes cambiarlo según la necesidad)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la entrada JSON desde la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Procesar la entrada con la función de tu bot
    if ($data) {
        $response = handle_bot_request($data); // Asegúrate de que esta función esté definida en bot.php
        
        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo 'Raven Bot is running';
}

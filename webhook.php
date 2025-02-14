<?php

ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

ignore_user_abort(true);
set_time_limit(0);

// Función que contiene la lógica del bot (ejemplo)
function run_bot() {
    while (true) {
        // Aquí va la lógica del bot, por ejemplo, revisando mensajes y enviando respuestas

        // Sleep para evitar que el ciclo consuma demasiados recursos
        sleep(5); // Espera 5 segundos entre iteraciones (puedes ajustarlo según lo necesites)
    }
}

$data = file_get_contents('php://input');

// Codifica los datos recibidos si es necesario
$encoded_data = base64_encode($data);

// Ejecutar el script bot.php en segundo plano
exec("nohup php -r '"
    . 'ignore_user_abort(true);'
    . 'set_time_limit(0);'
    . 'while (true) {'
    . '  // Aquí va tu lógica del bot; por ejemplo, escucha de mensajes o interacciones'
    . '  sleep(5);' // Ajusta el tiempo de espera según lo necesario
    . '}' // Fin del ciclo
    . "' > /dev/null 2>&1 &");

?>

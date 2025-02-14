<?php

// URL de tu bot o servicio (reemplaza esto con la URL correcta de tu bot en Railway)
$url = 'https://ravenbot-production.up.railway.app'; // Cambia a la URL de tu bot

// Intervalo de tiempo en segundos (por ejemplo, 5 minutos = 300 segundos)
$intervalo = 300;

while (true) {
    // Realiza una solicitud GET para mantener el bot activo
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    // Ejecuta la solicitud
    $response = curl_exec($ch);
    
    // Verifica si hubo un error
    if(curl_errno($ch)) {
        echo 'Error en la solicitud: ' . curl_error($ch);
    } else {
        echo 'Solicitud exitosa: ' . $response;
    }
    
    // Cierra la conexión cURL
    curl_close($ch);
    
    // Espera el intervalo especificado antes de hacer la siguiente solicitud
    sleep($intervalo);
}
?>

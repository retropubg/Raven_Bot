<?php

ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

ignore_user_abort(true);
set_time_limit(0);

require_once 'config.php';
require_once 'telegram.php';

$bot = new TelegramBot(BOT_TOKEN, BOT_LOGS, BOT_GROUP);
$bot->dbInfo(DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

$update = isset($argv[1]) && !empty($argv[1]) ? base64_decode($argv[1]) : file_get_contents('php://input');
$bot->setData($update);

require 'classes/CurlX.php';
require 'classes/Response.php';
require 'classes/Tools.php';
require 'classes/Generator.php';

$curlx = new CurlX;
$response = new Response;
$tools = new Tools;
$generator = new GenCard;

$bot->setChkAPI($curlx, $response, $tools);

if (isset($bot->getData()->callback_query)) {
    require 'inline.php';
    exit();
}

if (isset($bot->getData()->message)) {
    $msg = $bot->getData()->message;

    // Definir variables antes de usarlas
    $user_id = $msg->from->id ?? '';
    $first_n = $msg->from->first_name ?? '';
    $usern_n = $msg->from->username ?? '';
    $message = $msg->text ?? $msg->caption ?? '';
    $document = $msg->document ?? false;

    // Registro automático de usuarios
    $user_info = $bot->fetchUser($user_id);
    if (!$user_info && !empty($user_id)) {
        $pdo = $bot->dbConn();
        $sql = "INSERT INTO users (user_id, username, first_name, last_name, status, plan, credits, expiry) 
                VALUES (:user_id, :username, :first_name, :last_name, 'active', 'free', 10, NULL)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':username' => $usern_n ?? '',
                ':first_name' => $first_n ?? '',
                ':last_name' => ''
            ]);
            error_log("✅ Usuario {$user_id} añadido correctamente.");
        } catch (PDOException $e) {
            error_log("❌ Error al insertar usuario: " . $e->getMessage());
        }
    }
}

// Evitar el error de preg_match() en telegram.php
if (isset($message) && !empty($message)) {
    // Código normal con preg_match()
} else {
    $message = ''; // Asegurar que siempre es una cadena vacía si es NULL
}

?>

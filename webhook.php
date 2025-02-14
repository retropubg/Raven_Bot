<?php
require_once 'config.php';
require_once 'telegram.php';

$bot = new TelegramBot(BOT_TOKEN, BOT_LOGS, BOT_GROUP);
$bot->dbInfo(DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

// Obtener la actualización de Telegram
$data = file_get_contents('php://input');
$bot->setData($data);

// Ejecutar la lógica del bot
require 'bot.php';

http_response_code(200);
echo "OK";

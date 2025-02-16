<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config.php';

if (!class_exists('TelegramBot')) {
    require_once __DIR__ . '/telegram.php';
}

require_once __DIR__ . '/bot.php';

$bot = new TelegramBot(BOT_TOKEN, BOT_LOGS, BOT_GROUP);

$bot->dbInfo(DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

require 'classes/CurlX.php';
require 'classes/Response.php';
require 'classes/Tools.php';
require 'classes/Generator.php';

$curlx = new CurlX;
$response = new Response;
$tools = new Tools;
$generator = new GenCard;

$bot->setChkAPI($curlx, $response, $tools);

$gates = $bot->fetchTools();

$json = [];

if (!is_array($gates) || empty($gates)) {
    die("Error: No se pudieron obtener las herramientas.");
}

foreach ($gates as $gate) {
    $json[$gate['cmd']] = [
        'status' => $gate['status'],
        'name' => $gate['name'],
        'access' => $gate['type'],
        'info' => $gate['info'],
        'comm' => $gate['comm'],
        'status' => $gate['status'],
        'format' => $gate['format'],
        'creation' => $gate['creation']
    ];
}

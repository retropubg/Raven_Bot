<?php

// Habilitar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Conectar a la base de datos con variables de entorno
    $pdo = new PDO(
        "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_DATABASE') . ";charset=utf8mb4",
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Consulta SQL para insertar usuario
    $sql = "INSERT INTO users (user_id, username, first_name, last_name, status, plan, credits, expiry) 
            VALUES (:user_id, :username, :first_name, :last_name, :status, :plan, :credits, :expiry)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => 6699273462,
        ':username' => 'eretro_7',
        ':first_name' => 'Retro',
        ':last_name' => 'Smith',
        ':status' => 'active',
        ':plan' => 'premium',
        ':credits' => 1000,
        ':expiry' => null
    ]);

    echo "✅ Usuario agregado correctamente.";
} catch (PDOException $e) {
    echo "❌ Error al agregar usuario: " . $e->getMessage();
}

?>

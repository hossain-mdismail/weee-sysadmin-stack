<?php
// Read credentials injected by Docker Compose
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'weee_db';
$user = getenv('DB_USER') ?: 'weee_user';
$pass = getenv('DB_PASSWORD') ?: 'change_this_secure_password';

// Set response header
header('Content-Type: text/plain; charset=utf-8');

try {
    // 1. Establish connection via PDO
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    echo "[OK] Successfully connected to MariaDB service at '$host'!\n";

    // 2. Create a test table if it doesn't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS sysadmin_checks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        checked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status VARCHAR(50) NOT NULL
    )");

    // 3. Insert a health-check entry
    $stmt = $pdo->prepare("INSERT INTO sysadmin_checks (status) VALUES (:status)");
    $stmt->execute(['status' => 'healthy']);

    // 4. Query the count of total checks recorded
    $count = $pdo->query("SELECT COUNT(*) FROM sysadmin_checks")->fetchColumn();
    echo "[OK] Database write & read successful. Total health checks logged: $count\n";

} catch (PDOException $e) {
    echo "[ERROR] Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
EOF

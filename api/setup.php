<?php
require_once __DIR__ . '/config/db.php';

$hash = password_hash($_ENV['ADMIN_PASSWORD'], PASSWORD_BCRYPT);
getDB()->prepare('UPDATE admin SET password = ? WHERE username = ?')
    ->execute([$hash, $_ENV['ADMIN_USERNAME']]);

echo 'Done. Hash: ' . $hash;

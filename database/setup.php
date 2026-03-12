<?php
require_once 'config/db.php';
$hash = password_hash('P@ssw0rd', PASSWORD_BCRYPT);
getDB()->prepare('UPDATE admin SET password = ? WHERE username = ?')
    ->execute([$hash, 'admin']);
echo 'Done: ' . $hash;

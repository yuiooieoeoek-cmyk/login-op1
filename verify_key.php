<?php
// Set timezone to UTC to make menu expire same time for all users across the world
date_default_timezone_set("UTC");

// Get POST values
$username = trim($_POST['user'] ?? '');
$password = trim($_POST['pass'] ?? '');

// Basic validation
if (empty($username) || empty($password)) {
    echo "missing_fields";
    exit;
}

// Hardcoded accounts with expiration - ONLY ALI~BN
$accounts = [
    "ALI~BN1" => [
        "password" => "ALI~BN1", 
        "expires" => "2025-08-29 23:59:59"
    ]
];

if (isset($accounts[$username])) {
    $userData = $accounts[$username];
    $correctPass = $userData["password"];
    $expiresStr = $userData["expires"];
    $expires = strtotime($expiresStr);
    $now = time();

    if ($password !== $correctPass) {
        echo "wrong_pass";
    } else if ($now > $expires) {
        echo "expired";
    } else {
        // Return status, expiration time, and server time (all in UTC)
        echo "valid|$expiresStr|server=" . date("Y-m-d H:i:s");
    }
} else {
    echo "not_found";
}
?>
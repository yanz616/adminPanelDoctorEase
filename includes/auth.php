<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit;
}

// Validasi apakah admin
$opts = [
    'http' => [
        'header' => "Authorization: Bearer {$_SESSION['token']}"
    ]
];
$context = stream_context_create($opts);
$userJson = @file_get_contents("http://127.0.0.1:8000/api/user", false, $context);
$user = json_decode($userJson, true);

if (empty($user) || !$user['is_admin']) {
    echo "Akses ditolak. Anda bukan admin.";
    exit;
}
?>

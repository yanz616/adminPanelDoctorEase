<?php
include '../includes/auth.php';
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = http_build_query([
        'scheduled_at' => $_POST['scheduled_at'],
        'purpose' => $_POST['purpose'],
        'status' => $_POST['status'],
    ]);

    $opts = [
        'http' => [
            'method' => 'PUT',
            'header' => "Authorization: Bearer {$_SESSION['token']}\r\nContent-Type: application/x-www-form-urlencoded",
            'content' => $data,
        ]
    ];
    $context = stream_context_create($opts);
    file_get_contents("http://127.0.0.1:8000/api/admin/appointments/$id", false, $context);
    header("Location: index.php");
    exit;
}

$opts = ['http' => ['header' => "Authorization: Bearer {$_SESSION['token']}"]];
$context = stream_context_create($opts);
$response = file_get_contents("http://127.0.0.1:8000/api/admin/appointments", false, $context);
$appointments = json_decode($response, true);
$appointment = array_filter($appointments, fn($a) => $a['id'] == $id)[0];
?>

<h2>Edit Appointment</h2>
<form method="POST">
    Status: 
    <select name="status">
        <option value="pending" <?= $appointment['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="approved" <?= $appointment['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
        <option value="canceled" <?= $appointment['status'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
        <option value="completed" <?= $appointment['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
    </select><br>
    <button type="submit">Update</button>
</form>

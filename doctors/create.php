<?php include '../includes/auth.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = http_build_query([
        'name' => $_POST['name'],
        'specialization' => $_POST['specialization'],
        'photo_url' => $_POST['photo_url'],
    ]);

    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => "Authorization: Bearer {$_SESSION['token']}\r\nContent-Type: application/x-www-form-urlencoded",
            'content' => $data
        ]
    ];
    $context = stream_context_create($opts);
    file_get_contents("http://127.0.0.1:8000/api/admin/doctors", false, $context);

    header("Location: doctor.php");
    exit;
}
?>

<form method="POST">
    <h2>Tambah Dokter</h2>
    Nama: <input type="text" name="name"><br>
    Spesialisasi: <input type="text" name="specialization"><br>
    Foto URL: <input type="text" name="photo_url"><br>
    <button type="submit">Simpan</button>
</form>

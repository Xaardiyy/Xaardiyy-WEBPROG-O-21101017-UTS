<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title  = $_POST['title'];
    $author = $_POST['author'];
    $status = $_POST['status'];
    $rating = $_POST['rating'];
    $notes  = $_POST['notes'];

    $filePath = '';
    $fileType = '';

    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        $fileName = time() . '_' . basename($_FILES['file']['name']);
        $targetDir = 'assets/uploads/';
        $targetPath = $targetDir . $fileName;
        $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            $filePath = $fileName;
        }
    }

    $query = "INSERT INTO books (title, author, status, rating, notes, file_path, file_type)
              VALUES ('$title', '$author', '$status', $rating, '$notes', '$filePath', '$fileType')";

    mysqli_query($conn, $query);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2>Tambah Buku Baru</h2>
    <form method="POST" enctype="multipart/form-data">
        <input name="title" class="form-control mb-2" placeholder="Judul Buku" required>
        <input name="author" class="form-control mb-2" placeholder="Penulis" required>
        <select name="status" class="form-control mb-2">
            <option>Belum Dibaca</option>
            <option>Sedang Dibaca</option>
            <option>Selesai</option>
        </select>
        <input type="number" name="rating" class="form-control mb-2" placeholder="Rating (1-5)" min="1" max="5">
        <textarea name="notes" class="form-control mb-2" placeholder="Catatan"></textarea>
        <input type="file" name="file" class="form-control mb-3">
        <button class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>

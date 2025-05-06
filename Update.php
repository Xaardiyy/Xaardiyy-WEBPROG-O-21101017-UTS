<?php
include 'db.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id=$id"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $status = $_POST['status'];
    $rating = $_POST['rating'];
    $notes = $_POST['notes'];
    $filePath = $data['file_path'];
    $fileType = $data['file_type'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        if ($filePath && file_exists("assets/uploads/$filePath")) {
            unlink("assets/uploads/$filePath");
        }
        $fileName = time() . '_' . basename($_FILES['file']['name']);
        $targetPath = 'assets/uploads/' . $fileName;
        $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            $filePath = $fileName;
        }
    }

    $query = "UPDATE books SET 
        title='$title', author='$author', status='$status', 
        rating=$rating, notes='$notes',
        file_path='$filePath', file_type='$fileType'
        WHERE id=$id";

    mysqli_query($conn, $query);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2>Edit Buku</h2>
    <form method="POST" enctype="multipart/form-data">
        <input name="title" class="form-control mb-2" value="<?= $data['title'] ?>" required>
        <input name="author" class="form-control mb-2" value="<?= $data['author'] ?>" required>
        <select name="status" class="form-control mb-2">
            <option <?= $data['status']=='Belum Dibaca'?'selected':'' ?>>Belum Dibaca</option>
            <option <?= $data['status']=='Sedang Dibaca'?'selected':'' ?>>Sedang Dibaca</option>
            <option <?= $data['status']=='Selesai'?'selected':'' ?>>Selesai</option>
        </select>
        <input type="number" name="rating" class="form-control mb-2" value="<?= $data['rating'] ?>" min="1" max="5">
        <textarea name="notes" class="form-control mb-2"><?= $data['notes'] ?></textarea>
        <input type="file" name="file" class="form-control mb-3">
        <?php if ($data['file_path']): ?>
            <p>File Lama: <a href="assets/uploads/<?= $data['file_path'] ?>" target="_blank"><?= $data['file_path'] ?></a></p>
        <?php endif; ?>
        <button class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>

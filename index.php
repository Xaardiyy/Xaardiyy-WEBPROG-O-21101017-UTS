<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM books ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2>Daftar Buku</h2>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Buku</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Rating</th>
                <th>Catatan</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= $row['rating'] ?></td>
                <td><?= nl2br(htmlspecialchars($row['notes'])) ?></td>
                <td>
                    <?php if (!empty($row['file_path'])): ?>
                        <?php if (in_array(strtolower($row['file_type']), ['jpg','jpeg','png','gif'])): ?>
                            <img src="assets/uploads/<?= $row['file_path'] ?>" width="50">
                        <?php else: ?>
                            <a href="assets/uploads/<?= $row['file_path'] ?>" target="_blank">Lihat File</a>
                        <?php endif; ?>
                    <?php else: ?>
                        Tidak Ada
                    <?php endif; ?>
                </td>
                <td>
                    <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</body>
</html>

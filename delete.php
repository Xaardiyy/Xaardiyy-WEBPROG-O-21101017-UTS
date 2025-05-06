<?php
include 'db.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file_path FROM books WHERE id=$id"));

if ($data['file_path'] && file_exists("assets/uploads/" . $data['file_path'])) {
    unlink("assets/uploads/" . $data['file_path']);
}

mysqli_query($conn, "DELETE FROM books WHERE id=$id");
header("Location: index.php");
?>

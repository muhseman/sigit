<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "ID post tidak ditemukan.";
    exit;
}

$post_id = intval($_GET['id']);


$sql_check = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Post tidak ditemukan atau bukan milik Anda.";
    exit;
}


$sql_delete = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $post_id, $user_id);
if ($stmt_delete->execute()) {
    header("Location: dashboard.php");
    exit;
} else {
    echo "Gagal menghapus post.";
}
?>

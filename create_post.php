<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO posts (user_id, title, content, create_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Gagal menyimpan post.";
        }
    } else {
        $error = "Judul dan konten harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Post</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px; }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 6px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover { background-color: #0056b3; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Buat Post Baru</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label>Judul:</label>
            <input type="text" name="title" required>

            <label>Konten:</label>
            <textarea name="content" rows="6" required></textarea>

            <button type="submit" class="btn">Simpan</button>
        </form>
        <br>
        <a href="dashboard.php">← Kembali ke Dashboard</a>
    </div>
</body>
</html>
        
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


if (!isset($_GET['id'])) {
    echo "Post tidak ditemukan.";
    exit;
}

$post_id = $_GET['id'];


$sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Post tidak ditemukan atau bukan milik Anda.";
    exit;
}

$post = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['title'];
    $konten = $_POST['content'];

    $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $judul, $konten, $post_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal mengupdate post.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
        }
        .container {
            padding: 30px;
            max-width: 600px;
            margin: auto;
            background: white;
            margin-top: 50px;
            border-radius: 8px;
            box-shadow: 1px 1px 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
        }
        a {
            margin-left: 10px;
            text-decoration: none;
            color: #555;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Post</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="title" placeholder="Judul Post" value="<?= htmlspecialchars($post['title']) ?>" required>
            <textarea name="content" rows="6" placeholder="Isi post..." required><?= htmlspecialchars($post['content']) ?></textarea>
            <button type="submit">Simpan Perubahan</button>
            <a href="dashboard.php">Batal</a>
        </form>
    </div>
</body>
</html>

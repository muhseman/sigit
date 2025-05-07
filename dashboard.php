<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Post Saya</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
        }
        .navbar h1 {
            margin: 0;
            font-size: 20px;
            display: inline-block;
        }
        .navbar .menu {
            float: right;
            margin-top: 2px;
        }
        .navbar .menu a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
        }
        .container {
            padding: 20px;
        }
        .add-btn {
            display: inline-block;
            margin-bottom: 20px;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-btn:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            color: white;
            text-decoration: none;
        }
        .btn-detail {
            background-color: #007bff;
        }
        .btn-delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Post Saya</h1>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="logout.php" onclick="return confirm('Logout sekarang?')">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2>Daftar Post Anda</h2>
        <a class="add-btn" href="create_post.php">+ Tambah Post</a>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM posts WHERE user_id = ? ORDER BY create_at DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['create_at']}</td>";
                    echo "<td>
        <a class='btn btn-detail' href='post.php?id={$row['id']}'>Detail</a>
        <a class='btn btn-detail' href='edit_post.php?id={$row['id']}'>Edit</a>
        <a class='btn btn-delete' href='delete_post.php?id={$row['id']}' onclick=\"return confirm('Hapus post ini?')\">Hapus</a>
      </td>";

                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

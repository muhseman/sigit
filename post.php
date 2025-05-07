<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Post</title>
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
            padding: 30px;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .meta {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Navbar</h1>
        <div class="menu">
            <a href="index.php">Home</a>
        </div>
    </div>

    <div class="container">
        <?php
        if (!isset($_GET['id'])) {
            echo "<p>Post tidak ditemukan.</p>";
            exit;
        }

        $id = intval($_GET['id']);
        $sql = "SELECT posts.title, posts.content, posts.create_at, users.fullname FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE posts.id = $id";
        $result = $conn->query($sql);

        if (!$result) {
            echo "<p>Error SQL: " . $conn->error . "</p>";
        } elseif ($row = $result->fetch_assoc()) {
            echo '<div class="title">Detail ' . htmlspecialchars($row['title']) . '</div>';
            echo '<div class="meta"><strong>' . $row['create_at'] . '</strong><br>' . htmlspecialchars($row['fullname']) . '</div>';
            echo '<div class="content">' . nl2br(htmlspecialchars($row['content'])) . '</div>';
        } else {
            echo "<p>Post tidak ditemukan.</p>";
        }
        ?>
    </div>
</body>
</html>

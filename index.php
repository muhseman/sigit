<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Utama</title>
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
        .navbar .menu a, .navbar .menu form {
            display: inline-block;
            margin-left: 15px;
        }
        .navbar .menu a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }
        .navbar .menu button {
            background: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .container {
            padding: 20px;
        }
        .posts {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            width: 220px;
            box-shadow: 1px 1px 5px rgba(0,0,0,0.1);
        }
        .card a {
            font-weight: bold;
            color: #000;
            text-decoration: none;
        }
        .card a:hover {
            text-decoration: underline;
        }
        .card p {
            font-size: 14px;
            margin: 5px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Beranda</h1>
        <div class="menu">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="color: #ccc;">Hi, <?= htmlspecialchars($_SESSION['fullname']); ?></span>
                <form action="dashboard.php" method="get" style="display:inline;">
                    <button type="submit">Post Saya</button>
                </form>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <h2>Semua Post</h2>
        <div class="posts">
            <?php
            $sql = "SELECT posts.id, posts.title, posts.create_at, users.fullname FROM posts
                    JOIN users ON posts.user_id = users.id
                    ORDER BY posts.create_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<a href="post.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a>';
                    echo '<p>' . htmlspecialchars($row['fullname']) . '</p>';
                    echo '<p>' . $row['create_at'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>Belum ada post.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include 'koneksi.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fbfc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: white;
            padding: 40px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .form-container h2 {
            margin-bottom: 10px;
        }
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 6px 0 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .form-container p {
            margin-top: 15px;
            text-align: center;
        }
        .form-container a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Login</h2>
    <p>Welcome. Please enter your details.</p>
    <form method="POST" action="">
        <label>Email address</label>
        <input type="email" name="email" required placeholder="example@mail.com">
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>

    <?php
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $user = $res->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                header("Location: index.php");
                exit;
            } else {
                echo "<p style='color:red;'>Password salah.</p>";
            }
        } else {
            echo "<p style='color:red;'>Email tidak ditemukan.</p>";
        }
    }
    ?>
</div>
</body>
</html>

<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        .form-container input[type="text"],
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
    <h2>Register</h2>
    <p>Welcome. Please enter your details.</p>
    <form method="POST" action="">
        <label>Fullname</label>
        <input type="text" name="fullname" required placeholder="Enter your name here...">
        <label>Email address</label>
        <input type="email" name="email" required placeholder="example@mail.com">
        <label>Password</label>
        <input type="password" name="password" required>
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Have an account? <a href="login.php">Login</a></p>

    <?php
    if (isset($_POST['register'])) {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color:red;'>Format email tidak valid.</p>";
        } elseif ($password !== $confirm) {
            echo "<p style='color:red;'>Password tidak cocok.</p>";
        } else {
            $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                echo "<p style='color:red;'>Email sudah terdaftar.</p>";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $fullname, $email, $hash);
                if ($stmt->execute()) {
                    echo "<p style='color:green;'>Registrasi berhasil. Silakan <a href='login.php'>login</a>.</p>";
                } else {
                    echo "<p style='color:red;'>Terjadi kesalahan. Silakan coba lagi.</p>";
                }
            }

            $check->close();
        }
    }
    ?>
</div>
</body>
</html>

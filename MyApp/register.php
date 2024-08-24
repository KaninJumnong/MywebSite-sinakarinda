<?php
require 'data/server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ตรวจสอบว่ามีการป้อนข้อมูลครบถ้วน
    if (empty($username) || empty($email) || empty($password)) {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน";
        exit;
    }

    // เข้ารหัสรหัสผ่าน
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // เตรียมการสั่งซื้อข้อมูล
    $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $username, $email, $hashedPassword);

    // ตรวจสอบว่าคำสั่ง SQL ทำงานได้สำเร็จ
    if ($stmt->execute()) {
        echo "ลงทะเบียนสำเร็จ";
        header("location: login.php");
    } else {
        echo "เกิดข้อผิดพลาดในการลงทะเบียน: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<form method="post">
<h2>Register</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" placeholder="Username"><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Email"><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="Password"><br>
    <input type="submit" value="Register">
    <p>มีบัญชีผู้ใช้งานเเล้วหรือไม่<a href="login.php">เข้าสู่ระบบ</a></p>
</form>
</body>
</html>


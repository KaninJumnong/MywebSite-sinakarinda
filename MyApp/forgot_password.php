<?php
session_start();
include('data/server.php'); // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    if (empty($username)) {
        echo "กรุณากรอกชื่อผู้ใช้";
        exit;
    }

    $stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId);
        $stmt->fetch();

        // สร้างโทเค็นใหม่
        $token = bin2hex(random_bytes(32)); // สร้างโทเค็นแบบสุ่ม

        // บันทึกโทเค็นในฐานข้อมูล
        $stmt = $conn->prepare('INSERT INTO password_resets (user_id, token) VALUES (?, ?)');
        $stmt->bind_param('is', $userId, $token);
        $stmt->execute();

        // สร้างลิงก์รีเซ็ตรหัสผ่าน
        $resetLink = "http://yourwebsite.com/reset_password.php?token=" . urlencode($token);

        // ส่งอีเมลลิงก์รีเซ็ตรหัสผ่าน (ตัวอย่างนี้ส่งไปที่ตัวแปร $_SESSION['username'])
        $to = $_SESSION['username'] . "@example.com"; // แทนที่ด้วยอีเมลจริงของผู้ใช้
        $subject = "Reset Your Password";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = "From: no-reply@example.com";

        mail($to, $subject, $message, $headers);

        echo "ลิงก์รีเซ็ตรหัสผ่านถูกส่งไปยังอีเมลของคุณ";
    } else {
        echo "ชื่อผู้ใช้ไม่ถูกต้อง";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
<h2>Forgot Password</h2>
    <form action="reset_password.php" method="post">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>

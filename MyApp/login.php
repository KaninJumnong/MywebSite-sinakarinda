<?php
session_start();
include('data/server.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบว่ามีการป้อนข้อมูลครบถ้วน
    if (empty($username) || empty($password)) {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน";
        exit;
    }

    // เตรียมการสั่งซื้อข้อมูล
    $stmt = $conn->prepare('SELECT password, is_admin FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword, $isAdmin);
        $stmt->fetch();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $hashedPassword)) {
            // เริ่มต้นเซสชัน
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $isAdmin; // กำหนดค่าเป็น true หรือ false ขึ้นอยู่กับฐานข้อมูล
            header("Location: index.php");
            exit();
        } else {
            echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
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
    <title>Login</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
        <p>หากยังไม่สมัครสมาชิก <a href="register.php">สมัครสมาชิก</a></p>
        <p><a href="forgot_password.php">ลืมรหัสผ่าน?</a></p> <!-- เพิ่มลิงก์นี้ -->
    </form>
</body>
</html>

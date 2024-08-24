<?php
session_start();
require 'data/server.php'; // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบสิทธิ์การเข้าถึง (ให้แน่ใจว่าเป็น Admin)
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit;
}

// ลบสินค้า
if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    
    // ดึงชื่อไฟล์ภาพจากฐานข้อมูลก่อนที่จะลบ
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($product = $result->fetch_assoc()) {
        $image = $product['image'];
        
        // ลบสินค้าจากฐานข้อมูล
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();

        // ลบไฟล์ภาพจากเซิร์ฟเวอร์
        if (file_exists("img/" . $image)) {
            unlink("img/" . $image);
        }

        $stmt->close();
        $success = "ลบสินค้าสำเร็จ";

        // รีไดเร็กต์หลังการลบเพื่อป้องกันการส่งคำขอซ้ำ
        header("Location: admin.php");
        exit;
    } else {
        $error = "ไม่พบสินค้าดังกล่าว";
    }
}

// เพิ่มสินค้า
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "img/" . basename($image);

    // ตรวจสอบว่ามีการป้อนข้อมูลครบถ้วน
    if (empty($name) || empty($price) || empty($image)) {
        $error = "กรุณากรอกข้อมูลให้ครบถ้วน";
    } else {
        // ตรวจสอบว่าการอัปโหลดไฟล์เป็นไปอย่างถูกต้อง
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $price, $image);
            $stmt->execute();
            $stmt->close();
            $success = "เพิ่มสินค้าสำเร็จ";
        } else {
            $error = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
        }
    }
}

// ลบผู้ใช้
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->close();
    $success = "ลบผู้ใช้สำเร็จ";

    // รีไดเร็กต์หลังการลบเพื่อป้องกันการส่งคำขอซ้ำ
    header("Location: admin.php");
    exit;
}

// ดึงรายการสินค้า
$products_result = $conn->query("SELECT * FROM products");

// ดึงรายการผู้ใช้
$users_result = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="index.php"><img src="img/music.svg" alt="Music Shop"> Music Shop</a></li>
        </ul>
        <div class="login">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span> | 
            <a href="logout.php">Logout</a>
        </div>
    </nav>
    
    <main class="admin-dashboard">
        <section class="add-product">
            <h2>Add Product</h2>
            <?php if (isset($success)): ?>
                <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <?php elseif (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="admin.php" method="post" enctype="multipart/form-data">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required><br>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required><br>
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required><br>
                <input type="submit" name="add_product" value="Add Product">
            </form>
        </section>
        
        <section class="manage-products">
            <h2>Manage Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $products_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td><img src="img/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100"></td>
                            <td><a href="admin.php?delete_product=<?php echo htmlspecialchars($product['id']); ?>" class="delete-button">Delete</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        
        <section class="manage-users">
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><a href="admin.php?delete_user=<?php echo htmlspecialchars($user['id']); ?>" class="delete-button">Delete</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

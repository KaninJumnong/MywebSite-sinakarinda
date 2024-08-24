<?php
session_start(); // เริ่มต้นเซสชัน

// ข้อมูลกีตาร์ (ในกรณีนี้เป็นข้อมูลตัวอย่างที่คุณสามารถดึงจากฐานข้อมูลได้)
$guitar = [
    'name' => 'Fender Stratocaster',
    'description' => 'The Fender Stratocaster is an iconic electric guitar known for its exceptional versatility and rich sound. Perfect for various music genres including rock, blues, and jazz.',
    'price' => 999.99,
    'image' => 'img/stratocaster.jpg'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($guitar['name']); ?> - Guitar Details</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/guitar_information.css">
</head>
<body>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="index.php"><img src="img/music.svg" alt="Music Shop"> Music Shop</a></li>
        </ul>
        <div class="login">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span> | 
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </nav>
    
    <main class="guitar-details">
        <div class="guitar-image">
            <img src="img/main.png" alt="<?php echo htmlspecialchars($guitar['name']); ?>">
        </div>
        <div class="guitar-info">
            <h1><?php echo htmlspecialchars($guitar['name']); ?></h1>
            <p><?php echo htmlspecialchars($guitar['description']); ?></p>
            <p class="price">$<?php echo number_format($guitar['price'], 2); ?></p>
            <form action="cart.php" method="post">
                <input type="hidden" name="guitar_name" value="<?php echo htmlspecialchars($guitar['name']); ?>">
                <input type="hidden" name="guitar_price" value="<?php echo htmlspecialchars($guitar['price']); ?>">
                <button type="submit" class="buy-button">Add to Cart</button>
            </form>
        </div>
    </main>
</body>
</html>

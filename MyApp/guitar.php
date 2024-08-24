<?php
    include('data/server.php');

    session_start();

    if (!isset($_SESSION['username'])) {
        // ถ้าไม่มีการล็อกอิน ให้เปลี่ยนเส้นทางไปยังหน้า login
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guitar Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/guitar.css">
</head>
<body>
<nav class="navbar">
        <ul class="nav-links">
            <li><a href="index.php"><img src="img/music.svg" alt="Music Shop"><strong>Music Shop</strong></a></li>
        </ul>
        <div class="login">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span> | 
                <a href="logout.php"><strong>Logout</strong></a>
            <?php else: ?>
                <a href="login.php"><strong>Login</strong></a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Filter by Brand</h2>
            <ul>
                <li><a href="#" class="filter">Fender</a></li>
                <li><a href="#" class="filter">Gibson</a></li>
                <li><a href="#" class="filter">Ibanez</a></li>
                <li><a href="#" class="filter">Yamaha</a></li>
                <!-- Add more brands as needed -->
            </ul>
            <h2>Filter by Price</h2>
            <ul>
                <li><a href="#" class="filter">Under $500</a></li>
                <li><a href="#" class="filter">$500 - $1000</a></li>
                <li><a href="#" class="filter">$1000 - $2000</a></li>
                <li><a href="#" class="filter">Over $2000</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="guitar-item">
                <img src="img/main.png" alt="Fender Stratocaster">
                <h3>Fender Stratocaster</h3>
                <p>$699.99</p>
                <button class="buy-button">Buy Now</button>
            </div>
            <div class="guitar-item">
                <img src="img/main.png" alt="Gibson Les Paul">
                <h3>Gibson Les Paul</h3>
                <p>$2499.99</p>
                <button class="buy-button">Buy Now</button>
            </div>
            <div class="guitar-item">
                <img src="img/main.png" alt="Ibanez RG">
                <h3>Ibanez RG</h3>
                <p>$899.99</p>
                <button class="buy-button">Buy Now</button>
            </div>
            <div class="guitar-item">
                <img src="img/main.png" alt="Yamaha FG">
                <h3>Yamaha FG</h3>
                <p>$399.99</p>
                <button class="buy-button">Buy Now</button>
            </div>
            <!-- Add more guitars as needed -->
        </main>
    </div>

    <!-- Login Simulation -->
    <div id="login-prompt" class="login-prompt">
        <h2>Please Log In</h2>
        <button id="login-button">Log In</button>
    </div>

    <script src="scripts.js"></script>
</body>
</html>

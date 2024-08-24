<?php
    include('data/server.php');

    session_start();

    if (!isset($_SESSION['username'])) {
        // ถ้าไม่มีการล็อกอิน ให้เปลี่ยนเส้นทางไปยังหน้า login
        header("Location: login.php");
        exit();
    }

    if (isset($_GET['delete_product'])) {
        $product_id = $_GET['delete_product'];
    
        // ลบสินค้าจากฐานข้อมูล
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $stmt->close();
    
        // Redirect to prevent resubmission on refresh
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<nav class="navbar">
    <ul class="nav-links">
        <li><a href="index.php"><img src="img/music.svg" alt="Music Shop"><strong>Music Shop</strong></a></li>
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin']): ?>
            <li><a href="admin.php">Admin</a></li>
        <?php endif; ?>
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

    <div class="content"> 
        <div class="img">
            <a href="https://www.example.com/main-page">
                <img src="img/main.png" alt="Main Image">
            </a>
        </div>
    </div>

            <div class="guitar">
                <a href="guitar.php">
                    <img src="img/guitar.svg" alt="Guitar">
                </a>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At aspernatur quis excepturi nesciunt rerum explicabo, voluptas velit,</p>
            </div>
            <div class="piano">
                <a href="piano.php">
                    <img src="img/piano.svg" alt="Piano">
                </a>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At aspernatur quis excepturi nesciunt rerum explicabo, voluptas velit,</p>
            </div>
            <div class="drum">
                <a href="drum.php">
                    <img src="img/drum.svg" alt="Drum">
                </a>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At aspernatur quis excepturi nesciunt rerum explicabo, voluptas velit,</p>
            </div>

        <div class="content-lorem">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fuga maxime ipsam aliquid placeat, perferendis architecto optio culpa alias. Fugiat laudantium nam fugit vel! Dolorem nemo voluptates voluptas dolorum maiores cum.</p>
            <a href="#">join us</a>
        </div>

        <div class="products">
    <h2>Products</h2>
    <div class="grid-container">
        <div class="grid-item">
            <a href="guitar.php" class="product-link">
                <img src="img/main.png" alt="Guitar">
                <button class="buy-now"><a href="guitar_information.php">Buy Now</a></button>
            </a>
        </div>
        <div class="grid-item">
            <a href="guitar.php" class="product-link">
                <img src="img/main.png" alt="Guitar">
                <button class="buy-now"><a href="guitar_information.php">Buy Now</a></button>
            </a>
        </div>
        <div class="grid-item">
            <a href="guitar.php" class="product-link">
                <img src="img/main.png" alt="Guitar">
                <button class="buy-now"><a href="guitar_information.php">Buy Now</a></button>
            </a>
        </div>
        <div class="grid-item">
            <a href="guitar.php" class="product-link">
                <img src="img/main.png" alt="Guitar">
                <button class="buy-now"><a href="guitar_information.php">Buy Now</a></button>
            </a>
        </div>
        <div class="grid-item">
            <a href="guitar.php" class="product-link">
                <img src="img/main.png" alt="Guitar">
                <button class="buy-now"><a href="guitar_information.php">Buy Now</a></button>
            <?php $products_result = $conn->query("SELECT * FROM products");?>
            </a>
        </div>
    </div>
</div>

<main>
        <section class="products">
            <h2>Our Products</h2>
            <div class="product-list">
                <?php while ($product = $products_result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="img/main.png" alt="">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
                    </div>
                    <button class="buy-now"><a href="guitar_information.php">Buy Now</a></button>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-info">
            <h3>Contact Us</h3>
            <p>123 Main Street, City, Country</p>
            <p>Email: info@example.com</p>
            <p>Phone: +123 456 7890</p>
        </div>
        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-social">
            <h3>Follow Us</h3>
            <a href="#" class="social-icon"><img src="img/facebook.svg" alt="Facebook"></a>
            <a href="#" class="social-icon"><img src="img/twitter.svg" alt="Twitter"></a>
            <a href="#" class="social-icon"><img src="img/instagram.svg" alt="Instagram"></a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; Love coding. copyright 2024</p>
    </div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
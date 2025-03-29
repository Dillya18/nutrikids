<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// MySQL-ге қосылу
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "nutrikids_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Қосылым қатесі: " . $conn->connect_error);
}

// Пайдаланушының тапсырыстарын алу
$user_email = $_SESSION['user_email'];

$sql = "SELECT user_email, GROUP_CONCAT(item_name SEPARATOR ', ') AS items, SUM(item_price) AS total_price, 
        address, payment_method, status, ordered_at, shipped_at 
        FROM orders 
        WHERE user_email = '$user_email' 
        GROUP BY user_email, address, payment_method, status, ordered_at, shipped_at";
$result = $conn->query($sql);

// "Выйти" логикасы
if (isset($_GET['logout'])) {
    unset($_SESSION['loggedin']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - NutriKids</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <div class="head">
            <div class="head-1">
                <p><a href="catalog.php">Каталог продукции</a></p>
                <p><a href="index.php#continer-2">О нас</a></p>
                <p><a href="index.php#continer-6">Блог о питании</a></p>
            </div>
            <div class="head-12">
                <a href="index.php">NutriKids</a>
            </div>
            <div class="head-13">
                <p><a href="index.php#continer-7">Где купить</a></p>
                <p><a href="index.php#continer-5">Отзыв родителей</a></p>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <p><a href="favorites.php">Избранное</a></p>
                    <p><a href="cart.php">Корзина (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></p>
                    <p><a href="profile.php">Личный кабинет</a></p>
                    <p><a href="?logout=true">Выйти</a></p>
                <?php else: ?>
                    <p><a href="registration.php">Регистрация</a></p>
                    <p><a href="login.php">Войти</a></p>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="profile-section">
        <div class="profile-container">
            <h1>Личный кабинет</h1>
            
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>

            <div class="profile-buttons">
                <a href="cart.php" class="profile-btn cart-btn">В корзину</a>
                <a href="catalog.php" class="profile-btn catalog-btn">В каталог</a>
            </div>

            <h2>Ваши заказы</h2>
            <?php if ($result->num_rows > 0): ?>
                <div class="orders-table-wrapper">
                    <table class="orders-table">
                        <tr>
                            <th>Товарлар</th>
                            <th>Жалпы баға</th>
                            <th>Адрес</th>
                            <th>Төлем әдісі</th>
                            <th>Статус</th>
                            <th>Когда заказаны</th>
                            <th>Когда отправлены</th>
                        </tr>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['items']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_price']); ?> тг</td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo ($row['ordered_at'] ? htmlspecialchars($row['ordered_at']) : '-'); ?></td>
                                <td><?php echo ($row['shipped_at'] ? htmlspecialchars($row['shipped_at']) : '-'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            <?php else: ?>
                <p>Сізде тапсырыстар жоқ</p>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
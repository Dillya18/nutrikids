<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "nutrikids_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Қосылым қатесі: " . $conn->connect_error);
}

// Корзинадан затты өшіру
if (isset($_GET['remove_cart'])) {
    $index = $_GET['remove_cart'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        header("Location: cart.php");
        exit();
    }
}

// Тапсырыс беру
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $address = htmlspecialchars($_POST['address']);
        $payment_method = htmlspecialchars($_POST['payment_method']);
        $user_email = $_SESSION['user_email'];
        $ordered_at = date('Y-m-d H:i:s'); // Ағымдағы уақыт

        foreach ($_SESSION['cart'] as $item) {
            $item_name = $item['name'];
            $item_price = $item['price'];
            $sql = "INSERT INTO orders (user_email, item_name, item_price, address, payment_method, status, ordered_at) 
                    VALUES ('$user_email', '$item_name', '$item_price', '$address', '$payment_method', 'Ожидание', '$ordered_at')";
            $conn->query($sql);
        }
        unset($_SESSION['cart']); // Корзинаны тазалау
        echo "<script>alert('Тапсырыс сәтті берілді!'); window.location.href='index.php';</script>";
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['loggedin']);
    unset($_SESSION['user_email']);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - NutriKids</title>
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
                    <p><a href="?logout=true">Выйти</a></p>
                <?php else: ?>
                    <p><a href="registration.php">Регистрация</a></p>
                    <p><a href="login.php">Войти</a></p>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="cart-section">
        <h1>Ваша корзина</h1>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <div class="cart-items">
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $index => $item): ?>
                    <div class="cart-item">
                        <p><?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['price']); ?> тг</p>
                        <a href="?remove_cart=<?php echo $index; ?>" class="remove-btn">Удалить</a>
                    </div>
                    <?php $total += $item['price']; ?>
                <?php endforeach; ?>
                <p class="total">Общая сумма: <?php echo $total; ?> тг</p>

                <!-- Тапсырыс формасы -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="address">Адрес доставки:</label>
                        <textarea id="address" name="address" placeholder="Введите свой адрес" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Способ оплаты:</label>
                        <select name="payment_method" required>
                            <option value="онлайн">Онлайн</option>
                            <option value="при получении">При получении</option>
                        </select>
                    </div>
                    <button type="submit" name="order" class="auth-btn">Заказать</button>
                </form>
            </div>
        <?php else: ?>
            <p>Корзина пустая</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
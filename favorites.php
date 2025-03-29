<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// "Избранное"-дан өшіру
if (isset($_GET['remove_favorite'])) {
    $index = $_GET['remove_favorite'];
    if (isset($_SESSION['favorites'][$index])) {
        unset($_SESSION['favorites'][$index]);
        $_SESSION['favorites'] = array_values($_SESSION['favorites']);
        header("Location: favorites.php");
        exit();
    }
}

// "В корзину" қосу
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $item = [
        'name' => $_POST['item_name'],
        'price' => $_POST['item_price']
    ];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $item;
    echo "<script>alert('Товар добавлен в корзину!');</script>";
}

// "Выйти" логикасы
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
    <title>Избранное - NutriKids</title>
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
                <p><a href="profile.php">Личный кабинет</a></p> <!-- Жаңа сілтеме -->
                <p><a href="?logout=true">Выйти</a></p>
            <?php else: ?>
                <p><a href="registration.php">Регистрация</a></p>
                <p><a href="login.php">Войти</a></p>
            <?php endif; ?>
        </div>
    </div>
</header>

    <section class="cart-section">
        <h1>Ваше избранное</h1>
        <?php if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites'])): ?>
            <div class="cart-items">
                <?php foreach ($_SESSION['favorites'] as $index => $item): ?>
                    <div class="cart-item">
                        <p><?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['price']); ?> тг</p>
                        <div class="button-group">
                            <a href="?remove_favorite=<?php echo $index; ?>" class="remove-btn">Удалить</a>
                            <form method="POST" action="">
                                <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                                <input type="hidden" name="item_price" value="<?php echo htmlspecialchars($item['price']); ?>">
                                <button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Избранное пусто</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>
<?php
session_start();

// "Выйти" логикасы
if (isset($_GET['logout'])) {
    unset($_SESSION['loggedin']); // Тек логин белгісін жою
    unset($_SESSION['user_email']); // Email-ді жою (қажет болса)
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriKids</title>
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

    <section class="blog-hero">
        <h1>Подростковое питание</h1>
        <p>Поддержка активного образа жизни</p>
        <img src="../nutrikids/img/5.jpg" alt="Подростковое питание" class="hero-img">
    </section>

    <section class="blog-content">
        <div class="content-wrapper">
            <h2>Питание для подростков</h2>
            <p>Подростковый возраст — время интенсивного роста и изменений. Правильное питание помогает поддерживать здоровье, энергию и концентрацию. Включите в рацион белки, сложные углеводы и полезные жиры.</p>
            
            <div class="tips">
                <h3>Рекомендации для подростков</h3>
                <ul>
                    <li>Ешьте больше белка (курица, рыба, бобовые).</li>
                    <li>Избегайте сахара и быстрых углеводов.</li>
                    <li>Пейте достаточно воды в течение дня.</li>
                </ul>
            </div>

            <div class="image-gallery">
                <img src="../nutrikids/img/milk.jpg" alt="Молоко" class="gallery-img">
                <img src="../nutrikids/img/3.jpg" alt="Перекус" class="gallery-img">
            </div>

            <a href="catalog.php" class="cta-btn">Посмотреть продукты для подростков</a>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>
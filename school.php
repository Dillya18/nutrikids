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
                <p><a href="#continer-2">О нас</a></p>
                <p><a href="#continer-6">Блог о питании</a></p>
            </div>
            <div class="head-12">
                <a href="index.php">NutriKids</a>
            </div>
            <div class="head-13">
                <p><a href="#continer-7">Где купить</a></p>
                <p><a href="#continer-5">Отзыв родителей</a></p>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <p><a href="favorites.php">Избранное</a></p>
                    <p><a href="cart.php">Корзина (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></p>
                    <p><a href="?logout=true">Выйти</a></p> <!-- Жаңа "Выйти" сілтемесі -->
                <?php else: ?>
                    <p><a href="registration.php">Регистрация</a></p>
                    <p><a href="login.php">Войти</a></p>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="blog-hero">
        <h1>Здоровое питание школьников</h1>
        <p>Энергия и концентрация для учебы</p>
        <img src="../nutrikids/img/7.jpg" alt="Питание школьников" class="hero-img">
    </section>

    <section class="blog-content">
        <div class="content-wrapper">
            <h2>Организация питания для школьников</h2>
            <p>Школьный возраст — время активного роста и обучения. Правильное питание помогает детям оставаться энергичными и сосредоточенными. Включите в рацион цельнозерновые продукты, белки, овощи и полезные жиры.</p>
            
            <div class="tips">
                <h3>Идеи для перекусов</h3>
                <ul>
                    <li>Орехи и сухофрукты.</li>
                    <li>Йогурт с фруктами.</li>
                    <li>Сэндвичи с цельнозерновым хлебом.</li>
                </ul>
            </div>

            <div class="image-gallery">
                <img src="../nutrikids/img/yogurt.jpg" alt="Йогурт" class="gallery-img">
                <img src="../nutrikids/img/4.jpg" alt="Перекус" class="gallery-img">
            </div>

            <a href="catalog.php" class="cta-btn">Посмотреть продукты для школьников</a>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>
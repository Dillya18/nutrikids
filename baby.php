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
        <h1>Питание для малышей</h1>
        <p>Полезные советы и рекомендации для самых маленьких</p>
        <img src="../nutrikids/img/6.jpg" alt="Питание для малышей" class="hero-img">
    </section>

    <section class="blog-content">
        <div class="content-wrapper">
            <h2>Особенности питания до года</h2>
            <p>Первые месяцы жизни ребенка — это время, когда питание играет ключевую роль в его развитии. Материнское молоко или адаптированные смеси являются основой рациона до 6 месяцев. С этого возраста начинается введение прикорма: овощные пюре, каши и фрукты.</p>
            
            <div class="tips">
                <h3>Советы по введению прикорма</h3>
                <ul>
                    <li>Начинайте с одной ложки нового продукта.</li>
                    <li>Следите за реакцией малыша на аллергию.</li>
                    <li>Добавляйте новые продукты постепенно, через 3-5 дней.</li>
                </ul>
            </div>

            <div class="image-gallery">
                <img src="../nutrikids/img/puree.jpg" alt="Овощное пюре" class="gallery-img">
                <img src="../nutrikids/img/cereal.jpg" alt="Каша" class="gallery-img">
            </div>

            <a href="catalog.php" class="cta-btn">Посмотреть продукты для малышей</a>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>
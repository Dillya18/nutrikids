<?php
session_start();

// Корзинаға қосу логикасы
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

// Избранноеға қосу логикасы
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_favorites'])) {
    $item = [
        'name' => $_POST['item_name'],
        'price' => $_POST['item_price']
    ];
    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }
    $_SESSION['favorites'][] = $item;
    echo "<script>alert('Товар добавлен в избранное!');</script>";
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

// Каталогтан админ қосқан заттарды алу
$sql = "SELECT * FROM catalog";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог - NutriKids</title>
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

    <section class="catalog">
        <h1>Каталог продукции</h1>
        <p>Здесь вы найдете наш ассортимент детского питания.</p>
        <a href="https://www.molskaz.ru/upload/iblock/9ef/bn4lnd25bxj3fcn3j1fdcrtkl0yitdw6/Assortimentnaya-karta-Modest.pdf" 
           download="Assortimentnaya-karta-Modest.pdf" 
           class="download-btn">Скачать каталог</a>

        <div class="catalog-cards">
            <!-- Бастапқы заттар (қолмен қосылған) -->
            <div class="catalog-item">
                <img src="./img/milk.jpg" alt="Молоко сухое" class="cat-img">
                <h5>Молоко сухое Modest</h5>
                <p>Сухое молоко для детей от 0 до 12 месяцев, 350г.</p>
                <p class="price">Цена: 1500 тг</p>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <div class="button-group">
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Молоко сухое Modest">
                            <input type="hidden" name="item_price" value="1500">
                            <button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Молоко сухое Modest">
                            <input type="hidden" name="item_price" value="1500">
                            <button type="submit" name="add_to_favorites" class="fav-btn">Избранное</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="catalog-item">
                <img src="./img/cereal.jpg" alt="Каша" class="cat-img">
                <h5>Каша молочная Modest</h5>
                <p>Молочная каша с гречкой и черносливом, 200г.</p>
                <p class="price">Цена: 800 тг</p>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <div class="button-group">
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Каша молочная Modest">
                            <input type="hidden" name="item_price" value="800">
                            <button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Каша молочная Modest">
                            <input type="hidden" name="item_price" value="800">
                            <button type="submit" name="add_to_favorites" class="fav-btn">Избранное</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="catalog-item">
                <img src="./img/puree.jpg" alt="Пюре" class="cat-img">
                <h5>Пюре овощное Modest</h5>
                <p>Овощное пюре с кабачком и морковью, 100г.</p>
                <p class="price">Цена: 500 тг</p>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <div class="button-group">
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Пюре овощное Modest">
                            <input type="hidden" name="item_price" value="500">
                            <button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Пюре овощное Modest">
                            <input type="hidden" name="item_price" value="500">
                            <button type="submit" name="add_to_favorites" class="fav-btn">Избранное</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="catalog-item">
                <img src="./img/juice.jpg" alt="Сок" class="cat-img">
                <h5>Сок фруктовый Modest</h5>
                <p>Яблочно-грушевый сок для детей от 6 месяцев, 200мл.</p>
                <p class="price">Цена: 600 тг</p>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <div class="button-group">
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Сок фруктовый Modest">
                            <input type="hidden" name="item_price" value="600">
                            <button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Сок фруктовый Modest">
                            <input type="hidden" name="item_price" value="600">
                            <button type="submit" name="add_to_favorites" class="fav-btn">Избранное</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="catalog-item">
                <img src="./img/yogurt.jpg" alt="Йогурт" class="cat-img">
                <h5>Йогурт детский Modest</h5>
                <p>Натуральный йогурт с клубникой, 100г.</p>
                <p class="price">Цена: 400 тг</p>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <div class="button-group">
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Йогурт детский Modest">
                            <input type="hidden" name="item_price" value="400">
                            <button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="item_name" value="Йогурт детский Modest">
                            <input type="hidden" name="item_price" value="400">
                            <button type="submit" name="add_to_favorites" class="fav-btn">Избранное</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Админ қосқан заттар -->
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="catalog-item">';
                    echo '<img src="./img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" class="cat-img">';
                    echo '<h5>' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="price">Цена: ' . htmlspecialchars($row['price']) . ' тг</p>';
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        echo '<div class="button-group">';
                        echo '<form method="POST" action="">';
                        echo '<input type="hidden" name="item_name" value="' . htmlspecialchars($row['name']) . '">';
                        echo '<input type="hidden" name="item_price" value="' . htmlspecialchars($row['price']) . '">';
                        echo '<button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>';
                        echo '</form>';
                        echo '<form method="POST" action="">';
                        echo '<input type="hidden" name="item_name" value="' . htmlspecialchars($row['name']) . '">';
                        echo '<input type="hidden" name="item_price" value="' . htmlspecialchars($row['price']) . '">';
                        echo '<button type="submit" name="add_to_favorites" class="fav-btn">Избранное</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
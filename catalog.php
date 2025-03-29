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

// Іздеу логикасы
$search_query = '';
$where_clause = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = htmlspecialchars($_GET['search']);
    $search_words = explode(' ', $search_query); // Сөздерді бөлеміз
    $conditions = [];
    foreach ($search_words as $word) {
        $word = $conn->real_escape_string($word); // SQL инъекциядан қорғау
        $conditions[] = "(name LIKE '%$word%' OR description LIKE '%$word%')";
    }
    $where_clause = "WHERE " . implode(' OR ', $conditions); // Сөздерді "OR" арқылы біріктіреміз
}
$sql = "SELECT * FROM catalog $where_clause";
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
                <p><a href="profile.php">Личный кабинет</a></p>
                <p><a href="?logout=true">Выйти</a></p>
            <?php else: ?>
                <p><a href="registration.php">Регистрация</a></p>
                <p><a href="login.php">Войти</a></p>
            <?php endif; ?>
        </div>
    </div>
</header>

<section class="catalog">
    <!-- Іздеу формасы -->
    <form method="GET" action="" class="search-form">
        <input type="text" name="search" placeholder="Товар іздеу..." value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit" class="search-btn">Іздеу</button>
    </form>

    <h1>Каталог продукции</h1>
    <p>Здесь вы найдете наш ассортимент детского питания.</p>
    <a href="https://www.molskaz.ru/upload/iblock/9ef/bn4lnd25bxj3fcn3j1fdcrtkl0yitdw6/Assortimentnaya-karta-Modest.pdf" 
       download="Assortimentnaya-karta-Modest.pdf" 
       class="download-btn">Скачать каталог</a>

    <div class="catalog-cards">
        <!-- Бастапқы заттар (қолмен қосылған) -->
        <?php
        $static_items = [
            ['name' => 'Молоко сухое Modest', 'description' => 'Сухое молоко для детей от 0 до 12 месяцев, 350г.', 'price' => 1500, 'image' => 'milk.jpg'],
            ['name' => 'Каша молочная Modest', 'description' => 'Молочная каша с гречкой и черносливом, 200г.', 'price' => 800, 'image' => 'cereal.jpg'],
            ['name' => 'Пюре овощное Modest', 'description' => 'Овощное пюре с кабачком и морковью, 100г.', 'price' => 500, 'image' => 'puree.jpg'],
            ['name' => 'Сок фруктовый Modest', 'description' => 'Яблочно-грушевый сок для детей от 6 месяцев, 200мл.', 'price' => 600, 'image' => 'juice.jpg'],
            ['name' => 'Йогурт детский Modest', 'description' => 'Натуральный йогурт с клубникой, 100г.', 'price' => 400, 'image' => 'yogurt.jpg'],
        ];

        $items_to_display = [];
        if (empty($search_query)) {
            $items_to_display = $static_items;
        } else {
            foreach ($static_items as $item) {
                foreach ($search_words as $word) {
                    if (stripos($item['name'], $word) !== false || stripos($item['description'], $word) !== false) {
                        $items_to_display[] = $item;
                        break;
                    }
                }
            }
        }

        foreach ($items_to_display as $item) {
            echo '<div class="catalog-item">';
            echo '<img src="./img/' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '" class="cat-img">';
            echo '<h5>' . htmlspecialchars($item['name']) . '</h5>';
            echo '<p>' . htmlspecialchars($item['description']) . '</p>';
            echo '<p class="price">Цена: ' . htmlspecialchars($item['price']) . ' тг</p>';
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo '<div class="button-group">';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="item_name" value="' . htmlspecialchars($item['name']) . '">';
                echo '<input type="hidden" name="item_price" value="' . htmlspecialchars($item['price']) . '">';
                echo '<button type="submit" name="add_to_cart" class="cart-btn">В корзину</button>';
                echo '</form>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="item_name" value="' . htmlspecialchars($item['name']) . '">';
                echo '<input type="hidden" name="item_price" value="' . htmlspecialchars($item['price']) . '">';
                echo '<button type="submit" name="add_to_favorites" class="fav-btn">Избранное</button>';
                echo '</form>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>

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
        } elseif (!empty($search_query) && empty($items_to_display)) {
            echo '<p>«' . htmlspecialchars($search_query) . '» бойынша ешнәрсе табылмады</p>';
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
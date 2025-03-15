<?php
session_start();

// Админ тексерісі
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header("Location: index.php");
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

// Каталогқа зат қосу
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $item_name = htmlspecialchars($_POST['item_name']);
    $item_description = htmlspecialchars($_POST['item_description']);
    $item_price = htmlspecialchars($_POST['item_price']);
    
    $target_dir = "../img/";
    $image_name = basename($_FILES["item_image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO catalog (name, description, price, image) VALUES ('$item_name', '$item_description', '$item_price', '$image_name')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Зат сәтті қосылды!');</script>";
        } else {
            echo "<script>alert('Қате: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Суретті жүктеу қатесі немесе дұрыс формат емес (jpg, png, gif)');</script>";
    }
}

// Тапсырысты жіберу
if (isset($_GET['ship_order'])) {
    $user_email = $_GET['ship_order'];
    $address = $_GET['address'];
    $payment_method = $_GET['payment_method'];
    $shipped_at = date('Y-m-d H:i:s');
    $sql = "UPDATE orders SET status = 'Жіберілді', shipped_at = '$shipped_at' 
            WHERE user_email = '$user_email' AND address = '$address' AND payment_method = '$payment_method'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Тапсырыс жіберілді!');</script>";
    } else {
        echo "<script>alert('Қате: " . $conn->error . "');</script>";
    }
}

// Барлық тапсырыстарды файлға сақтау
if (isset($_GET['save_orders'])) {
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $file = fopen("data.txt", "a");
        if ($file) {
            fwrite($file, "=== Тапсырыстар (" . date('Y-m-d H:i:s') . ") ===\n");
            while ($row = $result->fetch_assoc()) {
                $data = "User: " . $row['user_email'] . " | Item: " . $row['item_name'] . " | Price: " . $row['item_price'] . 
                        " | Address: " . $row['address'] . " | Payment: " . $row['payment_method'] . 
                        " | Status: " . $row['status'] . " | Ordered: " . $row['ordered_at'] . 
                        " | Shipped: " . ($row['shipped_at'] ?: '-') . "\n";
                fwrite($file, $data);
            }
            fwrite($file, "====================\n\n");
            fclose($file);
            echo "<script>alert('Барлық тапсырыстар data.txt файлына сақталды!');</script>";
        } else {
            echo "<script>alert('Файлды ашу қатесі!');</script>";
        }
    } else {
        echo "<script>alert('Тапсырыстар жоқ!');</script>";
    }
}

// "Выйти" логикасы
if (isset($_GET['logout'])) {
    unset($_SESSION['admin_loggedin']);
    unset($_SESSION['loggedin']);
    unset($_SESSION['user_email']);
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - NutriKids</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="head">
            <div class="head-1">
                <p><a href="../catalog.php">Каталог</a></p>
            </div>
            <div class="head-12">
                <a href="../index.php">NutriKids</a>
            </div>
            <div class="head-13">
                <p><a href="?logout=true">Выйти</a></p>
            </div>
        </div>
    </header>

    <section class="admin-section">
        <h1>Admin Panel</h1>

        <!-- Каталогқа зат қосу -->
        <div class="admin-container">
            <h2>Добавить товар в каталог</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="item_name">Название:</label>
                    <input type="text" id="item_name" name="item_name" placeholder="Введите название" required>
                </div>
                <div class="form-group">
                    <label for="item_description">Описание:</label>
                    <textarea id="item_description" name="item_description" placeholder="Введите описание" required></textarea>
                </div>
                <div class="form-group">
                    <label for="item_price">Цена (в тг):</label>
                    <input type="number" id="item_price" name="item_price" placeholder="Введите цену" required>
                </div>
                <div class="form-group">
                    <label for="item_image">Фото (jpg, png, gif):</label>
                    <input type="file" id="item_image" name="item_image" accept="image/*" required>
                </div>
                <button type="submit" name="add_item" class="auth-btn">Добавить</button>
            </form>
        </div>

        <!-- Тапсырыстарды көру -->
        <div class="admin-container">
            <h2>Заказы</h2>
            <div class="button-group">
                <a href="#" id="hide-shipped-btn" class="delete-btn">Удалить товары</a>
                <a href="?save_orders=true" class="save-btn">Записать данные</a>
            </div>
            <?php
            $sql = "SELECT user_email, GROUP_CONCAT(item_name SEPARATOR ', ') AS items, SUM(item_price) AS total_price, 
                    address, payment_method, status, ordered_at, shipped_at 
                    FROM orders 
                    GROUP BY user_email, address, payment_method, status, ordered_at, shipped_at";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<div class='orders-table-wrapper'>";
                echo "<table class='orders-table'><tr><th>Пользователь</th><th>Товары</th><th>Общая цена</th><th>Адрес</th><th>Способ оплаты</th><th>Статус</th><th>Когда заказаны</th><th>Когда отправлены</th><th>Действие</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='order-row' data-status='" . htmlspecialchars($row['status']) . "'>";
                    echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['items']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_price']) . " тг</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>" . ($row['ordered_at'] ? htmlspecialchars($row['ordered_at']) : '-') . "</td>";
                    echo "<td>" . ($row['shipped_at'] ? htmlspecialchars($row['shipped_at']) : '-') . "</td>";
                    if ($row['status'] === 'Ожидание') {
                        echo "<td><a href='?ship_order=" . urlencode($row['user_email']) . "&address=" . urlencode($row['address']) . "&payment_method=" . urlencode($row['payment_method']) . "' class='ship-btn'>Отправить</a></td>";
                    } else {
                        echo "<td>Отправлено</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>Заказов нет</p>";
            }
            ?>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>

    <script>
        document.getElementById('hide-shipped-btn').addEventListener('click', function(e) {
            e.preventDefault(); // Сілтеменің әдепкі әрекетін тоқтатамыз
            const rows = document.querySelectorAll('.order-row');
            rows.forEach(row => {
                if (row.getAttribute('data-status') === 'Жіберілді') {
                    row.style.display = 'none'; // "Жіберілді" жолдарын жасырамыз
                }
            });
            alert('Отправленные товары скрыты с сайта!');
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>
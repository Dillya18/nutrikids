<?php
session_start();

// MySQL-ге қосылу
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "nutrikids_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Қосылым қатесі: " . $conn->connect_error);
}

// Регистрацияны өңдеу
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO registration (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['loggedin'] = true; // Пайдаланушы кіргенін белгілеу
        $_SESSION['user_email'] = $email; // Email-ді сессияда сақтау
        echo "<script>alert('Регистрация сәтті аяқталды!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Қате: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - NutriKids</title>
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
                    <p><a href="#">Корзина</a></p>
                    <p><a href="#">Избранное</a></p>
                <?php else: ?>
                    <p><a href="registration.php">Регистрация</a></p>
                    <p><a href="login.php">Войти</a></p>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="auth-section">
        <div class="auth-container">
            <h1>Регистрация</h1>
            <p>Присоединяйтесь к нашему сообществу родителей!</p>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" placeholder="Введите ваше имя" required>
                </div>
                <div class="form-group">
                    <label for="email">Почта:</label>
                    <input type="email" id="email" name="email" placeholder="Введите ваш email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Номер телефона:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Введите ваш номер" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" placeholder="Придумайте пароль" required>
                </div>
                <button type="submit" class="auth-btn">Зарегистрироваться</button>
            </form>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>